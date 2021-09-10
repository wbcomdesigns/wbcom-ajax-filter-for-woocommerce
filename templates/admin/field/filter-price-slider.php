<?php
/**
 * The template for price slider fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$style = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && 'price_slider' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wb-ajax-filter-toggle-content-row wb-price-slider-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Slider min value', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<input type="number" name="filters[price_slider_min]" class="wb-input wb-filter-type-price-slider" value="<?php echo ( isset( $filters['price_slider_min'] ) ) ? $filters['price_slider_min'] : 0; ?>" min="0" step="10">
	</div>
	<span class="description"><?php esc_html_e( 'Set the minimum value for the price slider', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-price-slider-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Slider max value', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-number-field-wrapper">
		<input type="number" name="filters[price_slider_max]" class="wb-input wb-filter-type-price-slider" value="<?php echo ( isset( $filters['price_slider_max'] ) ) ? $filters['price_slider_max'] : 0; ?>" min="0" step="10">
	</div>
	<span class="description"><?php esc_html_e( 'Set the maximum value for the price slider.', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-price-slider-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Slider step', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-number-field-wrapper">
		<input type="number" name="filters[price_slider_step]" class="wb-input wb-filter-type-price-slider" value="<?php echo ( isset( $filters['price_slider_step'] ) ) ? $filters['price_slider_step'] : 0; ?>" min="0" step="10">
	</div>
	<span class="description"><?php esc_html_e( 'Set the value for each increment of the price slider.', 'wb-ajax-filter' ); ?></span>
</div>

