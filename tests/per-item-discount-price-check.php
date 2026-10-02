<?php

/**
 * In per-item mode the bundle discount must be on each line's product object
 * as soon as the line exists, so every renderer sees it.
 *
 * It used to be set in woocommerce_before_calculate_totals behind a
 * did_action() > 1 guard: the mini cart and the cart fragments, which render
 * without recalculating, listed the base price, and a companion added after
 * the first totals pass was never discounted at all.
 *
 * Run: php tests/per-item-discount-price-check.php
 */

declare(strict_types=1);

namespace {
    define('ABSPATH', __DIR__);

    $filters = [];

    function add_filter(string $hook, mixed $cb, int $priority = 10, int $args = 1): void
    {
        $GLOBALS['filters'][$hook] = $cb;
    }

    function add_action(string $hook, mixed $cb, int $priority = 10, int $args = 1): void
    {
        $GLOBALS['filters'][$hook] = $cb;
    }

    function apply_filters(string $hook, mixed $value, mixed ...$args): mixed
    {
        return $value;
    }

    function absint(mixed $value): int
    {
        return abs((int) $value);
    }

    class WC_Product
    {
        public function __construct(private int $id, private string $price)
        {
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
    }

    function wc_get_product(int $id): WC_Product
    {
        return new WC_Product($id, '100');
    }

    require __DIR__ . '/../lib/storefront-kit/Bundle/ProductBundleEngine.php';

    $mode   = 'per_item';
    $engine = new \WPPoland\StorefrontKit\Bundle\ProductBundleEngine(
        'bundle_add',
        'bundle_add_bundle',
        '_bundle_parent',
        '',
        [],
        static fn (): bool => true,
        static function () use (&$mode): array {
            return ['discount_mode' => $mode];
        },
        static fn ($product): array => ['items' => [11], 'discount_percent' => 20],
        static function (string $template, array $args): void {
        },
    );
    $engine->registerHooks();

    $line = static fn (): array => ['data' => new WC_Product(11, '10'), '_bundle_parent' => 10];

    $failures = 0;
    foreach (['woocommerce_add_cart_item', 'woocommerce_get_cart_item_from_session'] as $hook) {
        if (! isset($filters[$hook])) {
            echo "FAIL: nothing prices the line on {$hook}\n";
            $failures++;
            continue;
        }
        $item = call_user_func($filters[$hook], $line());
        if (8.0 !== (float) $item['data']->get_price()) {
            echo "FAIL: {$hook} left the line at {$item['data']->get_price()}, expected 8\n";
            $failures++;
        }
    }

    $mode = 'fee';
    if (isset($filters['woocommerce_add_cart_item']) && '10' !== call_user_func($filters['woocommerce_add_cart_item'], $line())['data']->get_price()) {
        echo "FAIL: fee mode also discounted the line price\n";
        $failures++;
    }

    echo 0 === $failures ? "OK: per-item bundle discount is on the line from the start\n" : '';
    exit($failures > 0 ? 1 : 0);
}
