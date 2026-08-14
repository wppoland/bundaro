<?php

declare(strict_types=1);

namespace Bundle\Admin;

use Bundle\Contract\HasHooks;
use Bundle\Service\BundleService;

defined('ABSPATH') || exit;

/**
 * Adds a "Product bundle" panel to the WooCommerce product data meta box, where
 * the merchant links N other products to this product plus an optional bundle
 * discount %. The definition is saved as the `_bundle_definition` product meta
 * read back by {@see BundleService}. No custom table.
 *
 * Product ids are entered as a comma-separated list (kept dependency-free; the
 * PRO add-on upgrades this to a product search field). All input is sanitised on
 * save behind a nonce; all output is escaped.
 */
final class ProductBundleBox implements HasHooks
{
    private const NONCE_ACTION = 'bundle_save_definition';
    private const NONCE_FIELD  = 'bundle_definition_nonce';

    /** Per-user transient carrying the "these IDs were dropped" notice to the next screen. */
    private const SKIPPED_TRANSIENT = 'bundle_skipped_variable_';

    /**
     * Hard cap on bundled items per product. Bounds the per-request work the
     * storefront box and the one-click add-to-cart do (each item is a product
     * load + a cart add), so a pasted list of thousands of IDs cannot turn a
     * single product page or "add bundle" click into a denial-of-service.
     */
    private const MAX_ITEMS = 50;

    public function registerHooks(): void
    {
        add_action('woocommerce_product_data_panels', [$this, 'renderPanel']);
        add_filter('woocommerce_product_data_tabs', [$this, 'addTab']);
        add_action('woocommerce_process_product_meta', [$this, 'save']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('admin_notices', [$this, 'renderSkippedNotice']);
    }

    /**
     * Load the shared admin stylesheet on the product editor so the bundle panel
     * hint is styled. Scoped to the product edit screen only.
     */
    public function enqueueAssets(string $hook): void
    {
        if ($hook !== 'post.php' && $hook !== 'post-new.php') {
            return;
        }

        $screen = function_exists('get_current_screen') ? get_current_screen() : null;

        if ($screen === null || $screen->post_type !== 'product') {
            return;
        }

        wp_enqueue_style(
            'bundle-admin',
            BUNDLE_URL . 'assets/css/admin.css',
            [],
            \Bundle\VERSION,
        );
    }

    /**
     * Register the "Bundle" product-data tab.
     *
     * @param array<string, array<string, mixed>> $tabs
     * @return array<string, array<string, mixed>>
     */
    public function addTab(array $tabs): array
    {
        // Simple products only. The tab used to show on variable products too,
        // so a merchant could configure a bundle there, but the one-click add
        // sends no variation, and WooCommerce answers a variable product with
        // "please choose product options" instead of putting it in the cart. The
        // shopper got a cart missing the very product the box was selling.
        $tabs['bundle'] = [
            'label'    => __('Bundle', 'plogins-bundle'),
            'target'   => 'bundle_product_data',
            'class'    => ['show_if_simple'],
            'priority' => 65,
        ];

        return $tabs;
    }

    public function renderPanel(): void
    {
        global $post;

        $product = $post instanceof \WP_Post ? wc_get_product($post->ID) : null;
        $items   = '';
        $percent = '';

        if ($product instanceof \WC_Product) {
            $raw = $product->get_meta(BundleService::META_BUNDLE);

            if (is_array($raw)) {
                $items   = implode(', ', array_map('absint', (array) ($raw['items'] ?? [])));
                $percent = isset($raw['discount_percent']) ? (string) (float) $raw['discount_percent'] : '';
            }
        }
        ?>
        <div id="bundle_product_data" class="panel woocommerce_options_panel hidden">
            <?php wp_nonce_field(self::NONCE_ACTION, self::NONCE_FIELD); ?>
            <p class="bundle-panel-hint">
                <?php esc_html_e('Link the products that are usually bought together with this one. They appear in a "frequently bought together" box on this product\'s page, and shoppers can add the whole set to the cart in one click.', 'plogins-bundle'); ?>
                <br />
                <?php
                printf(
                    /* translators: %s: "Products > All Products" admin breadcrumb. */
                    esc_html__('Tip: the product ID is shown in the URL when you edit a product, and in the ID column under %s.', 'plogins-bundle'),
                    '<strong>' . esc_html__('Products', 'plogins-bundle') . '</strong>'
                );
                ?>
            </p>
            <div class="options_group">
                <p class="form-field bundle-field">
                    <label for="bundle_items"><?php esc_html_e('Bundled product IDs', 'plogins-bundle'); ?></label>
                    <input
                        type="text"
                        id="bundle_items"
                        name="bundle_items"
                        class="long"
                        value="<?php echo esc_attr($items); ?>"
                        placeholder="<?php esc_attr_e('e.g. 42, 108, 256', 'plogins-bundle'); ?>"
                        inputmode="numeric"
                        autocomplete="off"
                        aria-describedby="bundle_items_desc"
                    />
                    <span class="description" id="bundle_items_desc">
                        <?php esc_html_e('Comma-separated product IDs to sell alongside this product. Duplicates, blanks and this product\'s own ID are ignored automatically.', 'plogins-bundle'); ?>
                        <br />
                        <?php esc_html_e('Simple products only. A variable product needs its options chosen before it can go in the cart, so those IDs are dropped when you save.', 'plogins-bundle'); ?>
                    </span>
                </p>
                <p class="form-field bundle-field">
                    <label for="bundle_discount_percent"><?php esc_html_e('Bundle discount (%)', 'plogins-bundle'); ?></label>
                    <input
                        type="number"
                        id="bundle_discount_percent"
                        name="bundle_discount_percent"
                        class="short"
                        min="0"
                        max="100"
                        step="0.01"
                        value="<?php echo esc_attr($percent); ?>"
                        aria-describedby="bundle_discount_desc"
                    />
                    <span class="description" id="bundle_discount_desc">
                        <?php esc_html_e('Optional. The percentage off the combined price when the whole bundle is added to the cart. Leave at 0 for no discount (the box still cross-sells the items). Values are clamped to 0-100.', 'plogins-bundle'); ?>
                    </span>
                </p>
            </div>
        </div>
        <?php
    }

    public function save(int $postId): void
    {
        $nonce = isset($_POST[self::NONCE_FIELD])
            ? sanitize_text_field(wp_unslash($_POST[self::NONCE_FIELD]))
            : '';

        if (! wp_verify_nonce($nonce, self::NONCE_ACTION)) {
            return;
        }

        if (! current_user_can('edit_product', $postId)) {
            return;
        }

        $product = wc_get_product($postId);

        if (! $product instanceof \WC_Product) {
            return;
        }

        $rawItems = isset($_POST['bundle_items'])
            ? sanitize_text_field(wp_unslash($_POST['bundle_items']))
            : '';

        $items   = [];
        $skipped = [];

        foreach (explode(',', $rawItems) as $candidate) {
            $itemId = absint(trim($candidate));

            if ($itemId > 0 && $itemId !== $postId && ! in_array($itemId, $items, true)) {
                // A variable product cannot be added to the cart without a
                // chosen variation, and the one-click add sends none. Listing
                // one here looked fine on this screen and then dropped that
                // product from the shopper's cart, so it is refused at save
                // time and reported, rather than saved to fail on the
                // storefront.
                if (wc_get_product($itemId) instanceof \WC_Product_Variable) {
                    $skipped[] = $itemId;

                    continue;
                }

                $items[] = $itemId;
            }

            if (count($items) + count($skipped) >= self::MAX_ITEMS) {
                break;
            }
        }

        $percent = isset($_POST['bundle_discount_percent'])
            ? (float) sanitize_text_field(wp_unslash($_POST['bundle_discount_percent']))
            : 0.0;

        $percent = max(0.0, min(100.0, $percent));

        if ($items === []) {
            $product->delete_meta_data(BundleService::META_BUNDLE);
        } else {
            $product->update_meta_data(BundleService::META_BUNDLE, [
                'items'            => $items,
                'discount_percent' => $percent,
            ]);
        }

        $product->save();

        if ($skipped !== []) {
            set_transient(self::SKIPPED_TRANSIENT . get_current_user_id(), $skipped, MINUTE_IN_SECONDS);
        }
    }

    /**
     * Tell the merchant which IDs were dropped on the last save, so a variable
     * product silently vanishing from the bundle list is never a mystery.
     */
    public function renderSkippedNotice(): void
    {
        $key     = self::SKIPPED_TRANSIENT . get_current_user_id();
        $skipped = get_transient($key);

        if (! is_array($skipped) || $skipped === []) {
            return;
        }

        delete_transient($key);

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
            esc_html(
                sprintf(
                    /* translators: %s: comma-separated list of product IDs. */
                    __('Bundle: these product IDs were not saved because they are variable products, which cannot be added to the cart until the shopper picks their options: %s. Link simple products instead.', 'plogins-bundle'),
                    implode(', ', array_map('absint', $skipped))
                )
            )
        );
    }
}
