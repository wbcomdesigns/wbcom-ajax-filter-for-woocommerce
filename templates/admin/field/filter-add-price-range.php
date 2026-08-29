<?php
/**
 * The template for add price ranges field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin/field
 */

defined( 'ABSPATH' ) || exit;

$style = 'display:none;';
if ( isset( $_POST['count'] ) ) { //phpcs:ignore
	$count = sanitize_text_field( wp_unslash( $_POST['count'] ) ); //phpcs:ignore
}

if ( isset( $range ) && isset( $range_count ) ) {

	$style = ( $range_count === $count + 1 ) ? '' : 'display:none;';
}


$args = array(
	'posts_per_page' => 1,
	'post_type'      => 'product',
	'orderby'        => 'meta_value_num',
	'meta_key'       => '_price',
	'order'          => 'desc',
);

$prices        = get_posts( $args );
$prod          = wc_get_product( $prices[0]->ID );
$highest_price = $prod->get_price();

?>
<div id="wb_range_<?php echo esc_html( $count ); ?>" class="wb-ajax-filter-range-box" data-range_id="<?php echo esc_html( $count ); ?>">
	<a href="#" role="button" class="wb-ajax-filter-range-remove" aria-label="<?php esc_attr_e( 'Remove price range', 'wb-ajax-filter' ); ?>">
		<?php wb_ajax_filter_icon( 'x', 'wb-ajax-range-remove-icon', 14 ); ?>
	</a>
	<p class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper min">
		<span class="wb_price_range_min_error" hidden></span>
		<label for="wb_price_ranges_<?php echo esc_html( $count ); ?>_min"><?php esc_html_e( 'Minimum price', 'wb-ajax-filter' ); ?></label>
		<input type="number" class="wbcom-input wb-input wb-filter-type-price-range-min" data-highest-price=<?php echo esc_attr( $highest_price ); ?>  name="filters[price_ranges][<?php echo esc_html( $count ); ?>][min]" id="wb_price_ranges_<?php echo esc_html( $count ); ?>_min" value="<?php echo ( isset( $range['min'] ) && '' !== $range['min'] ) ? esc_html( $range['min'] ) : ''; ?>">
	</p>
	<div class="wb-ajax-filter-field-wrapper unlimited" style="<?php echo esc_attr( $style ); ?>">
		<label for="wb_price_ranges_<?php echo esc_html( $count ); ?>_unlimited"><?php esc_html_e( 'Show "&amp; Above" in last range', 'wb-ajax-filter' ); ?></label>
		<label class="wbcom-toggle">
			<input type="checkbox" id="wb_price_ranges_<?php echo esc_html( $count ); ?>_unlimited" class="wb-input wb-filter-type-price-range wb-filter-type-price-range-unlimited" name="filters[price_ranges][<?php echo esc_html( $count ); ?>][unlimited]" value="yes" <?php echo ( isset( $range['unlimited'] ) && 'yes' === $range['unlimited'] ) ? 'checked' : ''; ?>>
			<span class="wbcom-toggle-slider"></span>
		</label>
	</div>
	<p class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper max" style="<?php echo ( isset( $range['unlimited'] ) && 'yes' === $range['unlimited'] ) ? 'display:none' : ''; ?>">
		<label for="wb_price_ranges_<?php echo esc_html( $count ); ?>_max"><?php esc_html_e( 'Maximum price', 'wb-ajax-filter' ); ?></label>
		<input type="number" name="filters[price_ranges][<?php echo esc_html( $count ); ?>][max]" id="wb_price_ranges_<?php echo esc_html( $count ); ?>_max" class="wbcom-input wb-input wb-filter-type-price-range-max" value="<?php echo ( isset( $range['max'] ) && '' !== $range['max'] ) ? esc_html( $range['max'] ) : ''; ?>">
	</p>
</div>
