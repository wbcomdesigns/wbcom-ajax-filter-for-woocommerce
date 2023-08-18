<?php
/**
 * The template for edit filter preset.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 */

if ( isset( $_REQUEST['action'] ) && 'edit' === $_REQUEST['action'] ) { //phpcs:ignore
	$preset_id = ( isset( $_REQUEST['preset'] ) && '' !== $_REQUEST['preset'] ) ? wp_unslash( $_REQUEST['preset'] ) : ''; //phpcs:ignore
	$preset_data = get_post( $preset_id );
	$filters = get_post_meta( $preset_id, '_wb_filter', true );
}
?>
<div class="wb-ajax-filter-form-wraper">
</div>
