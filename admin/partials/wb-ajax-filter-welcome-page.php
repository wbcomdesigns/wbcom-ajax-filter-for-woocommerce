<?php
/**
 * This file is used for rendering and saving plugin welcome settings.
 *
 * @package    Wbcom_Quick_View_For_Woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
	// Exit if accessed directly.
}
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-welcome-head">
			<h2 class="wbcom-welcome-title"><?php esc_html_e( 'Wbcom Ajax Filter for Woocommerce', 'wb-ajax-filter' ); ?></h2>
			<p class="wbcom-welcome-description"><?php esc_html_e( 'Wbcom Ajax Filter for Woocommerce Plugin allows your users to find the product they are looking for as quickly as possible.', 'wb-ajax-filter' ); ?></p>
		</div><!-- .wbcom-welcome-head -->

		<div class="wbcom-welcome-content">

			<div class="wbcom-video-link-wrapper">

			</div>

			<div class="wbcom-welcome-support-info">
				<h3><?php esc_html_e( 'Help &amp; Support Resources', 'wb-ajax-filter' ); ?></h3>
				<p><?php esc_html_e( 'Here are all the resources you may need to get help from us. Documentation is usually the best place to start. Should you require help anytime, our customer care team is available to assist you at the support center.', 'wb-ajax-filter' ); ?></p>
				<hr>

				<div class="three-col">

					<div class="col">
						<h3><span class="dashicons dashicons-book"></span><?php esc_html_e( 'Documentation', 'wb-ajax-filter' ); ?></h3>
						<p><?php esc_html_e( 'We have prepared an extensive guide on Wbcom Ajax Filter for Woocommerce to learn all aspects of the plugin. You will find most of your answers here.', 'wb-ajax-filter' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/docs/buddypress-paid-addons/buddypress-woocommerce-integration/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Read Documentation', 'wb-ajax-filter' ); ?></a>
					</div>

					<div class="col">
						<h3><span class="dashicons dashicons-sos"></span><?php esc_html_e( 'Support Center', 'wb-ajax-filter' ); ?></h3>
						<p><?php esc_html_e( 'We strive to offer the best customer care via our support center. Once your theme is activated, you can ask us for help anytime.', 'wb-ajax-filter' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/support/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Get Support', 'wb-ajax-filter' ); ?></a>
					</div>

					<div class="col">
						<h3><span class="dashicons dashicons-admin-comments"></span><?php esc_html_e( 'Got Feedback?', 'wb-ajax-filter' ); ?></h3>
						<p><?php esc_html_e( 'We want to hear about your experience with the plugin. We would also love to hear any suggestions you may for future updates.', 'wb-ajax-filter' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/contact/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Send Feedback', 'wb-ajax-filter' ); ?></a>
					</div>

				</div>

			</div>
		</div>
	</div><!-- .wbcom-welcome-main-wrapper -->
</div><!-- .wbcom-tab-content -->
