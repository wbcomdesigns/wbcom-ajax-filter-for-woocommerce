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
	<div class="wb-ajax-filter-tab-content">
		<h2 class="wp-heading-inline"><?php esc_html_e( 'General Settings', 'wb-ajax-filter' ); ?></h2>
	</div>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wb_ajax_filter_admin_customization_options' );
		do_settings_sections( 'wb_ajax_filter_admin_customization_options' );
		?>
		<?php do_action( 'wb_ajax_filter_before_admin_customization_settings', $wb_ajax_filter_admin_customization_options ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Filters area title', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[filters_title]" type="text" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['filters_title'] ) ) ? esc_html( $wb_ajax_filter_admin_customization_options['filters_title'] ) : ''; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Enter a title to identify the “AJAX filter Preset” section', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Filters area colors', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
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
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Options style', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[filters_style]" type="radio" value="yes"<?php ( isset( $wb_ajax_filter_admin_customization_options['filters_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['filters_style'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Theme style', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[filters_style]" type="radio" value="yes"<?php ( isset( $wb_ajax_filter_admin_customization_options['filters_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['filters_style'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Custom style', 'wb-ajax-filter' ); ?></span>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Choose which preset of style options you\'d like to apply to your filters', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Color swatch style', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[color_swatches_style]" type="radio" value="yes"<?php ( isset( $wb_ajax_filter_admin_customization_options['color_swatches_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['color_swatches_style'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Rounded', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[color_swatches_style]" type="radio" value="yes"<?php ( isset( $wb_ajax_filter_admin_customization_options['color_swatches_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['color_swatches_style'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Square', 'wb-ajax-filter' ); ?></span>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Choose the style for color thumbnails', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Labels style color', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Background', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[label_style_background_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['label_style_background_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['label_style_background_color'] ) : '#1e73be'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
									<?php esc_html_e( 'Background Hover', 'wb-ajax-filter' ); ?>
								</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[label_style_hover_background_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['label_style_hover_background_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['label_style_hover_background_color'] ) : '#fff'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Background Active', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[label_style_active_background_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['label_style_active_background_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['label_style_active_background_color'] ) : '#fff'; ?>">
							</div>
						</div>
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[label_style_text_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['label_style_text_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['label_style_text_color'] ) : '#1e73be'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text Hover', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[label_style_hover_text_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['label_style_hover_text_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['label_style_hover_text_color'] ) : '#fff'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text Active', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[label_style_active_text_color]" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['label_style_active_text_color'] ) ) ? esc_attr( $wb_ajax_filter_admin_customization_options['label_style_active_text_color'] ) : '#fff'; ?>">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Textual terms color', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
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
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Color swatch size', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[color_swatches_size]" type="text" value="<?php echo ( isset( $wb_ajax_filter_admin_customization_options['color_swatches_size'] ) ) ? esc_html( $wb_ajax_filter_admin_customization_options['color_swatches_size'] ) : ''; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'The size for color thumbnails', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'AJAX loader', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[ajax_loader_style]" type="radio" value="default"<?php ( isset( $wb_ajax_filter_admin_customization_options['ajax_loader_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['ajax_loader_style'], 'default' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Use default loader', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_admin_customization_options[ajax_loader_style]" type="radio" value="custom"<?php ( isset( $wb_ajax_filter_admin_customization_options['ajax_loader_style'] ) ) ? checked( $wb_ajax_filter_admin_customization_options['ajax_loader_style'], 'custom' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Upload custom loader', 'wb-ajax-filter' ); ?></span>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Choose the style for AJAX loader icon', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
			</tbody>
		</table>
		<?php do_action( 'wb_ajax_filter_after_admin_customization_settings', $wb_ajax_filter_admin_customization_options ); ?>
		<?php submit_button(); ?>
	</form>
</div>
