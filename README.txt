=== Wbcom Designs - Ajax filter for WooCommerce ===
Contributors: wbcomdesigns
Donate link: https://wbcomdesigns.com/contact/
Tags: WooCommerce plugin Addon
Requires at least: 4.0
Tested up to: 6.9
Stable tag: 1.2.2
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
