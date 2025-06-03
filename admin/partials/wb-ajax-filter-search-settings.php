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
$is_search_enabled              = ( isset( $wb_ajax_filter_search_settings['enable_search'] ) && ( 'yes' === $wb_ajax_filter_search_settings['enable_search'] ) ) ? '' : 'display:none';
?>
<div class="wbcom-tab-content">
<div class="wb-ajax-filter-tab-content">
	<div class="wbcom-admin-title-section">
		<h3 class="wp-heading-inline"><?php esc_html_e( 'Search Settings', 'wb-ajax-filter' ); ?></h3>
	</div>
	<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
		<form method="post" action="options.php">
			<?php
			settings_fields( 'wb_ajax_filter_search_settings' );
			do_settings_sections( 'wb_ajax_filter_search_settings' );
			?>
			<?php do_action( 'wb_ajax_filter_before_admin_search_settings', $wb_ajax_filter_search_settings ); ?>
			<div class="form-table">
				<div class="wbcom-settings-section-wrap">
					<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Enable Search', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable/Disable search field.', 'wb-ajax-filter' ); ?></p>
					</div>			
					<label>
						<input name="wb_ajax_filter_search_settings[enable_search]" type="checkbox" value="yes" <?php ( isset( $wb_ajax_filter_search_settings['enable_search'] ) ) ? checked( $wb_ajax_filter_search_settings['enable_search'], 'yes' ) : ''; ?>>
					</label><br>
				</div>
				<div class="wb_ajax_search_options" style=<?php echo esc_attr( $is_search_enabled ); ?> > 
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Search input label', 'wb-ajax-filter' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Label for Search input field.', 'wb-ajax-filter' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<label>
								<input name="wb_ajax_filter_search_settings[search_input_label]" type="text" value="<?php echo ( isset( $wb_ajax_filter_search_settings['search_input_label'] ) ) ? esc_html( $wb_ajax_filter_search_settings['search_input_label'] ) : ''; ?>">
							</label><br>
						</div>	 
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Search submit label', 'wb-ajax-filter' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Label for Search submit button.', 'wb-ajax-filter' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<label>
								<input name="wb_ajax_filter_search_settings[search_submit_label]" type="text" value="<?php echo ( isset( $wb_ajax_filter_search_settings['search_submit_label'] ) ) ? esc_html( $wb_ajax_filter_search_settings['search_submit_label'] ) : ''; ?>">
							</label><br>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Minimum number of characters', 'wb-ajax-filter' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Minimum number of characters required to trigger autosuggest.', 'wb-ajax-filter' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<label>
								<input name="wb_ajax_filter_search_settings[min_chars]" type="number" value="<?php echo ( isset( $wb_ajax_filter_search_settings['min_chars'] ) ) ? esc_html( $wb_ajax_filter_search_settings['min_chars'] ) : '0'; ?>">
							</label><br>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Maximum number of results', 'wb-ajax-filter' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Maximum number of results showed in autosuggest box.', 'wb-ajax-filter' ); ?></p>
						</div>
						<div class="wbcom-settings-section-options">
							<label>
								<input name="wb_ajax_filter_search_settings[posts_per_page]" type="number" value="<?php echo ( isset( $wb_ajax_filter_search_settings['posts_per_page'] ) ) ? esc_html( $wb_ajax_filter_search_settings['posts_per_page'] ) : '0'; ?>">
							</label><br>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label>
								<?php esc_html_e( 'Additional Settings', 'wb-ajax-filter' ); ?>
							</label>
						</div>
						<div class="wbcom-settings-section-options">
							<div class="wbcom-filter-for-search-item">	
								<label>
									<?php esc_html_e( 'Show filter for search fields', 'wb-ajax-filter' ); ?>
								</label>				
								<p class="description"><?php esc_html_e( 'Show filter for search fields (it allows searching the Whole site or only among products)', 'wb-ajax-filter' ); ?></p>	
								<div class="swicher-option">
									<input name="wb_ajax_filter_search_settings[show_search_list]" type="checkbox" value="yes" <?php ( isset( $wb_ajax_filter_search_settings['show_search_list'] ) ) ? checked( $wb_ajax_filter_search_settings['show_search_list'], 'yes' ) : ''; ?>>							
								</div>
							</div>
							<div class="wbcom-filter-for-search-item">
								<label>
									<?php esc_html_e( 'Show the category list', 'wb-ajax-filter' ); ?>							
								</label>	
								<p class="description"><?php esc_html_e( 'This option lets you decide to show the categories dropdown', 'wb-ajax-filter' ); ?></p>
								<div class="swicher-option">
									<input name="wb_ajax_filter_search_settings[show_category_list]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_settings['show_category_list'] ) ) ? checked( $wb_ajax_filter_search_settings['show_category_list'], 'yes' ) : ''; ?>>							
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php do_action( 'wb_ajax_filter_after_admin_search_settings', $wb_ajax_filter_search_settings ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
</div>
</div>
