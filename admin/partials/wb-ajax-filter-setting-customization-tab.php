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
$wb_ajax_filter_admin_customization_options = get_option( 'wb_ajax_filter_admin_customization_options' );
?>
<div class="wbcom-tab-content">
<div class="wbcom-admin-title-section">
		<h3 class="wp-heading-inline"><?php esc_html_e( 'Customization Settings', 'wb-ajax-filter' ); ?></h3>
	</div>
	<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wb_ajax_filter_admin_customization_options' );
		do_settings_sections( 'wb_ajax_filter_admin_customization_options' );
		?>
		<?php do_action( 'wb_ajax_filter_before_admin_customization_settings', $wb_ajax_filter_admin_customization_options ); ?>
		<div class="form-table">
		<div class="wbcom-settings-section-wrap">
			<div class="wbcom-settings-section-options-heading">
				
						<label>
							<?php esc_html_e( 'Filters area title', 'wb-ajax-filter' ); ?>
						</label> 
						<p class="description"><?php esc_html_e( 'Enter a title to identify the “AJAX filter Preset” section', 'wb-ajax-filter' ); ?></p>

					</div>
					<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_customization_options[filters_title]" type="text" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['filters_title'] ) ) ? esc_html( $wb_ajax_filter_admin_customization_options['filters_title'] ) : ''; ?>">
						</label><br>
					</div>
				</div>
				<div class="wbcom-settings-section-wrap">
					<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Filters area colors', 'wb-ajax-filter' ); ?>
						</label>
					</div>
					<div class="wbcom-settings-section-options">
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Titles', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[filters_area_titles_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['filters_area_titles_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['filters_area_titles_color'] ) : '#1e73be'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Background', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[filters_area_background_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['filters_area_background_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['filters_area_background_color'] ) : '#fff'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Accent Color', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[filters_area_accent_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['filters_area_accent_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['filters_area_accent_color'] ) : '#fff'; ?>">
							</div>
						</div>
					 </div>
					 </div>
					 <div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Filter Columns', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Choose number of filters in a row', 'wb-ajax-filter' ); ?></p>

					   </div>
					   <div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_customization_options[filters_per_column]" type="number" min="2" max="5" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['filters_per_column'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['filters_per_column'] ) : '5'; ?>">
						</label><br>

					   </div>
				   </div>
				   <div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Options style', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Choose which preset of style options you\'d like to apply to your filters', 'wb-ajax-filter' ); ?></p>
					</div>
					<div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_customization_options[filters_style]" type="radio" value="theme"<?php ( isset( $wb_ajax_filter_admin_customization_options['filters_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['filters_style'], 'theme' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Theme style', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[filters_style]" type="radio" value="custom"<?php ( isset( $wb_ajax_filter_admin_customization_options['filters_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['filters_style'], 'custom' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Custom style', 'wb-ajax-filter' ); ?></span>
						</label><br>
					 </div>
					 </div>

					 <div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Textual terms color', 'wb-ajax-filter' ); ?>
						</label>
					</div>
					<div class="wbcom-settings-section-options">
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_text_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['textual_terms_text_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['textual_terms_text_color'] ) : '#1e73be'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text Hover', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_hover_text_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['textual_terms_hover_text_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['textual_terms_hover_text_color'] ) : '#fff'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text Active', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_active_text_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['textual_terms_active_text_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['textual_terms_active_text_color'] ) : '#fff'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Tooltip Text', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_tooltip_text_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['textual_terms_tooltip_text_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['textual_terms_tooltip_text_color'] ) : '#fff'; ?>">
							</div>
						</div>
					</div>
				   </div>
				<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'AJAX loader', 'wb-ajax-filter' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Choose the style for AJAX loader icon', 'wb-ajax-filter' ); ?></p>
					  </div>
					  <div class="wbcom-settings-section-options">
						<label>
							<input name="wb_ajax_filter_admin_customization_options[ajax_loader_style]" type="radio" value="default"<?php ( isset( $wb_ajax_filter_admin_customization_options['ajax_loader_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['ajax_loader_style'], 'default' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Use default loader', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[ajax_loader_style]" type="radio" value="custom"<?php ( isset( $wb_ajax_filter_admin_customization_options['ajax_loader_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['ajax_loader_style'], 'custom' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Upload custom loader', 'wb-ajax-filter' ); ?></span>			
						</label><br>
					</div>
				</div>


				<div class="wbcom-settings-section-wrap" style="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['ajax_loader_style'] ) && 'custom' !== $wb_ajax_filter_admin_customization_options['ajax_loader_style'] ) ? 'display:none;' : ''; ?>">
				
						<div class="wbcom-settings-section-options-heading">
						<label>
							<?php esc_html_e( 'Custom Ajax Loader', 'wb-ajax-filter' ); ?>
						</label>
					
					 </div>
						<div class="gif-container">
							<img src="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['loader_url'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['loader_url'] ) : ''; ?>" alt="" style="max-width:100%;">
						</div>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[loader_attachment_id]" type="hidden" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['loader_attachment_id'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['loader_attachment_id'] ) : ''; ?>">
							<input name="wb_ajax_filter_admin_customization_options[loader_url]" type="text" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['loader_url'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['loader_url'] ) : ''; ?>">
							<button class="btn" id="wb_upload_gif"><span class="dashicons dashicons-cloud-upload"></span><?php esc_html_e( 'Upload', 'wb-ajax-filter' ); ?></button>
							<button class="btn" id="wb_reset_upload_gif"><?php esc_html_e( 'Reset', 'wb-ajax-filter' ); ?></button>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Loader gif', 'wb-ajax-filter' ); ?></span>
						</label><br>
					
				
				</div>
		</div>
		<?php do_action( 'wb_ajax_filter_after_admin_customization_settings', $wb_ajax_filter_admin_customization_options ); ?>
		<?php submit_button(); ?>
	</form>
</div>
</div>
