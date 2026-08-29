<?php
/**
 * The template for stock fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

$style = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && 'stock_sale' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wbcom-field wbcom-field-group wb-stock-sale-toggle" style="<?php echo esc_attr( $style ); ?>">
	<div class="wbcom-field-info">
		<label for="show_stock_filter"><?php esc_html_e( 'Show stock filter', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( "Enable this to show the 'In Stock' filter", 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<label class="wbcom-toggle">
			<input id="show_stock_filter" type="checkbox" class="wb-input wb-filter-type-stock-sale" name="filters[show_stock_filter]" value="yes" <?php echo ( isset( $filters['show_stock_filter'] ) && 'yes' === $filters['show_stock_filter'] ) ? 'checked' : ''; ?>>
			<span class="wbcom-toggle-slider"></span>
		</label>
	</div>
</div>
<div class="wbcom-field wbcom-field-group wb-stock-sale-toggle" style="<?php echo esc_attr( $style ); ?>">
	<div class="wbcom-field-info">
		<label for="show_sale_filter"><?php esc_html_e( 'Show sale filter', 'wb-ajax-filter' ); ?></label>
		<p class="description"><?php esc_html_e( "Enable this to show the 'On Sale' filter", 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wbcom-field-control">
		<label class="wbcom-toggle">
			<input id="show_sale_filter" type="checkbox" class="wb-input wb-filter-type-stock-sale" name="filters[show_sale_filter]" value="yes" <?php echo ( isset( $filters['show_sale_filter'] ) && 'yes' === $filters['show_sale_filter'] ) ? 'checked' : ''; ?>>
			<span class="wbcom-toggle-slider"></span>
		</label>
	</div>
</div>
