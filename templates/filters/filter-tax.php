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

$terms = get_terms(
	array(
		'taxonomy'   => wp_unslash( $filters['taxonomy'] ),
		'hide_empty' => false,
	),
);

?>
<div class="wb-ajax-filter wb-ajax-filter-tax" id="filter_<?php echo esc_attr( $preset_id . '_' . $filter_count ); ?>" data-filter-type="<?php echo esc_attr( $filters['type'] ); ?>" data-filter-id="<?php echo esc_attr( $filter_count ); ?>" data-taxonomy="<?php echo esc_attr( $filters['taxonomy'] ); ?>" data-multiple="<?php echo ( isset( $filters['multiple'] ) && 'yes' === $filters['multiple'] ) ? esc_attr( $filters['multiple'] ) : ''; ?>" data-relation="<?php echo isset( $filters['relation'] ) ? esc_attr( $filters['relation'] ) : ''; ?>">
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<div class="filter-content">
		<?php
			include 'filter-tax/items/' . $filters['filter_design'] . '.php';
		?>
	</div>
</div>
