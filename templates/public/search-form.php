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

$selected_category = ( isset( $_GET['product_cat'] ) && !empty( $_GET['product_cat'] ) ) ? sanitize_text_field( $_GET['product_cat'] ) : ''; //phpcs:ignore

?>
<div class="wb-ajax-filter-ajaxsearch-filters-container" style="display: flex;">
	<div class="wb-ajax-filter-ajaxsearch-filters" style="display: flex;">
		<?php if ( isset( $wb_ajax_filter_search_settings['show_search_list'] ) && 'yes' === $wb_ajax_filter_search_settings['show_search_list'] ) { ?>
		<div class="wb-ajax-filter-ajaxsearchform-select wb-ajax-filter-ajaxsearchform-select-list">
			<select class="wb-ajax-filter-post-type" name="post_type" tabindex="-1" aria-hidden="true">
				<?php if ( isset( $wb_ajax_filter_search_content_settings['default_research'] ) && 'any' === $wb_ajax_filter_search_content_settings['default_research'] ) { ?>
				<option value="any" <?php echo ( isset( $_REQUEST['post_type'] ) && 'any' === $_REQUEST['post_type'] ) ? 'selected' : ''; //phpcs:ignore?>><?php esc_html_e( 'All', 'wb-ajax-filter' ); ?></option>
				<?php } ?>
				<option value="product" <?php echo ( isset( $_REQUEST['post_type'] ) && 'product' === $_REQUEST['post_type'] ) ? 'selected' : ''; //phpcs:ignore?>><?php esc_html_e( 'Products', 'wb-ajax-filter' ); ?></option>
			</select>
		</div>
		<?php } ?>
		<?php if ( isset( $wb_ajax_filter_search_settings['show_category_list'] ) && 'yes' === $wb_ajax_filter_search_settings['show_category_list'] ) { ?>
		<div class="wb-ajax-filter-ajaxsearchform-select wb-ajax-filter-ajaxsearchform-select-category"><?php
			
			$wb_ajax_category_dropdown = wp_dropdown_categories(
				array(
					'taxonomy'        => array( 'product_cat' ),
					'hierarchical'    => 1,
					'hide_empty'      => false,
					'class'           => 'wb-ajax-search_categories',
					'show_option_all' => __( 'Search by Category', 'wb-ajax-filter' ),
					'name'            => 'product_cat',
					'show_count'      => true,
					'value_field'     => 'slug',
					'echo'            => true,
					'selected'        =>$selected_category, 
				)
			);
			
		?>
		</div>
		<?php } ?>
	</div>
	<div class="wb-ajax-filter-ajaxsearchform-select">
		<select id="wb_ajax_search_input" type="search" name="s" placeholder="<?php echo esc_attr( $wb_ajax_filter_search_settings['search_input_label'] ); ?>" data-append-to=".wb-search-input-container" data-min-chars="<?php echo ( isset( $wb_ajax_filter_search_settings['min_chars'] ) && '' !== $wb_ajax_filter_search_settings['min_chars'] ) ? esc_attr( $wb_ajax_filter_search_settings['min_chars'] ) : '1'; ?>" autocomplete="off">
			</select>
	</div>
	<?php if ( isset( $wb_ajax_filter_search_content_settings['cf_name'] ) && '' !== $wb_ajax_filter_search_content_settings['cf_name'] ) : ?>
		<div class="wb-ajax-filter-ajaxsearchform-input">
			<input type="text" id="wb_ajax_search_custom_field" placeholder="<?php echo esc_attr__( 'Enter value', 'wb-ajax-filter' ); ?>" name="meta_<?php echo esc_attr( $wb_ajax_filter_search_content_settings['cf_name'] ); ?>" value="<?php echo ( isset( $_REQUEST[ 'meta_' . $wb_ajax_filter_search_content_settings['cf_name'] ] ) && '' !== $_REQUEST[ 'meta_' . $wb_ajax_filter_search_content_settings['cf_name'] ] ) ? esc_attr( sanitize_text_field( wp_unslash( $_REQUEST[ 'meta_' . $wb_ajax_filter_search_content_settings['cf_name'] ] ) ) ) : ''; //phpcs:ignore?>">
		</div>	
	<?php endif; ?>
	<div class="wb-search-submit-container"><input type="submit" value="<?php echo ( isset( $wb_ajax_filter_search_settings['search_submit_label'] ) && '' !== $wb_ajax_filter_search_settings['search_submit_label'] ) ? esc_attr( $wb_ajax_filter_search_settings['search_submit_label'] ) : 'Search'; ?>"> </div>
</div>
<?php

}// end of if

