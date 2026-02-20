<?php
/**
 * The template for price range fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

$style = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && isset( $filters['type'] ) && 'price_range' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wb-ajax-filter-toggle-content-row wb-price-range-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Customize price ranges', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-custom-field-wrapper">
		<button class="wb-ajax-filter-add-price-range button-primary"><?php esc_html_e( 'Add Range', 'wb-ajax-filter' ); ?></button>
		<div class="wb-ajax-filter-ranges-wrapper ui-sortable" data-index="0">
			<?php
			if ( isset( $filters['price_ranges'] ) && ! empty( $filters['price_ranges'] ) ) {
				$count       = 0;
				$range_count = count( $filters['price_ranges'] );
				foreach ( $filters['price_ranges'] as $range ) {
					include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-add-price-range.php';
					++$count;
				}
			}
			?>
		</div>
	</div>
</div>

