<?php
/**
 * The template for displaying tax filter on the frontend.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

$clear_style     = 'display:none;';
$terms           = get_terms(
	array(
		'taxonomy'   => wp_unslash( $filters['taxonomy'] ),
		'hide_empty' => false,
	),
);
$attributes      = wc_get_attribute_taxonomy_names();
$filter_taxonomy = $filters['taxonomy'];
if ( in_array( $filters['taxonomy'], $attributes, true ) ) {
	$filter_taxonomy = str_replace( 'pa_', 'filter_', $filters['taxonomy'] );
}
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single wb-ajax-filter-tax" id="filter_<?php echo esc_attr( $preset_id . '_' . $filter_count ); ?>" data-filter-type="<?php echo esc_attr( $filters['type'] ); ?>" data-filter-id="<?php echo esc_attr( $filter_count ); ?>" data-taxonomy="<?php echo esc_attr( $filter_taxonomy ); ?>" data-multiple="<?php echo ( isset( $filters['multiple'] ) && 'yes' === $filters['multiple'] ) ? esc_attr( $filters['multiple'] ) : ''; ?>" data-relation="<?php echo isset( $filters['relation'] ) ? esc_attr( $filters['relation'] ) : ''; ?>">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
	<a class="wb-ajax-clear-single-filter button" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" style="<?php echo ( ! isset( $_GET[ $filter_taxonomy ] ) ) ? esc_attr( $clear_style ) : ''; ?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
	<?php } ?>
	<div class="filter-content">
		<?php
		if ( count( $filters['terms'] ) > 0 ) {
			require 'filter-tax/items/' . $filters['filter_design'] . '.php';
		}
		?>
	</div>
</div>
