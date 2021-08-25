<?php
/**
 * The template for filter design select.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

?>
<div class="wb-ajax-filter filter-tax">
	<h4 class="filter-title"><?php esc_html( $filters['filter_title'] ); ?></h4>
	<div class="filter-content">
		<div class="wb-ajax-filter filter-tax">
			<select>
				<option value=""><?php esc_html_e( 'Choose term', 'wb-ajax-filter' ); ?></option>
				<?php
				foreach ( $filters['terms'] as $tm ) {
					$term_data = get_term( $tm->id, $filters['taxonomy'] );
					?>
					<option value="<?php echo esc_attr( $term_data->slug ); ?>"><?php echo esc_attr( $term_data->name ); ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>
