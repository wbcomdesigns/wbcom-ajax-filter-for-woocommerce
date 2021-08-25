<?php
/**
 * The admin Search output setting tab template.
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
$wb_ajax_filter_search_output_settings = get_option( 'wb_ajax_filter_search_output_settings' );
?>
<div class="wbcom-tab-content">
	<div class="wb-ajax-filter-tab-content">
		<h2 class="wp-heading-inline"><?php esc_html_e( 'Output Options', 'wb-ajax-filter' ); ?></h2>
	</div>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wb_ajax_filter_search_output_settings' );
		do_settings_sections( 'wb_ajax_filter_search_output_settings' );
		?>
		<?php do_action( 'wb_ajax_filter_before_admin_search_output_settings', $wb_ajax_filter_search_output_settings ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show thumbnail', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_thumbnail]" type="radio" value="none"<?php ( isset( $wb_ajax_filter_search_output_settings['show_thumbnail'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_thumbnail'], 'none' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Hide thumbnail', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_thumbnail]" type="radio" value="left"<?php ( isset( $wb_ajax_filter_search_output_settings['show_thumbnail'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_thumbnail'], 'left' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Show on the Left', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_thumbnail]" type="radio" value="right"<?php ( isset( $wb_ajax_filter_search_output_settings['show_thumbnail'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_thumbnail'], 'right' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Show on the Right', 'wb-ajax-filter' ); ?></span>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Choose if you want show thumbnail and position', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search form default template', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[search_default_template]" type="radio" value="default"<?php ( isset( $wb_ajax_filter_search_output_settings['search_default_template'] ) ) ? checked( $wb_ajax_filter_search_output_settings['search_default_template'], 'default' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Default', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_search_output_settings[search_default_template]" type="radio" value="wide"<?php ( isset( $wb_ajax_filter_search_output_settings['search_default_template'] ) ) ? checked( $wb_ajax_filter_search_output_settings['search_default_template'], 'wide' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Wide', 'wb-ajax-filter' ); ?></span>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'This option can be overridden by shortcode or widget', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Size of thumbnails', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[search_show_thumbnail_dim]" type="text" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['search_show_thumbnail_dim'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['search_show_thumbnail_dim'] ) : ''; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Insert in px the dimension of thumbnails', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show price', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_price]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['show_price'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_price'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Show price of product', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Price Label', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[search_price_label]" type="text" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['search_price_label'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['search_price_label'] ) : ''; ?>">
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Show a label before the price', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Include Product Variation', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[include_variations]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['include_variations'] ) ) ? checked( $wb_ajax_filter_search_output_settings['include_variations'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Choose if include or not the product variations in the search results', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Loader', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<div class="gif-container">
							<img src="<?php echo ( isset( $wb_ajax_filter_search_output_settings['loader_url'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['loader_url'] ) : ''; ?>" alt="" style="max-width:100%;">
						</div>
						<label>
							<input name="wb_ajax_filter_search_output_settings[loader_attchment_id]" type="hidden" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['loader_attchment_id'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['loader_attchment_id'] ) : ''; ?>">
							<input name="wb_ajax_filter_search_output_settings[loader_url]" type="text" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['loader_url'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['loader_url'] ) : ''; ?>">
							<button class="btn" id="wb_upload_gif"><span class="dashicons dashicons-cloud-upload"></span><?php esc_html_e( 'Upload', 'wb-ajax-filter' ); ?></button>
							<button class="btn" id="wb_reset_upload_gif"><?php esc_html_e( 'Reset', 'wb-ajax-filter' ); ?></button>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Loader gif', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<h3>
							<?php esc_html_e( 'Sales and Featured badges', 'wb-ajax-filter' ); ?>
						</h3>
					</th>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show sale badge', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_sale_badge]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['show_sale_badge'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_sale_badge'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Show sale badge if the product is on sale', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Sale badge color', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Background Color', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_search_output_settings[sale_badge_bg_color]" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['sale_badge_bg_color'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['sale_badge_bg_color'] ) : '#1e73be'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text Color', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_search_output_settings[sale_badge_text_color]" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['sale_badge_text_color'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['sale_badge_text_color'] ) : '#fff'; ?>">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show out of stock badge', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_outofstock_badge]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['show_outofstock_badge'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_outofstock_badge'], 'yes' ) : ''; ?>>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Out of stock badge color', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Background Color', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_search_output_settings[outofstock_badge_bg_color]" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['outofstock_badge_bg_color'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['outofstock_badge_bg_color'] ) : '#1e73be'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text Color', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_search_output_settings[outofstock_badge_text_color]" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['outofstock_badge_text_color'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['outofstock_badge_text_color'] ) : '#fff'; ?>">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show featured badge', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_featured_badge]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['show_featured_badge'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_featured_badge'], 'yes' ) : ''; ?>>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Featured badge color', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Background Color', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_search_output_settings[featured_badge_bg_color]" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['featured_badge_bg_color'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['featured_badge_bg_color'] ) : '#1e73be'; ?>">
							</div>
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<label>
								<?php esc_html_e( 'Text Color', 'wb-ajax-filter' ); ?>
							</label>
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_search_output_settings[featured_badge_text_color]" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['featured_badge_text_color'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['featured_badge_text_color'] ) : '#fff'; ?>">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Hide featured bagde if the product is on sale', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[hide_feature_if_on_sale]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['hide_feature_if_on_sale'] ) ) ? checked( $wb_ajax_filter_search_output_settings['hide_feature_if_on_sale'], 'yes' ) : ''; ?>>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<h3>
							<?php esc_html_e( 'Title & Excerpt', 'wb-ajax-filter' ); ?>
						</h3>
					</th>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Title color', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<div class="wb-ajax-filter-colorpicker">
							<div class="wb-ajax-filter-single-colorpicker colorpicker">
								<input class="wb-ajax-color-picker" name="wb_ajax_filter_search_output_settings[search_title_color]" value="<?php echo ( isset( $wb_ajax_filter_search_output_settings['search_title_color'] ) ) ? esc_attr( $wb_ajax_filter_search_output_settings['search_title_color'] ) : '#ffff'; ?>">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show excerpt', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[show_excerpt]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['show_excerpt'] ) ) ? checked( $wb_ajax_filter_search_output_settings['show_excerpt'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Show excerpt of product', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show product categories', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[categories]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['categories'] ) ) ? checked( $wb_ajax_filter_search_output_settings['categories'], 'yes' ) : ''; ?>>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<h3>
							<?php esc_html_e( '"View All" Link', 'wb-ajax-filter' ); ?>
						</h3>
					</th>
					<td></td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Show "view all" link', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_output_settings[search_show_view_all]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_output_settings['search_show_view_all'] ) ) ? checked( $wb_ajax_filter_search_output_settings['search_show_view_all'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Add a link to the bottom of results', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
			</tbody>
		</table>
		<?php do_action( 'wb_ajax_filter_after_admin_search_output_settings', $wb_ajax_filter_search_output_settings ); ?>
		<?php submit_button(); ?>
	</form>
</div>

