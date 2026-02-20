<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://wbcomdesigns.com
 * @since 1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin/partials
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wbcom-tab-content">
	<div class="wbcom-faq-adming-setting">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Frequently Asked Questions.', 'wb-ajax-filter' ); ?></h3>
		</div>
		<div class="wbcom-faq-admin-settings-block">
			<div id="wbcom-faq-settings-section" class="wbcom-faq-table">
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'Does this plugin require WooCommerce to work?', 'wb-ajax-filter' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p>
								<?php esc_html_e( 'Yes, this plugin requires WooCommerce to function, as it is specifically built for WooCommerce product filtering.', 'wb-ajax-filter' ); ?>
							</p>
						</div>
					</div>
				</div>
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'Is it possible to create custom filters?', 'wb-ajax-filter' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p>
								<?php esc_html_e( 'Yes, custom filters can be created and configured to match specific product attributes, categories, reviews, or price ranges for more tailored filtering options.', 'wb-ajax-filter' ); ?>
							</p>
						</div>
					</div>
				</div>
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'Do I need to use any shortcode to display the filters?', 'wb-ajax-filter' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p>
								<?php esc_html_e( 'No, the plugin automatically integrates with your WooCommerce shop and archive pages.', 'wb-ajax-filter' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'How many product attributes does this plugin support?', 'wb-ajax-filter' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p>
								<?php esc_html_e( 'Currently, the plugin supports filtering by category, price, name, reviews, brands, product tags, in stock, and On sale.', 'wb-ajax-filter' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'What if I have a question?', 'wb-ajax-filter' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p>
								<?php esc_html_e( 'No problem. Please get in touch with us via our', 'wb-ajax-filter' ); ?>
								<a href="<?php echo esc_url( 'https://wbcomdesigns.com/contact/' ); ?>" target="_blank"><?php esc_html_e( 'Contact page.', 'wb-ajax-filter' ); ?></a>
							</p>
						</div>
					</div>
				</div>
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'What if I need additional features?', 'wb-ajax-filter' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p>
								<?php esc_html_e( 'If you require extra features or custom functionality, our team is available for hire to assist with tailored development.', 'wb-ajax-filter' ); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>