<?php

/**
 * The [bundle id="N"] shortcode must not render a draft, private or password
 * protected product, nor list such a product as a linked item. A contributor
 * could otherwise put the shortcode in a post and expose its name and price.
 *
 * Run: php tests/shortcode-visibility-check.php
 */

declare(strict_types=1);

namespace {
    define('ABSPATH', __DIR__);

    // Temp plugin dir: the real defaults plus a template that prints what it got.
    $dir = sys_get_temp_dir() . '/bundle-visibility-check-' . getmypid() . '/';
    @mkdir($dir . 'config', 0777, true);
    @mkdir($dir . 'templates/single-product', 0777, true);
    copy(__DIR__ . '/../config/defaults.php', $dir . 'config/defaults.php');
    file_put_contents(
        $dir . 'templates/single-product/bundle-box.php',
        '<?php echo $product->get_id() . ":" . implode(",", $bundle["items"]);',
    );
    define('BUNDLE_DIR', $dir);
    define('BUNDLE_URL', '');

    // id => status; 30 is published but password protected.
    $statuses  = [10 => 'publish', 11 => 'publish', 12 => 'private', 13 => 'draft', 20 => 'draft', 30 => 'publish'];
    $canRead   = false;

    function __(string $text, string $domain = 'default'): string { return $text; }
    function get_option(string $name, mixed $default = false): mixed { return $default; }
    function shortcode_atts(array $pairs, array $atts, string $tag = ''): array { return array_merge($pairs, $atts); }
    function absint(mixed $value): int { return abs((int) $value); }
    function get_the_ID(): int { return 0; }
    function get_post_status(int $id): string|false { return $GLOBALS['statuses'][$id] ?? false; }
    function post_password_required(int $id): bool { return 30 === $id; }
    function current_user_can(string $cap, mixed ...$args): bool { return $GLOBALS['canRead']; }
    function wp_create_nonce(string $action): string { return 'nonce'; }
    function add_query_arg(array $args, string $url): string { return $url; }

    class WC_Product
    {
        public function __construct(private int $id)
        {
        }

        public function get_id(): int
        {
            return $this->id;
        }

        public function get_permalink(): string
        {
            return '';
        }

        public function get_meta(string $key): mixed
        {
            return ['items' => [11, 12, 13], 'discount_percent' => 10];
        }
    }

    function wc_get_product(int $id): WC_Product
    {
        return new WC_Product($id);
    }

    require __DIR__ . '/../lib/storefront-kit/Bundle/ProductBundleEngine.php';
    require __DIR__ . '/../src/Contract/HasHooks.php';
    require __DIR__ . '/../src/Service/Texts.php';
    require __DIR__ . '/../src/Service/BundleService.php';

    $service = new \Bundle\Service\BundleService();
    $render  = static fn (int $id): string => $service->renderShortcode(['id' => (string) $id]);

    $cases = [
        // [product id, user can read it, expected output, what it proves]
        [10, false, '10:11', 'published product lists only its published item'],
        [20, false, '', 'draft product renders nothing for a visitor'],
        [12, false, '', 'private product renders nothing for a visitor'],
        [30, false, '', 'password protected product renders nothing for a visitor'],
        [20, true, '20:11,12,13', 'a user who can read the draft still sees it'],
    ];

    $failures = 0;
    foreach ($cases as [$id, $can, $expected, $label]) {
        $canRead = $can;
        $got     = $render($id);
        if ($got !== $expected) {
            echo "FAIL: {$label}: got '{$got}', expected '{$expected}'\n";
            $failures++;
        }
    }

    array_map('unlink', [$dir . 'config/defaults.php', $dir . 'templates/single-product/bundle-box.php']);

    echo 0 === $failures ? "OK: the bundle shortcode shows only products the visitor may see\n" : '';
    exit($failures > 0 ? 1 : 0);
}
