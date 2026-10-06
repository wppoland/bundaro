<?php

/**
 * The bundle discount belongs to complete bundles only, and the box offers
 * only what one click can put in the cart.
 *
 * - Companions removed, or the main product raised to 10: the discount must
 *   cover the complete sets and nothing more (it used to take 20% off any
 *   quantity of a lone product).
 * - An out-of-stock main product, or an external or out-of-stock companion,
 *   must not be offered, listed or counted towards a complete set.
 * - A stale nonce must tell the shopper instead of doing nothing.
 *
 * Run: php tests/bundle-cart-check.php
 */

declare(strict_types=1);

namespace {
    define('ABSPATH', __DIR__);

    $hooks   = [];
    $notices = [];
    $mode    = 'fee';

    function add_filter(string $hook, mixed $cb, int $priority = 10, int $args = 1): void
    {
        $GLOBALS['hooks'][$hook] = $cb;
    }

    function add_action(string $hook, mixed $cb, int $priority = 10, int $args = 1): void
    {
        $GLOBALS['hooks'][$hook] = $cb;
    }

    function apply_filters(string $hook, mixed $value, mixed ...$args): mixed
    {
        return $value;
    }

    function absint(mixed $value): int
    {
        return abs((int) $value);
    }

    function wc_get_price_decimals(): int
    {
        return 2;
    }

    function wp_create_nonce(string $action): string
    {
        return 'good';
    }

    function wp_verify_nonce(string $nonce, string $action): bool
    {
        return 'good' === $nonce;
    }

    function sanitize_text_field(string $value): string
    {
        return $value;
    }

    function wp_unslash(mixed $value): mixed
    {
        return $value;
    }

    function wc_add_notice(string $message, string $type = 'success'): void
    {
        $GLOBALS['notices'][] = $message;
    }

    function add_query_arg(array $args, string $url): string
    {
        return $url;
    }

    class WC_Product
    {
        public function __construct(
            private int $id,
            private string $price,
            private string $type = 'simple',
            private bool $inStock = true,
        ) {
        }

        public function get_id(): int
        {
            return $this->id;
        }

        public function get_price(string $context = 'view'): string
        {
            return $this->price;
        }

        public function set_price(string $price): void
        {
            $this->price = $price;
        }

        public function is_type(string|array $type): bool
        {
            return in_array($this->type, (array) $type, true);
        }

        public function is_purchasable(): bool
        {
            return 'external' !== $this->type;
        }

        public function is_in_stock(): bool
        {
            return $this->inStock;
        }

        public function get_permalink(): string
        {
            return '';
        }
    }

    class WC_Cart
    {
        /** @var list<float> */
        public array $fees = [];

        /** @param array<string, array<string, mixed>> $lines */
        public function __construct(public array $lines)
        {
        }

        public function get_cart(): array
        {
            return $this->lines;
        }

        public function add_fee(string $name, float $amount): void
        {
            $this->fees[] = $amount;
        }
    }

    // 10 main (bundle: 11, 12 at 20%), 11 and 12 companions at 100.
    // 20 has an out-of-stock companion 21 and an external 22 next to 11.
    // 30 is out of stock itself.
    $products = [
        10 => ['100'], 11 => ['100'], 12 => ['100'],
        20 => ['100'], 21 => ['40', 'simple', false], 22 => ['50', 'external'],
        30 => ['100', 'simple', false],
    ];
    $bundles = [10 => [11, 12], 20 => [11, 21, 22], 30 => [11, 12]];

    function wc_get_product(int $id): ?WC_Product
    {
        $p = $GLOBALS['products'][$id] ?? null;

        return $p ? new WC_Product($id, ...$p) : null;
    }

    require __DIR__ . '/../lib/storefront-kit/Bundle/ProductBundleEngine.php';

    $engine = new \WPPoland\StorefrontKit\Bundle\ProductBundleEngine(
        'bundle_add',
        'bundle_add_bundle',
        '_bundle_parent',
        '',
        ['add_failed' => 'failed', 'expired' => 'expired', 'fee_label' => 'Bundle discount'],
        static fn (): bool => true,
        static function (): array {
            return ['discount_mode' => $GLOBALS['mode']];
        },
        static fn (WC_Product $product): array => ['items' => $GLOBALS['bundles'][$product->get_id()] ?? [], 'discount_percent' => 20],
        static function (string $template, array $args): void {
        },
    );
    $engine->registerHooks();

    $failures = 0;
    $check = static function (bool $ok, string $label) use (&$failures): void {
        if (! $ok) {
            echo "FAIL: {$label}\n";
            $failures++;
        }
    };

    // [main qty, companion 11 qty, companion 12 qty (0 = removed)] => expected discount.
    $line = static fn (int $id, int $qty, int $parent = 10): array => ['data' => wc_get_product($id), 'quantity' => $qty, '_bundle_parent' => $parent];
    $cart = static function (int $main, int $a, int $b) use ($line): WC_Cart {
        return new WC_Cart(array_filter(['m' => $main ? $line(10, $main) : null, 'a' => $a ? $line(11, $a) : null, 'b' => $b ? $line(12, $b) : null]));
    };
    $feeCases = [
        [[1, 1, 1], 60.0, 'one complete bundle'],
        [[10, 0, 0], 0.0, 'companions removed, main raised to 10'],
        [[10, 1, 1], 60.0, 'main raised to 10, companions kept: one set'],
        [[2, 2, 2], 120.0, 'two complete bundles'],
        [[1, 1, 0], 0.0, 'one companion removed'],
    ];

    foreach ($feeCases as [$q, $expected, $label]) {
        $c = $cart(...$q);
        call_user_func($hooks['woocommerce_cart_calculate_fees'], $c);
        $got = -array_sum($c->fees);
        $check(abs($got - $expected) < 0.001, "fee mode, {$label}: discount {$got}, expected {$expected}");
    }

    // Per-item: the total of discounted line prices must match the fee mode.
    $mode = 'per_item';
    foreach ($feeCases as [$q, $expected, $label]) {
        $c = $cart(...$q);
        // Two passes: recomputing must not compound the discount.
        call_user_func($hooks['woocommerce_before_calculate_totals'], $c);
        call_user_func($hooks['woocommerce_before_calculate_totals'], $c);
        $full = 0.0;
        $paid = 0.0;
        foreach ($c->lines as $l) {
            $full += 100 * $l['quantity'];
            $paid += (float) $l['data']->get_price() * $l['quantity'];
        }
        $got = round($full - $paid, 2);
        $check(abs($got - $expected) < 0.001, "per-item mode, {$label}: discount {$got}, expected {$expected}");
    }

    // Restoring the cart from the session prices the lines before anything
    // renders: the mini cart and the cart fragments do not recalculate.
    $c = $cart(1, 1, 1);
    call_user_func($hooks['woocommerce_cart_loaded_from_session'], $c);
    $check('80' === (string) (float) $c->lines['a']['data']->get_price(), 'per-item mode: line not priced when the cart is restored from the session');

    // Breaking a bundle in per-item mode puts the base price back.
    unset($c->lines['a'], $c->lines['b']);
    call_user_func($hooks['woocommerce_before_calculate_totals'], $c);
    $check('100' === (string) (float) $c->lines['m']['data']->get_price(), 'per-item mode: lone main product went back to 100, got ' . $c->lines['m']['data']->get_price());
    $mode = 'fee';
    $c = $cart(1, 1, 1);
    call_user_func($hooks['woocommerce_before_calculate_totals'], $c);
    $check('100' === $c->lines['a']['data']->get_price(), 'fee mode also discounted the line price');

    // Offer: unavailable main product, unavailable companions.
    $check(null === $engine->offer(wc_get_product(30)), 'out-of-stock main product still offered');
    $check([11] === ($engine->offer(wc_get_product(20))['items'] ?? null), 'out-of-stock or external companion still offered');
    $check(null === $engine->boxContext(wc_get_product(30)), 'box rendered for an out-of-stock main product');

    // Bundle 20 offers 20 + 11 only: that pair is complete.
    $c = new WC_Cart(['m' => $line(20, 1, 20), 'a' => $line(11, 1, 20)]);
    call_user_func($hooks['woocommerce_cart_calculate_fees'], $c);
    $check(abs(-array_sum($c->fees) - 40.0) < 0.001, 'offered subset 20 + 11 not discounted as a complete bundle');

    // Stale nonce: the shopper is told.
    $_REQUEST = ['bundle_add' => '10', '_wpnonce' => 'deadbeef00'];
    $engine->handleAddBundle();
    $check(['expired'] === $notices, 'stale nonce left no notice');

    echo 0 === $failures ? "OK: bundle discounts follow complete, purchasable bundles\n" : '';
    exit($failures > 0 ? 1 : 0);
}
