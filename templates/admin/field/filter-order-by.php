<?php
/**
 * The template for order by fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$style = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && 'orderby' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wb-ajax-filter-toggle-content-row wb-orderby-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Order options', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-buttons-field-wrapper">
		<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
			<select name="filters[order_options][]" class="wc-enhanced-select enhanced wb-input wb-filter-type-orderby" multiple="" tabindex="-1" aria-hidden="true" data-selected_orders="<?php echo ( isset( $filters['order_options'] ) ) ? wp_json_encode( $filters['order_options'] ) : ''; ?>">
				<option value=""><?php esc_html_e( 'Default sorting', 'wb-ajax-filter' ); ?></option>
				<option value="popularity"><?php esc_html_e( 'Sort by popularity', 'wb-ajax-filter' ); ?></option>
				<option value="rating"><?php esc_html_e( 'Sort by average rating', 'wb-ajax-filter' ); ?></option>
				<option value="date"><?php esc_html_e( 'Sort by latest', 'wb-ajax-filter' ); ?></option>
				<option value="price"><?php esc_html_e( 'Sort by price: low to high', 'wb-ajax-filter' ); ?></option>
				<option value="price-desc"><?php esc_html_e( 'Sort by price: high to low', 'wb-ajax-filter' ); ?></option>
			</select>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Select sorting options to show', 'wb-ajax-filter' ); ?></span>
</div>

