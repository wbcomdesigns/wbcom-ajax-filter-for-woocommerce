<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wbcomdesigns.com/
 * @since             1.0.0
 * @package           Wb_Ajax_Filter
 *
 * @wordpress-plugin
 * Plugin Name:       Wbcom Ajax Filter For WooCommerce
 * Plugin URI:        wb-ajax-filter
 * Description:       Wbcom Ajax Filter For WooCommerce allows your users to find the product they are looking for as quickly as possible.
 * Version:           1.0.0
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wb-ajax-filter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WB_AJAX_FILTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wb-ajax-filter-activator.php
 */
function activate_wb_ajax_filter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wb-ajax-filter-activator.php';
	Wb_Ajax_Filter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wb-ajax-filter-deactivator.php
 */
function deactivate_wb_ajax_filter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wb-ajax-filter-deactivator.php';
	Wb_Ajax_Filter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wb_ajax_filter' );
register_deactivation_hook( __FILE__, 'deactivate_wb_ajax_filter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wb-ajax-filter.php';

if ( ! function_exists( 'wb_ajax_filter_check_woocomerce' ) ) {
	add_action( 'admin_init', 'wb_ajax_filter_check_woocomerce' );
	/**
	 * Function check for woocommerce is installed and activate.
	 *
	 * @since    1.0.0
	 */
	function wb_ajax_filter_check_woocomerce() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			add_action( 'admin_notices', 'wb_ajax_filter_admin_notice__error' );
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}
}

if ( ! function_exists( 'wb_ajax_filter_admin_notice__error' ) ) {
	/**
	 * Checks if woocommerce plugin is activated, else gives admin notice.
	 */
	function wb_ajax_filter_admin_notice__error() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			$class    = 'notice notice-error is-dismissible';
			$plugin   = 'Wbcom Ajax Filter for WooCommerce';
			$requires = 'requires Woocommerce plugin to be activated.';
			printf( '<div class="%1$s"><p><b>%2$s</b> %3$s</p></div>', esc_attr( $class ), esc_html( $plugin ), esc_html( $requires ) );
		}
	}
}

if ( ! function_exists( 'wb_ajax_filter_add_settings_link' ) ) {
	add_filter( 'plugin_action_links', 'wb_ajax_filter_add_settings_link', 10, 2 );
	/**
	 * Add setttings column to plugin options.
	 *
	 * @param links_array      $links_array      The links array.
	 * @param plugin_file_name $plugin_file_name The plugin file name.
	 */
	function wb_ajax_filter_add_settings_link( $links_array, $plugin_file_name ) {
		if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
			$settings                = '<a href="admin.php?page=wc-ajax-filter-settings" id="setting-wbcom-ajax-filter-for-woocommerce">Settings</a>';
			$links_array['settings'] = $settings;
		}
		return $links_array;
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wb_ajax_filter() {

	$plugin = new Wb_Ajax_Filter();
	$plugin->run();

}
run_wb_ajax_filter();
