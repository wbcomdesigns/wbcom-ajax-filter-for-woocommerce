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

defined( 'ABSPATH' ) || exit;

$style = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && 'price_slider' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wbcom-field wbcom-field-group wb-price-slider-toggle" style="<?php echo esc_attr( $style ); ?>">
	<div class="wbcom-field-info">
		<label for="price_slider_min"><?php esc_html_e( 'Slider min value', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( 'Set the minimum value for the price slider', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<input class="wbcom-input wb-input wb-filter-type-price-slider" id="price_slider_min" type="number" name="filters[price_slider_min]" value="<?php echo ( isset( $filters['price_slider_min'] ) ) ? esc_attr( $filters['price_slider_min'] ) : 0; ?>" min="0" step="10">
	</div>
</div>
<div class="wbcom-field wbcom-field-group wb-price-slider-toggle" style="<?php echo esc_attr( $style ); ?>">
	<div class="wbcom-field-info">
		<label for="price_slider_max"><?php esc_html_e( 'Slider max value', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( 'Set the maximum value for the price slider.', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<input class="wbcom-input wb-input wb-filter-type-price-slider" id="price_slider_max" type="number" name="filters[price_slider_max]" value="<?php echo ( isset( $filters['price_slider_max'] ) ) ? esc_attr( $filters['price_slider_max'] ) : 0; ?>" min="0" step="10">
	</div>
</div>
<div class="wbcom-field wbcom-field-group wb-price-slider-toggle" style="<?php echo esc_attr( $style ); ?>">
	<div class="wbcom-field-info">
		<label for="price_slider_step"><?php esc_html_e( 'Slider step', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( 'Set the step value for the price slider (how much each step increases the price).', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<input class="wbcom-input wb-input wb-filter-type-price-slider" id="price_slider_step" type="number" name="filters[price_slider_step]" value="<?php echo ( isset( $filters['price_slider_step'] ) ) ? esc_attr( $filters['price_slider_step'] ) : 0; ?>" min="0" step="10">
	</div>
</div>
