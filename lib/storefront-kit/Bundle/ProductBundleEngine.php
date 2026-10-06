<?php

declare(strict_types=1);

namespace WPPoland\StorefrontKit\Bundle;

/**
 * Namespace-neutral "frequently bought together" bundle engine (powers the
 * Bundle, Product Bundles for WooCommerce plugin).
 *
 * An admin links N product ids to a product plus an optional bundle discount %.
 * The engine renders a bundle box on the product page, adds all linked items
 * (plus the main product) to the cart in one action, and applies the discount, 
 * either as a single cart fee or as a per-item price adjustment. The bundle
 * definition is stored as product meta, the host owns the meta key and
 * read access, injected via the `productMeta` closure (no custom table).
 *
 * Everything WooCommerce / text-domain / option / meta specific is
 * constructor-injected, mirroring {@see \WPPoland\StorefrontKit\Badge\BadgeEngine}.
 * The bundle box markup ships in the consuming plugin via the injected
 * `renderTemplate` closure.
 */
final class ProductBundleEngine
{
    /**
     * Per-request memo of resolved bundle discount percent, keyed by parent
     * product id, so repeated total recalculations don't reload the product and
     * re-read its meta for every cart line.
     *
     * @var array<int, float>
     */
    private array $discountPercentCache = [];

    /**
     * Undiscounted unit price of each bundle line's product object, recorded
     * the first time the line is priced, so per-item mode can recompute the
     * discount from scratch every pass instead of compounding it.
     *
     * @var \WeakMap<\WC_Product, float>
     */
    private \WeakMap $basePrices;

    /**
     * @param \Closure(): bool $isEnabled
     * @param \Closure(): array<string, mixed> $settings Resolved settings:
     *        `discount_mode` (`fee`|`per_item`), `show_on_single`.
     * @param \Closure(\WC_Product): mixed $productMeta Reads the raw bundle
     *        definition for a product (returns the stored array or null).
     * @param \Closure(string, array<string, mixed>): void $renderTemplate
     *        Echoes the bundle box template under the product summary.
     * @param array<string, string> $labels Fallback strings keyed by
     *        `box_title`, `add_bundle`, `fee_label`, `add_failed`.
     */
    public function __construct(
        private readonly string $requestKey,
        private readonly string $nonceAction,
        private readonly string $cartFlag,
        private readonly string $boxTemplate,
        private readonly array $labels,
        private readonly \Closure $isEnabled,
        private readonly \Closure $settings,
        private readonly \Closure $productMeta,
        private readonly \Closure $renderTemplate,
    ) {
        $this->basePrices = new \WeakMap();
    }

    public function registerHooks(): void
    {
        add_action('woocommerce_after_single_product_summary', [$this, 'renderBox'], 15);
        add_action('template_redirect', [$this, 'handleAddBundle'], 5);
        add_action('woocommerce_cart_calculate_fees', [$this, 'applyBundleFee'], 20);
        // Per-item prices depend on the whole cart (a bundle is discounted only
        // while it is complete), so they are recomputed for the whole cart once
        // it is restored from the session, before the mini cart or the cart
        // fragments render, and again on every totals pass, which WooCommerce
        // runs after each add, removal and quantity change.
        add_action('woocommerce_cart_loaded_from_session', [$this, 'applyPerItemDiscount'], 25);
        add_action('woocommerce_before_calculate_totals', [$this, 'applyPerItemDiscount'], 25);
    }

    public function renderBox(): void
    {
        global $product;

        if (! $product instanceof \WC_Product || ! $this->isEnabled() || ! ($this->getSettings()['show_on_single'] ?? true)) {
            return;
        }

        $context = $this->boxContext($product);

        if ($context !== null) {
            ($this->renderTemplate)($this->boxTemplate, $context);
        }
    }

    /**
     * Template context for the bundle box, or null when there is nothing the
     * shopper could actually buy: the main product is unavailable, or none of
     * its companions are. The listed items are the ones Add bundle adds.
     *
     * @return array<string, mixed>|null
     */
    public function boxContext(\WC_Product $product): ?array
    {
        $bundle = $this->offer($product);

        if ($bundle === null) {
            return null;
        }

        return [
            'product' => $product,
            'bundle' => $bundle,
            'action_url' => $this->getActionUrl($product),
            'nonce_field' => wp_create_nonce($this->nonceAction),
            'request_key' => $this->requestKey,
            'box_title' => $this->message('box_title'),
            'add_label' => $this->message('add_bundle'),
            'settings' => $this->getSettings(),
        ];
    }

    /**
     * The bundle as it can be bought right now: the definition with every
     * companion that cannot go into the cart dropped, or null when the main
     * product cannot, or no companion is left.
     *
     * @return array{items: list<int>, discount_percent: float}|null
     */
    public function offer(\WC_Product $product): ?array
    {
        if (! $this->isAddable($product)) {
            return null;
        }

        $bundle = $this->getBundle($product);
        $bundle['items'] = array_values(array_filter(
            $bundle['items'],
            function (int $itemId): bool {
                $item = wc_get_product($itemId);

                return $item instanceof \WC_Product && $this->isAddable($item);
            },
        ));

        return $bundle['items'] === [] ? null : $bundle;
    }

    /**
     * Whether one click can put this product in the cart: a bundleable type
     * (not external or grouped, which have no cart line of their own), on sale
     * and in stock.
     */
    public function isAddable(\WC_Product $product): bool
    {
        return $this->isBundleable($product)
            && ! $product->is_type(['external', 'grouped'])
            && $product->is_purchasable()
            && $product->is_in_stock();
    }

    public function handleAddBundle(): void
    {
        if (! $this->isEnabled() || ! isset($_REQUEST[$this->requestKey])) {
            return;
        }

        $nonce = isset($_REQUEST['_wpnonce']) ? sanitize_text_field((string) wp_unslash($_REQUEST['_wpnonce'])) : '';

        if (! wp_verify_nonce($nonce, $this->nonceAction)) {
            // A page served from cache carries a nonce that no longer verifies.
            wc_add_notice($this->message('expired'), 'error');

            return;
        }

        $productId = absint(wp_unslash($_REQUEST[$this->requestKey]));
        $product = wc_get_product($productId);

        if (! $product instanceof \WC_Product || ! WC()->cart instanceof \WC_Cart) {
            return;
        }

        $bundle = $this->offer($product);

        if ($bundle === null) {
            wc_add_notice($this->message('add_failed'), 'error');

            return;
        }

        // All or nothing: a bundle missing a product is not the bundle that
        // was offered, so whatever went in is taken out again.
        $added = [];

        foreach (array_merge([$productId], $bundle['items']) as $bundleProductId) {
            $key = WC()->cart->add_to_cart($bundleProductId, 1, 0, [], [$this->cartFlag => $productId]);

            if ($key === false) {
                foreach ($added as $addedKey) {
                    $line = WC()->cart->get_cart_item($addedKey);
                    WC()->cart->set_quantity($addedKey, max(0, (int) ($line['quantity'] ?? 1) - 1));
                }

                wc_add_notice($this->message('add_failed'), 'error');

                return;
            }

            $added[] = $key;
        }

        wp_safe_redirect(wc_get_cart_url());
        exit;
    }

    public function applyBundleFee(\WC_Cart $cart): void
    {
        if (! $this->isEnabled() || (string) ($this->getSettings()['discount_mode'] ?? 'fee') !== 'fee') {
            return;
        }

        $discount = $this->calculateBundleDiscount($cart);

        if ($discount > 0) {
            $cart->add_fee($this->message('fee_label'), -$discount);
        }
    }

    /**
     * Per-item mode: set each bundle line's unit price so the line carries
     * the discount for the complete bundles in the cart and no more. A line
     * with more units than complete bundles gets a blended unit price.
     */
    public function applyPerItemDiscount(\WC_Cart $cart): void
    {
        if (! $this->isEnabled() || (string) ($this->getSettings()['discount_mode'] ?? 'fee') !== 'per_item') {
            return;
        }

        $sets = $this->completeSets($cart);

        foreach ($cart->get_cart() as $cartItem) {
            $bundleParentId = $this->bundleParentId($cartItem);
            $data = $cartItem['data'] ?? null;

            if ($bundleParentId === 0 || ! $data instanceof \WC_Product) {
                continue;
            }

            $base = $this->basePrices[$data] ??= (float) $data->get_price('edit');
            $units = min($sets[$bundleParentId][$data->get_id()] ?? 0, (int) $cartItem['quantity']);

            /**
             * Filters the per-item bundle discount for one cart line, in percent.
             *
             * @param float $percent        Discount from the bundle definition.
             * @param int   $bundleParentId Product id of the bundle the line belongs to.
             */
            $percent = $units > 0
                ? (float) apply_filters('bundle/per_item_discount_percent', $this->discountPercentFor($bundleParentId), $bundleParentId)
                : 0.0;

            $data->set_price((string) ($base * (1 - $percent / 100 * $units / max(1, (int) $cartItem['quantity']))));
        }
    }

    /**
     * Normalise the host-stored bundle definition.
     *
     * @return array{items: list<int>, discount_percent: float}
     */
    public function getBundle(\WC_Product $product): array
    {
        if (! $this->isEnabled()) {
            return ['items' => [], 'discount_percent' => 0.0];
        }

        $raw = ($this->productMeta)($product);

        if (! is_array($raw)) {
            return ['items' => [], 'discount_percent' => 0.0];
        }

        $items = [];

        foreach ((array) ($raw['items'] ?? []) as $itemId) {
            $itemId = absint($itemId);

            if ($itemId > 0 && $itemId !== $product->get_id() && ! in_array($itemId, $items, true)) {
                $items[] = $itemId;
            }
        }

        return [
            'items' => $items,
            'discount_percent' => max(0.0, min(100.0, (float) ($raw['discount_percent'] ?? 0))),
        ];
    }

    /**
     * Whether a product can take part in a bundle at all.
     *
     * A variable product has no single cart line: WooCommerce refuses it until a
     * variation is chosen, and the one-click add sends none. The box used to
     * render on such products and the shopper ended up with the companions in
     * the cart and the product they were actually looking at missing, so a
     * variable product is left out of bundles entirely.
     */
    public function isBundleable(\WC_Product $product): bool
    {
        return ! $product instanceof \WC_Product_Variable;
    }

    /**
     * Product ids to add for the bundle: the main product plus its linked items.
     *
     * @return list<int>
     */
    public function bundleProductIds(\WC_Product $product): array
    {
        return array_values(array_unique(array_merge([$product->get_id()], $this->getBundle($product)['items'])));
    }

    private function calculateBundleDiscount(\WC_Cart $cart): float
    {
        $discount = 0.0;
        $sets = $this->completeSets($cart);

        foreach ($cart->get_cart() as $cartItem) {
            $bundleParentId = $this->bundleParentId($cartItem);

            if ($bundleParentId === 0 || ! $cartItem['data'] instanceof \WC_Product) {
                continue;
            }

            $percent = $this->discountPercentFor($bundleParentId);
            $units = min($sets[$bundleParentId][$cartItem['data']->get_id()] ?? 0, (int) $cartItem['quantity']);

            if ($percent <= 0.0 || $units <= 0) {
                continue;
            }

            $discount += (float) $cartItem['data']->get_price('edit') * $units * ($percent / 100);
        }

        return round($discount, wc_get_price_decimals());
    }

    /**
     * How many complete bundles the cart holds, per bundle: the lowest
     * quantity across the products the bundle offers right now. A line the
     * offer does not include, or a bundle with any of its products missing,
     * earns nothing.
     *
     * @return array<int, array<int, int>> Parent id => product id => discounted units.
     */
    private function completeSets(\WC_Cart $cart): array
    {
        $quantities = [];

        foreach ($cart->get_cart() as $cartItem) {
            $bundleParentId = $this->bundleParentId($cartItem);

            if ($bundleParentId === 0 || ! ($cartItem['data'] ?? null) instanceof \WC_Product) {
                continue;
            }

            $id = $cartItem['data']->get_id();
            $quantities[$bundleParentId][$id] = ($quantities[$bundleParentId][$id] ?? 0) + (int) $cartItem['quantity'];
        }

        $sets = [];

        foreach ($quantities as $bundleParentId => $have) {
            $parent = wc_get_product($bundleParentId);
            $offer = $parent instanceof \WC_Product ? $this->offer($parent) : null;

            if ($offer === null) {
                continue;
            }

            $ids = array_merge([$bundleParentId], $offer['items']);
            $complete = min(array_map(static fn (int $id): int => $have[$id] ?? 0, $ids));
            $sets[$bundleParentId] = array_fill_keys($ids, $complete);
        }

        return $sets;
    }

    private function discountPercentFor(int $parentProductId): float
    {
        if (isset($this->discountPercentCache[$parentProductId])) {
            return $this->discountPercentCache[$parentProductId];
        }

        $product = wc_get_product($parentProductId);
        $percent = $product instanceof \WC_Product ? $this->getBundle($product)['discount_percent'] : 0.0;

        return $this->discountPercentCache[$parentProductId] = $percent;
    }

    /**
     * @param array<string, mixed> $cartItem
     */
    private function bundleParentId(array $cartItem): int
    {
        return isset($cartItem[$this->cartFlag]) ? absint($cartItem[$this->cartFlag]) : 0;
    }

    private function getActionUrl(\WC_Product $product): string
    {
        return add_query_arg(
            [
                $this->requestKey => $product->get_id(),
                '_wpnonce' => wp_create_nonce($this->nonceAction),
            ],
            $product->get_permalink(),
        );
    }

    private function isEnabled(): bool
    {
        return (bool) ($this->isEnabled)();
    }

    /**
     * @return array<string, mixed>
     */
    private function getSettings(): array
    {
        $settings = ($this->settings)();

        return is_array($settings) ? $settings : [];
    }

    private function message(string $labelKey): string
    {
        return $this->labels[$labelKey] ?? '';
    }
}
