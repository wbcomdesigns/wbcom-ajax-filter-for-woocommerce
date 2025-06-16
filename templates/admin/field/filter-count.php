<?php
/**
 * The template for count field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$show_in = array( 'tax', 'price_range', 'review', 'stock_sale' );
$style   = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && in_array( $filters['type'], $show_in, true ) ) ) {
	$style = '';
}
?>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label for="show_count"><?php esc_html_e( 'Show item count for each filter option', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
		<div class="wb-ajax-filter-onoff-container ">
			<input id="show_count" type="checkbox" class="on_off wb-input wb-filter-type-tax wb-filter-type-price-range wb-filter-type-review wb-filter-type-stock-sale" name="filters[show_count]" value="yes" <?php echo ( isset( $filters['show_count'] ) && 'yes' === $filters['show_count'] ) ? 'checked' : ''; ?>>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Enable this if you want to show how many items are available for each term.', 'wb-ajax-filter' ); ?></span>
</div>
