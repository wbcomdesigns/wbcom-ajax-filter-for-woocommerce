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

defined( 'ABSPATH' ) || exit;

$hide_term       = ( isset( $wb_ajax_filter_general_options['hide_empty_terms'] ) && 'yes' === $wb_ajax_filter_general_options['hide_empty_terms'] ) ? true : false;
$show_term_count = ( isset( $filters['show_count'] ) && ( 'yes' === $filters['show_count'] ) ) ? true : false;

?>
<div class="wb-ajax-filter filter-tax">
	<select class="wb-ajax-filter-selectible" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" <?php echo ( isset( $filters['multiple'] ) && 'yes' === $filters['multiple'] ) ? 'multiple="multiple"' : ''; ?>>
		<option value=""><?php esc_html_e( 'Select term', 'wb-ajax-filter' ); ?></option>
		<?php
		foreach ( $filters['terms'] as $filter_term ) { //phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$term_data = get_term( $filter_term->id, $filters['taxonomy'] );


			$count_child_terms = wb_ajax_filter_get_taxonomy_child_terms_count( $filter_term->id, $filters['taxonomy'] );
			$count_child_terms = $count_child_terms + $term_data->count;

			$disabled = ( 0 === $count_child_terms ) ? 'disabled' : '';

			if ( ( $hide_term && '' === $disabled ) || ( ! $hide_term && '' === $disabled ) || ( ! $hide_term && 'disabled' === $disabled ) ) {
				?>
			<option value="<?php echo esc_attr( $term_data->slug ); ?>" <?php echo ( isset( $params[ $filter_taxonomy ] ) && $term_data->slug === $params[ $filter_taxonomy ] ) ? 'selected' : ''; ?> <?php echo esc_attr( $disabled ); ?>>
				<?php
				if ( $show_term_count ) {
					echo esc_html( $term_data->name . ' (' . $count_child_terms . ' )' );
				} else {
					echo esc_html( $term_data->name );
				}
				?>
			</option>
				<?php
			}
		}
		?>
	</select>
</div>
