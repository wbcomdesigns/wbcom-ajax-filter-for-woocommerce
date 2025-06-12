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
 * WB Ajax Filter Admin Class
 * 
 * Handles all admin-specific functionality for the WB Ajax Filter plugin.
 * Manages filter presets, settings, and admin interface interactions.
 * 
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 * @author     Wbcom Designs <https://wbcomdesigns.com/>
 * @since      1.0.0
 * 
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
	 * Plugin_settings_tabs
	 *
	 * @since  1.0.0
	 * @access public
	 * @var mixed     $plugin_settings_tabs    The settings Tabs.
	 */

	public $plugin_settings_tabs;

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
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$extension = is_rtl() ? '.rtl.css' : '.css';
			$path      = is_rtl() ? '/rtl' : '';
		} else {
			$extension = is_rtl() ? '.rtl.css' : '.min.css';
			$path      = is_rtl() ? '/rtl' : '/min';
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css' . $path . '/wb-ajax-filter-admin' . $extension, array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-color-picker' );
		if ( 'wb-plugins_page_wc-ajax-filter-settings' === $screen ) {
			wp_enqueue_style( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/css/select2.min.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( 'wp-color-picker' );
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
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$extension = '.js';
			$path      = '';
		} else {
			$extension = '.min.js';
			$path      = '/min';
		}

		if ( 'wb-plugins_page_wc-ajax-filter-settings' === $screen ) {
			wp_enqueue_script( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/js/select2.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js' . $path . '/wb-ajax-filter-admin' . $extension, array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_media();

		wp_localize_script( 
			$this->plugin_name,
			'wbAjaxFilterStrings', 
			array(
				'confirmDelete'      => __( 'Are you sure you want to delete this preset?', 'wb-ajax-filter' ),
				'confirmDuplicate'   => __( 'Do you want to create duplicate of this preset?', 'wb-ajax-filter' ),
				'nameExists'         => __( 'Name already exists.', 'wb-ajax-filter' ),
				'selectTaxonomy'     => __( 'Please select a taxonomy', 'wb-ajax-filter' ),
				'selectTerms'        => __( 'Please select terms', 'wb-ajax-filter' ),
				'nameRequired'       => __( 'Please enter name for preset.', 'wb-ajax-filter' ),
				'validTaxonomy'      => __( 'Please select a valid taxonomy', 'wb-ajax-filter' ),
				'minPriceNotice'     => __( 'Entered Min price is greater than the highest price on this store.', 'wb-ajax-filter' ),
				'maxPriceNotice'     => __( 'Max price cannot be smaller than Min price.', 'wb-ajax-filter' )
			)
		);
	}

	/**
	 * Wbcom_hide_all_admin_notices_from_setting_page
	 *
	 * @return void
	 */
	public function wbcom_hide_all_admin_notices_from_setting_page() {
		$wbcom_pages_array  = array( 'wbcomplugins', 'wbcom-plugins-page', 'wbcom-support-page', 'wc-ajax-filter-settings' );
		$wbcom_setting_page = filter_input( INPUT_GET, 'page' ) ? filter_input( INPUT_GET, 'page' ) : '';

		if ( in_array( $wbcom_setting_page, $wbcom_pages_array, true ) ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
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
		add_submenu_page( 'wbcomplugins', esc_html__( 'Wbcom Ajax Filter for Woocommerce', 'wb-ajax-filter' ), esc_html__( 'Wbcom Ajax Filter for Woocommerce', 'wb-ajax-filter' ), 'manage_options', 'wc-ajax-filter-settings', array( $this, 'wb_ajax_filter_admin_options_page' ) );
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
		<div class="wbcom-bb-plugins-offer-wrapper">
				<div id="wb_admin_logo">
				</div>
			</div>
		<div class="wbcom-wrap">

				<div class="blpro-header">
					<div class="wbcom_admin_header-wrapper">
						<div id="wb_admin_plugin_name">
							<?php esc_html_e( 'Wbcom Ajax Filter For WooCommerce', 'wb-ajax-filter' ); ?>
							<span><?php 
							/* translators: %s: */
							printf( esc_html__( 'Version %s', 'wb-ajax-filter' ), esc_attr( WB_AJAX_FILTER_VERSION ) );
							?></span>
						</div>
						<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
					</div>
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
		$page = ( isset( $_REQUEST['tab'] ) && 'wb-ajax-filter-presets' === sanitize_text_field( wp_unslash( $_REQUEST['tab'] ) ) ) ? true : false; //phpcs:ignore
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
	 * Create or update a filter preset
	 * 
	 * Processes form data from the preset creation modal and either creates
	 * a new preset or updates an existing one based on the provided data.
	 * 
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function create_filter_preset_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( isset( $_POST['form_data'] ) ) {
				$filter    = array();
				$form_data = wp_unslash( $_POST['form_data'] ); //phpcs:ignore
				// Converting form data into associative array.
				$filter_data   = $this->wb_ajax_process_form_data( $form_data );
				$result        = $this->wb_ajax_save_filter_data( $filter_data );

				echo $result;
			}
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
				if ( strtolower( $filter->post_title ) === $_POST['title'] || $_POST['title'] === $filter->post_title ) {
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
	 * Creates a duplicate filter preset.
	 * 
	 * @since 1.0.0
	 * @return void Output json response and terminates.
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
	 * Delete existing filter preset.
	 * 
	 * @since 1.0.0
	 * @return void Output json response and terminates.
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
	 * Creates a duplicate of single filter of a preset.
	 * 
	 * @since 1.0.0
	 * @return void Output json response and terminates.
	 */
	public function duplicate_single_filter_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['filter_id'] ) ) {
				exit;
			}
			$preset_id = sanitize_text_field( wp_unslash( $_POST['preset'] ) );
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
		}
		exit();
	}

	/**
	 * Deletes a single filter in preset.
	 * 
	 * @since 1.0.0
	 * @return void Output json response and terminates.
	 */
	public function delete_single_filter_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['filter_id'] ) ) {
				exit;
			}
			$new_filters = array();
			$preset_id   = sanitize_text_field( wp_unslash( $_POST['preset'] ) );
			$filter_id   = sanitize_text_field( wp_unslash( $_POST['filter_id'] ) );
			$filters     = get_post_meta( $preset_id, '_wb_filter', true );
			foreach ( $filters as $key => $filter ) {
				if ( $filter_id !== $filter['filter_id'] ) {
					$new_filters[] = $filter;
				}
			}
			update_post_meta( $preset_id, '_wb_filter', $new_filters );
			echo 'preset_deleted';
		}
		exit();
	}

	/**
	 * Enable/Disable filter preset to be rendered on shop page.
	 * 
	 * @since 1.0.0
	 * @return void 
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
	 * Enable/Disable single filter in preset to be rendered on shop page.
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function enable_disable_single_filter_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['enabled'] ) && ! isset( $_POST['filter_id'] ) ) {
				exit;
			}
			$preset_id = sanitize_text_field( wp_unslash( $_POST['preset'] ) );
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
		}
		exit();
	}

	/**
	 * Modifies the title of the preset.
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function edit_preset_post_title_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['preset'] ) && ! isset( $_POST['title'] ) ) {
				exit;
			}
			$preset_id     = sanitize_text_field( wp_unslash( $_POST['preset'] ) );
			$title         = sanitize_text_field( wp_unslash( $_POST['title'] ) );
			$preset_update = array(
				'ID'         => $preset_id,
				'post_title' => $title,
			);

			wp_update_post( $preset_update );
		}
		exit();
	}

	/**
	 * Customizes the text of the terms used in taxonomy filter.
	 * 
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function customize_term_text_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
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
		}
		exit();
	}

	/**
	 * Sort the position of single filters in preset.
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function sortable_single_filters_wb_callback() {
		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_POST['old_index'] ) && ! isset( $_POST['new_index'] ) && ! isset( $_POST['preset'] ) ) {
				exit;
			}
			$old_index = sanitize_text_field( wp_unslash( $_POST['old_index'] ) );
			$new_index = sanitize_text_field( wp_unslash( $_POST['new_index'] ) );
			$preset    = sanitize_text_field( wp_unslash( $_POST['preset'] ) );
			$filters   = get_post_meta( $preset, '_wb_filter', true );
			$filter    = $filters[ $old_index ];
			unset( $filters[ $old_index ] );
			array_splice( $filters, $new_index, 0, array( $filter ) );
			update_post_meta( $preset, '_wb_filter', $filters );
		}
		exit();
	}

	/**
	 * Checks if the custom fields exists to be used in filter.
	 * 
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function check_custom_field_exists_wb_callback() {
		if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_GET['q'] ) ) {
				exit;
			}
			$field_slug = sanitize_text_field( wp_unslash( $_GET['q'] ) );
			$args         = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
			);
			$products       = get_posts( $args );
			$matched_fields = array();
			$exclude        = array();
			foreach ( $products as $prod ) {
				$meta_fields = get_post_meta( $prod->ID, '', false );
				foreach ( $meta_fields as $key => $value ) {
					if ( strpos( $key, $field_slug ) !== false && ! in_array( $key, $exclude ) ) {
						$temp             = array( $key, $key );
						$exclude[]        = $key;
						$matched_fields[] = $temp;
					}
				}
			}
			echo wp_json_encode( $matched_fields );
		}
		exit();
	}

	/**
	 * Function to create settings tabs on the plugin menu page.
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_plugin_settings_tabs() {
		$current_tab = filter_input( INPUT_GET, 'tab' ) ? filter_input( INPUT_GET, 'tab' ) : 'wb-ajax-filter-welcome';
		// xprofile setup tab.
		echo '<div class="wbcom-tabs-section"><div class="nav-tab-wrapper"><div class="wb-responsive-menu"><span>' . esc_html( 'Menu' ) . '</span><input class="wb-toggle-btn" type="checkbox" id="wb-toggle-btn"><label class="wb-toggle-icon" for="wb-toggle-btn"><span class="wb-icon-bars"></span></label></div><ul>';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab === $tab_key ? 'nav-tab-active' : '';
			echo '<li class=' . esc_attr( $tab_key ) . '><a class="nav-tab ' . esc_attr( $active ) . '" id="' . esc_attr( $tab_key ) . '-tab" href="?page=wc-ajax-filter-settings&tab=' . esc_attr( $tab_key ) . '">' . esc_attr( $tab_caption ) . '</a></li>';
		}
		echo '</div></ul></div>';
	}

	/**
	 * Ajax callback function to search terms for select2 search box.
	 * 
	 * @since 1.0.0
	 * @return void Outputs JSON response and terminates.
	 */
	public function select2_get_terms_wb_callback() {
		if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_GET['q'] ) && ! isset( $_GET['cat'] ) ) {
				exit;
			}
			$taxonomy = sanitize_text_field( wp_unslash( $_GET['cat'] ) );
			if( ! empty( $taxonomy ) ) {
				
				$terms    = get_terms(
					array(
						'taxonomy'   => $taxonomy,
						'hide_empty' => false,
					),
				);
				
				if( !empty( $terms ) && is_array( $terms ) ) {
					$results  = array();
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
	 * Function to register the plugin settings.
	 *
	 * @since  1.0.9
	 * @return void
	 */
	public function wb_ajax_filter_init_plugin_settings() {
		$wb_ajax_filter_search_settings = get_option( 'wb_ajax_filter_search_settings' );

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

		$this->plugin_settings_tabs['wb-ajax-filter-ajax-search-settings'] = esc_html__( 'Search Settings', 'wb-ajax-filter' );
		register_setting( 'wb_ajax_filter_search_settings', 'wb_ajax_filter_search_settings' );
		add_settings_section( 'wb-ajax-filter-ajax-search-settings', ' ', array( $this, 'wb_ajax_filter_admin_ajax_search_settings_content' ), 'wb-ajax-filter-ajax-search-settings' );

		if( isset( $wb_ajax_filter_search_settings['enable_search'] ) && ( 'yes' === $wb_ajax_filter_search_settings['enable_search'] ) ) {
			$this->plugin_settings_tabs['wb-ajax-filter-search'] = esc_html__( 'Search Options', 'wb-ajax-filter' );
			register_setting( 'wb_ajax_filter_search_content_settings', 'wb_ajax_filter_search_content_settings' );
			add_settings_section( 'wb-ajax-filter-search', ' ', array( $this, 'wb_ajax_filter_admin_search_content' ), 'wb-ajax-filter-search' );
		}
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin welcome setting tab content file.
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_admin_welcome_content() {
		include_once 'partials/wb-ajax-filter-welcome-page.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin general setting tab content file.
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_admin_general_content() {
		include_once 'partials/wb-ajax-filter-setting-general-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin presets setting tab content file.
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_admin_presets_content() {
		include_once 'partials/wb-ajax-filter-setting-presets-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin customization setting tab content file.
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_admin_customization_content() {
		include_once 'partials/wb-ajax-filter-setting-customization-tab.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin ajax search setting tab content file.
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_admin_ajax_search_settings_content() {
		include_once 'partials/wb-ajax-filter-search-settings.php';
	}

	/**
	 * Include Wbcom ajax filter for woocommerce admin search setting tab content file.
	 * 
	 * @since  1.0.0
	 * @return void
	 */
	public function wb_ajax_filter_admin_search_content() {
		include_once 'partials/wb-ajax-filter-search-content.php';
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
	 * 
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
				return 'filter_created';
			}
		} else {
			$filters    = get_post_meta( $post_id, '_wb_filter', true );
			$new_filter = 0;
			foreach ( $filters as $key => $val ) {
				if ( $val['filter_id'] === $filter['filter_id'] ) {
					$filters[ $key ] = $filter;
					$new_filter++;
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