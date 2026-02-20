<?php
/**
 * The template for apply filters button.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wb-ajax-reset-all-filters-container">
	<a href="javascript:void(0)" class="wb-ajax-apply-all-filters  button" role="button" aria-label="Apply Filter"><?php esc_html_e( 'Apply filters', 'wb-ajax-filter' ); ?></a>
</div>
