<?php
/**
 * The admin Search content setting tab template.
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
$wb_ajax_filter_search_content_settings = get_option( 'wb_ajax_filter_search_content_settings' );
?>
<div class="wbcom-tab-content">
<div class="wb-ajax-filter-tab-content">
	<h2 class="wp-heading-inline"><?php esc_html_e( 'Search Options', 'wb-ajax-filter' ); ?></h2>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'wb_ajax_filter_search_content_settings' );
		do_settings_sections( 'wb_ajax_filter_search_content_settings' );
		?>
		<?php do_action( 'wb_ajax_filter_before_admin_search_option_settings', $wb_ajax_filter_search_content_settings ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Choose element types to search', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[default_research]" type="radio" value="any"<?php ( isset( $wb_ajax_filter_search_content_settings['default_research'] ) ) ? checked( $wb_ajax_filter_search_content_settings['default_research'], 'any' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'All', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_search_content_settings[default_research]" type="radio" value="product"<?php ( isset( $wb_ajax_filter_search_content_settings['default_research'] ) ) ? checked( $wb_ajax_filter_search_content_settings['default_research'], 'product' ) : ''; ?>>
							<span class="wb-ajax-filter-option-text"><?php esc_html_e( 'Products', 'wb-ajax-filter' ); ?></span>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Choose if you want to extend search also to posts and pages', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search in title', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_in_title]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['search_in_title'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_in_title'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Extend search in the title of the product', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search in excerpt', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_in_excerpt]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['search_in_excerpt'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_in_excerpt'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Extend search in the excerpt of the product', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search in content', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_in_content]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['search_in_content'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_in_content'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Extend search in the content of the product', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search in product categories', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_in_product_categories]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['search_in_product_categories'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_in_product_categories'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Extend search in product categories', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search in product tags', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_in_product_tags]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['search_in_product_tags'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_in_product_tags'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Extend search in product tags', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search in author', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_in_author]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['search_in_author'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_in_author'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Extend search in author', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Multiple Word Search', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_type_more_words]" type="radio" value="and"<?php ( isset( $wb_ajax_filter_search_content_settings['search_type_more_words'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_type_more_words'], 'and' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Show items containing all words typed', 'wb-ajax-filter' ); ?></span>
						</label><br>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_type_more_words]" type="radio" value="or"<?php ( isset( $wb_ajax_filter_search_content_settings['search_type_more_words'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_type_more_words'], 'or' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Show items containing at least one of the words typed', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Hide out of stock products', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[hide_out_of_stock]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['hide_out_of_stock'] ) ) ? checked( $wb_ajax_filter_search_content_settings['hide_out_of_stock'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Enable this option if you don\'t want to show out of stock products in the results', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<h2>
							<?php esc_html_e( 'Order Options', 'wb-ajax-filter' ); ?>
						</h2>
					</th>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Enable order by post type', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[order_by_post_type]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['order_by_post_type'] ) ) ? checked( $wb_ajax_filter_search_content_settings['order_by_post_type'], 'yes' ) : ''; ?>>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<h2>
							<?php esc_html_e( 'Search by Custom Field', 'wb-ajax-filter' ); ?>
						</h2>
					</th>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Custom field name', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<select id="wb_ajax_check_custom_field_option" name="wb_ajax_filter_search_content_settings[cf_name]">
								<?php if ( isset( $wb_ajax_filter_search_content_settings['cf_name'] ) && '' !== $wb_ajax_filter_search_content_settings['cf_name'] ) : ?>
									<option value="<?php echo esc_attr( $wb_ajax_filter_search_content_settings['cf_name'] ); ?>" selected><?php echo esc_html( $wb_ajax_filter_search_content_settings['cf_name'] ); ?></option>
								<?php endif; ?>
							</select>
						</label><br>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<h2>
							<?php esc_html_e( 'Search by Sku Settings', 'wb-ajax-filter' ); ?>
						</h2>
					</th>
				</tr>
				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Search by sku', 'wb-ajax-filter' ); ?>
						</label>
					</th>
					<td>
						<label>
							<input name="wb_ajax_filter_search_content_settings[search_by_sku]" type="checkbox" value="yes"<?php ( isset( $wb_ajax_filter_search_content_settings['search_by_sku'] ) ) ? checked( $wb_ajax_filter_search_content_settings['search_by_sku'], 'yes' ) : ''; ?>>
							<span class="wb-ajax-filter-option-desc"><?php esc_html_e( 'Extend search functionality so that search includes also sku', 'wb-ajax-filter' ); ?></span>
						</label><br>
					</td>
				</tr>
			</tbody>
		</table>
		<?php do_action( 'wb_ajax_filter_after_admin_search_option_settings', $wb_ajax_filter_search_content_settings ); ?>
		<?php submit_button(); ?>
	</form>
</div>
</div>
