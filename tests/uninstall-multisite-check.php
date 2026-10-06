<?php

/**
 * Deleting the plugin on a network must clean every site, not only the one
 * the uninstall runs in. The user meta is global and is deleted once.
 *
 * Run: php tests/uninstall-multisite-check.php
 */

declare(strict_types=1);

define('WP_UNINSTALL_PLUGIN', 'fasko/fasko.php');

$blog    = 1;
$deleted = [];

function is_multisite(): bool { return true; }
function get_sites(array $args): array { return [1, 2, 3]; }
function switch_to_blog(int $id): void { $GLOBALS['blog'] = $id; }
function restore_current_blog(): void { $GLOBALS['blog'] = 1; }
function delete_option(string $name): void { $GLOBALS['deleted'][] = $GLOBALS['blog'] . ':' . $name; }
function delete_post_meta_by_key(string $key): void { $GLOBALS['deleted'][] = $GLOBALS['blog'] . ':meta:' . $key; }
function delete_metadata(string $type, int $id, string $key, string $value = '', bool $all = false): void { $GLOBALS['deleted'][] = 'user:' . $key; }

require __DIR__ . '/../uninstall.php';

$expected = ['user:bundle_pro_banner_dismissed'];
foreach ([1, 2, 3] as $site) {
    array_push($expected, "{$site}:bundle_settings", "{$site}:bundle_db_version", "{$site}:meta:_bundle_definition");
}
sort($expected);
sort($deleted);

if ($deleted !== $expected) {
    echo 'FAIL: uninstall deleted ' . implode(', ', $deleted) . "\n";
    exit(1);
}

echo "OK: uninstall cleans every site of the network\n";
