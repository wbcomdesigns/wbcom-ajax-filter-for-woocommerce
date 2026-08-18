<?php
/**
 * License tab - EDD license key plus support resources.
 *
 * The license form logic lives in edd-license/edd-plugin-license.php; this
 * partial only supplies the card chrome the shared settings screen expects.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin/partials
 * @since      1.2.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Wbcom_Settings_Page::card_open(
	__( 'License', 'wb-ajax-filter' ),
	__( 'An active license key enables automatic plugin updates.', 'wb-ajax-filter' )
);

if ( function_exists( 'edd_wbcom_ajax_filter_render_license_section' ) ) {
	edd_wbcom_ajax_filter_render_license_section();
}

Wbcom_Settings_Page::card_close();

Wbcom_Settings_Page::card_open(
	__( 'Help & support', 'wb-ajax-filter' ),
	__( 'Documentation and help for Ajax Filter for WooCommerce.', 'wb-ajax-filter' )
);
?>
<ul class="wbcom-feature-list">
	<li>
		<i data-lucide="book-open"></i>
		<a href="https://docs.wbcomdesigns.com/doc_category/ajax-filter-woocommerce/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Documentation', 'wb-ajax-filter' ); ?></a>
	</li>
	<li>
		<i data-lucide="life-buoy"></i>
		<a href="https://wbcomdesigns.com/support/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Support center', 'wb-ajax-filter' ); ?></a>
	</li>
	<li>
		<i data-lucide="message-square"></i>
		<a href="https://wbcomdesigns.com/submit-review/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Share your feedback', 'wb-ajax-filter' ); ?></a>
	</li>
</ul>
<?php
Wbcom_Settings_Page::card_close();
