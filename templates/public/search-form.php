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

$wb_ajax_filter_search_settings = get_option( 'wb_ajax_filter_search_settings' );
if ( isset( $wb_ajax_filter_search_settings['enable_search'] ) && 'yes' === $wb_ajax_filter_search_settings['enable_search'] ) {
	$exclude_tax = array( 'product_type', 'product_visibility', 'product_shipping_class' );
	$taxonomies  = get_object_taxonomies( 'product', 'name' );
	$attributes  = wc_get_attribute_taxonomy_names();
	?>
<div class="wb-ajax-filter-ajaxsearch-filters" style="display: flex;">
	<div class="wb-ajax-filter-ajaxsearchform-select wb-ajax-filter-ajaxsearchform-select-list">
		<select class="wb-ajax-filter-post-type" name="post_type" tabindex="-1" aria-hidden="true">
			<option value="product"><?php esc_html_e( 'Products', 'wb-ajax-filter' ); ?></option>
			<option value="any"><?php esc_html_e( 'All', 'wb-ajax-filter' ); ?></option>
		</select>
	</div>
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
			<option value="<?php echo esc_attr( $tm->slug ); ?>"><?php echo esc_html( $tm->name ); ?></option>
						<?php
					}
				}
			}
			?>
		</select>
	</div>
</div>
<div class="wb-search-input-container">
	<input type="search" value="" name="s" placeholder="<?php echo esc_attr( $wb_ajax_filter_search_settings['search_input_label'] ); ?>" data-append-to=".wb-search-input-container" data-min-chars="3" autocomplete="off">
	<div class="wb-autocomplete-suggestions" style="position: absolute; display:none; z-index: 9999;"></div>
</div>
<div class="wb-search-submit-container"> <input type="submit" value="Search"> </div>
				<?php
			}
