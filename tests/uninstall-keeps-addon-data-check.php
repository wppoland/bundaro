<?php

/**
 * Deleting Bundaro must not wipe bundle definitions an add-on also builds in
 * the `_bundle_definition` product meta while that add-on is on disk. Whichever
 * plugin is deleted last removes the meta.
 *
 * Core's bulk delete runs both uninstalls in one request and caches the plugin
 * list, so the check also covers a cache that still lists an add-on whose files
 * are already gone.
 *
 * Run: php tests/uninstall-keeps-addon-data-check.php
 */

declare(strict_types=1);

define('ABSPATH', sys_get_temp_dir() . '/');
define('WP_UNINSTALL_PLUGIN', 'bundaro/bundaro.php');

$deleted = [];
$disk    = [];
$cache   = null;

function is_multisite(): bool
{
    return false;
}
function wp_cache_delete(string $key, string $group): bool
{
    if ('plugins' === $key && 'plugins' === $group) {
        $GLOBALS['cache'] = null;
    }

    return true;
}
function get_plugins(): array
{
    return $GLOBALS['cache'] ?? $GLOBALS['disk'];
}
function delete_option(string $name): bool
{
    $GLOBALS['deleted'][] = $name;

    return true;
}
function delete_post_meta_by_key(string $key): bool
{
    $GLOBALS['deleted'][] = 'meta:' . $key;

    return true;
}
function delete_metadata(string $type, int $id, string $key, string $value = '', bool $all = false): bool
{
    $GLOBALS['deleted'][] = $type . ':' . $key;

    return true;
}

/**
 * uninstall.php declares a function, so each case runs in its own process.
 *
 * @return list<string>
 */
function run_uninstall(array $disk, ?array $cache): array
{
    $cmd = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__FILE__) . ' '
        . escapeshellarg((string) json_encode([$disk, $cache]));

    return (array) json_decode((string) shell_exec($cmd), true);
}

if (isset($argv[1])) {
    [$disk, $cache] = json_decode($argv[1], true);
    include dirname(__DIR__) . '/uninstall.php';
    sort($deleted);
    echo json_encode($deleted);
    exit(0);
}

$free  = ['bundaro/bundaro.php' => ['TextDomain' => 'bundaro']];
$addon = ['any-folder/bundaro-pro.php' => ['TextDomain' => 'bundaro-pro']];

$all  = ['bundle_db_version', 'bundle_settings', 'meta:_bundle_definition', 'user:bundle_pro_banner_dismissed'];
$kept = ['bundle_db_version', 'bundle_settings', 'user:bundle_pro_banner_dismissed'];

$cases = [
    'add-on on disk keeps _bundle_definition'         => [run_uninstall($free + $addon, null), $kept],
    'no add-on deletes everything'                    => [run_uninstall($free, null), $all],
    'stale cache listing a deleted add-on is ignored' => [run_uninstall($free, $free + $addon), $all],
];

$failed = false;
foreach ($cases as $name => [$got, $want]) {
    if ($got !== $want) {
        $failed = true;
        fwrite(STDERR, "FAIL: {$name}: deleted " . implode(', ', $got) . "\n");
    }
}
if ($failed) {
    exit(1);
}

echo "OK: uninstall keeps _bundle_definition only while an add-on is on disk\n";
