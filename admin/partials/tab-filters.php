<?php
/**
 * Your Filters tab - the preset list and builder.
 *
 * This is the primary owner path: the tab a store owner lands on, where the
 * seeded Default preset and any custom presets are edited. The builder
 * templates under templates/admin/ are unchanged - only the shell around
 * them moved to the shared Wbcom settings screen.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin/partials
 * @since      1.2.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only view routing.
$method     = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
$sub_method = isset( $_REQUEST['wb'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wb'] ) ) : '';
// phpcs:enable WordPress.Security.NonceVerification.Recommended

$args = array(
	'post_type'   => 'wb_filter_preset',
	'post_status' => 'publish',
	'numberposts' => -1,
);

$all_presets = get_posts( $args );

?>
<div class="wb-ajax-filter-preset-container">
	<?php if ( '' === $method ) { ?>
		<?php include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filters.php'; ?>
	<?php } elseif ( 'create' === $method ) { ?>
		<?php include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filter-create.php'; ?>
	<?php } elseif ( 'edit' === $method && 'list' === $sub_method ) { ?>
		<?php include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filter-create.php'; ?>
	<?php } elseif ( 'edit' === $method && 'update' === $sub_method ) { ?>
	<div class="wb-ajax-filter-modal-content">
		<?php include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/preset-filter-create-form.php'; ?>
	</div>
	<?php } ?>
</div>
