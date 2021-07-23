<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wbcom_Ajax_Filter_For_Woocommerce
 * @subpackage Wbcom_Ajax_Filter_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wbcom_Ajax_Filter_For_Woocommerce
 * @subpackage Wbcom_Ajax_Filter_For_Woocommerce/includes
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Wbcom_Ajax_Filter_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wbcom_Ajax_Filter_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public function __construct() {
		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		} // Exit if accessed directly

		// define required constants.

		! defined( 'YITH_WCAN' ) && define( 'YITH_WCAN', true );
		! defined( 'YITH_WCAN_URL' ) && define( 'YITH_WCAN_URL', plugin_dir_url( __FILE__ ) );
		! defined( 'YITH_WCAN_DIR' ) && define( 'YITH_WCAN_DIR', plugin_dir_path( __FILE__ ) );
		! defined( 'YITH_WCAN_INC' ) && define( 'YITH_WCAN_INC', YITH_WCAN_DIR . 'includes/' );
		! defined( 'YITH_WCAN_VERSION' ) && define( 'YITH_WCAN_VERSION', '4.0.4' );
		! defined( 'YITH_WCAN_DB_VERSION' ) && define( 'YITH_WCAN_DB_VERSION', '4.0.0' );
		! defined( 'YITH_WCAN_PREMIUM' ) && define( 'YITH_WCAN_PREMIUM', true );
		! defined( 'YITH_WCAN_FILE' ) && define( 'YITH_WCAN_FILE', __FILE__ );
		! defined( 'YITH_WCAN_SLUG' ) && define( 'YITH_WCAN_SLUG', 'yith-woocommerce-ajax-navigation' );
		! defined( 'YITH_WCAN_SECRET_KEY' ) && define( 'YITH_WCAN_SECRET_KEY', 'VsQ4mRdupNhzcONEx1mj' );
		! defined( 'YITH_WCAN_INIT' ) && define( 'YITH_WCAN_INIT', plugin_basename( __FILE__ ) );

		define('plugin_url',plugins_url() . '/wbcom-ajax-filter-for-woocommerce/');
		if ( defined( 'WBCOM_AJAX_FILTER_FOR_WOOCOMMERCE_VERSION' ) ) {
			$this->version = WBCOM_AJAX_FILTER_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wbcom-ajax-filter-for-woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		// load plugin framework.
		yith_wcan_install_plugin_framework();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wbcom_Ajax_Filter_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Wbcom_Ajax_Filter_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Wbcom_Ajax_Filter_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Wbcom_Ajax_Filter_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wbcom-ajax-filter-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wbcom-ajax-filter-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wbcom-ajax-filter-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wbcom-ajax-filter-for-woocommerce-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-admin-settings.php';

		$this->loader = new Wbcom_Ajax_Filter_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wbcom_Ajax_Filter_For_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wbcom_Ajax_Filter_For_Woocommerce_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wbcom_Ajax_Filter_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Load setting in woocommerce setting tab.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpc_admin_menu', 100 );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wpc_add_admin_register_setting' );
		// install plugin.
		add_action( 'plugins_loaded', 'yith_wcan_install', 11 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wbcom_Ajax_Filter_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wbcom_Ajax_Filter_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
// define required functions.

	if ( !function_exists( 'yith_wcan_install' ) ) {
		/**
		 * Installs plugin and start the processing
		 *
		 * @return void
		 *
		 * @since 4.0
		 * @author Antonio La Rocca <antonio.larocca@yithemes.com>
		 */
		function yith_wcan_install() {

			if ( ! function_exists( 'WC' ) ) {
				add_action( 'admin_notices', 'yith_wcan_install_woocommerce_admin_notice' );
			} else {
				/**
				 * Instance main plugin class
				 */
				global $yith_wcan;

				// deactivate free version.
				yith_wcan_deactivate_free_version();

				// load plugin text domain.
				load_plugin_textdomain( 'yith-woocommerce-ajax-navigation', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

				$yith_wcan = yith_wcan_initialize();
			}
		}
	}

if ( ! function_exists( 'yith_wcan_initialize' ) ) {
	/**
	 * Unique access to instance of YITH_Vendors class.
	 *
	 * @return YITH_WCAN|YITH_WCAN_Premium
	 * @since 1.0.0
	 */
	function yith_wcan_initialize() {
		// Load required classes and functions.
		require_once( YITH_WCAN_INC . 'class.yith-wcan.php' );

		if ( defined( 'YITH_WCAN_PREMIUM' ) && file_exists( YITH_WCAN_DIR . 'includes/class.yith-wcan-premium.php' ) ) {
			require_once( YITH_WCAN_INC . 'class.yith-wcan-premium.php' );
			return YITH_WCAN_Premium();
		}

		return YITH_WCAN();
	}
}

if ( ! function_exists( 'yith_wcan_install_plugin_framework' ) ) {
	/**
	 * Performs check over plugin framework, and maybe loads it
	 *
	 * @return void
	 *
	 * @since 4.0
	 * @author Antonio La Rocca <antonio.larocca@yithemes.com>
	 */
	function yith_wcan_install_plugin_framework() {
		// plugin framework version check.
		if ( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YITH_WCAN_DIR . 'plugin-fw/init.php' ) ) {
			require_once( YITH_WCAN_DIR . 'plugin-fw/init.php' );
		}
		yit_maybe_plugin_fw_loader( YITH_WCAN_DIR );
	}
}

if ( ! function_exists( 'yith_wcan_deactivate_free_version' ) ) {
	/**
	 * Deactivate free version, when premium version is installed
	 *
	 * @return void
	 *
	 * @since 4.0
	 * @author Antonio La Rocca <antonio.larocca@yithemes.com>
	 */
	function yith_wcan_deactivate_free_version() {
		if ( ! function_exists( 'yit_deactive_free_version' ) ) {
			require_once( 'plugin-fw/yit-deactive-plugin.php' );
		}

		yit_deactive_free_version( 'YITH_WCAN_FREE_INIT', plugin_basename( __FILE__ ) );
	}
}

if ( ! function_exists( 'yith_wcan_install_woocommerce_admin_notice' ) ) {
	/**
	 * Print an admin notice if woocommerce is deactivated
	 *
	 * @return void
	 *
	 * @author Andrea Grillo <andrea.grillo@yithemes.com>
	 * @since 1.0
	 * @use admin_notices hooks
	 */
	function yith_wcan_install_woocommerce_admin_notice() { ?>
		<div class="error">
			<p><?php echo esc_html_x( 'YITH WooCommerce Ajax Product Filter is enabled but not effective. It requires WooCommerce in order to work.', '[Plugin Name]', 'yith-woocommerce-ajax-navigation' ); ?></p>
		</div>
		<?php
	}
}