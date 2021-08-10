<?php
/**
 * The admin setting tab template.
 *
 * @link       support@wbcom.com
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$method = isset( $_REQUEST['action'] ) ? wp_unslash( $_REQUEST['action'] ) : '';

$args = array(
	'post_type'   => 'wb_filter_preset',
	'post_status' => 'publish',
	'numberposts' => -1,
);

$all_presets = get_posts( $args );

?>
<div class="wbcom-tab-content">
	<div class="wb-ajax-filter-preset-container">
		<?php if ( '' === $method ) { ?>
			<?php include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filters.php'; ?>
		<?php } elseif ( 'create' === $method ) { ?>
			<?php include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filter-create.php'; ?>
		<?php } elseif ( 'edit' === $method ) { ?>
			<?php include_once WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filter-edit.php'; ?>
		<?php } ?>
	</div>
</div>
