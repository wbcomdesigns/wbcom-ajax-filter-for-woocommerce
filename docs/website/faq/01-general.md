# General FAQ

## What is the Wbcom Ajax Filter for WooCommerce?

It's a WordPress plugin that adds AJAX product filtering to WooCommerce shops. Shoppers narrow results by category, attribute, price, rating, and stock status without a page reload, and the store owner controls the filters through reusable presets saved in the plugin's own dashboard area.

## Do I need WooCommerce?

Yes. WooCommerce is a hard requirement. If WooCommerce is not active, the plugin deactivates itself and shows an admin notice.

## Is there a free version?

The plugin is a single-tier product from Wbcom Designs - there is no separate "Pro" edition with a different set of features. It is licensed through the **License** tab inside the settings. A valid licence keeps the plugin updateable; one licence per site.

## Does it work with block themes?

Yes. On classic themes, filters render automatically on the shop and category/tag archives. On block themes - which usually do not fire the classic archive hooks - place the **Ajax Product Filters** block or the `[wb_ajax_filters]` shortcode where you want the filters to appear.

## Can I override the templates?

Yes. Copy any file from the plugin's `templates/` directory into your theme under `wb-ajax-filter/`, keeping the same relative path. Your copies survive plugin updates. See [Theme Overrides](../frontend-display/04-theme-overrides.md).

## Does it support RTL stores?

Yes. Public and admin stylesheets ship RTL versions, and the markup follows WordPress bidirectional text conventions.

## Does it follow the theme's look?

Yes. The frontend reads the theme's colour tokens (BuddyX and Reign vocabularies, plus theme.json presets) through CSS custom properties, so it follows the store's accent and dark mode rather than repainting it.

## Next Steps

- [Installation](../getting-started/02-installation.md)
- [Quick Start](../getting-started/03-quick-start.md)
- [Common Issues](../troubleshooting/01-common-issues.md)