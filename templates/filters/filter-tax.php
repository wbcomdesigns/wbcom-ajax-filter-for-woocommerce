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

$clear_style = 'display:none;';
$attributes  = wc_get_attribute_taxonomy_names();
if ( isset( $filters['taxonomy'] ) ) {
	$terms = get_terms(
		array(
			'taxonomy'   => wp_unslash( $filters['taxonomy'] ),
			'hide_empty' => false,
		),
	);
	$filter_taxonomy = $filters['taxonomy'];
	if ( in_array( $filters['taxonomy'], $attributes, true ) ) {
		$filter_taxonomy = str_replace( 'pa_', 'filter_', $filters['taxonomy'] );
	}
}


$toggle_enabled                 = ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? true : false;
$toggle_class                   = ( $toggle_enabled ) ? 'wb-ajax-accordian' : '';
$toggle_style                   = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : '';
$toggle_icon                    = ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'dashicons-arrow-down-alt2' : 'dashicons-arrow-up-alt2';
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single wb-ajax-filter-tax" id="filter_<?php echo esc_attr( $preset_id . '_' . $filter_count ); ?>" data-filter-type="<?php echo esc_attr( $filters['type'] ); ?>" data-filter-id="<?php echo esc_attr( $filter_count ); ?>" data-taxonomy="<?php echo esc_attr( $filter_taxonomy ); ?>" data-multiple="<?php echo ( isset( $filters['multiple'] ) && 'yes' === $filters['multiple'] ) ? esc_attr( $filters['multiple'] ) : ''; ?>" data-relation="<?php echo isset( $filters['relation'] ) ? esc_attr( $filters['relation'] ) : ''; ?>">
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?>">
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		<?php if ( $toggle_enabled ) : ?>
		<span class="dashicons <?php echo esc_attr( $toggle_icon ); ?>"></span>
		<?php endif; ?>
	</a>
	<div class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && 'closed' === $filters['toggle_style'] ) ? 'display:none' : ''; ?>">
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
		<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" style="<?php echo ( ! isset( $_GET[ $filter_taxonomy ] ) ) ? esc_attr( $clear_style ) : ''; ?>"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
		<?php } ?>
		<div class="filter-content">
			<?php
			if ( isset( $filters['terms'] ) && count( $filters['terms'] ) > 0 ) {
				$terms_order_by  = ( isset( $filters['order_by'] ) ) ? $filters['order_by'] : 'name';
				$terms_order     = ( isset( $filters['order'] ) ) ? $filters['order'] : 'ASC';
				$term_args       = array(
					'taxonomy'   => $filters['taxonomy'],
					'orderby'    => $terms_order_by,
					'order'      => $terms_order,
					'hide_empty' => false,
				);
				$sorted_terms    = get_terms( $term_args );
				$old_terms_array = $filters['terms'];
				unset( $filters['terms'] );
				$new_terms_array = array();
				foreach ( $sorted_terms as $stm ) {
					foreach ( $old_terms_array as $ftm ) {
						if ( (int) $ftm->id === (int) $stm->term_id ) {
							$new_terms_array[] = $ftm;
						}
					}
				}
				$filters['terms'] = $new_terms_array;
				require 'filter-tax/items/' . $filters['filter_design'] . '.php';
			}
			?>
		</div>
	</div>
</div>
