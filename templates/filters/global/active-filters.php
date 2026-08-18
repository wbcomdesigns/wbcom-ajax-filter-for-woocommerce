<?php
/**
 * The template for active filters section.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

$wb_active_chips = wb_ajax_filter_get_active_chips( $params );
if ( count( $wb_active_chips ) > 0 ) {
	?>
	<div class="wb-ajax-active-filters-container" role="region" aria-label="Active Filters">
	<?php
	foreach ( $wb_active_chips as $wb_chip ) {
		// data-filter-value stays the RAW url value - the clear-single JS removes it from the query string.
		?>
		<div class="wb-ajax-active-filters-container-single">
			<span class="wb-ajax-filter-single-keyword"><?php echo esc_html( $wb_chip['label'] ); ?></span>
			<span class="wb-ajax-filter-clear-single button" role="button" tabindex="0" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: active filter label. */ __( 'Remove filter: %s', 'wb-ajax-filter' ), $wb_chip['label'] ) ); ?>" data-filter="<?php echo esc_attr( $wb_chip['filter'] ); ?>" data-filter-value="<?php echo esc_attr( $wb_chip['value'] ); ?>"><span class="dashicons dashicons-no-alt" aria-hidden="true"></span></span>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}
?>
