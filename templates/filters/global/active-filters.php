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

if ( count( $params ) > 0 ) {
	?>
	<div class="wb-ajax-active-filters-container" role="region" aria-label="Active Filters">
	<?php
 	$exclude_filters = array( 'preset', 'orderby', 'post_type', 'onsale_filter', 'instock_filter', 'min_price', 'max_price', 'rating_filter' );
	foreach ( $params as $key => $param ) {

		if( empty( $param ) ) {
			continue;
		}
		if ( in_array( $key, $exclude_filters, true ) ) {
			continue;
		}
		if ( is_array( $param ) ) {
			foreach ( $param as $pm ) {
				if( empty($pm) ){
					continue;
				}
			?>
			<div class="wb-ajax-active-filters-container-single">
				<span class="wb-ajax-filter-single-keyword"><?php echo esc_html( $pm ); ?></span>
				<span class="wb-ajax-filter-clear-single button" data-filter="<?php echo esc_attr( $key ); ?>" data-filter-value="<?php echo esc_attr( $pm ); ?>"><span class="dashicons dashicons-no-alt"></span></span>
			</div>
				<?php
			}
		} else {
			?>
		<div class="wb-ajax-active-filters-container-single">
			<span class="wb-ajax-filter-single-keyword"><?php echo esc_html( $param ); ?></span>
			<span class="wb-ajax-filter-clear-single button" data-filter="<?php echo esc_attr( $key ); ?>" data-filter-value="<?php echo esc_attr( $param ); ?>"><span class="dashicons dashicons-no-alt"></span></span>
		</div>
			<?php
		}
	}
	?>
	</div>
	<?php
}
?>

