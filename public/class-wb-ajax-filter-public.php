<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/public
 * @author     Wbcom Designs <https://wbcomdesigns.com/>
 */
class Wb_Ajax_Filter_Public {

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
	 * @since    1.0.0
	 * @param    string $plugin_name   The name of the plugin.
	 * @param    string $version       The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 * @param hook $hook hook.
	 */
	public function enqueue_styles( $hook ) {

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
		global $post;
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$extension = is_rtl() ? '.rtl.css' : '.css';
			$path      = is_rtl() ? '/rtl' : '';
		} else {
			$extension = is_rtl() ? '.rtl.css' : '.min.css';
			$path      = is_rtl() ? '/rtl' : '/min';
		}

		if( is_shop() || is_product_category()  || is_product_tag() || has_shortcode($post->post_content, 'wb_ajax_filters') ) {
			
			
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css' . $path . '/wb-ajax-filter-public' . $extension, array(), $this->version, 'all' );
			wp_enqueue_style( 'wb-ion-rangeslider', WB_AJAX_FILTER_URL . 'assets/css/ion.rangeSlider.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/css/select2.min.css', array(), $this->version, 'all' );
			wp_add_inline_style( $this->plugin_name, $this->wb_ajax_add_custom_css_to_frontend() );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		global $post;

		$wb_ajax_filter_search_settings   = get_option( 'wb_ajax_filter_search_settings' );
		$wb_ajax_filter_search_label      = isset( $wb_ajax_filter_search_settings['search_input_label'] ) ? $wb_ajax_filter_search_settings['search_input_label'] : 'Search';
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$extension = '.js';
			$path      = '';
		} else {
			$extension = '.min.js';
			$path      = '/min';
		}
		if( is_shop() || is_product_category()  || is_product_tag() || has_shortcode($post->post_content, 'wb_ajax_filters')  ) {
			
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js' . $path . '/wb-ajax-filter-public' . $extension, array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'wb-ion-rangeslider', WB_AJAX_FILTER_URL . 'assets/js/ion.rangeSlider.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/js/select2.min.js', array( 'jquery' ), $this->version, true );
			wp_localize_script(
				$this->plugin_name,
				'wbcom_plugin_installer_params',
				array(
					'ajax_url'         => admin_url( 'admin-ajax.php' ),
					'wbcom_ajax_nonce' => wp_create_nonce( 'ajax-nonce' ),
					'wb_ajax_filter_search_label' => $wb_ajax_filter_search_label
				)
			);
		}
	}

	/**
	 * Renders default search filters on shop page.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function add_wb_ajax_filters() {
		$customization_options = get_option( 'wb_ajax_filter_admin_customization_options' );
		$columns               = isset( $customization_options['filters_per_column'] ) ? $customization_options['filters_per_column'] : 5;
		echo '<div class="wb-ajax-filter-content-container filter-columns-' . esc_attr( $columns ) . '">';
		echo do_shortcode( '[wb_ajax_filters]' );
		echo '</div>';
	}

	/**
	 * Add custom css from customization settings
	 *
	 * @since    1.0.0
	 */
	public function wb_ajax_add_custom_css_to_frontend() {
		$css_settings = get_option( 'wb_ajax_filter_admin_customization_options' );

		if( empty( $css_settings ) ) {
			return '';
		}

		$custom_css   = '
				.wb-ajax-filters-container{
					background: ' . $css_settings['filters_area_background_color'] . ';
				}
				span.select2-selection.select2-selection--single {
					background: ' . $css_settings['filters_area_background_color'] . ';
				}
				.wb-ajax-filter-container-single h4{
					color: ' . $css_settings['filters_area_titles_color'] . ';
				}
				.wb-ajax-filter-container-single .wb-ajax-accordian span.dashicons{
					color: ' . $css_settings['filters_area_titles_color'] . ';
				}
				.select2-container--default .select2-search--dropdown input.select2-search__field{
					border: 1px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				span.select2-dropdown.select2-dropdown--above {
					border: 1px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				span.select2-dropdown.select2-dropdown--below {
					border: 1px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				span.wb-ajax-filter-tooltip-text, 
				.wb-ajax-active-filters-container span.wb-ajax-filter-clear-single.button
				{
					color: ' . $css_settings['textual_terms_tooltip_text_color'] . ';
					background: ' . $css_settings['filters_area_accent_color'] . ';
				}
				.wb-ajax-active-filters-container .wb-ajax-active-filters-container-single{
					border: 1px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				span.wb-ajax-filter-tooltip-text:before{
					border-color:' . $css_settings['filters_area_accent_color'] . ' transparent !important;
				}
				.irs span.irs-bar {
					background: ' . $css_settings['filters_area_accent_color'] . ';
				}
				.irs span.irs-handle{
					border: 3px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				.irs span.irs-from{
					background: ' . $css_settings['filters_area_accent_color'] . ';
				}
				.irs span.irs-to{
					background: ' . $css_settings['filters_area_accent_color'] . ';
				}
				a.wb-term-label {
					color: ' . $css_settings['textual_terms_text_color'] . ';
				}
				a.wb-term-label:hover {
					color: ' . $css_settings['textual_terms_hover_text_color'] . ';
				}
				li.select2-results__option{
					color: ' . $css_settings['textual_terms_text_color'] . ';
				}
				li.select2-results__option:hover{
					color: ' . $css_settings['textual_terms_hover_text_color'] . ';
				}
				li a.price-range{
					color: ' . $css_settings['textual_terms_text_color'] . ';
				}
				li a.price-range.filter-active{
					color: ' . $css_settings['textual_terms_active_text_color'] . ';
					border: 1px dotted ' . $css_settings['textual_terms_active_text_color'] . ';
				}
				li a.price-range:hover{
					color: ' . $css_settings['textual_terms_hover_text_color'] . ';
				}
				.select2-container--default .select2-selection--single span.select2-selection__rendered{
					color: ' . $css_settings['textual_terms_text_color'] . ';
				}
				span.wb-ajax-filter-option-text{
					color: ' . $css_settings['textual_terms_text_color'] . ';
				}
				span.wb-ajax-filter-option-text.filter-active{
					color: ' . $css_settings['textual_terms_active_text_color'] . ';
				}
				a.wb-term-label.wb-tooltip-added.filter-active{
					color: ' . $css_settings['textual_terms_active_text_color'] . ';
				}
				a.wb-term-label.wb-tooltip-added.filter-active:hover{
					color: ' . $css_settings['textual_terms_hover_text_color'] . ';
				}
				span.wb-ajax-filter-option-text:hover{
					color: ' . $css_settings['textual_terms_hover_text_color'] . ';
				}
				li.select2-results__option[data-selected="true"]{
					color: ' . $css_settings['textual_terms_active_text_color'] . ';
				}
				';
		return $custom_css;
	}

	/**
	 * Add ajax loader gif on shop page.
	 *
	 * @since    1.0.0
	 */
	public function add_wb_ajax_filters_loader_in_footer() {
		?>
		<div class="wb-ajax-filter-loader-container" style="display:none">
		<?php
		$customization_options = get_option( 'wb_ajax_filter_admin_customization_options' );
		if ( isset( $customization_options['ajax_loader_style'] ) && 'custom' === $customization_options['ajax_loader_style'] ) {
			?>
			<?php if ( isset( $customization_options['loader_url'] ) && '' !== $customization_options['loader_url'] ) { ?>
			<div class="gif-container">
				<img src="<?php echo ( isset( $customization_options['loader_url'] ) ) ? esc_attr( $customization_options['loader_url'] ) : ''; ?>" alt="">
			</div>
				<?php
			}
		} else {
			?>
			<div class="gif-container-default"></div>
			<?php
		}
		?>
		</div>
		<?php
	}

	/**
	 * Check if parent exists in terms array.
	 *
	 * @param int $term_id The term id to find.
	 * @param array  $terms The terms array.
	 * @since    1.0.0
	 */
	public function wb_ajax_check_parent_is_included( $term_id, $terms ) {
		$exists = false;
		
		if( empty( $terms ) || empty( $term_id ) ) {
			$exists = false;
		}

		foreach ( $terms as $term ) {
			if ( (int) $term_id === (int) $term->id ) {
				$exists = true;
			}
		}
		return $exists;
	}

	/**
	 * Check string inside string
	 *
	 * @param string $content The content.
	 * @param string $find  The string to be searched inside content.
	 * @since    1.0.0
	 */
	public function wb_check_content_contains_string( $content, $find ) {
		if ( strpos( $content, $find ) !== false || strpos( $content, ucfirst( $find ) ) !== false || strpos( $content, strtolower( $find ) ) !== false ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Ajax search box autocomplete callback.
	 *
	 * @since    1.0.0
	 */
	public function get_ajax_search_autocomplete_title_wb_callback() {
		if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'ajax-nonce' ) ) {
			wp_die();
		}

		if ( ! isset( $_GET['q'] ) ) {
			wp_die();
		}

		$q               = sanitize_text_field( wp_unslash( $_GET['q'] ) );
		$limit           = 10; // Default or get from settings
		$matched_results = $this->get_search_suggestions( $q, $limit );

		$matched_products = array();
		foreach ( $matched_results as $product ) {
			$matched_products[] = array( $product->post_title, $product->post_title );
		}

		if ( ! empty( $matched_products ) ) {
			$matched_products = apply_filters( 'wb_ajax_filter_restrict_products', $matched_products );
			echo wp_json_encode( $matched_products );
		}

		wp_die();
	}

	private function get_search_suggestions( $query, $limit = 10 ) {
		global $wpdb;

		$cache_key = 'wb_search_ext_' . md5( $query . $limit );
		$results   = wp_cache_get( $cache_key, 'wb_ajax_filter' );

		if ( false === $results ) {
			$search_settings        = get_option( 'wb_ajax_filter_search_settings' );
			$search_filter_settings = get_option( 'wb_ajax_filter_search_content_settings' );

			$searchable_fields = [];

			if ( isset( $search_filter_settings['search_in_title'] ) && $search_filter_settings['search_in_title'] === 'yes' ) {
				$searchable_fields[] = 'p.post_title';
			}
			if ( isset( $search_filter_settings['search_in_content'] ) && $search_filter_settings['search_in_content'] === 'yes' ) {
				$searchable_fields[] = 'p.post_content';
			}
			if ( isset( $search_filter_settings['search_in_excerpt'] ) && $search_filter_settings['search_in_excerpt'] === 'yes' ) {
				$searchable_fields[] = 'p.post_excerpt';
			}
			$include_sku = isset( $search_filter_settings['search_by_sku'] ) && $search_filter_settings['search_by_sku'] === 'yes';
			
			if ( empty( $searchable_fields ) && ! $include_sku ) {
				return []; // Nothing to search
			}

			$like_query = '%' . $wpdb->esc_like( $query ) . '%';
			$like_clauses = [];

			foreach ( $searchable_fields as $field ) {
				$like_clauses[] = $wpdb->prepare( "$field LIKE %s", $like_query ); //phpcs:ignore
			}

			if ( $include_sku ) {
				$like_clauses[] = $wpdb->prepare( "pm.meta_value LIKE %s", $like_query );
			}

			$where_clause = implode( ' OR ', $like_clauses );

			// Dynamic limit fallback
			$limit = isset( $search_settings['posts_per_page'] ) ? intval( $search_settings['posts_per_page'] ) : $limit;

			// Final SQL query
			$sql = "
				SELECT DISTINCT p.ID, p.post_title
				FROM {$wpdb->posts} p
				" . ( $include_sku ? "LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = '_sku'" : '' ) . "
				WHERE p.post_type = 'product'
				AND p.post_status = 'publish'
				AND ( $where_clause )
				LIMIT %d
			";

			$results = $wpdb->get_results( $wpdb->prepare( $sql, $limit ) ); //phpcs:ignore

			wp_cache_set( $cache_key, $results, 'wb_ajax_filter', 300 );
		}

		return $results;
	}

	/**
	 * Alter woocommerce products query.
	 *
	 * @param object $q Query Object.
	 */
	public function wb_ajax_filter_modify_wc_product_query( $q ) {
		
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			$params = $_GET; //phpcs:ignore
			$meta_query      = array();
			if ( isset( $params['preset'] ) ) {
				$preset_id   = absint( $params['preset'] );
				
				$filters                     = get_post_meta( $preset_id, '_wb_filter', true );
				if ( $filters ) {
					foreach ( $filters as $filter ) {
						
						if ( isset( $filter['type'] ) && 'tax' == $filter['type'] ) {
							$q = $this->wb_ajax_apply_taxonomy_filter( $q, $filter, $params );
						}
						
					}
				}
			} 
			
			$q = $this->wb_ajax_apply_meta_filter( $q, array(), $params );
		}
		return $q;
	}

	/**
	 * Function to check if the preset is enabled or not.
	 * 
	 * @param array $presets Array of presets.
	 * @since 1.0.0
	 * @return bool True/False
	 */
	public function wb_ajax_filter_presets_are_enabled( $presets ) {
		$enabled = false;
		foreach ( $presets as $preset ) {
			if ( $enabled ) {
				break;
			}
			$preset_enabled = get_post_meta( $preset->ID, 'preset_enabled', true );
			$enabled        = ( 'yes' === $preset_enabled ) ? true : false;
		}
		return $enabled;
	}

	/**
	 * Filter preset shortcode callback.
	 */
	public function filter_preset_shortcode_callback() {
		ob_start();
		$args                           = array(
			'post_type'   => 'wb_filter_preset',
			'post_status' => 'publish',
			'numberposts' => -1,
		);
		$presets                        = get_posts( $args );
		$wb_ajax_filter_admin_custom    = get_option( 'wb_ajax_filter_admin_customization_options' );
		$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );

		$wb_ajax_filter_search_settings = get_option( 'wb_ajax_filter_search_settings' );

		if ( isset( $_GET ) ) { //phpcs:ignore
			$params     = array();
			$get_params = $_GET; //phpcs:ignore
			foreach ( $get_params as $key => $val ) {
				$values = explode( ',', $val );
				if ( count( $values ) > 1 ) {
					$tmp = array();
					foreach ( $values as $val ) {
						$tmp[] = $val;
					}
					$params[ $key ] = $tmp;
				} else {
					$params[ $key ] = $val;
				}
			}
		}
		
		$enable_filter_actions = !empty( $presets ) ? self::wb_ajax_filter_presets_are_enabled( $presets ) : false;

		$render_setting  = ( isset( $wb_ajax_filter_search_settings['enable_search'] ) || ( $enable_filter_actions ) ) ? true : false;
		
		do_action( 'wb_ajax_filter_before_content' );
		if ( $render_setting && isset( $wb_ajax_filter_admin_custom['filters_title'] ) && '' !== $wb_ajax_filter_admin_custom['filters_title'] ) {
			?>
			<h3 class="wb-ajax-preset-filter-title" style="display:block;"><?php echo esc_html( $wb_ajax_filter_admin_custom['filters_title'] ); ?></h3>
			<?php
		}
		if ( $render_setting && isset( $wb_ajax_filter_general_options['show_active_labels'] ) && 'yes' === $wb_ajax_filter_general_options['show_active_labels'] ) {
			require WB_AJAX_FILTER_TEMPLATE_PATH . '/filters/global/active-filters.php';
		}
		if ( $render_setting && isset( $wb_ajax_filter_general_options['show_reset'] ) && isset( $wb_ajax_filter_general_options['reset_button_position'] ) && 'before_filters' === $wb_ajax_filter_general_options['reset_button_position'] ) {
			require WB_AJAX_FILTER_TEMPLATE_PATH . '/filters/global/reset-filters.php';
		}
		if( isset( $wb_ajax_filter_search_settings['enable_search'] ) && ( 'yes' == $wb_ajax_filter_search_settings['enable_search'] ) ) { ?>
			<div class="wb-ajax-search-container">
				<form method="GET" action="">
					<?php
					$custom_template = get_stylesheet_directory() . '/wb-ajax-filter/search-form.php';
					if ( file_exists( $custom_template ) ) {
						include $custom_template;
					} else {
						require_once WB_AJAX_FILTER_TEMPLATE_PATH . 'public/search-form.php';
					}
					?>
				</form>
			</div>
		<?php }

		if ( ! empty( $presets ) ) {

			foreach ( $presets as $preset ) {
				$preset_id   = $preset->ID;
				$all_filters = apply_filters( 'wb_ajax_filter_get_preset_filters', get_post_meta( $preset_id, '_wb_filter', true ), $preset_id );
				$enabled     = get_post_meta( $preset_id, 'preset_enabled', true );
				include WB_AJAX_FILTER_TEMPLATE_PATH . '/shortcode/preset-filter.php';
			}
			
			if ( $enable_filter_actions && isset( $wb_ajax_filter_general_options['instant_filters'] ) && 'no' === $wb_ajax_filter_general_options['instant_filters'] ) {
				require WB_AJAX_FILTER_TEMPLATE_PATH . '/filters/global/apply-filters.php';
			}
			do_action( 'wb_ajax_filter_after_content' );
		}
		
		if ( $render_setting && isset( $wb_ajax_filter_general_options['show_reset'] ) &&  isset( $wb_ajax_filter_general_options['reset_button_position'] ) && ( 'after_filters' === $wb_ajax_filter_general_options['reset_button_position'] ) ) {
			require WB_AJAX_FILTER_TEMPLATE_PATH . '/filters/global/reset-filters.php';
		}
				
		return ob_get_clean();
	}

	/**
	 * Function to redirect single product search result on shop page instead of redirecting to product page.
	 * 
	 * @since 1.2.1
	 * @return bool false
	 */
	public function wb_ajax_filter_redirect_single_search_result() {
		return false;
	}

	/**
	 * Function to build tax query to filter products.
	 * 
	 * @param array $q Product Query.
	 * @param array $filter Custom Filter data.
	 * @param array $params URL parameters.
	 * 
	 * @return array $q Modified Product Query.
	 * 
	 */
	public function wb_ajax_apply_taxonomy_filter( $q, $filter, $params ) {

		$taxonomy     = $filter['taxonomy'];
		$include_tags = array( 'product_tag', 'product_cat' );
		$attributes   = wc_get_attribute_taxonomy_names();
		if ( in_array( $filter['taxonomy'], $attributes, true ) ) {
			if ( strpos( $taxonomy, 'pa_' ) !== false ) {
				$taxonomy = str_replace( 'pa_', 'filter_', $taxonomy );
			}
			if ( array_key_exists( $taxonomy, $params ) ) {
				$tax_query = $q->query_vars['tax_query'];
				foreach ( $tax_query as $key => $qr ) {
					if ( is_array( $qr ) && isset( $qr['taxonomy'] ) && $filter['taxonomy'] === $qr['taxonomy'] ) {
						if ( isset( $filter['multiple'] ) && isset( $filter['relation'] ) && 'yes' === $filter['multiple'] ) {
							unset( $tax_query[ $key ]['operator'] );
							$tax_query[ $key ]['operator'] = strtoupper( $filter['relation'] );

						}
					}
				}
				unset( $q->query_vars['tax_query'] );
				$q->query_vars['tax_query'] = $tax_query;
			}
		} elseif ( in_array( $taxonomy, $include_tags, true ) ) {
			$tax_query = $q->tax_query->queries;
			foreach ( $tax_query as $key => $qr ) {
				if ( is_array( $qr ) && isset( $qr['taxonomy'] ) && $filter['taxonomy'] === $qr['taxonomy'] ) {
					if ( isset( $filter['multiple'] ) && isset( $filter['relation'] ) && 'yes' === $filter['multiple'] ) {
						unset( $tax_query[ $key ]['operator'] );
						$tax_query[ $key ]['operator'] = strtoupper( $filter['relation'] );
					}
				}
			}
			$q->tax_query->queries = $tax_query;
		}
		return $q;
	}

	/**
	 * Function to build meta query to filter products.
	 * 
	 * @param array $q Product Query.
	 * @param array $filter Custom Filter data.
	 * @param array $params URL parameters.
	 * 
	 * @return array $q Modified Product Query.
	 * 
	 */
	public function wb_ajax_apply_meta_filter( $q, $filter, $params ) {
				
		$search_settings         = get_option( 'wb_ajax_filter_admin_general_options' );
		$search_content_settings = get_option( 'wb_ajax_filter_search_content_settings' );
		
		if( !empty( $params ) && ( isset( $params['instock_filter'] ) || isset( $params['onsale_filter'] ) ) ) {
				
			if( array_key_exists( 'instock_filter', $params ) ) {
				$meta_query[] = array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '==',
				);
			} else if( array_key_exists( 'onsale_filter', $params ) ) {
				$meta_query[] = array(
					'key'     => '_sale_price',
					'value'   => '0',
					'compare' => '>=',
				);
				$q->query_vars['post_type']  = array( 'product', 'product_variation' );
			}
			$q->query_vars['meta_query'] = $meta_query;
		} 
		if( ! empty( $params ) && isset( $search_settings['hide_out_of_stock'] ) && 'yes' === $search_settings['hide_out_of_stock'] ) {
			
			$meta_query[] = array(
				'key'     => '_stock_status',
				'value'   => 'instock',
				'compare' => '==',
			);
			$q->query_vars['meta_query'] = $meta_query;
			
		}
		if ( isset( $search_content_settings['cf_name'] ) && '' !== $search_content_settings['cf_name'] && isset( $q->query_vars['post_type'] ) && 'product' === $q->query_vars['post_type'] ) {
			$custom = $search_content_settings['cf_name'];
			
			if ( array_key_exists( 'meta_' . $custom, $params ) ) {
				$meta_query[] = array(
					'key'     => $custom,
					'value'   => $params[ 'meta_' . $custom ],
					'compare' => '==',
				);
				$q->query_vars['meta_query'] = $meta_query;
			}
			
		}
		
		
		return $q;
	}
}
