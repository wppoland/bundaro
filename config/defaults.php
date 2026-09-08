<?php
/**
 * Default settings, merged under the option key `bundle_settings`.
 *
 * The feature ships enabled. The merchant tunes the bundle box title, the
 * add-to-cart button label and how the discount is applied (`fee` adds a single
 * negative cart fee; `per_item` lowers the price of each bundled line). All
 * bundle logic lives in the storefront-kit ProductBundleEngine; these values are
 * passed through to it as the resolved settings.
 *
 * @package Bundle
 *
 * @return array<string, mixed>
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

return [
    'enabled' => true,

    // Where the bundle box renders.
    'show_on_single' => true,

    // How the bundle discount is applied: `fee` | `per_item`.
    'discount_mode' => 'fee',

    // Bundle box chrome. Every customer-facing string below is empty on
    // purpose. A literal here is not a gettext call, so it never reaches the
    // .pot and no translator can touch it, and the first time a merchant saves
    // the settings form the English wording is frozen into `bundle_settings`
    // where no language pack can reach it either. Empty means "use
    // Bundle\Service\Texts", which is translated; anything a merchant types
    // still wins.
    'box_title'       => '',
    'add_label'       => '',
    'fee_label'       => '',
    'add_failed_text' => '',

    // Whether the box lists the individual bundled items with thumbnails.
    'show_items' => true,

    // Whether the box shows the bundle total and the money saved (percentage mode).
    'show_savings' => true,
];
