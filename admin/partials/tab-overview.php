<?php
/**
 * Overview tab - what the filter is doing on this store right now.
 *
 * The landing screen: version and dependency state, stat tiles with
 * explanatory captions, the current configuration written as consequences
 * rather than stored values, and quick actions routing to the tab that
 * changes the thing just described. Included from
 * Wb_Ajax_Filter_Admin::render_settings_tab(), so $this is the admin class.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin/partials
 * @since      1.2.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wb_stats   = $this->get_overview_stats();
$wb_general = get_option( 'wb_ajax_filter_admin_general_options', array() );
$wb_search  = get_option( 'wb_ajax_filter_search_settings', array() );
$wb_scope   = get_option( 'wb_ajax_filter_search_content_settings', array() );
$wb_custom  = get_option( 'wb_ajax_filter_admin_customization_options', array() );

$wb_presets_url  = Wbcom_Settings_Page::tab_url( Wb_Ajax_Filter_Admin::PAGE_SLUG, 'wb-ajax-filter-presets' );
$wb_advanced_url = Wbcom_Settings_Page::tab_url( Wb_Ajax_Filter_Admin::PAGE_SLUG, 'advanced' );
$wb_license_url  = Wbcom_Settings_Page::tab_url( Wb_Ajax_Filter_Admin::PAGE_SLUG, 'license' );
$wb_shop_url     = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '';

$wb_search_on = isset( $wb_search['enable_search'] ) && 'yes' === $wb_search['enable_search'];

/*
 * The configuration snapshot: each line states what a shopper experiences as a
 * consequence of the saved options, never the option value itself. Defaults
 * mirror the Advanced tab (ajax_filters and instant_filters default to yes,
 * filters_style defaults to theme).
 */
$wb_snapshot = array();

$wb_snapshot[] = array(
	'icon' => 'store',
	'text' => __( 'Filters render on the shop page and on every product category and tag archive. The [wb_ajax_filters] shortcode places them on any other page.', 'wb-ajax-filter' ),
);

if ( ( ! isset( $wb_general['ajax_filters'] ) || 'yes' === $wb_general['ajax_filters'] ) ) {
	$wb_snapshot[] = array(
		'icon' => 'zap',
		'text' => __( 'Results update in place - shoppers never wait for a page reload.', 'wb-ajax-filter' ),
	);
} else {
	$wb_snapshot[] = array(
		'icon' => 'refresh-cw',
		'text' => __( 'Every filter change reloads the page. Switch AJAX filtering on under Advanced to update results in place.', 'wb-ajax-filter' ),
	);
}

if ( ( ! isset( $wb_general['instant_filters'] ) || 'yes' === $wb_general['instant_filters'] ) ) {
	$wb_snapshot[] = array(
		'icon' => 'mouse-pointer-click',
		'text' => __( 'Products narrow the moment a shopper picks a value.', 'wb-ajax-filter' ),
	);
} else {
	$wb_snapshot[] = array(
		'icon' => 'list-checks',
		'text' => __( 'Shoppers choose several values first, then apply them together.', 'wb-ajax-filter' ),
	);
}

if ( $wb_search_on ) {
	$wb_snapshot[] = array(
		'icon' => 'search',
		'text' => ( isset( $wb_scope['default_research'] ) && 'any' === $wb_scope['default_research'] )
			? __( 'A product search box sits above the filters and matches product titles and descriptions.', 'wb-ajax-filter' )
			: __( 'A product search box sits above the filters and matches product titles.', 'wb-ajax-filter' ),
	);
} else {
	$wb_snapshot[] = array(
		'icon' => 'search-x',
		'text' => __( 'No search box is shown above the filters. Enable it under Advanced.', 'wb-ajax-filter' ),
	);
}

if ( ! empty( $wb_general['show_reset'] ) ) {
	$wb_snapshot[] = array(
		'icon' => 'rotate-ccw',
		'text' => ( isset( $wb_general['reset_button_position'] ) && 'after_filters' === $wb_general['reset_button_position'] )
			? __( 'A Reset control after the filters clears every choice in one click.', 'wb-ajax-filter' )
			: __( 'A Reset control before the filters clears every choice in one click.', 'wb-ajax-filter' ),
	);
} else {
	$wb_snapshot[] = array(
		'icon' => 'rotate-ccw',
		'text' => __( 'Shoppers clear filters one by one - no Reset control is shown.', 'wb-ajax-filter' ),
	);
}

if ( ! empty( $wb_general['show_active_labels'] ) ) {
	$wb_snapshot[] = array(
		'icon' => 'tags',
		'text' => __( 'Each active filter appears as a removable chip above the products.', 'wb-ajax-filter' ),
	);
}

$wb_snapshot[] = array(
	'icon' => 'palette',
	'text' => ( isset( $wb_custom['filters_style'] ) && 'custom' === $wb_custom['filters_style'] )
		? __( 'Filters use the custom colours set under Advanced instead of your theme\'s styling.', 'wb-ajax-filter' )
		: __( 'Filters inherit your theme\'s colours and typography.', 'wb-ajax-filter' ),
);

Wbcom_Settings_Page::card_open(
	__( 'At a glance', 'wb-ajax-filter' ),
	__( 'The plugin state and headline numbers for this store right now.', 'wb-ajax-filter' )
);
?>

<div class="wb-ajax-overview-meta">
	<span class="wbcom-badge">
		<?php
		echo esc_html(
			sprintf(
				/* translators: %s: plugin version number. */
				__( 'Version %s', 'wb-ajax-filter' ),
				defined( 'WB_AJAX_FILTER_VERSION' ) ? WB_AJAX_FILTER_VERSION : ''
			)
		);
		?>
	</span>
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<span class="wbcom-badge wbcom-badge--success">
			<?php
			echo esc_html(
				defined( 'WC_VERSION' )
					/* translators: %s: WooCommerce version number. */
					? sprintf( __( 'WooCommerce %s active', 'wb-ajax-filter' ), WC_VERSION )
					: __( 'WooCommerce active', 'wb-ajax-filter' )
			);
			?>
		</span>
	<?php else : ?>
		<span class="wbcom-badge wbcom-badge--danger">
			<?php esc_html_e( 'WooCommerce is not active - filters are not running on your store.', 'wb-ajax-filter' ); ?>
		</span>
	<?php endif; ?>
	<?php if ( 0 === $wb_stats['enabled_count'] ) : ?>
		<span class="wbcom-badge wbcom-badge--warn">
			<?php esc_html_e( 'No preset is enabled - shoppers currently see no filters.', 'wb-ajax-filter' ); ?>
		</span>
	<?php endif; ?>
</div>

<div class="wb-ajax-overview-tiles">
	<div class="wb-ajax-overview-tile">
		<span class="wb-ajax-overview-tile__value">
			<?php
			echo esc_html(
				sprintf(
					/* translators: 1: enabled preset count, 2: total preset count. */
					_x( '%1$s of %2$s', 'enabled presets out of total', 'wb-ajax-filter' ),
					number_format_i18n( $wb_stats['enabled_count'] ),
					number_format_i18n( $wb_stats['total'] )
				)
			);
			?>
		</span>
		<span class="wb-ajax-overview-tile__label"><?php esc_html_e( 'Presets enabled', 'wb-ajax-filter' ); ?></span>
		<p class="wb-ajax-overview-tile__caption"><?php esc_html_e( 'Enabled presets render their filters to shoppers; disabled ones stay saved here without showing anywhere.', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wb-ajax-overview-tile">
		<span class="wb-ajax-overview-tile__value"><?php echo esc_html( number_format_i18n( $wb_stats['live_fields'] ) ); ?></span>
		<span class="wb-ajax-overview-tile__label"><?php esc_html_e( 'Filter fields live', 'wb-ajax-filter' ); ?></span>
		<p class="wb-ajax-overview-tile__caption"><?php esc_html_e( 'Dropdowns, checkboxes, sliders and ranges shoppers can filter with right now, across every enabled preset.', 'wb-ajax-filter' ); ?></p>
	</div>
	<div class="wb-ajax-overview-tile">
		<span class="wb-ajax-overview-tile__value">
			<?php $wb_search_on ? esc_html_e( 'On', 'wb-ajax-filter' ) : esc_html_e( 'Off', 'wb-ajax-filter' ); ?>
		</span>
		<span class="wb-ajax-overview-tile__label"><?php esc_html_e( 'Product search', 'wb-ajax-filter' ); ?></span>
		<p class="wb-ajax-overview-tile__caption">
			<?php
			$wb_search_on
				? esc_html_e( 'A search box with live suggestions renders above the filters on shop and archive pages.', 'wb-ajax-filter' )
				: esc_html_e( 'The search box above the filters is switched off; shoppers filter without free-text search.', 'wb-ajax-filter' );
			?>
		</p>
	</div>
</div>

<?php
Wbcom_Settings_Page::card_close();

Wbcom_Settings_Page::card_open(
	__( 'Current configuration', 'wb-ajax-filter' ),
	__( 'What a shopper experiences with the options saved right now.', 'wb-ajax-filter' )
);
?>
<ul class="wb-ajax-overview-snapshot">
	<?php foreach ( $wb_snapshot as $wb_line ) : ?>
		<li>
			<i data-lucide="<?php echo esc_attr( $wb_line['icon'] ); ?>"></i>
			<span><?php echo esc_html( $wb_line['text'] ); ?></span>
		</li>
	<?php endforeach; ?>
</ul>
<?php
Wbcom_Settings_Page::card_close();

Wbcom_Settings_Page::card_open(
	__( 'Your presets', 'wb-ajax-filter' ),
	__( 'Each preset is a reusable set of filters; the shortcode column of Your Filters places one on a specific page.', 'wb-ajax-filter' )
);

if ( empty( $wb_stats['presets'] ) ) :
	?>
	<div class="wbcom-empty-state">
		<i data-lucide="sliders-horizontal"></i>
		<p class="wbcom-empty-state__title"><?php esc_html_e( 'No filter presets yet', 'wb-ajax-filter' ); ?></p>
		<p class="wbcom-empty-state__desc"><?php esc_html_e( 'Create one under Your Filters and it renders on your shop and archive pages as soon as it is enabled.', 'wb-ajax-filter' ); ?></p>
		<a class="wbcom-btn wbcom-btn--primary" href="<?php echo esc_url( $wb_presets_url ); ?>">
			<i data-lucide="plus"></i>
			<?php esc_html_e( 'Create your first preset', 'wb-ajax-filter' ); ?>
		</a>
	</div>
	<?php
else :
	?>
	<table class="wb-ajax-overview-presets">
		<thead>
			<tr>
				<th scope="col"><?php esc_html_e( 'Preset', 'wb-ajax-filter' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Filter fields', 'wb-ajax-filter' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Status', 'wb-ajax-filter' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $wb_stats['presets'] as $wb_row ) : ?>
				<tr>
					<td><a href="<?php echo esc_url( $wb_row['edit_url'] ); ?>"><?php echo esc_html( $wb_row['title'] ); ?></a></td>
					<td><?php echo esc_html( number_format_i18n( $wb_row['fields'] ) ); ?></td>
					<td>
						<?php if ( $wb_row['enabled'] ) : ?>
							<span class="wbcom-badge wbcom-badge--success"><?php esc_html_e( 'Enabled', 'wb-ajax-filter' ); ?></span>
						<?php else : ?>
							<span class="wbcom-badge"><?php esc_html_e( 'Disabled', 'wb-ajax-filter' ); ?></span>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if ( $wb_stats['truncated'] ) : ?>
		<p class="wb-ajax-overview-truncated">
			<?php
			echo esc_html(
				sprintf(
					/* translators: 1: presets listed, 2: total presets. */
					__( 'Showing the first %1$s of %2$s presets. The full list lives under Your Filters.', 'wb-ajax-filter' ),
					number_format_i18n( count( $wb_stats['presets'] ) ),
					number_format_i18n( $wb_stats['total'] )
				)
			);
			?>
		</p>
	<?php endif; ?>
	<?php
endif;

Wbcom_Settings_Page::card_close();

Wbcom_Settings_Page::card_open(
	__( 'Quick actions', 'wb-ajax-filter' ),
	__( 'Jump straight to the screen that changes what you just read.', 'wb-ajax-filter' )
);
?>
<div class="wb-ajax-overview-actions">
	<a class="wbcom-btn wbcom-btn--primary" href="<?php echo esc_url( $wb_presets_url ); ?>">
		<i data-lucide="sliders-horizontal"></i>
		<?php esc_html_e( 'Create or edit presets', 'wb-ajax-filter' ); ?>
	</a>
	<a class="wbcom-btn" href="<?php echo esc_url( $wb_advanced_url ); ?>">
		<i data-lucide="settings-2"></i>
		<?php esc_html_e( 'Behaviour, search & appearance', 'wb-ajax-filter' ); ?>
	</a>
	<a class="wbcom-btn" href="<?php echo esc_url( $wb_license_url ); ?>">
		<i data-lucide="key-round"></i>
		<?php esc_html_e( 'Manage license', 'wb-ajax-filter' ); ?>
	</a>
	<?php if ( $wb_shop_url ) : ?>
		<a class="wbcom-btn" href="<?php echo esc_url( $wb_shop_url ); ?>" target="_blank" rel="noopener noreferrer">
			<i data-lucide="external-link"></i>
			<?php esc_html_e( 'See the filters on your shop', 'wb-ajax-filter' ); ?>
		</a>
	<?php endif; ?>
</div>
<?php
Wbcom_Settings_Page::card_close();
