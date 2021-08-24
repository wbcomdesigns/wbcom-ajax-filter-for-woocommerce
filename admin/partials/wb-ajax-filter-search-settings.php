<?php
/**
 * The admin Search setting tab template.
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
$wb_ajax_filter_search_settings = get_option( 'wb_ajax_filter_search_settings' );
?>
<div class="wbcom-tab-content">
<div class="wb-ajax-filter-tab-content">
	<h2 class="wp-heading-inline"><?php esc_html_e( 'Search Settings', 'wb-ajax-filter' ); ?></h2>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wb_ajax_filter_search_settings' );
		do_settings_sections( 'wb_ajax_filter_search_settings' );
		?>
		<?php do_action( 'wb_ajax_filter_before_admin_settings', $wb_ajax_filter_search_settings ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search input label', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_settings[search_input_label]" type="text" value="<?php echo ( isset( $wb_ajax_filter_search_settings['search_input_label'] ) ) ? esc_html( $wb_ajax_filter_search_settings['search_input_label'] ) : ''; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Label for Search input field.', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search submit label', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_settings[search_submit_label]" type="text" value="<?php echo ( isset( $wb_ajax_filter_search_settings['search_submit_label'] ) ) ? esc_html( $wb_ajax_filter_search_settings['search_submit_label'] ) : ''; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Label for Search submit button.', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr><tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Minimum number of characters', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_settings[min_chars]" type="number" value="<?php echo ( isset( $wb_ajax_filter_search_settings['min_chars'] ) ) ? esc_html( $wb_ajax_filter_search_settings['min_chars'] ) : '0'; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Minimum number of characters required to trigger autosuggest.', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr><tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Maximum number of results', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_settings[posts_per_page]" type="number" value="<?php echo ( isset( $wb_ajax_filter_search_settings['posts_per_page'] ) ) ? esc_html( $wb_ajax_filter_search_settings['posts_per_page'] ) : '0'; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Maximum number of results showed in autosuggest box.', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<h2>
							<?php esc_html_e( 'Additional Settings', 'wb-ajax-filter' ); ?>
						</h2>
					</th>
					<td>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show filter for search fields', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_settings[show_search_list]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_settings['show_search_list'] ) ) ? checked( $wb_ajax_filter_search_settings['show_search_list'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Show filter for search fields (it allows searching the Whole site or only among products)', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show the category list', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_settings[show_category_list]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_settings['show_category_list'] ) ) ? checked( $wb_ajax_filter_search_settings['show_category_list'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'This option lets you decide to show the categories dropdown', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
			</tbody>
		</table>
		<?php do_action( 'wb_ajax_filter_after_admin_settings', $wb_ajax_filter_search_settings ); ?>
		<?php submit_button(); ?>
	</form>
</div>
</div>