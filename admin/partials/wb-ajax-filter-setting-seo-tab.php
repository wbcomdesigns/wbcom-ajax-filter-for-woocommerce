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
/* admin setting on dashboard */
$wb_ajax_filter_admin_seo_options = get_option( 'wb_ajax_filter_admin_seo_options' );
?>
<div class="wbcom-tab-content">
	<div class="wb-ajax-filter-tab-content">
		<h2 class="wp-heading-inline"><?php esc_html_e( 'SEO', 'wb-ajax-filter' ); ?></h2>
	</div>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wb_ajax_filter_admin_seo_options' );
		do_settings_sections( 'wb_ajax_filter_admin_seo_options' );
		?>
		<?php do_action( 'wb_ajax_filter_before_admin_seo_settings', $wb_ajax_filter_admin_seo_options ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Enable SEO options', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_admin_seo_options[enable_seo]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_admin_seo_options['enable_seo'] ) ) ? checked( $wb_ajax_filter_admin_seo_options['enable_seo'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Add "robots" meta tag in head tag of HTML page if filters have been activated.', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'URL permalinks', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_admin_seo_options[change_browser_url]" type="radio" value="custom" <?php ( isset( $wb_ajax_filter_admin_seo_options['change_browser_url'] ) ) ? checked( $wb_ajax_filter_admin_seo_options['change_browser_url'], 'custom' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Use plugin customized permalinks', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_seo_options[change_browser_url]" type="radio" value="yes" <?php ( isset( $wb_ajax_filter_admin_seo_options['change_browser_url'] ) ) ? checked( $wb_ajax_filter_admin_seo_options['change_browser_url'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Add filters parameters to default URL', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_seo_options[change_browser_url]" type="radio" value="no" <?php ( isset( $wb_ajax_filter_admin_seo_options['change_browser_url'] ) ) ? checked( $wb_ajax_filter_admin_seo_options['change_browser_url'], 'no' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Don\'t change URL', 'wb-ajax-filter' ); ?></span>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Choose how to manage browser URL during filtering', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				
			</tbody>
		</table>
		<?php do_action( 'wb_ajax_filter_after_admin_seo_settings', $wb_ajax_filter_admin_seo_options ); ?>
		<?php submit_button(); ?>
	</form>
</div>