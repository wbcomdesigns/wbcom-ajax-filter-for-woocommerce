<?php
/**
 * The template for adoptive filtering field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

$show_in = array( 'tax', 'price_range', 'review', 'stock_sale' );
$style   = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && in_array( $filters['type'], $show_in, true ) ) ) {
	$style = '';
}
?>
<div class="wbcom-field wbcom-field-group wb-price-range-toggle wb-tax-toggle wb-review-toggle wb-stock-sale-toggle" style="<?php echo esc_attr( $style ); ?>">
	<div class="wbcom-field-info">
		<label><?php esc_html_e( 'Adaptive filtering', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( 'Choose how to handle filter options that show no results. Choose to hide them or make them visible (this will show them in lighter grey and not clickable).', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<label>
			<input id="hidden_term" type="radio" name="filters[adoptive]" class="wb-input wb-filter-type-tax wb-filter-type-price-range wb-filter-type-review wb-filter-type-stock-sale" value="hide" <?php echo ( isset( $filters['adoptive'] ) && 'hide' === $filters['adoptive'] ) ? 'checked' : ''; ?>>
			<span class="description"><?php esc_html_e( 'Unavailable terms will be hidden.', 'wb-ajax-filter' ); ?></span>
		</label>
		<label>
			<input id="visible_term" type="radio" name="filters[adoptive]" class="wb-input wb-filter-type-tax wb-filter-type-price-range wb-filter-type-review wb-filter-type-stock-sale" value="show" <?php echo ( isset( $filters['adoptive'] ) && 'show' === $filters['adoptive'] ) ? 'checked' : ''; ?>>
			<span class="description"><?php esc_html_e( 'Unavailable terms will be visible but not clickable.', 'wb-ajax-filter' ); ?></span>
		</label>
	</div>
</div>
