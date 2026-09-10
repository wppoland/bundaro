<?php
/**
 * Uninstall cleanup for Bundle, Product Bundles for WooCommerce.
 *
 * Runs only when the plugin is deleted from the Plugins screen. Removes the
 * settings option, the migration version marker and every per-product bundle
 * definition meta row. No custom tables are created, so none are dropped.
 *
 * @package Bundle
 */

declare(strict_types=1);

defined('WP_UNINSTALL_PLUGIN') || exit;

// Settings + migration marker.
delete_option('bundle_settings');
delete_option('bundle_db_version');

// The PRO banner's dismissal is stored per user, so it belongs to the
// plugin rather than to the site content. User meta is global, not
// per-site, which is why this uses delete_metadata's \$delete_all rather
// than a loop over the users of one blog.
delete_metadata('user', 0, 'bundle_pro_banner_dismissed', '', true);

// Per-product bundle definitions, stored as the `_bundle_definition` post meta.
// delete_post_meta_by_key() removes every row for the key in one call; this is
// the canonical WP helper, so no direct $wpdb query is needed.
if (function_exists('delete_post_meta_by_key')) {
    delete_post_meta_by_key('_bundle_definition');
}
