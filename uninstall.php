<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Plugin options + EDD licence keys.
$wb_ajax_filter_options = array(
	'wb_ajax_filter_admin_general_options',
	'wb_ajax_filter_admin_customization_options',
	'wb_ajax_filter_search_settings',
	'wb_ajax_filter_search_content_settings',
	'wb_ajax_filter_default_preset_seeded',
	'edd_wbcom_ajax_filter_license_key',
	'edd_wbcom_ajax_filter_license_status',
);
foreach ( $wb_ajax_filter_options as $wb_ajax_filter_option ) {
	delete_option( $wb_ajax_filter_option );
}

// Licence-check cache.
delete_transient( 'edd_wbcom_ajax_filter_license_key_data' );

// Filter-preset posts. Their meta (_wb_filter, parent_preset, preset_enabled) is removed
// with the post. ponytail: single-site cleanup; wrap in a get_sites() loop if a network
// uninstall ever needs to sweep every blog.
$wb_ajax_filter_presets = get_posts(
	array(
		'post_type'   => 'wb_filter_preset',
		'post_status' => 'any',
		'numberposts' => -1,
		'fields'      => 'ids',
	)
);
foreach ( $wb_ajax_filter_presets as $wb_ajax_filter_preset_id ) {
	wp_delete_post( $wb_ajax_filter_preset_id, true );
}
