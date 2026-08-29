<?php
/**
 * Gutenberg block registration.
 *
 * Block themes frequently never fire the classic WooCommerce hooks this plugin
 * auto-renders through (woocommerce_before_shop_loop), so a store owner on a
 * block theme needs a way to place the filter UI by hand. The block, the
 * [wb_ajax_filters] shortcode and the auto-render all resolve to the same
 * renderer: Wb_Ajax_Filter_Public::filter_preset_shortcode_callback().
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.2.2
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the wb-ajax-filter/filters dynamic block.
 *
 * @since 1.2.2
 */
class Wb_Ajax_Filter_Blocks {

	/**
	 * The public class instance - owns the shared renderer and asset enqueues.
	 *
	 * @since 1.2.2
	 * @access private
	 * @var Wb_Ajax_Filter_Public $plugin_public
	 */
	private $plugin_public;

	/**
	 * The registered block type, kept to resolve the editor script handle.
	 *
	 * @since 1.2.2
	 * @access private
	 * @var WP_Block_Type|false $block_type
	 */
	private $block_type = false;

	/**
	 * Set up the block registrar.
	 *
	 * @since 1.2.2
	 * @param Wb_Ajax_Filter_Public $plugin_public The public class instance.
	 */
	public function __construct( $plugin_public ) {
		$this->plugin_public = $plugin_public;
	}

	/**
	 * Register the filters block from its block.json metadata.
	 *
	 * @since 1.2.2
	 * @return void
	 */
	public function register_blocks() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$this->block_type = register_block_type(
			WB_AJAX_FILTER_PLUGIN_PATH . 'assets/blocks/filters',
			array(
				'render_callback' => array( $this, 'render_filters_block' ),
			)
		);
	}

	/**
	 * Expose the preset list to the block editor's preset dropdown.
	 *
	 * Hooked to enqueue_block_editor_assets so the (bounded) preset query only
	 * runs when the editor actually loads, never on frontend requests.
	 *
	 * @since 1.2.2
	 * @return void
	 */
	public function localize_editor_presets() {
		if ( ! $this->block_type || empty( $this->block_type->editor_script_handles ) ) {
			return;
		}

		$presets = get_posts(
			array(
				'post_type'   => 'wb_filter_preset',
				'post_status' => 'publish',
				'numberposts' => 100,
				'orderby'     => 'title',
				'order'       => 'ASC',
			)
		);

		$choices = array(
			array(
				'label' => __( 'All enabled presets', 'wb-ajax-filter' ),
				'value' => '',
			),
		);
		foreach ( $presets as $preset ) {
			$choices[] = array(
				'label' => $preset->post_title,
				'value' => $preset->post_name,
			);
		}

		wp_localize_script(
			$this->block_type->editor_script_handles[0],
			'wbAjaxFilterBlock',
			array( 'presets' => $choices )
		);
	}

	/**
	 * Server-render the filters block through the shared shortcode renderer.
	 *
	 * @since 1.2.2
	 * @param array $attributes Block attributes.
	 * @return string Rendered block markup.
	 */
	public function render_filters_block( $attributes ) {
		// The wp_enqueue_scripts gate cannot see blocks placed in FSE template
		// areas (there is no $post to inspect), so enqueue from render as well.
		// Both calls are idempotent by handle.
		$this->plugin_public->enqueue_filter_styles();
		$this->plugin_public->enqueue_filter_scripts();

		$shortcode = '[wb_ajax_filters]';
		if ( ! empty( $attributes['preset'] ) ) {
			$shortcode = '[wb_ajax_filters slug="' . sanitize_title( $attributes['preset'] ) . '"]';
		}

		$wrapper_attributes = function_exists( 'get_block_wrapper_attributes' )
			? get_block_wrapper_attributes( array( 'class' => 'wb-ajax-filter-block' ) )
			: 'class="wb-ajax-filter-block"';

		return '<div ' . $wrapper_attributes . '>' . do_shortcode( $shortcode ) . '</div>';
	}
}
