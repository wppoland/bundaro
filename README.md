# Bundle – Product Bundles for WooCommerce

Bundle adds a "frequently bought together" box to your WooCommerce product pages. Link any number of products to a product, set an optional bundle discount, and let customers add the whole bundle to the cart in one click.

## Features

- Bundle box under the product summary listing the linked products, with an "Add bundle to cart" button that adds everything at once.
- Optional bundle discount applied as a single cart fee or a per-item price adjustment, with an optional savings line.
- `[bundle]` shortcode to place the box anywhere, optionally targeting a product with `[bundle id="123"]`.
- Editable, translatable box title, button label and discount-line label.
- Bundle definitions stored as product meta — no custom database tables.
- Lightweight, accessible, themeable markup that is dark-mode aware with no layout shift and no jQuery.

## Installation

1. Upload the plugin to `/wp-content/plugins/bundle`, or install it via Plugins → Add New.
2. Activate it. WooCommerce must be active.
3. Edit a product, open the "Bundle" tab, enter the bundled product IDs and an optional discount, then save.
4. Adjust global options under WooCommerce → Bundle.

## Frequently Asked Questions

**Does it require WooCommerce?**
Yes. WooCommerce must be installed and active.

**How is the discount applied?**
Choose between a single negative cart fee (one line in the cart) or a per-item price adjustment on each bundled product, set under WooCommerce → Bundle.

Built by WPPoland — https://plogins.com

License: GPL-2.0-or-later
