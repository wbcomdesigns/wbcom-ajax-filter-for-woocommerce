<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
 * @author     Wbcom Designs <https://wbcomdesigns.com/>
 */
class Wb_Ajax_Filter_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		unregister_post_type( 'wb_filter_preset' );
		$remove_options = array(
			'wb_ajax_filter_search_settings',
			'wb_ajax_filter_admin_general_options',
			'wb_ajax_filter_admin_customization_options',
			'wb_ajax_filter_search_content_settings',
		);
		foreach ( $remove_options as $option ) {
			delete_option( $option );
		}
	}

}
