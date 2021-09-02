<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
 * @author     Wbcom Designs <https://wbcomdesigns.com/>
 */
class Wb_Ajax_Filter_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$wb_ajax_filter_settings = array();
		$wb_ajax_filter_settings['wb_ajax_filter_admin_general_options']       = array(
			'instant_filters'       => 'yes',
			'ajax_filters'          => 'yes',
			'hide_out_of_stock'     => 'yes',
			'show_reset'            => 'yes',
			'reset_button_position' => 'before_filters',
			'show_clear_filter'     => 'yes',
			'show_active_labels'    => 'yes',
			'scroll_top'            => 'yes',
		);
		$wb_ajax_filter_settings['wb_ajax_filter_admin_customization_options'] = array(
			'filters_title'                   => 'Filters',
			'filters_area_titles_color'       => '#000000',
			'filters_area_background_color'   => '#ffffff',
			'filters_area_accent_color'       => '#1e73be',
			'filters_style'                   => 'yes',
			'textual_terms_text_color'        => '#000000',
			'textual_terms_hover_text_color'  => '#000000',
			'textual_terms_active_text_color' => '#db4e32',
			'ajax_loader_style'               => 'default',
		);
		$wb_ajax_filter_settings['wb_ajax_filter_search_settings']             = array(
			'enable_search'       => 'yes',
			'search_input_label'  => 'Search',
			'search_submit_label' => 'Search',
			'min_chars'           => '1',
			'posts_per_page'      => '10',
			'show_search_list'    => 'yes',
			'show_category_list'  => 'yes',
		);
		$wb_ajax_filter_settings['wb_ajax_filter_search_content_settings']     = array(
			'default_research'             => 'product',
			'search_in_title'              => 'yes',
			'search_in_excerpt'            => 'yes',
			'search_in_content'            => 'yes',
			'search_in_product_categories' => 'yes',
			'search_in_product_tags'       => 'yes',
			'search_in_author'             => 'yes',
			'search_type_more_words'       => 'and',
			'hide_out_of_stock'            => 'yes',
			'order_by_post_type'           => 'yes',
		);
		foreach ( $wb_ajax_filter_settings as $key => $settings ) {
			update_option( $key, $settings );
		}
	}

}
