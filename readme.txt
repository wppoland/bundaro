=== Plogins Bundle - Product Bundles for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, product bundles, frequently bought together, bundle discount, upsell
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 8.1
Stable tag: 1.0.8
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sell product bundles and frequently bought together offers with an optional WooCommerce bundle discount.

== Description ==

Bundle adds a "frequently bought together" product bundle box to your WooCommerce product pages. Link any number of products to a product, set an optional bundle discount, and let customers add the whole product set to the cart in one click.

* A bundle box under the product summary that lists the bundled products.
* "Add bundle to cart" adds the main product plus every linked item at once.
* Optional bundle discount, applied either as a single cart fee or as a per-item price adjustment.
* An optional savings line that shows the bundle total and the amount saved.
* A `[bundle]` shortcode to place the bundle box anywhere, use `[bundle id="123"]` to target a specific product.
* Editable box title, button label and discount-line label, all translatable.
* Bundle definitions are stored as product meta, no custom database tables.
* Clean uninstall: removes its options and bundle definitions when deleted.
* One small stylesheet, no JavaScript on the storefront and no jQuery. Images reserve their space so the box does not shift the layout as it loads, and it follows the visitor's dark-mode preference.
* A "?" help bubble on every setting, reachable by keyboard, plus the box hides itself when a product has no bundle left to show.

Configure global behaviour under WooCommerce → Bundle. Link products and set the discount per product in the product editor's "Bundle" tab. Turn off "Show on product page" to render the box only where you drop the `[bundle]` shortcode.

The plugin is developed in the open. Code, bug reports and patches live at [github.com/wppoland/plogins-bundle](https://github.com/wppoland/plogins-bundle).

== Installation ==

1. Upload the plugin to `/wp-content/plugins/bundle`, or install via Plugins → Add New.
2. Activate it. WooCommerce must be active.
3. Edit a product, open the "Bundle" tab, enter the bundled product IDs and an optional discount, then save.
4. Adjust global options under WooCommerce → Bundle.

== Frequently Asked Questions ==

= Documentation and links =

* **Documentation**: [plogins.com/plogins-bundle/docs/](https://plogins.com/plogins-bundle/docs/)
* **Plugin page**: [plogins.com/plogins-bundle/](https://plogins.com/plogins-bundle/)
* **Source code**: [github.com/wppoland/plogins-bundle](https://github.com/wppoland/plogins-bundle)
* **Bug reports and feature requests**: [github.com/wppoland/plogins-bundle/issues](https://github.com/wppoland/plogins-bundle/issues)


= Does it require WooCommerce? =

Yes. WooCommerce must be installed and active.

= How is the discount applied? =

Choose between a single negative cart fee (one line in the cart) or a per-item price adjustment on each bundled product. Set this under WooCommerce → Bundle.

= Can a bundle include a discount? =

Yes. Set an optional percentage discount per product bundle. Bundle can show the bundle total and savings line before add to cart.

= Does the bundle add all products to the cart? =

Yes. The "Add bundle to cart" button adds the main product and linked products together.

= Does it create custom database tables? =

No. Bundle definitions are stored as product meta.

= Can I place the bundle box somewhere other than under the product summary? =

Yes. Use the `[bundle]` shortcode anywhere the current product is known, or `[bundle id="123"]` to render a specific product's bundle. Turn off "Show on product page" under WooCommerce → Bundle to use the shortcode only.

= Does Bundle use JavaScript on the storefront? =

No. The free bundle box is server-rendered with one small stylesheet and no storefront JavaScript.


= Does this plugin work on WordPress Multisite? =

Yes. This plugin is compatible with WordPress Multisite. Network activate it or activate it on individual sites; each site keeps its own settings and data.

== Screenshots ==

1. On the storefront.
2. Settings in the WordPress admin.
3. On a mobile device.
== External Services ==

Bundle does not connect to any external services. It makes no remote API calls and sends no data off your site. Its only stylesheet and admin script are served from your own WordPress install (`assets/css/bundle.css`, `assets/css/admin.css` and `assets/js/admin.js`), with no third-party fonts, CDNs or analytics. All data stays in your database: global options in `bundle_settings` and `bundle_db_version`, and each product's bundle in the `_bundle_definition` post meta. The plugin sends no email.

== Translations ==

Plogins Bundle is fully translatable and ships the `plogins-bundle.pot` template. Translations are delivered by WordPress.org language packs from translate.wordpress.org, which is where Polish, German and Spanish are being contributed; the package itself carries no compiled translation files.

== Changelog ==

= 1.0.8 =
* Renamed to Plogins Bundle - Product Bundles for WooCommerce so the name leads with the brand rather than a generic word, which is what the WordPress.org plugin review team asks for. The plugin slug is unchanged.

= 1.0.7 =
* Tested against WordPress 7.1. Verified by activating this build on a clean 7.1 install with WooCommerce 11.1, not by editing the header.

= 1.0.6 =
* Fixed the PRO promo on the settings screen quoting a price in PLN. PRO is priced and charged in EUR, so an admin on a Polish site was shown a zloty amount and then billed in euro, and the zloty figure was a fixed conversion that drifted from the real charge as the rate moved. The promo now shows the euro price that is actually taken.

= 1.0.5 =
* Clearing the box title, the button label or the discount line label now really restores the packaged default, instead of quietly bringing your previous wording back.
* Bundles are offered on simple products only. A variable product cannot reach the cart until the shopper picks its options, so the "Bundle" tab no longer shows on variable products and the box no longer renders on them.
* Putting a variable product ID in the bundled list is refused when you save, with a notice naming the dropped IDs, instead of leaving shoppers with a cart missing those products.

= 1.0.3 =
* Translations: completed Polish, German and Spanish for the PRO upgrade panel.

= 1.0.2 =
* Added bundled Polish, German and Spanish translations for the plugin interface.

= 1.0.1 =
* First stable release.

= 0.2.1 =
* Renamed to Plogins Bundle for WooCommerce for a more distinctive plugin name.

= 0.2.0 =
* Settings page laid out as cards, with a "?" help bubble explaining each option.
* Storefront box restyled: fluid sizing, dark-mode support, reserved image space so it does not shift the layout, and a savings line that spells out the amount saved.
* Accessibility: keyboard-operable help bubbles, visible focus styles and reduced-motion support.
* Deleted or missing bundled products are skipped, and the box hides itself when nothing is left to bundle.
* New: `[bundle]` shortcode to render the bundle box anywhere, with an optional `id` attribute to target a specific product.
* New: "Show savings" option that displays the bundle total and the amount saved on the box.
* New: the admin-saved box title, button label and discount-line label are now used by the bundle box (previously the box ignored them).
* New: clean uninstall removes the plugin's options and all stored bundle definitions.
* I18n: regenerated the translation template with the new strings.

= 0.1.0 =
* Initial release.
