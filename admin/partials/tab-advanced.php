<?php
/**
 * Advanced tab - behaviour, search and appearance.
 *
 * One tab, three cards. Every option key is unchanged from the old
 * multi-tab screen, so saved settings carry over untouched; only the
 * grouping is new. The primary decisions (instant vs apply, AJAX vs
 * reload, search on/off) lead each card.
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin/partials
 * @since      1.2.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wb_general       = get_option( 'wb_ajax_filter_admin_general_options', array() );
$wb_search        = get_option( 'wb_ajax_filter_search_settings', array() );
$wb_search_scope  = get_option( 'wb_ajax_filter_search_content_settings', array() );
$wb_customization = get_option( 'wb_ajax_filter_admin_customization_options', array() );

$wb_general       = is_array( $wb_general ) ? $wb_general : array();
$wb_search        = is_array( $wb_search ) ? $wb_search : array();
$wb_search_scope  = is_array( $wb_search_scope ) ? $wb_search_scope : array();
$wb_customization = is_array( $wb_customization ) ? $wb_customization : array();

$wb_search_enabled = isset( $wb_search['enable_search'] ) && 'yes' === $wb_search['enable_search'];

Wbcom_Settings_Page::card_open(
	__( 'Filtering behaviour', 'wb-ajax-filter' ),
	__( 'How filters apply and how results arrive on shop and archive pages.', 'wb-ajax-filter' )
);
?>
<form method="post" action="options.php">
	<?php settings_fields( 'wb_ajax_filter_admin_general_options' ); ?>
	<?php do_action( 'wb_ajax_filter_before_admin_general_settings', $wb_general ); ?>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label><?php esc_html_e( 'Apply filters', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'Apply each filter the moment it changes, or wait for an "Apply filters" button.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<label>
				<input name="wb_ajax_filter_admin_general_options[instant_filters]" type="radio" value="yes" <?php checked( isset( $wb_general['instant_filters'] ) ? $wb_general['instant_filters'] : 'yes', 'yes' ); ?>>
				<span class="description"><?php esc_html_e( 'Instantly', 'wb-ajax-filter' ); ?></span>
			</label>
			<label>
				<input name="wb_ajax_filter_admin_general_options[instant_filters]" type="radio" value="no" <?php checked( isset( $wb_general['instant_filters'] ) ? $wb_general['instant_filters'] : 'yes', 'no' ); ?>>
				<span class="description"><?php esc_html_e( 'With an "Apply filters" button', 'wb-ajax-filter' ); ?></span>
			</label>
		</div>
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label><?php esc_html_e( 'Display results', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'Update the product grid over AJAX, or reload the whole page.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<label>
				<input name="wb_ajax_filter_admin_general_options[ajax_filters]" type="radio" value="yes" <?php checked( isset( $wb_general['ajax_filters'] ) ? $wb_general['ajax_filters'] : 'yes', 'yes' ); ?>>
				<span class="description"><?php esc_html_e( 'Without page reload', 'wb-ajax-filter' ); ?></span>
			</label>
			<label>
				<input name="wb_ajax_filter_admin_general_options[ajax_filters]" type="radio" value="no" <?php checked( isset( $wb_general['ajax_filters'] ) ? $wb_general['ajax_filters'] : 'yes', 'no' ); ?>>
				<span class="description"><?php esc_html_e( 'On page reload', 'wb-ajax-filter' ); ?></span>
			</label>
		</div>
	</div>

	<?php
	$wb_behaviour_toggles = array(
		'hide_empty_terms'   => array(
			'label'       => __( 'Hide empty terms', 'wb-ajax-filter' ),
			'description' => __( 'Hide filter terms that have no matching products.', 'wb-ajax-filter' ),
		),
		'hide_out_of_stock'  => array(
			'label'       => __( 'Hide out of stock products', 'wb-ajax-filter' ),
			'description' => __( 'Leave out-of-stock products out of the results.', 'wb-ajax-filter' ),
		),
		'show_reset'         => array(
			'label'       => __( 'Show reset button', 'wb-ajax-filter' ),
			'description' => __( 'Let shoppers cancel the whole filter selection in one click.', 'wb-ajax-filter' ),
		),
		'show_clear_filter'  => array(
			'label'       => __( 'Show "Clear" above each filter', 'wb-ajax-filter' ),
			'description' => __( 'A per-filter clear link above every filter in the preset.', 'wb-ajax-filter' ),
		),
		'show_active_labels' => array(
			'label'       => __( 'Show active filters as labels', 'wb-ajax-filter' ),
			'description' => __( 'Chips that show the current selection and remove a filter on click.', 'wb-ajax-filter' ),
		),
		'scroll_top'         => array(
			'label'       => __( 'Scroll to top after filtering', 'wb-ajax-filter' ),
			'description' => __( 'Bring the shopper back to the top of the results after each filter.', 'wb-ajax-filter' ),
		),
	);
	?>
	<?php foreach ( $wb_behaviour_toggles as $wb_key => $wb_field ) : ?>
		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-<?php echo esc_attr( $wb_key ); ?>"><?php echo esc_html( $wb_field['label'] ); ?></label>
				<p class="description"><?php echo esc_html( $wb_field['description'] ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<label class="wbcom-toggle">
					<input type="checkbox"
						id="wb-ajax-filter-<?php echo esc_attr( $wb_key ); ?>"
						name="wb_ajax_filter_admin_general_options[<?php echo esc_attr( $wb_key ); ?>]"
						value="yes"
						<?php checked( isset( $wb_general[ $wb_key ] ) ? $wb_general[ $wb_key ] : '', 'yes' ); ?>>
					<span class="wbcom-toggle-slider"></span>
				</label>
			</div>
		</div>
		<?php if ( 'show_reset' === $wb_key ) : ?>
			<div class="wb-ajax-filter-reset-position" style="<?php echo ( isset( $wb_general['show_reset'] ) && 'yes' === $wb_general['show_reset'] ) ? '' : 'display:none;'; ?>">
				<div class="wbcom-field wbcom-field-group">
					<div class="wbcom-field-info">
						<label><?php esc_html_e( 'Reset button position', 'wb-ajax-filter' ); ?></label>
						<p class="description"><?php esc_html_e( 'Where the reset button sits relative to the filters.', 'wb-ajax-filter' ); ?></p>
					</div>
					<div class="wbcom-field-control">
						<label>
							<input name="wb_ajax_filter_admin_general_options[reset_button_position]" type="radio" value="before_filters" <?php checked( isset( $wb_general['reset_button_position'] ) ? $wb_general['reset_button_position'] : 'before_filters', 'before_filters' ); ?>>
							<span class="description"><?php esc_html_e( 'Before filters', 'wb-ajax-filter' ); ?></span>
						</label>
						<label>
							<input name="wb_ajax_filter_admin_general_options[reset_button_position]" type="radio" value="after_filters" <?php checked( isset( $wb_general['reset_button_position'] ) ? $wb_general['reset_button_position'] : 'before_filters', 'after_filters' ); ?>>
							<span class="description"><?php esc_html_e( 'After filters', 'wb-ajax-filter' ); ?></span>
						</label>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>

	<?php do_action( 'wb_ajax_filter_after_admin_general_settings', $wb_general ); ?>

	<div class="wbcom-save-bar">
		<?php submit_button( __( 'Save Changes', 'wb-ajax-filter' ), 'wbcom-btn wbcom-btn--primary', 'submit', false ); ?>
	</div>
</form>
<?php
Wbcom_Settings_Page::card_close();

Wbcom_Settings_Page::card_open(
	__( 'Product search', 'wb-ajax-filter' ),
	__( 'The search field inside the filter block, with live autosuggest.', 'wb-ajax-filter' )
);
?>
<form method="post" action="options.php">
	<?php settings_fields( 'wb_ajax_filter_search_settings' ); ?>
	<?php do_action( 'wb_ajax_filter_before_admin_search_settings', $wb_search ); ?>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label for="wb-ajax-filter-enable-search"><?php esc_html_e( 'Enable search', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'Show a product search field in the filter block.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<label class="wbcom-toggle">
				<input type="checkbox"
					id="wb-ajax-filter-enable-search"
					name="wb_ajax_filter_search_settings[enable_search]"
					value="yes"
					<?php checked( $wb_search_enabled ? 'yes' : '', 'yes' ); ?>>
				<span class="wbcom-toggle-slider"></span>
			</label>
		</div>
	</div>

	<div class="wb_ajax_search_options" style="<?php echo $wb_search_enabled ? '' : 'display:none'; ?>">
		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-search-input-label"><?php esc_html_e( 'Search input label', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Placeholder text inside the search field.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<input class="wbcom-input" type="text" id="wb-ajax-filter-search-input-label"
					name="wb_ajax_filter_search_settings[search_input_label]"
					value="<?php echo esc_attr( isset( $wb_search['search_input_label'] ) ? $wb_search['search_input_label'] : '' ); ?>">
			</div>
		</div>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-search-submit-label"><?php esc_html_e( 'Search submit label', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Text on the search submit button.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<input class="wbcom-input" type="text" id="wb-ajax-filter-search-submit-label"
					name="wb_ajax_filter_search_settings[search_submit_label]"
					value="<?php echo esc_attr( isset( $wb_search['search_submit_label'] ) ? $wb_search['search_submit_label'] : '' ); ?>">
			</div>
		</div>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-min-chars"><?php esc_html_e( 'Minimum characters', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Characters typed before autosuggest starts.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<input class="wbcom-input" type="number" min="0" id="wb-ajax-filter-min-chars"
					name="wb_ajax_filter_search_settings[min_chars]"
					value="<?php echo esc_attr( isset( $wb_search['min_chars'] ) ? $wb_search['min_chars'] : '0' ); ?>">
			</div>
		</div>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-max-results"><?php esc_html_e( 'Maximum results', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Results shown in the autosuggest box.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<input class="wbcom-input" type="number" min="0" id="wb-ajax-filter-max-results"
					name="wb_ajax_filter_search_settings[posts_per_page]"
					value="<?php echo esc_attr( isset( $wb_search['posts_per_page'] ) ? $wb_search['posts_per_page'] : '0' ); ?>">
			</div>
		</div>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-show-search-list"><?php esc_html_e( 'Show search scope selector', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Let shoppers choose between searching the whole site or only products.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<label class="wbcom-toggle">
					<input type="checkbox" id="wb-ajax-filter-show-search-list"
						name="wb_ajax_filter_search_settings[show_search_list]" value="yes"
						<?php checked( isset( $wb_search['show_search_list'] ) ? $wb_search['show_search_list'] : '', 'yes' ); ?>>
					<span class="wbcom-toggle-slider"></span>
				</label>
			</div>
		</div>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-show-category-list"><?php esc_html_e( 'Show categories dropdown', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'A product-categories dropdown next to the search field.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<label class="wbcom-toggle">
					<input type="checkbox" id="wb-ajax-filter-show-category-list"
						name="wb_ajax_filter_search_settings[show_category_list]" value="yes"
						<?php checked( isset( $wb_search['show_category_list'] ) ? $wb_search['show_category_list'] : '', 'yes' ); ?>>
					<span class="wbcom-toggle-slider"></span>
				</label>
			</div>
		</div>

		<?php do_action( 'wb_ajax_filter_before_admin_search_option_settings', $wb_search_scope ); ?>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label><?php esc_html_e( 'What to search', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Search only products, or extend to posts and pages too.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<label>
					<input name="wb_ajax_filter_search_content_settings[default_research]" type="radio" value="product" <?php checked( isset( $wb_search_scope['default_research'] ) ? $wb_search_scope['default_research'] : 'product', 'product' ); ?>>
					<span class="description"><?php esc_html_e( 'Products only', 'wb-ajax-filter' ); ?></span>
				</label>
				<label>
					<input name="wb_ajax_filter_search_content_settings[default_research]" type="radio" value="any" <?php checked( isset( $wb_search_scope['default_research'] ) ? $wb_search_scope['default_research'] : 'product', 'any' ); ?>>
					<span class="description"><?php esc_html_e( 'Whole site', 'wb-ajax-filter' ); ?></span>
				</label>
			</div>
		</div>

		<?php
		$wb_scope_toggles = array(
			'search_in_title'   => __( 'Search in title', 'wb-ajax-filter' ),
			'search_in_excerpt' => __( 'Search in excerpt', 'wb-ajax-filter' ),
			'search_in_content' => __( 'Search in content', 'wb-ajax-filter' ),
			'search_by_sku'     => __( 'Search by SKU', 'wb-ajax-filter' ),
		);
		?>
		<?php foreach ( $wb_scope_toggles as $wb_key => $wb_label ) : ?>
			<div class="wbcom-field wbcom-field-group">
				<div class="wbcom-field-info">
					<label for="wb-ajax-filter-<?php echo esc_attr( $wb_key ); ?>"><?php echo esc_html( $wb_label ); ?></label>
				</div>
				<div class="wbcom-field-control">
					<label class="wbcom-toggle">
						<input type="checkbox"
							id="wb-ajax-filter-<?php echo esc_attr( $wb_key ); ?>"
							name="wb_ajax_filter_search_content_settings[<?php echo esc_attr( $wb_key ); ?>]"
							value="yes"
							<?php checked( isset( $wb_search_scope[ $wb_key ] ) ? $wb_search_scope[ $wb_key ] : '', 'yes' ); ?>>
						<span class="wbcom-toggle-slider"></span>
					</label>
				</div>
			</div>
		<?php endforeach; ?>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label><?php esc_html_e( 'Multiple word search', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'How several typed words combine.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<label>
					<input name="wb_ajax_filter_search_content_settings[search_type_more_words]" type="radio" value="and" <?php checked( isset( $wb_search_scope['search_type_more_words'] ) ? $wb_search_scope['search_type_more_words'] : 'and', 'and' ); ?>>
					<span class="description"><?php esc_html_e( 'Match all words', 'wb-ajax-filter' ); ?></span>
				</label>
				<label>
					<input name="wb_ajax_filter_search_content_settings[search_type_more_words]" type="radio" value="or" <?php checked( isset( $wb_search_scope['search_type_more_words'] ) ? $wb_search_scope['search_type_more_words'] : 'and', 'or' ); ?>>
					<span class="description"><?php esc_html_e( 'Match any word', 'wb-ajax-filter' ); ?></span>
				</label>
			</div>
		</div>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb_ajax_check_custom_field_option"><?php esc_html_e( 'Search by custom field', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Extend search to a product custom field.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control wbcom-ajax-check-custom-option">
				<select id="wb_ajax_check_custom_field_option" name="wb_ajax_filter_search_content_settings[cf_name]">
					<?php if ( isset( $wb_search_scope['cf_name'] ) && '' !== $wb_search_scope['cf_name'] ) : ?>
						<option value="<?php echo esc_attr( $wb_search_scope['cf_name'] ); ?>" selected><?php echo esc_html( $wb_search_scope['cf_name'] ); ?></option>
					<?php endif; ?>
				</select>
			</div>
		</div>

		<div class="wbcom-field wbcom-field-group">
			<div class="wbcom-field-info">
				<label for="wb-ajax-filter-custom-field-label"><?php esc_html_e( 'Custom field placeholder', 'wb-ajax-filter' ); ?></label>
				<p class="description"><?php esc_html_e( 'Placeholder shown for the custom field input.', 'wb-ajax-filter' ); ?></p>
			</div>
			<div class="wbcom-field-control">
				<input class="wbcom-input" type="text" id="wb-ajax-filter-custom-field-label"
					name="wb_ajax_filter_search_content_settings[custom_field_label]"
					value="<?php echo esc_attr( isset( $wb_search_scope['custom_field_label'] ) ? $wb_search_scope['custom_field_label'] : '' ); ?>">
			</div>
		</div>

		<?php do_action( 'wb_ajax_filter_after_admin_search_option_settings', $wb_search_scope ); ?>
	</div>

	<?php do_action( 'wb_ajax_filter_after_admin_search_settings', $wb_search ); ?>

	<div class="wbcom-save-bar">
		<?php submit_button( __( 'Save Changes', 'wb-ajax-filter' ), 'wbcom-btn wbcom-btn--primary', 'submit', false ); ?>
	</div>
</form>
<?php
Wbcom_Settings_Page::card_close();

Wbcom_Settings_Page::card_open(
	__( 'Appearance', 'wb-ajax-filter' ),
	__( 'Optional. "Theme style" follows your theme; custom colors override it.', 'wb-ajax-filter' )
);
?>
<form method="post" action="options.php">
	<?php settings_fields( 'wb_ajax_filter_admin_customization_options' ); ?>
	<?php do_action( 'wb_ajax_filter_before_admin_customization_settings', $wb_customization ); ?>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label for="wb-ajax-filter-filters-title"><?php esc_html_e( 'Filters area title', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'Heading shown above the filter block.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<input class="wbcom-input" type="text" id="wb-ajax-filter-filters-title"
				name="wb_ajax_filter_admin_customization_options[filters_title]"
				value="<?php echo esc_attr( isset( $wb_customization['filters_title'] ) ? $wb_customization['filters_title'] : '' ); ?>">
		</div>
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label><?php esc_html_e( 'Options style', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'Theme style inherits your theme; custom style uses the colors below.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<label>
				<input name="wb_ajax_filter_admin_customization_options[filters_style]" type="radio" value="theme" <?php checked( isset( $wb_customization['filters_style'] ) ? $wb_customization['filters_style'] : 'theme', 'theme' ); ?>>
				<span class="description"><?php esc_html_e( 'Theme style', 'wb-ajax-filter' ); ?></span>
			</label>
			<label>
				<input name="wb_ajax_filter_admin_customization_options[filters_style]" type="radio" value="custom" <?php checked( isset( $wb_customization['filters_style'] ) ? $wb_customization['filters_style'] : 'theme', 'custom' ); ?>>
				<span class="description"><?php esc_html_e( 'Custom style', 'wb-ajax-filter' ); ?></span>
			</label>
		</div>
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label><?php esc_html_e( 'Filters area colors', 'wb-ajax-filter' ); ?></label>
		</div>
		<div class="wbcom-field-control">
			<div class="wb-ajax-filter-colorpicker">
				<div class="wb-ajax-filter-single-colorpicker colorpicker">
					<label><?php esc_html_e( 'Titles', 'wb-ajax-filter' ); ?></label>
					<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[filters_area_titles_color]" value="<?php echo esc_attr( isset( $wb_customization['filters_area_titles_color'] ) ? $wb_customization['filters_area_titles_color'] : '#1e73be' ); ?>">
				</div>
				<div class="wb-ajax-filter-single-colorpicker colorpicker">
					<label><?php esc_html_e( 'Background', 'wb-ajax-filter' ); ?></label>
					<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[filters_area_background_color]" value="<?php echo esc_attr( isset( $wb_customization['filters_area_background_color'] ) ? $wb_customization['filters_area_background_color'] : '#fff' ); ?>">
				</div>
				<div class="wb-ajax-filter-single-colorpicker colorpicker">
					<label><?php esc_html_e( 'Accent', 'wb-ajax-filter' ); ?></label>
					<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[filters_area_accent_color]" value="<?php echo esc_attr( isset( $wb_customization['filters_area_accent_color'] ) ? $wb_customization['filters_area_accent_color'] : '#fff' ); ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label><?php esc_html_e( 'Textual terms colors', 'wb-ajax-filter' ); ?></label>
		</div>
		<div class="wbcom-field-control">
			<div class="wb-ajax-filter-colorpicker">
				<div class="wb-ajax-filter-single-colorpicker colorpicker">
					<label><?php esc_html_e( 'Text', 'wb-ajax-filter' ); ?></label>
					<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_text_color]" value="<?php echo esc_attr( isset( $wb_customization['textual_terms_text_color'] ) ? $wb_customization['textual_terms_text_color'] : '#1e73be' ); ?>">
				</div>
				<div class="wb-ajax-filter-single-colorpicker colorpicker">
					<label><?php esc_html_e( 'Text hover', 'wb-ajax-filter' ); ?></label>
					<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_hover_text_color]" value="<?php echo esc_attr( isset( $wb_customization['textual_terms_hover_text_color'] ) ? $wb_customization['textual_terms_hover_text_color'] : '#fff' ); ?>">
				</div>
				<div class="wb-ajax-filter-single-colorpicker colorpicker">
					<label><?php esc_html_e( 'Text active', 'wb-ajax-filter' ); ?></label>
					<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_active_text_color]" value="<?php echo esc_attr( isset( $wb_customization['textual_terms_active_text_color'] ) ? $wb_customization['textual_terms_active_text_color'] : '#fff' ); ?>">
				</div>
				<div class="wb-ajax-filter-single-colorpicker colorpicker">
					<label><?php esc_html_e( 'Tooltip text', 'wb-ajax-filter' ); ?></label>
					<input class="wb-ajax-color-picker" name="wb_ajax_filter_admin_customization_options[textual_terms_tooltip_text_color]" value="<?php echo esc_attr( isset( $wb_customization['textual_terms_tooltip_text_color'] ) ? $wb_customization['textual_terms_tooltip_text_color'] : '#fff' ); ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label for="wb-ajax-filter-filters-per-column"><?php esc_html_e( 'Filter columns', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'Number of filters in a row on desktop.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<input class="wbcom-input" type="number" min="2" max="5" id="wb-ajax-filter-filters-per-column"
				name="wb_ajax_filter_admin_customization_options[filters_per_column]"
				value="<?php echo esc_attr( isset( $wb_customization['filters_per_column'] ) ? $wb_customization['filters_per_column'] : '5' ); ?>">
		</div>
	</div>

	<div class="wbcom-field wbcom-field-group">
		<div class="wbcom-field-info">
			<label><?php esc_html_e( 'Ajax loader', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'The spinner shown while results load.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<label>
				<input name="wb_ajax_filter_admin_customization_options[ajax_loader_style]" type="radio" value="default" <?php checked( isset( $wb_customization['ajax_loader_style'] ) ? $wb_customization['ajax_loader_style'] : 'default', 'default' ); ?>>
				<span class="description"><?php esc_html_e( 'Default loader', 'wb-ajax-filter' ); ?></span>
			</label>
			<label>
				<input name="wb_ajax_filter_admin_customization_options[ajax_loader_style]" type="radio" value="custom" <?php checked( isset( $wb_customization['ajax_loader_style'] ) ? $wb_customization['ajax_loader_style'] : 'default', 'custom' ); ?>>
				<span class="description"><?php esc_html_e( 'Custom loader', 'wb-ajax-filter' ); ?></span>
			</label>
		</div>
	</div>

	<div class="wbcom-field wb_ajax_filter_custom_loader_image" style="<?php echo ( isset( $wb_customization['ajax_loader_style'] ) && 'custom' === $wb_customization['ajax_loader_style'] ) ? '' : 'display:none;'; ?>">
		<div class="wbcom-field-info">
			<label><?php esc_html_e( 'Custom Ajax loader', 'wb-ajax-filter' ); ?></label>
			<p class="description"><?php esc_html_e( 'Upload a GIF to use as the loading indicator.', 'wb-ajax-filter' ); ?></p>
		</div>
		<div class="wbcom-field-control">
			<div class="gif-container">
				<img src="<?php echo esc_url( isset( $wb_customization['loader_url'] ) ? $wb_customization['loader_url'] : '' ); ?>" alt="" style="max-width:100%;">
			</div>
			<input name="wb_ajax_filter_admin_customization_options[loader_attachment_id]" type="hidden" value="<?php echo esc_attr( isset( $wb_customization['loader_attachment_id'] ) ? $wb_customization['loader_attachment_id'] : '' ); ?>">
			<input class="wbcom-input" name="wb_ajax_filter_admin_customization_options[loader_url]" type="text" value="<?php echo esc_attr( isset( $wb_customization['loader_url'] ) ? $wb_customization['loader_url'] : '' ); ?>">
			<button class="button btn" id="wb_upload_gif"><?php esc_html_e( 'Upload custom loader', 'wb-ajax-filter' ); ?></button>
			<button class="button btn" id="wb_reset_upload_gif"><?php esc_html_e( 'Reset to default', 'wb-ajax-filter' ); ?></button>
			<p class="description"><?php esc_html_e( 'Only GIFs are allowed.', 'wb-ajax-filter' ); ?></p>
		</div>
	</div>

	<?php do_action( 'wb_ajax_filter_after_admin_customization_settings', $wb_customization ); ?>

	<div class="wbcom-save-bar">
		<?php submit_button( __( 'Save Changes', 'wb-ajax-filter' ), 'wbcom-btn wbcom-btn--primary', 'submit', false ); ?>
	</div>
</form>
<?php
Wbcom_Settings_Page::card_close();
