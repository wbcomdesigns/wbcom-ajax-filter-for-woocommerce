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

$hide_term = ( isset( $wb_ajax_filter_general_options['hide_empty_terms'] ) && 'yes' === $wb_ajax_filter_general_options['hide_empty_terms'] ) ? true : false;
?>
<div class="wb-ajax-filter filter-tax">
	<select class="wb-ajax-filter-selectible" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" <?php echo ( isset( $filters['multiple'] ) && 'yes' === $filters['multiple'] ) ? 'multiple="multiple"' : ''; ?>>
		<option value=""><?php esc_html_e( 'Select term', 'wb-ajax-filter' ); ?></option>
		<?php
		foreach ( $filters['terms'] as $term ) {
			$term_data = get_term( $term->id, $filters['taxonomy'] );
			$disabled  = ( 0 === $term_data->count ) ? 'disabled' : '';
			if ( ( $hide_term && '' === $disabled ) || ( ! $hide_term && '' === $disabled ) || ( ! $hide_term && 'disabled' === $disabled ) ) {
				?>
			<option value="<?php echo esc_attr( $term_data->slug ); ?>" <?php echo ( isset( $params[ $filter_taxonomy ] ) && $term_data->slug === $params[ $filter_taxonomy ] ) ? 'selected' : ''; ?> <?php echo esc_attr( $disabled ); ?>><?php echo esc_attr( $term_data->name ); ?><?php if ( isset( $filters['show_count'] ) && 'yes' === $filters['show_count'] ) : ?>
				<small class="item-count">(<?php echo esc_html( $term_data->count ); ?>)</small>
				<?php endif; ?>
			</option>
			<?php
			}
		}
		?>
	</select>
</div>
