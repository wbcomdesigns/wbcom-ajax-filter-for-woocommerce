=== Wbcom Designs - Ajax filter for WooCommerce ===
Contributors: wbcomdesigns
Donate link: https://wbcomdesigns.com/contact/
Tags: WooCommerce plugin Addon
Requires at least: 4.0
Tested up to: 6.9
Stable tag: 1.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Wbcom Ajax Filter for WooCommerce Plugin allows your users to find the product they are looking for as quickly as possible.

== Installation ==

1. Upload `wbcom-ajax-filter-for-woocommerce` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Does this plugin requires any other plugin? =
Yes. This plugin requires WooCommerce plugin to be active.

= How do I place the filters on a block theme? =
Add the "Ajax Product Filters" block anywhere - a page, the shop template, or any block-theme template area. The block has a preset picker in its sidebar. On classic themes the filters also render automatically on WooCommerce shop, category, and tag archives.

= Is there a shortcode? =
Yes. Use [wb_ajax_filters] to render every enabled preset, or [wb_ajax_filters slug="your-preset-slug"] for one preset. The block, the shortcode, and the automatic archive placement all render the same output.

= Can my theme override the plugin templates? =
Yes. Copy any file from the plugin's templates/ directory into yourtheme/wb-ajax-filter/ keeping the same relative path - for example yourtheme/wb-ajax-filter/filters/filter-tax.php or yourtheme/wb-ajax-filter/public/search-form.php. Templates load through wc_get_template, so plugin updates never overwrite your copies. Flat-path copies made before 1.2.2 (yourtheme/wb-ajax-filter/filter-tax.php, yourtheme/wb-ajax-filter/search-form.php) keep working. If you override filters/filter-tax/items/checkbox.php or radio.php, copy term-children.php alongside them.

== Changelog ==
= 1.3.0 - August 2026 =

Closes the four gaps every store owner and developer expects - a block, an admin screen for stored data, a REST API and a test-ready shell - alongside a security fix and a full accessibility pass.

* New      - Gutenberg block renders the filter in block themes and the site editor through the same shortcode seam, with a preset picker in the sidebar.
* New      - Stored Data admin screen lists, moderates and exports saved presets (JSON and CSV) so support never needs phpMyAdmin.
* New      - REST API at wb-ajax-filter/v1/presets reaches headless and mobile clients, every route gated by manage_woocommerce with a schema.
* New      - Overview screen opens the settings on what the filter is doing right now: active presets, live fields and the archives it renders on.
* New      - Theme-overridable templates load through wc_get_template, so copies in yourtheme/wb-ajax-filter/ survive plugin updates.
* Improve  - Filter components follow the active theme (BuddyX, Reign or any block theme) through --wb-* custom properties, dark mode included.
* Improve  - Fresh installs ship an enabled Default preset so the filter works immediately with no configuration.
* Improve  - Mobile filter collapses behind one Filters toggle below 640px so products stay above the fold, and active-filter chips show human labels.
* Improve  - Admin panel rebuilt on the shared settings shell with a version pill, dependency state and a tab registry.
* Improve  - Accessibility pass: keyboard-reachable controls, visible focus rings, RTL-correct spacing, and inline SVG icons that render for logged-out shoppers.
* Fix      - Search autocomplete now works for logged-out shoppers through a public, nonce-verified endpoint.
* Fix      - Native browser alert() and confirm() dialogs replaced with an accessible, localized in-page dialog.
* Security - Close an authentication bypass in preset create, delete and duplicate handlers; every admin action passes one fail-closed capability gate.

= 1.2.0 =
* Fix - Fixed error message show on save options
* Fix - Updated admin wrapper
* Fix - (#33) - Fixed options style option is not saving issue
* Fix - (#40) - Fixed placeholder value
* Fix - (#36) - Fixed shortcode save issue when we insert in a page
* Fix - (#35) - Fixed button and text is visible when we uncheck the search
* Fix - (#32) - Updated wbcom wrapper
* Fix - (#29) - Added plugin redirection to welcome tab on activation

= 1.0.0 =
* Initial Release
