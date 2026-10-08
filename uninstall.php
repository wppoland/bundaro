<?php
/**
 * Uninstall cleanup for Bundle, Product Bundles for WooCommerce.
 *
 * Runs only when the plugin is deleted from the Plugins screen. Removes the
 * settings option, the migration version marker and every per-product bundle
 * definition meta row, on every site of a network. No custom tables are
 * created, so none are dropped.
 *
 * @package Bundle
 */

declare(strict_types=1);

defined('WP_UNINSTALL_PLUGIN') || exit;

function bundle_uninstall_cleanup(): void
{
    // Settings + migration marker.
    delete_option('bundle_settings');
    delete_option('bundle_db_version');

    // Per-product bundle definitions, stored as the `_bundle_definition` post
    // meta. delete_post_meta_by_key() removes every row for the key in one
    // call; this is the canonical WP helper, so no direct $wpdb query is needed.
    delete_post_meta_by_key('_bundle_definition');
}

// Options and post meta are per site, so a network uninstall has to visit
// every site.
if (is_multisite()) {
    $bundle_site_ids = get_sites(['fields' => 'ids', 'number' => 0]);

    foreach ($bundle_site_ids as $bundle_site_id) {
        switch_to_blog((int) $bundle_site_id);
        bundle_uninstall_cleanup();
        restore_current_blog();
    }

    unset($bundle_site_ids, $bundle_site_id);
} else {
    bundle_uninstall_cleanup();
}

// The PRO banner's dismissal is stored per user, so it belongs to the
// plugin rather than to the site content. User meta is global, not
// per-site, which is why this uses delete_metadata's \$delete_all rather
// than a loop over the users of one blog.
delete_metadata('user', 0, 'bundle_pro_banner_dismissed', '', true);
