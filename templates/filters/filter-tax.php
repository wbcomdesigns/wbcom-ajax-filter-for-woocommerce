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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$clear_style = 'display:none;';
$attributes  = wc_get_attribute_taxonomy_names();
if ( isset( $filters['taxonomy'] ) ) {
	$terms           = get_terms(
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
$toggle_open                    = ! ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] );
$wb_ajax_filter_general_options = get_option( 'wb_ajax_filter_admin_general_options' );
?>
<div class="wb-ajax-filter-container-single wb-ajax-filter-tax" id="filter_<?php echo esc_attr( $preset_id . '_' . $filter_count ); ?>" data-filter-type="<?php echo esc_attr( $filters['type'] ); ?>" data-filter-id="<?php echo esc_attr( $filter_count ); ?>" data-taxonomy="<?php echo esc_attr( $filter_taxonomy ); ?>" data-multiple="<?php echo ( isset( $filters['multiple'] ) && 'yes' === $filters['multiple'] ) ? esc_attr( $filters['multiple'] ) : ''; ?>" data-relation="<?php echo isset( $filters['relation'] ) ? esc_attr( $filters['relation'] ) : ''; ?>" role="region" aria-label="Taxonomy Filter">
	
	<a href="javascript:void(0)" class="wb-ajax-filter-toggle <?php echo esc_attr( $toggle_class ); ?><?php echo ( $toggle_enabled && $toggle_open ) ? ' wb-ajax-open' : ''; ?>" role="button"<?php echo $toggle_enabled ? ' aria-expanded="' . esc_attr( $toggle_open ? 'true' : 'false' ) . '"' : ''; ?>>
		<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
		<?php if ( $toggle_enabled ) : ?>
			<?php wb_ajax_filter_icon( 'chevron-down', 'wb-ajax-toggle-icon' ); ?>
		<?php endif; ?>
	</a>
	<div class="wb-ajax-panel" style="<?php echo ( $toggle_enabled && isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'display:none' : ''; ?>" id="taxonomy-filter-panel">
		<?php if ( isset( $wb_ajax_filter_general_options['show_clear_filter'] ) && 'yes' === $wb_ajax_filter_general_options['show_clear_filter'] ) { ?>
		<a href="javascript:void(0)" class="wb-ajax-clear-single-filter" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" style="<?php echo ( ! isset( $_GET[ $filter_taxonomy ] ) ) ? esc_attr( $clear_style ) : ''; //phpcs:ignore?>" role="button"><?php esc_html_e( 'Clear', 'wb-ajax-filter' ); ?></a>
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
				if ( isset( $filters['filter_design'] ) && '' !== $filters['filter_design'] ) {
					// Theme override: yourtheme/wb-ajax-filter/filters/filter-tax/items/<design>.php.
					// checkbox.php/radio.php pull in term-children.php with a plain relative
					// require on purpose - it writes back into the parent's $terms_added
					// accumulator, so it must share scope. A theme overriding either file
					// must copy term-children.php alongside it.
					wb_ajax_filter_get_template(
						'filters/filter-tax/items/' . $filters['filter_design'] . '.php',
						array(
							'filters'         => $filters,
							'filter_taxonomy' => isset( $filter_taxonomy ) ? $filter_taxonomy : '',
							'params'          => isset( $params ) ? $params : array(),
							'base_url'        => isset( $base_url ) ? $base_url : '',
							'wb_ajax_filter_general_options' => $wb_ajax_filter_general_options,
						)
					);
				}
			}
			?>
		</div>
	</div>
</div>

<!-- Skip link at top of the page -->
<a href="#taxonomy-filter-panel" class="skip-link screen-reader-text"><?php esc_html_e( 'Skip to taxonomy filter', 'wb-ajax-filter' ); ?></a>
