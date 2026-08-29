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

defined( 'ABSPATH' ) || exit;

$style = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && 'orderby' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wbcom-field wbcom-field-group wb-orderby-toggle" style="<?php echo esc_attr( $style ); ?>">
	<div class="wbcom-field-info">
		<label for="order_by_form_field"><?php esc_html_e( 'Order options', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( 'Select sorting options to show', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<select id="order_by_form_field" name="filters[order_options][]" class="wbcom-select wc-enhanced-select enhanced wb-input wb-filter-type-orderby" multiple="" tabindex="-1" aria-hidden="true" data-selected_orders="<?php echo ( isset( $filters['order_options'] ) ) ? wp_json_encode( $filters['order_options'] ) : ''; ?>">
			<option value=""><?php esc_html_e( 'Default sorting', 'wb-ajax-filter' ); ?></option>
			<option value="popularity"><?php esc_html_e( 'Sort by popularity', 'wb-ajax-filter' ); ?></option>
			<option value="rating"><?php esc_html_e( 'Sort by average rating', 'wb-ajax-filter' ); ?></option>
			<option value="date"><?php esc_html_e( 'Sort by latest', 'wb-ajax-filter' ); ?></option>
			<option value="price"><?php esc_html_e( 'Sort by price: low to high', 'wb-ajax-filter' ); ?></option>
			<option value="price-desc"><?php esc_html_e( 'Sort by price: high to low', 'wb-ajax-filter' ); ?></option>
		</select>
	</div>
</div>
