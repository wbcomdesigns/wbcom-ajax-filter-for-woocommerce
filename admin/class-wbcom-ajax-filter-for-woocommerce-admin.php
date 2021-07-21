<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wbcom_Ajax_Filter_For_Woocommerce
 * @subpackage Wbcom_Ajax_Filter_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wbcom_Ajax_Filter_For_Woocommerce
 * @subpackage Wbcom_Ajax_Filter_For_Woocommerce/admin
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Wbcom_Ajax_Filter_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wbcom_Ajax_Filter_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wbcom_Ajax_Filter_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wbcom-ajax-filter-for-woocommerce-admin.css', array(), $this->version, 'all' );

		if ( ! wp_style_is( 'font-awesome', 'enqueued' ) ) {
			wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wbcom_Ajax_Filter_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wbcom_Ajax_Filter_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wbcom-ajax-filter-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add Woo ajax filter Menu in admin.
	 *
	 * @since    1.0.0
	 */
	public function wpc_admin_menu() {

		/* add sub menu in wnplugin setting page */
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'wb-ajaxfilter' ), esc_html__( 'WB Plugins', 'wb-ajaxfilter' ), 'manage_options', 'wbcomplugins', array( $this, 'get_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'wb-ajaxfilter' ), esc_html__( 'General', 'wb-ajaxfilter' ), 'manage_options', 'wbcomplugins' );
		}

		add_submenu_page( 'wbcomplugins', esc_html__( 'WB Ajax Filter', 'wb-ajaxfilter' ), esc_html__( 'WB Ajax Filter', 'wb-ajaxfilter' ), 'manage_options', 'wb-ajaxfilter', array( $this, 'get_page' ) );
	}


	/**
	 * display welcome page in admin.
	 *
	 * @since    1.0.0
	 */
	public function get_page()
	{
		$page = ( filter_input( INPUT_GET, 'page' ) !== null ) ? filter_input( INPUT_GET, 'page' ) : 'wb-ajaxfilter';
		$current = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : '';
		if('wb-ajaxfilter' == $page && empty($current)){
			self::wpc_admin_settings_page_welcome();
		}elseif(empty($current) && $page=='wbcomplugins'){
			$current = 'wpc-general';
			self::wpc_admin_settings_page($current);
		}else{
			self::wpc_admin_settings_page($current);
		}
	}
	/**
	 * display welcome page in admin.
	 *
	 * @since    1.0.0
	 */
	public function wpc_admin_settings_page_welcome() {
		?>
		<div class="wrap">
			<div class="ess-admin-header">
			<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
			<h1 class="wbcom-plugin-heading">
				<?php esc_html_e( 'WB Ajax Filter', 'wb-ajaxfilter' ); ?>
			</h1>
		</div>
		<div class="wbcom-admin-settings-page">
			<?php $this->wpc_plugin_settings_tabs_wbcom(); ?>
			<?php include 'wbcom-welcome-page.php'; ?>
		</div>
	</div>
		<?php
	}

	/**
	 * display welcome page in admin.
	 *
	 * @since    1.0.0
	 */
	public function wpc_admin_settings_page($current) {
		?>
		<div class="wrap">
			<div class="ess-admin-header">
				<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
				<h1 class="wbcom-plugin-heading">
					<?php esc_html_e( 'WB Ajax Filter', 'wb-ajaxfilter' ); ?>
				</h1>
			</div>
			<div class="wbcom-admin-settings-page">
				<?php $this->wpc_plugin_settings_tabs(); ?>
				<form method="post" id="wbrecaptcha" action="" enctype="multipart/form-data">
				<?php echo $current; ?>
				<button name="save" class="button-primary woocommerce-save-button" type="submit" value="Save changes">Save changes</button>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Register all settings.
	 */
	public function wpc_add_admin_register_setting() {
		$this->plugin_settings_tabs['wpc-welcome']['name'] = esc_html__( 'Welcome', 'wb-ajaxfilter' );
		$this->plugin_settings_tabs['wpc-welcome']['icon'] = 'dashicons-admin-home';

		$this->plugin_settings_tabs['wpc-general']['name'] = esc_html__( 'General', 'wb-ajaxfilter' );
		$this->plugin_settings_tabs['wpc-general']['icon'] = 'dashicons-admin-generic';

		$this->plugin_settings_tabs['wpc-filter-preset']['name'] = esc_html__( 'Filter Preset', 'wb-ajaxfilter' );
		$this->plugin_settings_tabs['wpc-filter-preset']['icon'] = 'dashicons-admin-home';
	}

	/**
	 * Add tab in setting page
	 */
	public function wpc_plugin_settings_tabs() {
		$current = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : 'wpc-general';

		$tab_html = '<div class="wbcom-tabs-section"><h2 class="nav-tab-wrapper">';

		foreach ( $this->plugin_settings_tabs as $edd_tab => $tab_name ) {
			$class     = ( $edd_tab === $current ) ? 'nav-tab-active' : '';
			$page      = 'wb-ajaxfilter';
			$tab_html .= '<a id="' . $edd_tab . '" class="nav-tab ' . $class . '" href="admin.php?page=' . $page . '&tab=' . $edd_tab . '"><span class="dashicons ' . $tab_name['icon'] . '"></span>&nbsp;' . $tab_name['name'] . '</a>';
		}
		$tab_html .= '</h2></div>';
		echo $tab_html;
	}

	/**
	 * Template Class Doc Comment
	 *
	 * Template Class.
	 */
	public function wpc_plugin_settings_tabs_wbcom() {
		$current = ( filter_input( INPUT_GET, 'tab' ) !== null ) ? filter_input( INPUT_GET, 'tab' ) : 'wpc-welcome';

		$tab_html = '<div class="wbcom-tabs-section"><h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $edd_tab => $tab_name ) {
			$class     = ( $edd_tab === $current ) ? 'nav-tab-active' : '';
			$page      = 'wb-ajaxfilter';
			$tab_html .= '<a id="' . $edd_tab . '" class="nav-tab ' . $class . '" href="admin.php?page=' . $page . '&tab=' . $edd_tab . '"><span class="dashicons ' . $tab_name['icon'] . '"></span>&nbsp;' . $tab_name['name'] . '</a>';
		}
		$tab_html .= '</h2></div>';
		echo $tab_html;
	}

}
