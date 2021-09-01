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
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wb-ajax-filter-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wb-ion-rangeslider', WB_AJAX_FILTER_URL . 'assets/css/ion.rangeSlider.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/css/select2.min.css', array(), $this->version, 'all' );
		wp_add_inline_style( $this->plugin_name, $this->wb_ajax_add_custom_css_to_frontend() );

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wb-ajax-filter-public.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'wb_ajax_filter_shortcode', plugin_dir_url( __FILE__ ) . 'js/wb-ajax-filter-shortcode.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wb-ion-rangeslider', WB_AJAX_FILTER_URL . 'assets/js/ion.rangeSlider.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'wb-select2', WB_AJAX_FILTER_URL . 'assets/js/select2.min.js', array( 'jquery' ), $this->version, true );
		wp_localize_script(
			$this->plugin_name,
			'wbcom_plugin_installer_params',
			array(
				'ajax_url'         => admin_url( 'admin-ajax.php' ),
				'wbcom_ajax_nonce' => wp_create_nonce( 'ajax-nonce' ),
			)
		);
	}

	/**
	 * Display search filters on frontend
	 *
	 * @since    1.0.0
	 */
	public function add_wb_ajax_filters() {
		echo do_shortcode( '[wb_ajax_filters]' );
	}

	/**
	 * Add custom css from customization settings
	 *
	 * @since    1.0.0
	 */
	public function wb_ajax_add_custom_css_to_frontend() {
		$css_settings = get_option( 'wb_ajax_filter_admin_customization_options' );
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
				.select2-container--default .select2-search--dropdown input.select2-search__field{
					border: 1px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				span.select2-dropdown.select2-dropdown--above {
					border: 1px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				span.select2-dropdown.select2-dropdown--below {
					border: 1px solid ' . $css_settings['filters_area_accent_color'] . ';
				}
				span.wb-ajax-filter-tooltip-text{
					background: ' . $css_settings['filters_area_accent_color'] . ';
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
	 * Ajax search autocomplete callback.
	 *
	 * @since    1.0.0
	 */
	public function get_ajax_search_autocomplete_title_wb_callback() {
		if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'ajax-nonce' ) ) {
			exit();
		} else {
			if ( ! isset( $_GET['q'] ) ) {
				die();
			}
			$args             = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
			);
			$products         = get_posts( $args );
			$matched_products = array();
			$q                = sanitize_text_field( wp_unslash( $_GET['q'] ) );
			foreach ( $products as $product ) {
				if ( strpos( $product->post_title, ucfirst( $q ) ) === false && strpos( $product->post_title, strtolower( $q ) ) === false ) {
					continue;
				}
				$tmp                = array( $product->post_title, $product->post_title );
				$matched_products[] = $tmp;
			}
			echo wp_json_encode( $matched_products );
		}
		die();
	}
}
