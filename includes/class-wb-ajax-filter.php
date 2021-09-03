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
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
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
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
 * @author     Wbcom Designs <https://wbcomdesigns.com/>
 */
class Wb_Ajax_Filter {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wb_Ajax_Filter_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'WB_AJAX_FILTER_VERSION' ) ) {
			$this->version = WB_AJAX_FILTER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wb-ajax-filter';
		$this->define_constants();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Define plugin constants that are use entire plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_constants() {
		$this->define( 'WB_AJAX_FILTER', __FILE__ );
		$this->define( 'WB_AJAX_FILTER_URL', plugin_dir_url( dirname( __FILE__ ) ) );
		$this->define( 'WB_AJAX_FILTER_PATH', plugin_dir_path( dirname( __FILE__ ) ) );
		$this->define( 'WB_AJAX_FILTER_TEMPLATE_PATH', plugin_dir_path( dirname( __FILE__ ) ) . '/templates/' );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wb_Ajax_Filter_Loader. Orchestrates the hooks of the plugin.
	 * - Wb_Ajax_Filter_i18n. Defines internationalization functionality.
	 * - Wb_Ajax_Filter_Admin. Defines all hooks for the admin area.
	 * - Wb_Ajax_Filter_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wb-ajax-filter-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wb-ajax-filter-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wb-ajax-filter-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom/wbcom-admin-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wb-ajax-filter-public.php';

		$this->loader = new Wb_Ajax_Filter_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wb_Ajax_Filter_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wb_Ajax_Filter_i18n();

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

		$plugin_admin = new Wb_Ajax_Filter_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 999 );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wb_ajax_filter_add_admin_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wb_ajax_filter_init_plugin_settings' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'wb_ajax_filter_add_modal_to_admin_footer' );
		// Ajax callbacks.
		$this->loader->add_action( 'wp_ajax_load_create_filter_template_wb', $plugin_admin, 'load_create_filter_template_wb_callback' );
		$this->loader->add_action( 'wp_ajax_create_filter_preset_wb', $plugin_admin, 'create_filter_preset_wb_callback' );
		$this->loader->add_action( 'wp_ajax_check_filter_preset_title_wb', $plugin_admin, 'check_filter_preset_title_wb_callback' );
		$this->loader->add_action( 'wp_ajax_duplicate_filter_preset_wb', $plugin_admin, 'duplicate_filter_preset_wb_callback' );
		$this->loader->add_action( 'wp_ajax_delete_filter_preset_wb', $plugin_admin, 'delete_filter_preset_wb_callback' );
		$this->loader->add_action( 'wp_ajax_duplicate_single_filter_wb', $plugin_admin, 'duplicate_single_filter_wb_callback' );
		$this->loader->add_action( 'wp_ajax_delete_single_filter_wb', $plugin_admin, 'delete_single_filter_wb_callback' );
		$this->loader->add_action( 'wp_ajax_enable_disable_filter_preset_wb', $plugin_admin, 'enable_disable_filter_preset_wb_callback' );
		$this->loader->add_action( 'wp_ajax_select2_get_terms_wb', $plugin_admin, 'select2_get_terms_wb_callback' );
		$this->loader->add_action( 'wp_ajax_add_price_range_field_wb', $plugin_admin, 'add_price_range_field_wb_callback' );
		$this->loader->add_action( 'wp_ajax_enable_disable_single_filter_wb', $plugin_admin, 'enable_disable_single_filter_wb_callback' );
		$this->loader->add_action( 'wp_ajax_edit_preset_post_title_wb', $plugin_admin, 'edit_preset_post_title_wb_callback' );
		$this->loader->add_action( 'wp_ajax_customize_term_text_wb', $plugin_admin, 'customize_term_text_wb_callback' );
		$this->loader->add_action( 'wp_ajax_sortable_single_filters_wb', $plugin_admin, 'sortable_single_filters_wb_callback' );

		// Hook callback.
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_name_field', 10 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_for_field', 20 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_tax_field', 30 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_price_slider_field', 40 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_order_by_field', 50 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_price_range_field', 60 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_stock_field', 70 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_toggle_field', 80 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_count_field', 90 );
		$this->loader->add_action( 'wb_ajax_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_adoptive_filtering_field', 100 );
		$this->loader->add_action( 'wb_ajax_filter_after_filter_fields', $plugin_admin, 'wb_ajax_filter_create_filter_save_button', 10 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wb_Ajax_Filter_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_after_shop_loop', $plugin_public, 'add_wb_ajax_filters' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'add_wb_ajax_filters_loader_in_footer' );
		// Ajax callback.
		$this->loader->add_action( 'wp_ajax_get_ajax_search_autocomplete_title_wb', $plugin_public, 'get_ajax_search_autocomplete_title_wb_callback' );
		// Shortcode callback.
		$this->loader->add_shortcode( 'wb_ajax_filters', $plugin_public, 'filter_preset_shortcode_callback' );
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
	 * @return    Wb_Ajax_Filter_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Define constant if not already defined
	 *
	 * @since 1.0.0
	 *
	 * @param string      $name Name.
	 * @param string|bool $value Value.
	 *
	 * @return void
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

}
