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
 * Plugin Name:       Wbcom Designs - Ajax Filter For WooCommerce
 * Plugin URI:        https://wbcomdesigns.com/downloads/wbcom-ajax-filter-for-woocommerce/
 * Description:       Provide your customers with a smooth and responsive shopping experience. Filter products by attributes, categories, and more using real-time AJAX requests, no more waiting for page reloads.
 * Version:           1.2.2
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

if ( ! defined( 'WB_AJAX_FILTER_VERSION' ) ) {
	define( 'WB_AJAX_FILTER_VERSION', '1.2.2' );
}

if ( ! defined( 'WB_AJAX_FILTER_PLUGIN_URL' ) ) {
	define( 'WB_AJAX_FILTER_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'WB_AJAX_FILTER_PLUGIN_FILE' ) ) {
	define( 'WB_AJAX_FILTER_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'WB_AJAX_FILTER_PLUGIN_PATH' ) ) {
	define( 'WB_AJAX_FILTER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wb-ajax-filter-activator.php
 *
 * @since 1.0.0
 */
function activate_wb_ajax_filter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wb-ajax-filter-activator.php';
	Wb_Ajax_Filter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wb-ajax-filter-deactivator.php
 *
 * @since 1.0.0
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
 *
 * @since 1.0.0
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wb-ajax-filter.php';

if ( ! function_exists( 'wb_ajax_filter_check_woocomerce' ) ) {
	add_action( 'admin_init', 'wb_ajax_filter_check_woocomerce' );
	/**
	 * Function to check if woocommerce is installed and active.
	 *
	 * @since    1.0.0
	 */
	function wb_ajax_filter_check_woocomerce() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			add_action( 'admin_notices', 'wb_ajax_filter_admin_notice_error' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
		} else {
			run_wb_ajax_filter();
		}
	}
}

if ( ! function_exists( 'wb_ajax_filter_admin_notice_error' ) ) {
	/**
	 * Checks if woocommerce plugin is activated, else gives admin notice.
	 */
	function wb_ajax_filter_admin_notice_error() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			$class    = 'notice notice-error is-dismissible';
			$plugin   = 'Wbcom Ajax Filter for WooCommerce';
			$requires = 'WooCommerce';

			printf(
				'<div class="%1$s"><p><b>%2$s</b> requires %3$s plugin to be installed and active .</p></div>',
				esc_attr( $class ),
				esc_html( $plugin ),
				esc_html( $requires )
			);

			if ( null !== filter_input( INPUT_GET, 'activate' ) ) {
				unset( $_GET['activate'] );
			}
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

add_action( 'activated_plugin', 'wb_ajax_filter_activation_redirect_settings' );

/**
 * Redirect to plugin settings page after activated
 *
 * @param plugin $plugin plugin.
 */
function wb_ajax_filter_activation_redirect_settings( $plugin ) {
	if ( ! isset( $_GET['plugin'] ) ) { //phpcs:ignore
		return;
	}
	if ( plugin_basename( __FILE__ ) === $plugin && class_exists( 'WooCommerce' ) ) {
		if ( isset( $_REQUEST['action'] ) && 'activate' === $_REQUEST['action'] && isset( $_REQUEST['plugin'] ) && $_REQUEST['plugin'] === $plugin ) { //phpcs:ignore
			wp_redirect( admin_url( 'admin.php?page=wc-ajax-filter-settings' ) );
			exit;
		}
	}
}


add_action( 'plugins_loaded', 'wb_ajax_filter_initialize_plugin' );

/**
 * Function to initialize the plugin execution.
 *
 * @since 1.0.0
 */
function wb_ajax_filter_initialize_plugin() {
	if ( class_exists( 'WooCommerce' ) ) {
		run_wb_ajax_filter();
	} else {
		add_action( 'admin_notices', 'wb_ajax_filter_admin_notice_error' );
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
