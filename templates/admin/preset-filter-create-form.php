<?php
/**
 * The template for create filter preset form.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

$filters = array();
if ( isset( $_REQUEST['action'] ) && ( 'edit' === $_REQUEST['action'] || 'load_create_filter_template_wb' === $_REQUEST['action'] ) ) { //phpcs:ignore
	$preset_id = ( isset( $_REQUEST['preset'] ) && '' !== $_REQUEST['preset'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['preset'] ) ) : false; //phpcs:ignore
	if ( $preset_id ) {
		$filters = get_post_meta( $preset_id, '_wb_filter', true );
		if ( isset( $_REQUEST['wb_index'] ) ) { //phpcs:ignore
			$filters = $filters[ wp_unslash( $_REQUEST['wb_index'] ) ]; //phpcs:ignore
		}
	}
}
?>
<div class="wb-ajax-filter-form-wraper">
	<form id="filter-preset-create" method="post">
		<?php
			/**
			 * Hook - wb_ajax_filter_before_filter_fields
			 */
			do_action( 'wb_ajax_filter_before_filter_fields', $filters );
		?>
		<div class="wb-ajax-filter-toggle-content">
			<?php
				/**
				 * Hook - wb_ajax_filter_fields
				 *
				 * @hooked wb_ajax_filter_create_filter_name_field - 10
				 * @hooked wb_ajax_filter_create_filter_for_field - 20
				 * @hooked wb_ajax_filter_create_filter_tax_field - 30
				 * @hooked wb_ajax_filter_create_filter_price_slider_field - 40
				 * @hooked wb_ajax_filter_create_filter_order_by_field - 50
				 * @hooked wb_ajax_filter_create_filter_price_range_field - 60
				 * @hooked wb_ajax_filter_create_filter_stock_field - 70
				 * @hooked wb_ajax_filter_create_filter_toggle_field - 80
				 * @hooked wb_ajax_filter_create_filter_count_field - 90
				 * @hooked wb_ajax_filter_create_filter_adoptivr_filtering_field - 100
				 */
				do_action( 'wb_ajax_filter_fields', $filters );
			?>
		</div>
		<?php
			/**
			 * Hook - wb_ajax_filter_after_filter_fields
			 *
			 * @hooked wb_ajax_filter_create_filter_save_button - 10
			 */
			do_action( 'wb_ajax_filter_after_filter_fields', $filters );
		?>
	</form>
<div>
<?php

