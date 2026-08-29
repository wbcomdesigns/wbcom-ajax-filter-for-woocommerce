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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wb_Ajax_Filter_Admin. Defines all hooks for the admin area.
	 * - Wb_Ajax_Filter_Public. Defines all hooks for the public side of the site.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The one owner of stored-preset queries, record serialization and
		 * moderation - read by the Stored Data screen, the REST API and exports.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-wb-ajax-filter-presets.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 * The settings screen itself is the shared Wbcom shell bundled at
		 * lib/wbcom-settings/ and registered from the plugin bootstrap.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-wb-ajax-filter-admin.php';

		/**
		 * The Stored Data screen controller: moderation actions on admin_init,
		 * export downloads on admin-post. The WP_List_Table subclass itself is
		 * required lazily by the tab partial - core only loads list tables in
		 * wp-admin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-wb-ajax-filter-data-screen.php';

		/**
		 * REST controller exposing the same preset records to store managers.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-wb-ajax-filter-rest-controller.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-wb-ajax-filter-public.php';

		/**
		 * The class responsible for the Gutenberg block (block themes have no
		 * classic WooCommerce hooks to auto-render through).
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-wb-ajax-filter-blocks.php';

		/** This file is responsible for the plugin license functionality. */
		require_once plugin_dir_path( __DIR__ ) . 'edd-license/edd-plugin-license.php';

		/**
		 * This file contains the general/common functions used in the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/wb-ajax-filter-general-functions.php';

		/**
		 * The activator also owns the one-time Default preset seeding, which must be
		 * retryable at runtime (existing sites update without the activation hook firing).
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-wb-ajax-filter-activator.php';
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

		// One-time Default preset seed for installs that never ran the activation hook
		// (plugin updates) or activated before WooCommerce. Latches after the first
		// successful pass, so this is a single autoloaded get_option() per request.
		// Priority 20: after WooCommerce registers its taxonomies and after our CPT.
		add_action( 'init', array( 'Wb_Ajax_Filter_Activator', 'maybe_seed_default_preset' ), 20 );

		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ), 999 );
		// Shared Wbcom settings shell (lib/wbcom-settings/): register our screen early,
		// then make sure the shared parent menu exists before the shell adds submenus at 20.
		add_action( 'init', array( $plugin_admin, 'boot_settings_page' ), 1 );
		add_action( 'admin_menu', array( $plugin_admin, 'register_parent_menu' ), 5 );
		add_action( 'admin_init', array( $plugin_admin, 'wb_ajax_filter_init_plugin_settings' ) );

		// Stored Data screen: state changes run before any output, downloads via admin-post.
		$data_screen = new Wb_Ajax_Filter_Data_Screen();
		add_action( 'admin_init', array( $data_screen, 'handle_actions' ) );
		add_action( 'admin_post_wb_ajax_filter_export', array( $data_screen, 'handle_export' ) );
		add_action( 'admin_footer', array( $plugin_admin, 'wb_ajax_filter_add_modal_to_admin_footer' ) );
		// Ajax callbacks.
		add_action( 'wp_ajax_load_create_filter_template_wb', array( $plugin_admin, 'load_create_filter_template_wb_callback' ) );
		add_action( 'wp_ajax_create_filter_preset_wb', array( $plugin_admin, 'create_filter_preset_wb_callback' ) );
		add_action( 'wp_ajax_check_filter_preset_title_wb', array( $plugin_admin, 'check_filter_preset_title_wb_callback' ) );
		add_action( 'wp_ajax_duplicate_filter_preset_wb', array( $plugin_admin, 'duplicate_filter_preset_wb_callback' ) );
		add_action( 'wp_ajax_delete_filter_preset_wb', array( $plugin_admin, 'delete_filter_preset_wb_callback' ) );
		add_action( 'wp_ajax_duplicate_single_filter_wb', array( $plugin_admin, 'duplicate_single_filter_wb_callback' ) );
		add_action( 'wp_ajax_delete_single_filter_wb', array( $plugin_admin, 'delete_single_filter_wb_callback' ) );
		add_action( 'wp_ajax_enable_disable_filter_preset_wb', array( $plugin_admin, 'enable_disable_filter_preset_wb_callback' ) );
		add_action( 'wp_ajax_select2_get_terms_wb', array( $plugin_admin, 'select2_get_terms_wb_callback' ) );
		add_action( 'wp_ajax_add_price_range_field_wb', array( $plugin_admin, 'add_price_range_field_wb_callback' ) );
		add_action( 'wp_ajax_enable_disable_single_filter_wb', array( $plugin_admin, 'enable_disable_single_filter_wb_callback' ) );
		add_action( 'wp_ajax_edit_preset_post_title_wb', array( $plugin_admin, 'edit_preset_post_title_wb_callback' ) );
		add_action( 'wp_ajax_customize_term_text_wb', array( $plugin_admin, 'customize_term_text_wb_callback' ) );
		add_action( 'wp_ajax_sortable_single_filters_wb', array( $plugin_admin, 'sortable_single_filters_wb_callback' ) );
		add_action( 'wp_ajax_check_custom_field_exists_wb', array( $plugin_admin, 'check_custom_field_exists_wb_callback' ) );

		// Hook callback.
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_name_field' ), 10 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_for_field' ), 20 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_tax_field' ), 30 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_price_slider_field' ), 40 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_order_by_field' ), 50 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_price_range_field' ), 60 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_stock_field' ), 70 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_toggle_field' ), 80 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_count_field' ), 90 );
		add_action( 'wb_ajax_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_adoptive_filtering_field' ), 100 );
		add_action( 'wb_ajax_filter_after_filter_fields', array( $plugin_admin, 'wb_ajax_filter_create_filter_save_button' ), 10 );
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

		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_scripts' ) );

		add_action( 'woocommerce_before_shop_loop', array( $plugin_public, 'add_wb_ajax_filters' ) );

		add_action( 'woocommerce_product_query', array( $plugin_public, 'wb_ajax_filter_modify_wc_product_query' ), 999 );
		add_action( 'wp_footer', array( $plugin_public, 'add_wb_ajax_filters_loader_in_footer' ) );
		// Ajax callback. Registered for nopriv too: most shoppers browse logged out,
		// and admin-ajax.php only routes wp_ajax_ for authenticated users.
		add_action( 'wp_ajax_get_ajax_search_autocomplete_title_wb', array( $plugin_public, 'get_ajax_search_autocomplete_title_wb_callback' ) );
		add_action( 'wp_ajax_nopriv_get_ajax_search_autocomplete_title_wb', array( $plugin_public, 'get_ajax_search_autocomplete_title_wb_callback' ) );
		// Shortcode callback.
		add_shortcode( 'wb_ajax_filters', array( $plugin_public, 'filter_preset_shortcode_callback' ) );

		// Gutenberg block: same renderer as the shortcode, placeable on block themes.
		$plugin_blocks = new Wb_Ajax_Filter_Blocks( $plugin_public );
		add_action( 'init', array( $plugin_blocks, 'register_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array( $plugin_blocks, 'localize_editor_presets' ) );

		add_action( 'woocommerce_redirect_single_search_result', array( $plugin_public, 'wb_ajax_filter_redirect_single_search_result' ) );

		// Added filters when no products found.
		add_action( 'woocommerce_no_products_found', array( $plugin_public, 'add_wb_ajax_filters' ) );

		add_action( 'posts_search', array( $plugin_public, 'wb_ajax_filters_product_search_by_sku' ), 9999, 2 );

		// REST API: the stored presets, readable and moderatable by store managers.
		$rest_controller = new Wb_Ajax_Filter_REST_Controller();
		add_action( 'rest_api_init', array( $rest_controller, 'register_routes' ) );
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
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
