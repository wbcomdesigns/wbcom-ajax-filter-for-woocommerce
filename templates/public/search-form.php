<?php
/**
 * The template for displaying search form on the frontend.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

$wb_ajax_filter_search_settings         = get_option( 'wb_ajax_filter_search_settings' );
$wb_ajax_filter_search_content_settings = get_option( 'wb_ajax_filter_search_content_settings' );
if ( isset( $wb_ajax_filter_search_settings['enable_search'] ) && 'yes' === $wb_ajax_filter_search_settings['enable_search'] ) {
	$exclude_tax = array( 'product_type', 'product_visibility', 'product_shipping_class' );
	$taxonomies  = get_object_taxonomies( 'product', 'name' );
	$attributes  = wc_get_attribute_taxonomy_names();
	?>
<div class="wb-ajax-filter-ajaxsearch-filters-container" style="display: flex;">
	<div class="wb-ajax-filter-ajaxsearch-filters" style="display: flex;">
		<?php if ( isset( $wb_ajax_filter_search_settings['show_search_list'] ) && 'yes' === $wb_ajax_filter_search_settings['show_search_list'] ) { ?>
		<div class="wb-ajax-filter-ajaxsearchform-select wb-ajax-filter-ajaxsearchform-select-list">
			<select class="wb-ajax-filter-post-type" name="post_type" tabindex="-1" aria-hidden="true">
				<?php if ( isset( $wb_ajax_filter_search_content_settings['default_research'] ) && 'any' === $wb_ajax_filter_search_content_settings['default_research'] ) { ?>
				<option value="any" <?php echo ( isset( $_REQUEST['post_type'] ) && 'any' === $_REQUEST['post_type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'All', 'wb-ajax-filter' ); ?></option>
				<?php } ?>
				<option value="product" <?php echo ( isset( $_REQUEST['post_type'] ) && 'product' === $_REQUEST['post_type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Products', 'wb-ajax-filter' ); ?></option>
			</select>
		</div>
		<?php } ?>
		<?php if ( isset( $wb_ajax_filter_search_settings['show_category_list'] ) && 'yes' === $wb_ajax_filter_search_settings['show_category_list'] ) { ?>
		<div class="wb-ajax-filter-ajaxsearchform-select wb-ajax-filter-ajaxsearchform-select-category">
			<select class="wb-ajax-search_categories" name="product_cat" tabindex="-1" aria-hidden="true">
				<option value=""><?php esc_html_e( 'All', 'wb-ajax-filter' ); ?></option>
				<?php
				foreach ( $taxonomies as $key => $val ) {
					if ( ! in_array( $val->name, $exclude_tax, true ) ) {
						$value = $val->name;
						$terms = get_terms(
							array(
								'taxonomy'   => $val->name,
								'hide_empty' => false,
							)
						);
						foreach ( $terms as $tm ) {
							?>
				<option value="<?php echo esc_attr( $tm->slug ); ?>" <?php echo ( isset( $_REQUEST['product_cat'] ) && $tm->slug === $_REQUEST['product_cat'] ) ? 'selected' : ''; ?>><?php echo esc_html( $tm->name ); ?></option>
							<?php
						}
					}
				}
				?>
			</select>
		</div>
		<?php } ?>
	</div>
	<div class="wb-ajax-filter-ajaxsearchform-select">
		<select id="wb_ajax_search_input" type="search" value="<?php echo ( isset( $_REQUEST['s'] ) && '' !== $_REQUEST['s'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) ) : ''; ?>" name="s" placeholder="<?php echo esc_attr( $wb_ajax_filter_search_settings['search_input_label'] ); ?>" data-append-to=".wb-search-input-container" data-min-chars="<?php echo ( isset( $wb_ajax_filter_search_settings['min_chars'] ) && '' !== $wb_ajax_filter_search_settings['min_chars'] ) ? esc_attr( $wb_ajax_filter_search_settings['min_chars'] ) : '1'; ?>" autocomplete="off">
			</select>
	</div>
	<div class="wb-search-submit-container"> <input type="submit" value="<?php echo ( isset( $wb_ajax_filter_search_settings['search_submit_label'] ) && '' !== $wb_ajax_filter_search_settings['search_submit_label'] ) ? esc_attr( $wb_ajax_filter_search_settings['search_submit_label'] ) : 'Search'; ?>"> </div>
</div>
				<?php
}
