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
			'filters_title'                    => 'Filters',
			'filters_area_titles_color'        => '#000000',
			'filters_area_background_color'    => '#ffffff',
			'filters_area_accent_color'        => '#1e73be',
			'filters_style'                    => 'theme',
			'textual_terms_text_color'         => '#000000',
			'textual_terms_hover_text_color'   => '#000000',
			'textual_terms_active_text_color'  => '#db4e32',
			'textual_terms_tooltip_text_color' => '#000000',
			'ajax_loader_style'                => 'default',
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
			'default_research'       => 'product',
			'search_in_title'        => 'yes',
			'search_in_excerpt'      => 'yes',
			'search_in_content'      => 'yes',
			'search_type_more_words' => 'and',
		);
		foreach ( $wb_ajax_filter_settings as $key => $settings ) {

			if ( empty( get_option( $key ) ) ) {

				update_option( $key, $settings );
			}
		}

		self::maybe_seed_default_preset();
	}

	/**
	 * Seed one enabled "Default" preset so the shop filters immediately after activation.
	 *
	 * The front end only renders filters from presets, so without this a fresh install
	 * shows an empty shell (title/search/reset) until the owner hand-builds a preset.
	 * Runs once: on activation when WooCommerce is already active, otherwise retried on
	 * `init` (also covers existing sites that update the plugin, where the activation
	 * hook never fires). The `wb_ajax_filter_default_preset_seeded` option is the
	 * one-shot latch - once set, the owner can edit, disable or delete the Default
	 * preset and it is never recreated.
	 *
	 * @since 1.2.2
	 * @return void
	 */
	public static function maybe_seed_default_preset() {
		if ( get_option( 'wb_ajax_filter_default_preset_seeded' ) ) {
			return;
		}

		// WooCommerce not loaded yet (or taxonomies not registered): retry on a later
		// request instead of latching, so the seed still lands once WooCommerce is up.
		if ( ! function_exists( 'wc_get_attribute_taxonomy_names' ) || ! taxonomy_exists( 'product_cat' ) ) {
			return;
		}

		$latch = defined( 'WB_AJAX_FILTER_VERSION' ) ? WB_AJAX_FILTER_VERSION : '1';

		// A store that already has any preset has configured (or deliberately disabled)
		// filtering - never overwrite that decision.
		$existing = get_posts(
			array(
				'post_type'   => 'wb_filter_preset',
				'post_status' => 'publish',
				'numberposts' => 1,
				'fields'      => 'ids',
			)
		);
		if ( ! empty( $existing ) ) {
			update_option( 'wb_ajax_filter_default_preset_seeded', $latch );
			return;
		}

		$preset_id = wp_insert_post(
			array(
				'post_type'      => 'wb_filter_preset',
				'post_title'     => __( 'Default', 'wb-ajax-filter' ),
				'post_content'   => 'Wb Ajax filter Preset',
				'post_status'    => 'publish',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			)
		);

		if ( $preset_id && ! is_wp_error( $preset_id ) ) {
			update_post_meta( $preset_id, '_wb_filter', self::build_default_filters() );
			update_post_meta( $preset_id, 'preset_enabled', 'yes' );
		}

		update_option( 'wb_ajax_filter_default_preset_seeded', $latch );
	}

	/**
	 * Build the `_wb_filter` entries for the seeded Default preset.
	 *
	 * Category, price slider, in stock/on sale, then one filter per product attribute
	 * taxonomy that already has terms. Empty taxonomies are skipped. Every entry uses
	 * the exact shape the admin create flow saves (see wb_ajax_save_filter_data()),
	 * so the owner can edit each seeded filter in the preset builder afterwards.
	 *
	 * @since 1.2.2
	 * @return array Filter entries for the `_wb_filter` post meta.
	 */
	private static function build_default_filters() {
		$filters = array();

		$category_filter = self::build_tax_filter( 'product_cat', __( 'Category', 'wb-ajax-filter' ) );
		if ( $category_filter ) {
			$filters[] = $category_filter;
		}

		$filters[] = array(
			'filter_id'      => uniqid( 'wb_filter_' ),
			'filter_title'   => __( 'Price', 'wb-ajax-filter' ),
			'type'           => 'price_slider',
			'filter_enabled' => 'yes',
		);

		$filters[] = array(
			'filter_id'         => uniqid( 'wb_filter_' ),
			'filter_title'      => __( 'Availability', 'wb-ajax-filter' ),
			'type'              => 'stock_sale',
			'show_stock_filter' => 'yes',
			'show_sale_filter'  => 'yes',
			'filter_enabled'    => 'yes',
		);

		foreach ( wc_get_attribute_taxonomy_names() as $attribute_taxonomy ) {
			$label            = wc_attribute_label( $attribute_taxonomy );
			$attribute_filter = self::build_tax_filter( $attribute_taxonomy, $label );
			if ( $attribute_filter ) {
				$filters[] = $attribute_filter;
			}
		}

		return $filters;
	}

	/**
	 * Build one taxonomy filter entry, or null when the taxonomy has no terms.
	 *
	 * Terms are stored the way the admin builder stores them: an array of objects
	 * with `id` and `text` (the front-end templates read exactly those two keys).
	 * Capped at 100 terms by product count so a large catalog cannot balloon the
	 * preset meta row; the owner can curate the list in the builder later.
	 *
	 * @since 1.2.2
	 * @param string $taxonomy Taxonomy slug (product_cat or a pa_* attribute).
	 * @param string $title    Filter title shown to shoppers.
	 * @return array|null Filter entry, or null when the taxonomy has no terms.
	 */
	private static function build_tax_filter( $taxonomy, $title ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'orderby'    => 'count',
				'order'      => 'DESC',
				'number'     => 100,
			)
		);

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return null;
		}

		$term_options = array();
		foreach ( $terms as $term ) {
			$term_option       = new stdClass();
			$term_option->id   = (string) $term->term_id;
			$term_option->text = $term->name;
			$term_options[]    = $term_option;
		}

		return array(
			'filter_id'      => uniqid( 'wb_filter_' ),
			'filter_title'   => $title,
			'type'           => 'tax',
			'taxonomy'       => $taxonomy,
			'terms'          => $term_options,
			'filter_design'  => 'checkbox',
			'order_by'       => 'name',
			'order'          => 'ASC',
			'hierarchical'   => 'no',
			'multiple'       => 'yes',
			'relation'       => 'or',
			'filter_enabled' => 'yes',
		);
	}
}
