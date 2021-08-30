<?php
/**
 * The template for filter by order.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

$sort        = array(
	'popularity' => 'Sort by popularity',
	'rating'     => 'Sort by average rating',
	'date'       => 'Sort by latest',
	'price'      => 'Sort by price: low to high',
	'price-desc' => 'Sort by price: high to low',
);
$clear_style = 'display:none';

?>
<div class="wb-ajax-filter-container-single filter-orderby">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<a class="wb-ajax-clear-single-filter" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" style="<?php echo ( ! isset( $_GET['orderby'] ) ) ? esc_attr( $clear_style ) : ''; ?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
	<div class="filter-content">
		<div class="wb-ajax-filter filter-orderby">
			<select name="filters[orderby]" class="wb-ajax-filter-selectible" data-filter="orderby">
				<option value=""><?php esc_html_e( 'Default Sorting', 'wb-ajax-filter' ); ?></option>
				<?php
				foreach ( $filters['order_options'] as $opt ) {
					?>
					<option value="<?php echo esc_attr( $opt ); ?>" <?php echo ( isset( $params['orderby'] ) && $opt === $params['orderby'] ) ? 'selected' : ''; ?>><?php echo esc_html( $sort[ $opt ] ); ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>
