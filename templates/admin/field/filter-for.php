<?php
/**
 * The template for filter for field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

?>
<div class="wb-ajax-filter-toggle-content-row wb-all-toggle">
	<label for="filter_type"><?php esc_html_e( 'Filter for', 'wb-ajax-filter' ); ?></label>
	<select id="filter_type" name="filters[type]" class="wc-enhanced-select enhanced" data-value="tax" tabindex="-1" aria-hidden="true">
		<option value="tax" <?php echo ( isset( $filters['type'] ) && 'tax' === $filters['type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Taxonomy', 'wb-ajax-filter' ); ?></option>
		<option value="orderby" <?php echo ( isset( $filters['type'] ) && 'orderby' === $filters['type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Order by', 'wb-ajax-filter' ); ?></option>
		<option value="price_range" <?php echo ( isset( $filters['type'] ) && 'price_range' === $filters['type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Price Range', 'wb-ajax-filter' ); ?></option>
		<option value="price_slider" <?php echo ( isset( $filters['type'] ) && 'price_slider' === $filters['type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Price Slider', 'wb-ajax-filter' ); ?></option>
		<option value="review" <?php echo ( isset( $filters['type'] ) && 'review' === $filters['type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Review', 'wb-ajax-filter' ); ?></option>
		<option value="stock_sale" <?php echo ( isset( $filters['type'] ) && 'stock_sale' === $filters['type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'In stock/On sale', 'wb-ajax-filter' ); ?></option>
	</select>
	<span class="description"><?php esc_html_e( 'Select the parameters you wish to filter for', 'wb-ajax-filter' ); ?>	</span>
</div>
