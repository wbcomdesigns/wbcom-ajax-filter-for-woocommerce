<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WB Ajax Filter Admin Class
 *
 * Handles all admin-specific functionality for the WB Ajax Filter plugin.
 * Manages filter presets, settings, and admin interface interactions.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 * @author     Wbcom Designs <https://wbcomdesigns.com/>
 * @since      1.0.0
 */
class Wb_Ajax_Filter_Admin {

	/**
	 * The settings page slug.
	 *
	 * Unchanged across releases so bookmarks, the plugins-list Settings link
	 * and the activation redirect keep working.
	 *
	 * @since 1.2.2
	 * @var   string
	 */
	const PAGE_SLUG = 'wc-ajax-filter-settings';

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  1.0.0
	 * @param  string $plugin_name       The name of this plugin.
	 * @param  string $version           The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_action( 'init', array( $this, 'wb_ajax_filter_register_post_type' ) );
	}

	/**
	 * Whether the current request is this plugin's settings screen.
	 *
	 * @since  1.2.2
	 * @return bool
	 */
	private function is_settings_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Routing only.
		$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

		return self::PAGE_SLUG === $page;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * The shared Wbcom settings shell (lib/wbcom-settings/) ships its own
	 * stylesheet; this one carries only the plugin-specific preset builder
	 * and color picker layout.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if ( ! $this->is_settings_page() ) {
			return;
		}

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$extension = is_rtl() ? '.rtl.css' : '.css';
			$path      = is_rtl() ? '/rtl' : '';
		} else {
			$extension = is_rtl() ? '.rtl.css' : '.min.css';
			$path      = is_rtl() ? '/rtl' : '/min';
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css' . $path . '/wb-ajax-filter-admin' . $extension, array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/css/select2.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ( ! $this->is_settings_page() ) {
			return;
		}

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$extension = '.js';
			$path      = '';
		} else {
			$extension = '.min.js';
			$path      = '/min';
		}

		wp_enqueue_script( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/js/select2.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js' . $path . '/wb-ajax-filter-admin' . $extension, array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_media();

		// The preset-builder JS reads its AJAX endpoint and nonce from this
		// object. It was previously localized by the deleted admin/wbcom/
		// wrapper; the plugin now owns its own admin nonce seam.
		wp_localize_script(
			$this->plugin_name,
			'wbcom_plugin_installer_params',
			array(
				'ajax_url'         => admin_url( 'admin-ajax.php' ),
				'wbcom_ajax_nonce' => wp_create_nonce( 'ajax-nonce' ),
			)
		);

		wp_localize_script(
			$this->plugin_name,
			'wbAjaxFilterStrings',
			array(
				'confirmDelete'    => __( 'Are you sure you want to delete this preset?', 'wb-ajax-filter' ),
				'confirmDuplicate' => __( 'Do you want to create duplicate of this preset?', 'wb-ajax-filter' ),
				'nameExists'       => __( 'Name already exists.', 'wb-ajax-filter' ),
				'selectTaxonomy'   => __( 'Please select a taxonomy', 'wb-ajax-filter' ),
				'selectTerms'      => __( 'Please select terms', 'wb-ajax-filter' ),
				'nameRequired'     => __( 'Please enter name for preset.', 'wb-ajax-filter' ),
				'validTaxonomy'    => __( 'Please select a valid taxonomy', 'wb-ajax-filter' ),
				'minPriceNotice'   => __( 'Entered Min price is greater than the highest price on this store.', 'wb-ajax-filter' ),
				'maxPriceNotice'   => __( 'Max price cannot be smaller than Min price.', 'wb-ajax-filter' ),
				'titleRequired'    => __( 'Filter name is required.', 'wb-ajax-filter' ),
				'ok'               => __( 'OK', 'wb-ajax-filter' ),
				'cancel'           => __( 'Cancel', 'wb-ajax-filter' ),
			)
		);
	}

	/** Register post type for presets. */
	public function wb_ajax_filter_register_post_type() {
		$post_type_labels = array(
			'name'          => _x( 'Filter presets', '[Admin] name of presets custom post type', 'wb-ajax-filter' ),
			'singular_name' => _x( 'Filter preset', '[Admin] singular name of presets custom post type', 'wb-ajax-filter' ),
			'add_new_item ' => _x( 'Add new preset', '[Admin] add new filter preset label', 'wb-ajax-filter' ),
		);
		$post_type_args   = array(
			'label'        => _x( 'Filter presets', '[Admin] name of presets custom post type', 'wb-ajax-filter' ),
			'labels'       => $post_type_labels,
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => false,
			'supports'     => array( 'title' ),
		);

		register_post_type( 'wb_filter_preset', $post_type_args );
	}

	/**
	 * Register this plugin's screen on the shared Wbcom settings shell.
	 *
	 * The shell (lib/wbcom-settings/) owns the menu entry, sidebar, routing,
	 * assets and notice suppression; this plugin only contributes nav entries
	 * and tab bodies through the two prefixed seams below.
	 *
	 * @since 1.2.2
	 */
	public function boot_settings_page() {
		if ( ! class_exists( 'Wbcom_Settings_Page' ) ) {
			return;
		}

		Wbcom_Settings_Page::boot(
			array(
				'prefix'     => 'wb_ajax_filter',
				'slug'       => self::PAGE_SLUG,
				'assets_url' => WB_AJAX_FILTER_PLUGIN_URL,
				'version'    => $this->version,
				'icon'       => 'filter',
				'labels'     => array(
					'menu_title' => __( 'Ajax Filter', 'wb-ajax-filter' ),
					'brand'      => __( 'Ajax Filter', 'wb-ajax-filter' ),
					'subtitle'   => __( 'AJAX product filtering for WooCommerce', 'wb-ajax-filter' ),
					'nav_label'  => __( 'Ajax Filter settings sections', 'wb-ajax-filter' ),
					'pro_badge'  => __( 'Pro', 'wb-ajax-filter' ),
				),
			)
		);

		add_filter( 'wb_ajax_filter_settings_nav_groups', array( $this, 'settings_nav_groups' ) );
		add_action( 'wb_ajax_filter_settings_tab_content', array( $this, 'render_settings_tab' ) );
	}

	/**
	 * Create the shared "WB Plugins" parent menu when no other Wbcom plugin has.
	 *
	 * @since 1.2.2
	 */
	public function register_parent_menu() {
		if ( ! class_exists( 'Wbcom_Settings_Page' ) || ! empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			return;
		}

		add_menu_page(
			esc_html__( 'WB Plugins', 'wb-ajax-filter' ),
			esc_html__( 'WB Plugins', 'wb-ajax-filter' ),
			'manage_options',
			'wbcomplugins',
			array( 'Wbcom_Settings_Page', 'render_welcome' ),
			'dashicons-lightbulb',
			59
		);
	}

	/**
	 * Declare the settings nav.
	 *
	 * This array IS the tab registry: the shell builds the sidebar, the section
	 * routing and the default tab from it, so adding a screen means adding one
	 * entry here plus a case in render_settings_tab() - no markup elsewhere.
	 *
	 * Overview is first, so opening the plugin answers "what is this doing on
	 * my store right now?" before offering an input. The filters tab keeps its
	 * historical id: the preset builder templates, the footer modal gate and
	 * back-links all address tab=wb-ajax-filter-presets.
	 *
	 * @since  1.2.2
	 * @param  array $groups Groups declared so far.
	 * @return array
	 */
	public function settings_nav_groups( $groups ) {
		$groups['main'] = array(
			'label' => __( 'Ajax Filter', 'wb-ajax-filter' ),
			'items' => array(
				'overview'               => array(
					'title' => __( 'Overview', 'wb-ajax-filter' ),
					'icon'  => 'layout-dashboard',
				),
				'wb-ajax-filter-presets' => array(
					'title' => __( 'Your Filters', 'wb-ajax-filter' ),
					'icon'  => 'sliders-horizontal',
				),
				'stored-data'            => array(
					'title' => __( 'Stored Data', 'wb-ajax-filter' ),
					'icon'  => 'database',
				),
				'advanced'               => array(
					'title' => __( 'Advanced', 'wb-ajax-filter' ),
					'icon'  => 'settings-2',
				),
				'license'                => array(
					'title' => __( 'License', 'wb-ajax-filter' ),
					'icon'  => 'key-round',
				),
			),
		);

		return $groups;
	}

	/**
	 * The numbers the Overview tab renders.
	 *
	 * One bounded posts query plus one batched meta query (get_posts primes the
	 * meta cache), so the per-preset reads below never hit the database again.
	 * The list is capped at 100 presets; the true total still comes from
	 * wp_count_posts() (a COUNT(*)), and the tab says when the list is cut.
	 *
	 * @since  1.2.2
	 * @return array {
	 *     @type array $presets       Rows: id, title, enabled, fields, edit_url.
	 *     @type int   $total         Published presets on the site.
	 *     @type int   $enabled_count Presets whose filters render to shoppers.
	 *     @type int   $live_fields   Enabled fields inside enabled presets.
	 *     @type bool  $truncated     True when more presets exist than listed.
	 * }
	 */
	public function get_overview_stats() {
		$counts = wp_count_posts( 'wb_filter_preset' );
		$total  = isset( $counts->publish ) ? (int) $counts->publish : 0;

		$presets = get_posts(
			array(
				'post_type'      => 'wb_filter_preset',
				'post_status'    => 'publish',
				'posts_per_page' => 100,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		$rows          = array();
		$enabled_count = 0;
		$live_fields   = 0;

		foreach ( $presets as $preset ) {
			$enabled = ( 'yes' === get_post_meta( $preset->ID, 'preset_enabled', true ) );
			$fields  = get_post_meta( $preset->ID, '_wb_filter', true );
			$fields  = is_array( $fields ) ? $fields : array();

			$field_count = 0;
			foreach ( $fields as $field ) {
				if ( ! isset( $field['filter_enabled'] ) || 'yes' === $field['filter_enabled'] ) {
					++$field_count;
				}
			}

			if ( $enabled ) {
				++$enabled_count;
				$live_fields += $field_count;
			}

			$rows[] = array(
				'id'       => $preset->ID,
				'title'    => $preset->post_title,
				'enabled'  => $enabled,
				'fields'   => $field_count,
				'edit_url' => add_query_arg(
					array(
						'action' => 'edit',
						'wb'     => 'list',
						'page'   => self::PAGE_SLUG,
						'tab'    => 'wb-ajax-filter-presets',
						'preset' => $preset->ID,
					),
					admin_url( 'admin.php' )
				),
			);
		}

		return array(
			'presets'       => $rows,
			'total'         => $total,
			'enabled_count' => $enabled_count,
			'live_fields'   => $live_fields,
			'truncated'     => $total > count( $rows ),
		);
	}

	/**
	 * Render one settings tab.
	 *
	 * @since 1.2.2
	 * @param string $tab Tab id.
	 */
	public function render_settings_tab( $tab ) {
		switch ( $tab ) {
			case 'overview':
				include plugin_dir_path( __FILE__ ) . 'partials/tab-overview.php';
				break;
			case 'wb-ajax-filter-presets':
				include plugin_dir_path( __FILE__ ) . 'partials/tab-filters.php';
				break;
			case 'stored-data':
				include plugin_dir_path( __FILE__ ) . 'partials/tab-data.php';
				break;
			case 'advanced':
				include plugin_dir_path( __FILE__ ) . 'partials/tab-advanced.php';
				break;
			case 'license':
				include plugin_dir_path( __FILE__ ) . 'partials/tab-license.php';
				break;
		}
	}

	/**
	 * Add modal wrapper to the footer of admin section.
	 *
	 * The shared shell renders every tab's section in the DOM and switches
	 * between them client-side without a reload, so the preset builder (and
	 * this modal it depends on) can be reached from any tab. Gating on the
	 * tab parameter therefore broke the builder after a client-side switch;
	 * the modal loads whenever the settings screen does.
	 */
	public function wb_ajax_filter_add_modal_to_admin_footer() {
		if ( ! is_admin() || ! $this->is_settings_page() ) {
			return;
		}
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-modal.php';
	}

	/**
	 * Shared capability gate for the admin AJAX callbacks.
	 *
	 * Each callback first calls check_ajax_referer( 'ajax-nonce', 'nonce' ) inline - which
	 * dies with a 403 when the nonce is missing or invalid, closing the old bypass where an
	 * omitted nonce skipped verification entirely - and then this method, which blocks any
	 * user who cannot manage the store (e.g. a logged-in customer) before any write runs.
	 *
	 * @since 1.2.2
	 * @return void Dies with a 403 response when the current user is not a store manager.
	 */
	private function require_woocommerce_manager() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( esc_html__( 'You are not allowed to perform this action.', 'wb-ajax-filter' ), 403 );
		}
	}

	/**
	 * Assert that an ID really is a filter preset before any write touches it.
	 *
	 * Without this, a request could pass any post ID (a product, an order, a page) to
	 * wp_delete_post()/wp_update_post()/update_post_meta() and mutate unrelated content.
	 *
	 * @since 1.2.2
	 * @param mixed $preset_id Candidate post ID from the request.
	 * @return int Validated preset post ID; dies with a 400 response otherwise.
	 */
	private function verify_preset_id( $preset_id ) {
		$preset_id = absint( $preset_id );
		if ( ! $preset_id || 'wb_filter_preset' !== get_post_type( $preset_id ) ) {
			wp_send_json_error( esc_html__( 'Invalid filter preset.', 'wb-ajax-filter' ), 400 );
		}
		return $preset_id;
	}

	/**
	 * Call create filter template inside modal through ajax.
	 */
	public function load_create_filter_template_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		ob_start();
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filter-create-form.php';
		$response = ob_get_clean();
		echo wp_json_encode( $response );
		die();
	}

	/**
	 * Create or update a filter preset
	 *
	 * Processes form data from the preset creation modal and either creates
	 * a new preset or updates an existing one based on the provided data.
	 *
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function create_filter_preset_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( isset( $_POST['form_data'] ) ) {
			$filter    = array();
			$form_data = wp_unslash( $_POST['form_data'] ); //phpcs:ignore
			// Converting form data into associative array.
			$filter_data = $this->wb_ajax_process_form_data( $form_data );
			$result      = $this->wb_ajax_save_filter_data( $filter_data );

			echo $result; //phpcs:ignore
		}
		die();
	}

	/**
	 * Checks if filter preset title name already exists.
	 *
	 * @since 1.0.0
	 * @return void Output json response and terminates.
	 */
	public function check_filter_preset_title_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['title'] ) ) {
			exit;
		}
		$args    = array(
			'post_type'    => 'wb_filter_preset',
			'post_status'  => 'publish',
			'number_posts' => -1,
		);
		$filters = get_posts( $args );
		foreach ( $filters as $filter ) {
			if ( strtolower( $filter->post_title ) === sanitize_text_field( wp_unslash( $_POST['title'] ) ) || sanitize_text_field( wp_unslash( $_POST['title'] ) ) === $filter->post_title ) {
				echo 'exists';
				die();
			} else {
				echo 'not exists';
				die();
			}
		}
		die();
	}
	/**
	 * Creates a duplicate filter preset.
	 *
	 * @since 1.0.0
	 * @return void Output json response and terminates.
	 */
	public function duplicate_filter_preset_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['preset'] ) ) {
			exit;
		}
		$preset_id   = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		$preset_data = get_post( $preset_id );
		$filters     = get_post_meta( $preset_id, '_wb_filter', true );
		$args        = array(
			'post_type'    => 'wb_filter_preset',
			'number_posts' => -1,
			'meta_query'   => array(
				array(
					'key'     => 'parent_preset',
					'value'   => $preset_id,
					'compare' => '==',
				),
			),
		);
		$siblings    = get_posts( $args );
		$count       = count( $siblings ) + 1;
		$title       = $preset_data->post_title . ' Copy ' . $count;
		$post_id     = wp_insert_post(
			array(
				'post_type'      => 'wb_filter_preset',
				'post_title'     => $title,
				'post_content'   => 'Wb Ajax filter Preset',
				'post_status'    => 'publish',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			)
		);
		if ( $post_id ) {
			update_post_meta( $post_id, '_wb_filter', $filters );
			update_post_meta( $post_id, 'parent_preset', $preset_id );
			echo 'copy_created';
		}
		exit();
	}

	/**
	 * Delete existing filter preset.
	 *
	 * @since 1.0.0
	 * @return void Output json response and terminates.
	 */
	public function delete_filter_preset_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['preset'] ) ) {
			exit;
		}
		$preset_id = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		wp_delete_post( $preset_id, false );
		echo 'preset_deleted';
		exit();
	}

	/**
	 * Creates a duplicate of single filter of a preset.
	 *
	 * @since 1.0.0
	 * @return void Output json response and terminates.
	 */
	public function duplicate_single_filter_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['filter_id'] ) ) {
			exit;
		}
		$preset_id = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		$filter_id = sanitize_text_field( wp_unslash( $_POST['filter_id'] ) );
		$filters   = get_post_meta( $preset_id, '_wb_filter', true );
		foreach ( $filters as $key => $filter ) {
			if ( $filter_id === $filter['filter_id'] ) {
				$copy_filter = array();
				$copy_filter = $filter;
				unset( $copy_filter['filter_id'] );
				unset( $copy_filter['filter_title'] );
				$copy_filter['filter_id']    = esc_html( uniqid( 'wb_filter_' ) );
				$title                       = $filter['filter_title'] . ' Copy';
				$copy_filter['filter_title'] = $title;
				$filters[]                   = $copy_filter;
				update_post_meta( $preset_id, '_wb_filter', $filters );
			}
		}
		echo 'copy_created';
		exit();
	}

	/**
	 * Deletes a single filter in preset.
	 *
	 * @since 1.0.0
	 * @return void Output json response and terminates.
	 */
	public function delete_single_filter_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['filter_id'] ) ) {
			exit;
		}
		$new_filters = array();
		$preset_id   = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		$filter_id   = sanitize_text_field( wp_unslash( $_POST['filter_id'] ) );
		$filters     = get_post_meta( $preset_id, '_wb_filter', true );
		foreach ( $filters as $key => $filter ) {
			if ( $filter_id !== $filter['filter_id'] ) {
				$new_filters[] = $filter;
			}
		}
		update_post_meta( $preset_id, '_wb_filter', $new_filters );
		echo 'preset_deleted';
		exit();
	}

	/**
	 * Enable/Disable filter preset to be rendered on shop page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enable_disable_filter_preset_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['enabled'] ) ) {
			exit;
		}
		$preset_id = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		update_post_meta( $preset_id, 'preset_enabled', sanitize_text_field( wp_unslash( $_POST['enabled'] ) ) );
		exit();
	}

	/**
	 * Enable/Disable single filter in preset to be rendered on shop page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enable_disable_single_filter_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['enabled'] ) && ! isset( $_POST['filter_id'] ) ) {
			exit;
		}
		$preset_id = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		$filter_id = sanitize_text_field( wp_unslash( $_POST['filter_id'] ) );
		$filters   = get_post_meta( $preset_id, '_wb_filter', true );
		foreach ( $filters as $key => $filter ) {
			if ( $filter_id === $filter['filter_id'] ) {
				unset( $filter['filter_enabled'] );
				$filter['filter_enabled'] = sanitize_text_field( wp_unslash( $_POST['enabled'] ) );
				$filters[ $key ]          = $filter;
			}
		}
		update_post_meta( $preset_id, '_wb_filter', $filters );
		exit();
	}

	/**
	 * Modifies the title of the preset.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function edit_preset_post_title_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['title'] ) ) {
			exit;
		}
		$preset_id     = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		$title         = sanitize_text_field( wp_unslash( $_POST['title'] ) );
		$preset_update = array(
			'ID'         => $preset_id,
			'post_title' => $title,
		);

		wp_update_post( $preset_update );
		exit();
	}

	/**
	 * Customizes the text of the terms used in taxonomy filter.
	 *
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function customize_term_text_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['id'] ) && ! isset( $_POST['text'] ) ) {
			exit;
		}
		$term_id = sanitize_text_field( wp_unslash( $_POST['id'] ) );
		$text    = sanitize_text_field( wp_unslash( $_POST['text'] ) );
		$tooltip = sanitize_text_field( wp_unslash( $_POST['text'] ) );
		ob_start();
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-customize-term.php';
		$response = ob_get_clean();
		echo wp_json_encode( $response );
		exit();
	}

	/**
	 * Sort the position of single filters in preset.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function sortable_single_filters_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_POST['old_index'] ) && ! isset( $_POST['new_index'] ) && ! isset( $_POST['preset'] ) ) {
			exit;
		}
		$old_index = sanitize_text_field( wp_unslash( $_POST['old_index'] ) );
		$new_index = sanitize_text_field( wp_unslash( $_POST['new_index'] ) );
		$preset    = $this->verify_preset_id( sanitize_text_field( wp_unslash( $_POST['preset'] ) ) );
		$filters   = get_post_meta( $preset, '_wb_filter', true );
		$filter    = $filters[ $old_index ];
		unset( $filters[ $old_index ] );
		array_splice( $filters, $new_index, 0, array( $filter ) );
		update_post_meta( $preset, '_wb_filter', $filters );
		exit();
	}

	/**
	 * Checks if the custom fields exists to be used in filter.
	 *
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function check_custom_field_exists_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_GET['q'] ) ) {
			exit;
		}
		$field_slug = sanitize_text_field( wp_unslash( $_GET['q'] ) );

		/*
		 * Ask the database for DISTINCT meta keys, rather than reading every
		 * product to find out which key names exist.
		 *
		 * This used to run `posts_per_page => -1` over the whole catalogue and
		 * then call get_post_meta() inside the loop - every product, every meta
		 * row, to discover a handful of key NAMES. On a store with a few
		 * thousand products that is an admin request that never finishes, and
		 * before the nonce bypass was closed any logged-in user could fire it.
		 *
		 * meta_key is indexed by WordPress, so one LIKE with a LIMIT answers the
		 * same question in a single query, bounded whatever the catalogue size.
		 * The match is a substring anywhere in the key, which is what the old
		 * strpos() check did.
		 */
		global $wpdb;

		$limit = (int) apply_filters( 'wb_ajax_filter_custom_field_search_limit', 30 );
		$like  = '%' . $wpdb->esc_like( $field_slug ) . '%';

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Indexed lookup for an admin autocomplete; table names cannot be placeholders and the user value is prepared.
		$meta_keys = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT DISTINCT pm.meta_key
				   FROM {$wpdb->postmeta} pm
				   INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				  WHERE p.post_type = 'product'
				    AND pm.meta_key LIKE %s
				  ORDER BY pm.meta_key ASC
				  LIMIT %d",
				$like,
				$limit
			)
		);

		$matched_fields = array();
		foreach ( (array) $meta_keys as $key ) {
			$matched_fields[] = array( $key, $key );
		}

		echo wp_json_encode( $matched_fields );
		exit();
	}

	/**
	 * Ajax callback function to search terms for select2 search box.
	 *
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function select2_get_terms_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		if ( ! isset( $_GET['q'] ) && ! isset( $_GET['cat'] ) ) {
			exit;
		}
		$taxonomy = sanitize_text_field( wp_unslash( $_GET['cat'] ) );
		if ( ! empty( $taxonomy ) ) {

			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				),
			);

			if ( ! empty( $terms ) && is_array( $terms ) ) {
				$results = array();
				foreach ( $terms as $term ) {
					if ( strpos( $term->name, ucfirst( sanitize_text_field( wp_unslash( $_GET['q'] ) ) ) ) === false && strpos( $term->name, strtolower( sanitize_text_field( wp_unslash( $_GET['q'] ) ) ) ) === false ) {
						continue;
					}
					$tmp       = array( $term->term_id, $term->name );
					$results[] = $tmp;
				}
				$results = apply_filters( 'wb_ajax_filter_restrict_terms', $results, $taxonomy );
				echo wp_json_encode( $results );
			}
		}
		die();
	}

	/**
	 * Includes the price range field while filter creation.
	 *
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function add_price_range_field_wb_callback() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );
		$this->require_woocommerce_manager();

		ob_start();
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-add-price-range.php';
		$response = ob_get_clean();
		echo wp_json_encode( $response );
		die();
	}

	/**
	 * Function to register the plugin settings.
	 *
	 * The two search options share one settings group so the merged Search
	 * card on the Advanced tab saves both in a single form submit. Option
	 * NAMES are unchanged, so values saved under the old multi-tab screen
	 * carry over untouched.
	 *
	 * @since  1.0.9
	 * @return void
	 */
	public function wb_ajax_filter_init_plugin_settings() {
		register_setting( 'wb_ajax_filter_admin_general_options', 'wb_ajax_filter_admin_general_options' );
		register_setting( 'wb_ajax_filter_admin_customization_options', 'wb_ajax_filter_admin_customization_options' );
		register_setting( 'wb_ajax_filter_search_settings', 'wb_ajax_filter_search_settings' );
		register_setting( 'wb_ajax_filter_search_settings', 'wb_ajax_filter_search_content_settings' );
	}

	/**
	 * Includes filter name form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_name_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-name.php';
	}

	/**
	 * Includes filter type form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_for_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-for.php';
	}

	/**
	 * Includes taxonomy filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_tax_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-tax.php';
	}

	/**
	 * Includes price slider filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_price_slider_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-price-slider.php';
	}

	/**
	 * Includes order by filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_order_by_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-order-by.php';
	}

	/**
	 * Includes price range filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_price_range_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-price-range.php';
	}

	/**
	 * Includes stock filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_stock_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-stock.php';
	}

	/**
	 * Includes toogle filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_toggle_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-toggle.php';
	}

	/**
	 * Includes show count filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_count_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-count.php';
	}

	/**
	 * Includes adoptive filtering form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_adoptive_filtering_field( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-adoptive-filtering.php';
	}

	/**
	 * Includes save filter form field.
	 *
	 * @param array $filters Filter array.
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_create_filter_save_button( $filters ) {
		include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-save.php';
	}

	/**
	 * Function to create associative array of filter data using form data.
	 *
	 * @param array $form_data Preset data.
	 * @return array $filter Array of filter data.
	 */
	private function wb_ajax_process_form_data( $form_data ) {
		$filter = array();
		foreach ( $form_data as $field ) {
			if ( '' !== $field['value'] ) {
				$str_after_brack  = explode( '[', $field['name'] );
				$str_before_brack = explode( ']', $str_after_brack[1] );
				if ( 'order_options' === $str_before_brack[0] ) {
					$filter[ $str_before_brack[0] ][] = $field['value'];
				} elseif ( 'price_ranges' === $str_before_brack[0] ) {
					$price_ranges_key      = explode( ']', $str_after_brack[2] );
					$price_ranges_meta_key = explode( ']', $str_after_brack[3] );
					$filter[ $str_before_brack[0] ][ $price_ranges_key[0] ][ $price_ranges_meta_key[0] ] = $field['value'];
				} elseif ( isset( $filter['taxonomy'] ) && 'terms' === $str_before_brack[0] ) {
					$term_data                        = get_term( $field['value'], $filter['taxonomy'] );
					$tm                               = new stdClass();
					$tm->id                           = $field['value'];
					$tm->text                         = $term_data->name;
					$filter[ $str_before_brack[0] ][] = $tm;
				} elseif ( 'terms_text' === $str_before_brack[0] ) {
					$price_ranges_key      = explode( ']', $str_after_brack[2] );
					$price_ranges_meta_key = explode( ']', $str_after_brack[3] );
					$filter[ $str_before_brack[0] ][ $price_ranges_key[0] ][ $price_ranges_meta_key[0] ] = $field['value'];
				} else {
					$filter[ $str_before_brack[0] ] = $field['value'];
				}
			}
		}

		return $filter;
	}

	/**
	 * Function to save filter preset data.
	 *
	 * @param array $filter Preset Filter Data.
	 * @return string Message string.
	 */
	private function wb_ajax_save_filter_data( $filter ) {
		$post_title = $filter['preset_title'];
		if ( isset( $filter['preset_id'] ) && '' !== $filter['preset_id'] ) {
			$post_id = $filter['preset_id'];
			unset( $filter['preset_id'] );
		} else {
			$post_id = '';
		}
		$filter['filter_enabled'] = 'yes';
		unset( $filter['preset_title'] );
		if ( '' === $post_id ) {
			$post_id = wp_insert_post(
				array(
					'post_type'      => 'wb_filter_preset',
					'post_title'     => $post_title,
					'post_content'   => 'Wb Ajax filter Preset',
					'post_status'    => 'publish',
					'comment_status' => 'closed',
					'ping_status'    => 'closed',
				)
			);
			if ( $post_id ) {
				$filters[] = $filter;
				update_post_meta( $post_id, '_wb_filter', $filters );
				// Enable on create so the preset renders immediately; rendering gates on preset_enabled === 'yes'.
				update_post_meta( $post_id, 'preset_enabled', 'yes' );
				return 'filter_created';
			}
		} else {
			$filters    = get_post_meta( $post_id, '_wb_filter', true );
			$new_filter = 0;
			foreach ( $filters as $key => $val ) {
				if ( $val['filter_id'] === $filter['filter_id'] ) {
					$filters[ $key ] = $filter;
					++$new_filter;
					break;
				}
			}
			if ( 0 === $new_filter ) {
				$filters[] = $filter;
			}
			update_post_meta( $post_id, '_wb_filter', $filters );
			return 'filter_edited';
		}
	}
}
