<?php
/**
 * The template for taxonomy fields.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

if ( empty( $filters ) || ( ! empty( $filters ) && 'tax' === $filters['type'] ) ) {
	?>
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
	<select id="wb_ajax_filter_select2_terms" name="wb_ajax_filter_select2_terms[]" multiple="multiple" style="width:99%;max-width:25em;">
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
<?php } ?>
