<?php
/**
 * The template for filter name field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

?>
<div class="wb-ajax-filter-toggle-content-row wb-all-toggle">
	<label for="show_toggle"><?php esc_html_e( 'Show as toggle', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
		<div class="wb-ajax-filter-onoff-container">
			<input id="show_toggle" type="checkbox" class="on_off" name="filters[show_toggle]" value="yes" <?php echo ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? 'checked' : ''; ?>>
			<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Enable this to show this filter as a toggle.', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-show-style-toggle" <?php echo ( isset( $filters['show_toggle'] ) && 'yes' === $filters['show_toggle'] ) ? '' : 'style="display:none;"'; ?>>
	<label><?php esc_html_e( 'Toggle style', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-radio-field-wrapper">
		<div class="wb-ajax-filter-radio " data-value="opened" data-type="radio">
			<div class="wb-ajax-filter-radio__row">
				<input id="toggle_style_closed" type="radio" name="filters[toggle_style]" value="closed" <?php echo ( isset( $filters['toggle_style'] ) && 'closed' === $filters['toggle_style'] ) ? 'checked' : ''; ?>>
				<label for="toggle_style_closed"><?php esc_html_e( 'Closed by default', 'wb-ajax-filter' ); ?></label>
			</div>
			<div class="wb-ajax-filter-radio__row">
				<input id="toggle_style_opened" type="radio" name="filters[toggle_style]" value="opened" <?php echo ( isset( $filters['toggle_style'] ) && 'opened' === $filters['toggle_style'] ) ? 'checked' : ''; ?>>
				<label for="toggle_style_opened"><?php esc_html_e( 'Opened by default', 'wb-ajax-filter' ); ?></label>
			</div>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Choose if the toggle should be closed or opened by default.', 'wb-ajax-filter' ); ?></span>
</div>
