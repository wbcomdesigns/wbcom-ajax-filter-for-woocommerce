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

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 * @author     Wbcom Designs <https://wbcomdesigns.com/>
 */
class Wb_Ajax_Filter_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param screen $screen Current screen.
	 */
	public function enqueue_styles( $screen ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wb_Ajax_Filter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wb_Ajax_Filter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wb-ajax-filter-admin.css', array(), $this->version, 'all' );
		if ( 'wb-plugins_page_wb-ajax-filter-integration-settings' === $screen ) {
			wp_enqueue_style( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/js/select2/dist/css/select2.min.css', array(), $this->version, 'all');	
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param screen $screen Current screen.
	 */
	public function enqueue_scripts( $screen ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wb_Ajax_Filter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wb_Ajax_Filter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( 'wb-plugins_page_wb-ajax-filter-integration-settings' === $screen ) {
			wp_enqueue_script( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/js/select2/dist/js/select2.full.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'wb-select2-full', WB_AJAX_FILTER_URL . 'assets/js/select2/dist/js/select2.min.js', array( 'jquery' ), $this->version, true );
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wb-ajax-filter-admin.js', array( 'jquery' ), $this->version, true );
	}

	/** Register post type for presets */
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
	 * Actions performed on loading admin_menu.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function wb_ajax_filter_add_admin_settings() {
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'wb-ajax-filter' ), esc_html__( 'WB Plugins', 'wb-ajax-filter' ), 'manage_options', 'wbcomplugins', array( $this, 'wb_ajax_filter_admin_options_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'wb-ajax-filter' ), esc_html__( 'General', 'wb-ajax-filter' ), 'manage_options', 'wbcomplugins' );

		}
		add_submenu_page( 'wbcomplugins', esc_html__( 'Wbcom Ajax Filter for Woocommerce', 'wb-ajax-filter' ), esc_html__( 'Wbcom Ajax Filter for Woocommerce', 'wb-ajax-filter' ), 'manage_options', 'wb-ajax-filter-integration-settings', array( $this, 'wb_ajax_filter_admin_options_page' ) );
	}

	/**
	 * Actions performed to create a submenu page content.
	 *
	 * @since    1.0.0
	 * @access public
	 */
	public function wb_ajax_filter_admin_options_page() {
		global $allowedposttags;
		$tab = filter_input( INPUT_GET, 'tab' ) ? filter_input( INPUT_GET, 'tab' ) : 'wb-ajax-filter-welcome';
		?>
	<div class="wrap">
		<div class="wbcom-wrap">
			<div class="bupr-header">
				<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
				<hr class="wp-header-end">
				<h1 class="wbcom-plugin-heading">
					<?php esc_html_e( 'Wbcom Ajax Filter for Woocommerce Settings', 'wb-ajax-filter' ); ?>
				</h1>
			</div>
			<div class="wbcom-admin-settings-page">
				<?php
				settings_errors();
				$this->wb_ajax_filter_plugin_settings_tabs();
				settings_fields( $tab );
				do_settings_sections( $tab );
				?>
			</div>
		</div>
	</div>
		<?php
	}

	/**
	 * Add modal wrapper to the footer of admin section.
	 */
	public function wb_ajax_filter_add_modal_to_admin_footer() {
		$page = ( isset( $_REQUEST['tab'] ) && 'wb-ajax-filter-presets' === sanitize_text_field( wp_unslash( $_REQUEST['tab'] ) ) ) ? true : false;
		if ( is_admin() && $page ) {
			include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-modal.php';
		}
	}

	/**
	 * Call create filter template inside modal through ajax.
	 */
	public function load_create_filter_template_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			ob_start();
			include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filter-create-form.php';
			$response = ob_get_clean();
			echo wp_json_encode( $response );
		}
		die();
	}

	/**
	 * Create new filter preset ajax callback.
	 */
	public function create_filter_preset_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( isset( $_POST['form_data'] ) ) {
				$filter    = array();
				$form_data = wp_unslash( $_POST['form_data'] );
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
						} else {
							$filter[ $str_before_brack[0] ] = $field['value'];
						}
					}
				}
				$post_title = $filter['preset_title'];
				if ( isset( $filter['preset_id'] ) && '' !== $filter['preset_id'] ) {
					$post_id = $filter['preset_id'];
					unset( $filter['preset_id'] );
				} else {
					$post_id = '';
				}
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
						echo 'filter_created';
					}
				} else {
					$filters = get_post_meta( $post_id, '_wb_filter', true );
					foreach ( $filters as $key => $val ) {
						if ( $val['filter_id'] === $filter['filter_id'] ) {
							$filters[ $key ] = $filter;
						} else {
							$filters[] = $filter;
						}
					}
					update_post_meta( $post_id, '_wb_filter', $filters );
					echo 'filter_created';
				}
			}
		}
		die();
	}

	/**
	 * Checks if Filter preset title already exists.
	 */
	public function check_filter_preset_title_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
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
				if ( $_POST['title'] === $filter->post_title ) {
					echo 'exists';
					die();
				} else {
					echo 'not exists';
					die();
				}
			}
		}
		die();
	}
	/**
	 * Create a duplicate filter preset.
	 */
	public function duplicate_filter_preset_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['preset'] ) ) {
				exit;
			}
			$preset_id   = sanitize_text_field( wp_unslash( $_POST['preset'] ) );
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
		}
		exit();
	}

	/**
	 * Delete filter preset.
	 */
	public function delete_filter_preset_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['preset'] ) ) {
				exit;
			}
			$preset_id = sanitize_text_field( wp_unslash( $_POST['preset'] ) );
			wp_delete_post( $preset_id, false );
			echo 'preset_deleted';
		}
		exit();
	}

	/**
	 * Enable/Disable filter preset.
	 */
	public function enable_disable_filter_preset_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['enabled'] ) ) {
				exit;
			}
			update_post_meta( sanitize_text_field( wp_unslash( $_POST['preset'] ) ), 'preset_enabled', sanitize_text_field( wp_unslash( $_POST['enabled'] ) ) );
		}
		exit();
	}

	/**
	 * Actions performed to create tabs on the sub menu page.
	 */
	public function wb_ajax_filter_plugin_settings_tabs() {
		$current_tab = filter_input( INPUT_GET, 'tab' ) ? filter_input( INPUT_GET, 'tab' ) : 'wb-ajax-filter-welcome';
		// xprofile setup tab.
		echo '<div class="wbcom-tabs-section"><div class="nav-tab-wrapper"><div class="wb-responsive-menu"><span>' . esc_html( 'Menu' ) . '</span><input class="wb-toggle-btn" type="checkbox" id="wb-toggle-btn"><label class="wb-toggle-icon" for="wb-toggle-btn"><span class="wb-icon-bars"></span></label></div><ul>';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab === $tab_key ? 'nav-tab-active' : '';
			echo '<li><a class="nav-tab ' . esc_attr( $active ) . '" id="' . esc_attr( $tab_key ) . '-tab" href="?page=wb-ajax-filter-integration-settings&tab=' . esc_attr( $tab_key ) . '">' . esc_attr( $tab_caption ) . '</a></li>';
		}
		echo '</div></ul></div>';
	}

	/**
	 * Search terms ajax callabck for select2.
	 */
	public function select2_get_terms_wb_callback() {
		if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_GET['q'] ) && ! isset( $_GET['cat'] ) ) {
				exit;
			}
			$terms   = get_terms(
				array(
					'taxonomy'   => wp_unslash( $_GET['cat'] ),
					'hide_empty' => false,
				),
			);
			$results = array();
			foreach ( $terms as $term ) {
				if ( strpos( $term->name, strtoupper( wp_unslash( $_GET['q'] ) ) ) === false && strpos( $term->name, strtolower( wp_unslash( $_GET['q'] ) ) ) === false ) {
					continue;
				}
				if ( 0 === $term->parent ) {
					$results[] = array( $term->term_id, $term->name );
				} else {
						$parent    = get_term_by( 'id', $term->parent, wp_unslash( $_GET['cat'] ) );
						$results[] = array( $term->term_id, $parent->name . ' > ' . $term->name );
				}
			}
			echo wp_json_encode( $results );
		}
		die();
	}

	/**
	 * Filter preset shortcode callback.
	 *
	 * @param attr $attr The params for shortcode.
	 */
	public function filter_preset_shortcode_callback( $attr ) {
		$post_name = $attr['slug'];
		$args      = array(
			'name'        => $post_name,
			'post_type'   => 'wb_filter_preset',
			'post_status' => 'publish',
			'numberposts' => 1,
		);
		$preset    = get_posts( $args );
		if ( $preset ) {
			$preset_id   = $preset[0]->ID;
			$all_filters = get_post_meta( $preset_id, '_wb_filter', true );
			$enabled     = get_post_meta( $preset_id, 'preset_enabled', true );
			if ( 'yes' === $enabled ) {
				$custom_template = get_stylesheet_directory() . '/wb-ajax-filter/preset-filter.php';
				if ( file_exists( $custom_template ) ) {
					include_once $custom_template;
				} else {
					include_once WB_AJAX_FILTER_TEMPLATE_PATH . '/shortcode/preset-filter.php';
				}
			} else {
				echo esc_html__( 'This filter is disabled.', 'wb-ajax-filter' );
			}
		}
	}

	/**
	 * Add price range field.
	 */
	public function add_price_range_field_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			ob_start();
			include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-add-price-range.php';
			$response = ob_get_clean();
			echo wp_json_encode( $response );
		}
		die();
	}

	/**
	 * Actions performed on loading plugin settings
	 *
	 * @since    1.0.9
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function wb_ajax_filter_init_plugin_settings() {
		$this->plugin_settings_tabs['wb-ajax-filter-welcome'] = esc_html__( 'Welcome', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_welcome_options', 'wb_ajax_filter_admin_welcome_options' );
		add_settings_section( 'wb-ajax-filter-welcome', ' ', array( $this, 'wb_ajax_filter_admin_welcome_content' ), 'wb-ajax-filter-welcome' );

		$this->plugin_settings_tabs['wb-ajax-filter-presets'] = esc_html__( 'Filter Presets', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_presets_options', 'wb_ajax_filter_admin_presets_options' );
		add_settings_section( 'wb-ajax-filter-presets', ' ', array( $this, 'wb_ajax_filter_admin_presets_content' ), 'wb-ajax-filter-presets' );

		$this->plugin_settings_tabs['wb-ajax-filter-general'] = esc_html__( 'General Settings', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_general_options', 'wb_ajax_filter_admin_general_options' );
		add_settings_section( 'wb-ajax-filter-general', ' ', array( $this, 'wb_ajax_filter_admin_general_content' ), 'wb-ajax-filter-general' );

		$this->plugin_settings_tabs['wb-ajax-filter-customization'] = esc_html__( 'Customization', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_customization_options', 'wb_ajax_filter_admin_customization_options' );
		add_settings_section( 'wb-ajax-filter-customization', ' ', array( $this, 'wb_ajax_filter_admin_customization_content' ), 'wb-ajax-filter-customization' );

		$this->plugin_settings_tabs['wb-ajax-filter-seo'] = esc_html__( 'SEO', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_seo_options', 'wb_ajax_filter_admin_seo_options' );
		add_settings_section( 'wb-ajax-filter-seo', ' ', array( $this, 'wb_ajax_filter_admin_seo_content' ), 'wb-ajax-filter-seo' );

		$this->plugin_settings_tabs['wb-ajax-filter-ajax-search-settings'] = esc_html__( 'Search Settings', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_ajax_search_settings_options', 'wb_ajax_filter_admin_ajax_search_settings_options' );
		add_settings_section( 'wb-ajax-filter-ajax-search-settings', ' ', array( $this, 'wb_ajax_filter_admin_ajax_search_settings_content' ), 'wb-ajax-filter-ajax-search-settings' );

		$this->plugin_settings_tabs['wb-ajax-filter-search'] = esc_html__( 'Search Options', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_search_options', 'wb_ajax_filter_admin_search_options' );
		add_settings_section( 'wb-ajax-filter-search', ' ', array( $this, 'wb_ajax_filter_admin_search_content' ), 'wb-ajax-filter-search' );

		$this->plugin_settings_tabs['wb-ajax-filter-output'] = esc_html__( 'Search Output', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_admin_output_options', 'wb_ajax_filter_admin_output_options' );
		add_settings_section( 'wb-ajax-filter-output', ' ', array( $this, 'wb_ajax_filter_admin_output_content' ), 'wb-ajax-filter-output' );
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin welcome setting tab content file.
	 */
	public function wb_ajax_filter_admin_welcome_content() {
		include 'partials/wb-ajax-filter-welcome-page.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin general setting tab content file.
	 */
	public function wb_ajax_filter_admin_general_content() {
		include 'partials/wb-ajax-filter-setting-general-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin presets setting tab content file.
	 */
	public function wb_ajax_filter_admin_presets_content() {
		include 'partials/wb-ajax-filter-setting-presets-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin customization setting tab content file.
	 */
	public function wb_ajax_filter_admin_customization_content() {
		include 'partials/wb-ajax-filter-setting-customization-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin seo setting tab content file.
	 */
	public function wb_ajax_filter_admin_seo_content() {
		include 'partials/wb-ajax-filter-setting-seo-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin ajax search setting tab content file.
	 */
	public function wb_ajax_filter_admin_ajax_search_settings_content() {
		include 'partials/wb-ajax-filter-setting-presets-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin search setting tab content file.
	 */
	public function wb_ajax_filter_admin_search_content() {
		include 'partials/wb-ajax-filter-setting-customization-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin outpur setting tab content file.
	 */
	public function wb_ajax_filter_admin_output_content() {
		include 'partials/wb-ajax-filter-setting-seo-tab.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_name_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-name.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_for_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-for.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_tax_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-tax.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_price_slider_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-price-slider.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_order_by_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-order-by.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_price_range_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-price-range.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_stock_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-stock.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_toggle_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-toggle.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_count_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-count.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_adoptive_filtering_field( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-adoptive-filtering.php';
	}

	/**
	 * Load create filter form field.
	 *
	 * @param filters $filters Filter array.
	 */
	public function wb_ajax_filter_create_filter_save_button( $filters ) {
		include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-save.php';
	}

}
