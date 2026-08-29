<?php
/**
 * The template for reset filters button.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="wb-ajax-reset-all-filters-container">
	<a href="javascript:void(0)" class="wb-ajax-reset-all-filters button" role="button"><?php wb_ajax_filter_icon( 'rotate-ccw', 'wb-ajax-reset-icon', 14 ); ?><?php esc_html_e( 'Reset filters', 'wb-ajax-filter' ); ?></a>
</div>
