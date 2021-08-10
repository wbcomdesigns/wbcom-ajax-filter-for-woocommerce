<?php
/**
 * The template for create filter preset form.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/admin
 */

?>
<div class="wb-ajax-filter-form-wraper">
	<form id="filter-preset-create" method="post">
		<!-- <input type="hidden" name="wb_ajax_filter_preset_title">
		<input type="hidden" name="_wpnonce"> -->

		<div class="wb-ajax-filter-toggle-title"></div>
		<div class="wb-ajax-filter-toggle-content">
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Filter name', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper">
					<input type="text" name="filters[title]" value="<?php echo ( isset( $_POST['title'] ) && '' !== $_POST['title'] ) ? $_POST['title'] : 'New filter'; ?>">
				</div>
				<span class="description"><?php esc_html_e( 'Enter a name to identify this filter', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Filter for', 'wb-ajax-filter' ); ?></label>
				<select name="filters[type]" class="wc-enhanced-select enhanced" data-value="tax" tabindex="-1" aria-hidden="true">
					<option value="tax"><?php esc_html_e( 'Taxonomy', 'wb-ajax-filter' ); ?></option>
					<option value="orderby"><?php esc_html_e( 'Order by', 'wb-ajax-filter' ); ?></option>
					<option value="price_range"><?php esc_html_e( 'Price Range', 'wb-ajax-filter' ); ?></option>
					<option value="price_slider"><?php esc_html_e( 'Price Slider', 'wb-ajax-filter' ); ?></option>
					<option value="review"><?php esc_html_e( 'Review', 'wb-ajax-filter' ); ?></option>
					<option value="stock_sale"><?php esc_html_e( 'In stock/On sale', 'wb-ajax-filter' ); ?></option>
				</select>
				<span class="description"><?php esc_html_e( 'Select the parameters you wish to filter for', 'wb-ajax-filter' ); ?>	</span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label>
					<?php esc_html_e( 'Choose taxonomy', 'wb-ajax-filter' ); ?>
				</label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
					<select name="filters[taxonomy]" class="wc-enhanced-select taxonomy enhanced" data-value="" tabindex="-1" aria-hidden="true">
						<option value="product_cat"><?php esc_html_e( 'Product categories', 'wb-ajax-filter' ); ?></option>
						<option value="product_tag"><?php esc_html_e( 'Product tags', 'wb-ajax-filter' ); ?></option>
						<option value="pa_color"><?php esc_html_e( 'Product Color', 'wb-ajax-filter' ); ?></option>
						<option value="pa_size"><?php esc_html_e( 'Product Size', 'wb-ajax-filter' ); ?></option>
					</select>
				</div>
				<span class="description"><?php esc_html_e( 'Select which taxonomy to use for this filter', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Choose terms', 'wb-ajax-filter' ); ?></label>
				<select name="filters[terms][]" class="wc-enhanced-select term-search enhanced" tabindex="-1" aria-hidden="true">
				</select>
				<span class="description"><?php esc_html_e( 'Select which terms to use for filtering', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Filter type', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
					<select name="filters[filter_design]" class="wc-enhanced-select enhanced" data-value="checkbox" tabindex="-1" aria-hidden="true">
						<option value="checkbox"><?php esc_html_e( 'Checkbox', 'wb-ajax-filter' ); ?></option>
						<option value="radio"><?php esc_html_e( 'Radio', 'wb-ajax-filter' ); ?></option>
						<option value="select"><?php esc_html_e( 'Select', 'wb-ajax-filter' ); ?></option>
						<option value="text"><?php esc_html_e( 'Text', 'wb-ajax-filter' ); ?></option>
						<option value="color"><?php esc_html_e( 'Color Swatches', 'wb-ajax-filter' ); ?></option>
						<option value="label"><?php esc_html_e( 'Label/Image', 'wb-ajax-filter' ); ?></option>
					</select>
				</div>
				<span class="description"><?php esc_html_e( 'Select the filter type for this filter', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Columns number', 'wb-ajax-filter' ); ?>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
					<input type="number" name="filters[column_number]" class="" value="4" min="1" max="8" step="1">
				</div>
				<span class="description"><?php esc_html_e( 'Set the number of items per row you want to show for this design', 'wb-ajax-filter' ); ?></span></label>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Customize terms', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
					<div class="terms-wrapper ui-sortable"></div>
				</div>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Show search field', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-fw-field-wrapper wb-ajax-filter-fw-onoff-field-wrapper">
					<div class="wb-ajax-filter-fw-onoff-container ">
						<input type="checkbox" class="on_off" name="filters[show_search]" value="yes">
						<span class="wb-ajax-filter-fw-onoff" data-text-on="YES" data-text-off="NO"></span>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Enable if you want to show search field inside dropdown.', 'wb-ajax-filter' ); ?></span>	
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Slider min value', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
					<input type="number" name="filters[price_slider_min]" class="" value="0" min="0" step="0.01">
				</div>
				<span class="description"><?php esc_html_e( 'Set the minimum value for the price slider', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Slider max value', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-number-field-wrapper">
					<input type="number" name="filters[price_slider_max]" class="" value="100" min="0" step="0.01">
				</div>
				<span class="description"><?php esc_html_e( 'Set the maximum value for the price slider.', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Slider step', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-number-field-wrapper">
					<input type="number" name="filters[price_slider_step]" class="" value="0.01" min="0.01" step="0.01">
				</div>
				<span class="description"><?php esc_html_e( 'Set the value for each increment of the price slider.', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Order options', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-buttons-field-wrapper">
					<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
						<select name="filters[order_options][]" class="wc-enhanced-select enhanced" data-value="menu_order" multiple="" tabindex="-1" aria-hidden="true">
							<option value="menu_order"><?php esc_html_e( 'Default sorting', 'wb-ajax-filter' ); ?></option>
							<option value="popularity"><?php esc_html_e( 'Sort by popularity', 'wb-ajax-filter' ); ?></option>
							<option value="rating"><?php esc_html_e( 'Sort by average rating', 'wb-ajax-filter' ); ?></option>
							<option value="date"><?php esc_html_e( 'Sort by latest', 'wb-ajax-filter' ); ?></option>
							<option value="price"><?php esc_html_e( 'Sort by price: low to high', 'wb-ajax-filter' ); ?></option>
							<option value="price-desc"><?php esc_html_e( 'Sort by price: high to low', 'wb-ajax-filter' ); ?></option>
						</select>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Select sorting options to show', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Customize price ranges', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-custom-field-wrapper">
					<button class="add-price-range button-primary"><?php esc_html_e( 'Add range', 'wb-ajax-filter' ); ?></button>
					<div class="ranges-wrapper ui-sortable" data-index="0"></div>
				</div>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Show stock filter', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
					<div class="wb-ajax-filter-onoff-container ">
						<input type="checkbox" class="on_off" name="filters[show_stock_filter]" value="yes">
						<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Enable if you want to show "In Stock" filter', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Show sale filter', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
					<div class="wb-ajax-filter-onoff-container ">
						<input type="checkbox" class="on_off" name="filters[show_sale_filter]" value="yes">
						<span class="yith-plugin-fw-onoff" data-text-on="YES" data-text-off="NO"></span>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Enable if you want to show "On Sale" filter', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Show as toggle', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
					<div class="wb-ajax-filter-onoff-container">
						<input type="checkbox" class="on_off" name="filters[show_toggle]" value="no">
						<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Enable if you want to show this filter as a toggle', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Toggle style', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-radio-field-wrapper">
					<div class="wb-ajax-filter-radio " data-value="opened" data-type="radio">
						<div class="wb-ajax-filter-radio__row">
							<input type="radio" name="filters[toggle_style]" value="closed">
							<label><?php esc_html_e( 'Closed by default', 'wb-ajax-filter' ); ?></label>
						</div>
						<div class="wb-ajax-filter-radio__row">
							<input type="radio" name="filters[toggle_style]" value="opened">
							<label><?php esc_html_e( 'Opened by default', 'wb-ajax-filter' ); ?></label>
						</div>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Choose if toggle has to closed or opened by default', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Order by', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
					<select name="filters[order_by]" class="wb-ajax-filter-select" data-value="name">
						<option value="name"><?php esc_html_e( 'Name', 'wb-ajax-filter' ); ?></option>
						<option value="slug"><?php esc_html_e( 'Slug', 'wb-ajax-filter' ); ?></option>
						<option value="count"><?php esc_html_e( 'Term count', 'wb-ajax-filter' ); ?></option>
						<option value="term_order"><?php esc_html_e( 'Term order', 'wb-ajax-filter' ); ?></option>
					</select>
				</div>
				<span class="description"><?php esc_html_e( 'Select the default order for terms of this filter.', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Order type', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
					<select name="filters[order]" class="wb-ajax-filter-select" data-value="asc">
					<option value="asc"><?php esc_html_e( 'ASC', 'wb-ajax-filter' ); ?></option>
					<option value="desc"><?php esc_html_e( 'DESC', 'wb-ajax-filter' ); ?></option>
					</select>
				</div>
				<span class="description"><?php esc_html_e( 'Select the default order for terms of this filter', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Show count of items', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
					<div class="wb-ajax-filter-onoff-container ">
						<input type="checkbox" class="on_off" name="filters[show_count]" value="no">
						<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Enable if you want to show how many items are available for each term', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Show hierarchy', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-radio-field-wrapper">
					<div class="wb-ajax-filter-radio " data-value="no" data-type="radio">
					<div class="wb-ajax-filter-radio__row">
						<input type="radio" name="filters[hierarchical]" value="no">
						<label><?php esc_html_e( 'No, show all terms in same level', 'wb-ajax-filter' ); ?></label>
					</div>
					<div class="wb-ajax-filter-radio__row">
						<input type="radio" name="filters[hierarchical]" value="parents_only">
						<label><?php esc_html_e( 'No, show only parent terms', 'wb-ajax-filter' ); ?></label>
					</div>
					<div class="wb-ajax-filter-radio__row">
						<input type="radio" name="filters[hierarchical]" value="collapsed">
						<label><?php esc_html_e( 'Yes, with terms collapsed', 'wb-ajax-filter' ); ?></label>
					</div>
					<div class="wb-ajax-filter-radio__row">
						<input type="radio" name="filters[hierarchical]" value="expanded">
						<label><?php esc_html_e( 'Yes, with terms expanded', 'wb-ajax-filter' ); ?></label>
					</div>
					<div class="wb-ajax-filter-radio__row">
						<input type="radio" name="filters[hierarchical]" value="open">
						<label><?php esc_html_e( 'Yes, without toggles', 'wb-ajax-filter' ); ?></label>
					</div>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Choose how to show terms hierarchy', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Allow multiple selection', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
					<div class="wb-ajax-filter-onoff-container ">
						<input type="checkbox" class="on_off" name="filters[multiple]" value="no">
						<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Enable if the user can select multiple terms when filtering products', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Multiselect relation', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-radio-field-wrapper">
					<div class="wb-ajax-filter-radio " data-value="and" data-type="radio">
						<div class="wb-ajax-filter-radio__row">
							<input type="radio" name="filters[relation]" value="and">
							<label><?php esc_html_e( 'AND - Results need to match all selected terms at the same time.', 'wb-ajax-filter' ); ?></label>
						</div>
						<div class="wb-ajax-filter-radio__row">
							<input type="radio" name="filters[relation]" value="or">
							<label><?php esc_html_e( 'OR - Results need to match at least one of the selected terms.', 'wb-ajax-filter' ); ?></label>
						</div>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Choose how multiple terms selection should behave.', 'wb-ajax-filter' ); ?></span>
			</div>
			<div class="wb-ajax-filter-toggle-content-row">
				<label><?php esc_html_e( 'Adoptive filtering', 'wb-ajax-filter' ); ?></label>
				<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-radio-field-wrapper">
					<div class="wb-ajax-filter-radio " data-value="hide" data-type="radio">
						<div class="wb-ajax-filter-radio__row">
						<input type="radio" name="filters[adoptive]" value="hide">
						<label><?php esc_html_e( 'Terms will be hidden', 'wb-ajax-filter' ); ?></label>
						</div>
						<div class="wb-ajax-filter-radio__row">
						<input type="radio" name="filters[adoptive]" value="or">
						<label><?php esc_html_e( 'Terms will be visible, but not clickable', 'wb-ajax-filter' ); ?></label>
						</div>
					</div>
				</div>
				<span class="description"><?php esc_html_e( 'Decide how to manage filter options that show no results when applying filters. Choose to hide them or make them visible (this will show them in lighter grey and not clickable)', 'wb-ajax-filter' ); ?></span>
			</div>
		</div>
		<div class="wb-ajax-filter-toggle-content-row yith-toggle-content-buttons">
			<div class="spinner"></div>
			<button id="wb-ajax-filer-create-filter-save" class="save button-primary">Save Filter</button>
		</div>
	</form>
<div>
