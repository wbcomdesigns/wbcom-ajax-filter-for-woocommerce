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

$exclude_tax = array( 'product_type', 'product_visibility', 'product_shipping_class' );
$style       = 'display:none;';
if ( empty( $filters ) || ( ! empty( $filters ) && 'tax' === $filters['type'] ) ) {
	$style = '';
}
?>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label>
		<?php esc_html_e( 'Choose taxonomy', 'wb-ajax-filter' ); ?>
	</label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<select name="filters[taxonomy]" class="wc-enhanced-select taxonomy enhanced wb-input wb-filter-type-tax" data-value="" tabindex="-1" aria-hidden="true">
			<option value=""><?php esc_html_e( 'Select taxonomy', 'wb-ajax-filter' ); ?></option>
			<?php
			$taxonomies = get_object_taxonomies( 'product', 'name' );
			foreach ( $taxonomies as $key => $val ) {
				if ( ! in_array( $val->name, $exclude_tax, true ) ) {
					?>
					<option value="<?php echo esc_attr( $val->name ); ?>" <?php echo ( isset( $filters['taxonomy'] ) && $val->name === $filters['taxonomy'] ) ? 'selected' : ''; ?>><?php echo esc_html( $val->label ); ?></option>
					<?php
				}
			}
			?>
		</select>
	</div>
	<span class="description"><?php esc_html_e( 'Select which taxonomy to use for this filter', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Choose terms', 'wb-ajax-filter' ); ?></label>
	<select id="wb_ajax_filter_select2_terms" class="wb-input wb-filter-type-tax" name="filters[terms][]" multiple="multiple" data-selected_terms='<?php echo ( isset( $filters['terms'] ) ) ? wp_json_encode( $filters['terms'] ) : ''; ?>' style="width:99%;max-width:25em;">
	</select>
	<span class="description"><?php esc_html_e( 'Select which terms to use for filtering', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Filter type', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<select name="filters[filter_design]" class="wc-enhanced-select enhanced wb-input wb-filter-type-tax" data-value="checkbox" tabindex="-1" aria-hidden="true">
			<option value=""><?php esc_html_e( 'Select Design', 'wb-ajax-filter' ); ?></option>
			<option value="checkbox" <?php echo ( isset( $filters['filter_design'] ) && 'checkbox' === $filters['filter_design'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Checkbox', 'wb-ajax-filter' ); ?></option>
			<option value="radio" <?php echo ( isset( $filters['filter_design'] ) && 'radio' === $filters['filter_design'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Radio', 'wb-ajax-filter' ); ?></option>
			<option value="select" <?php echo ( isset( $filters['filter_design'] ) && 'select' === $filters['filter_design'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Select', 'wb-ajax-filter' ); ?></option>
			<option value="text" <?php echo ( isset( $filters['filter_design'] ) && 'text' === $filters['filter_design'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Text', 'wb-ajax-filter' ); ?></option>
			<option value="color" <?php echo ( isset( $filters['filter_design'] ) && 'color' === $filters['filter_design'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Color Swatches', 'wb-ajax-filter' ); ?></option>
			<option value="label" <?php echo ( isset( $filters['filter_design'] ) && 'label' === $filters['filter_design'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Label/Image', 'wb-ajax-filter' ); ?></option>
		</select>
	</div>
	<span class="description"><?php esc_html_e( 'Select the filter type for this filter', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Columns number', 'wb-ajax-filter' ); ?>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<input type="number" name="filters[column_number]" class="wb-input wb-filter-type-tax" value="<?php echo ( isset( $filters['column_number'] ) && '' !== $filters['column_number'] ) ? $filters['column_number'] : '0'; ?>" min="1" max="8" step="1">
	</div>
	<span class="description"><?php esc_html_e( 'Set the number of items per row you want to show for this design', 'wb-ajax-filter' ); ?></span></label>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Customize terms', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<div class="terms-wrapper ui-sortable">
			<?php
			if ( isset( $filters['terms_text'] ) ) {
				foreach ( $filters['terms_text'] as $key => $val ) {
					$term_id = $key;
					$text    = $val['label'];
					$tooltip = ( isset( $val['tooltip'] ) ) ? $val['tooltip'] : '';
					include WB_AJAX_FILTER_TEMPLATE_PATH . 'admin/field/filter-customize-term.php';
				}
			}
			?>
		</div>
	</div>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Order by', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<select name="filters[order_by]" class="wb-ajax-filter-select wb-input wb-filter-type-tax" data-value="name">
			<option value=""><?php esc_html_e( 'Select Order By', 'wb-ajax-filter' ); ?></option>
			<option value="name" <?php echo ( isset( $filters['order_by'] ) && 'name' === $filters['order_by'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Name', 'wb-ajax-filter' ); ?></option>
			<option value="slug" <?php echo ( isset( $filters['order_by'] ) && 'slug' === $filters['order_by'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Slug', 'wb-ajax-filter' ); ?></option>
			<option value="count" <?php echo ( isset( $filters['order_by'] ) && 'count' === $filters['order_by'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Term count', 'wb-ajax-filter' ); ?></option>
			<option value="term_order" <?php echo ( isset( $filters['order_by'] ) && 'term_order' === $filters['order_by'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Term order', 'wb-ajax-filter' ); ?></option>
		</select>
	</div>
	<span class="description"><?php esc_html_e( 'Select the default order for terms of this filter.', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Order type', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-select-field-wrapper">
		<select name="filters[order]" class="wb-ajax-filter-select wb-input wb-filter-type-tax" data-value="">
			<option value=""><?php esc_html_e( 'Select Order type', 'wb-ajax-filter' ); ?></option>
			<option value="asc" <?php echo ( isset( $filters['order'] ) && 'asc' === $filters['order'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'ASC', 'wb-ajax-filter' ); ?></option>
			<option value="desc" <?php echo ( isset( $filters['order'] ) && 'desc' === $filters['order'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'DESC', 'wb-ajax-filter' ); ?></option>
		</select>
	</div>
	<span class="description"><?php esc_html_e( 'Select the default order for terms of this filter', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Show hierarchy', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-radio-field-wrapper">
		<div class="wb-ajax-filter-radio " data-value="no" data-type="radio">
		<div class="wb-ajax-filter-radio__row">
			<input type="radio" class="wb-input wb-filter-type-tax" name="filters[hierarchical]" value="no" <?php echo ( isset( $filters['hierarchical'] ) && 'no' === $filters['hierarchical'] ) ? 'checked' : ''; ?>>
			<label><?php esc_html_e( 'No, show all terms in same level', 'wb-ajax-filter' ); ?></label>
		</div>
		<div class="wb-ajax-filter-radio__row">
			<input type="radio" class="wb-input wb-filter-type-tax" name="filters[hierarchical]" value="parents_only" <?php echo ( isset( $filters['hierarchical'] ) && 'parents_only' === $filters['hierarchical'] ) ? 'checked' : ''; ?>>
			<label><?php esc_html_e( 'No, show only parent terms', 'wb-ajax-filter' ); ?></label>
		</div>
		<div class="wb-ajax-filter-radio__row">
			<input type="radio" class="wb-input wb-filter-type-tax" name="filters[hierarchical]" value="collapsed" <?php echo ( isset( $filters['hierarchical'] ) && 'collapsed' === $filters['hierarchical'] ) ? 'checked' : ''; ?>>
			<label><?php esc_html_e( 'Yes, with terms collapsed', 'wb-ajax-filter' ); ?></label>
		</div>
		<div class="wb-ajax-filter-radio__row">
			<input type="radio" class="wb-input wb-filter-type-tax" name="filters[hierarchical]" value="expanded" <?php echo ( isset( $filters['hierarchical'] ) && 'expanded' === $filters['hierarchical'] ) ? 'checked' : ''; ?>>
			<label><?php esc_html_e( 'Yes, with terms expanded', 'wb-ajax-filter' ); ?></label>
		</div>
		<div class="wb-ajax-filter-radio__row">
			<input type="radio" class="wb-input wb-filter-type-tax" name="filters[hierarchical]" value="open" <?php echo ( isset( $filters['hierarchical'] ) && 'open' === $filters['hierarchical'] ) ? 'checked' : ''; ?>>
			<label><?php esc_html_e( 'Yes, without toggles', 'wb-ajax-filter' ); ?></label>
		</div>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Choose how to show terms hierarchy', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Allow multiple selection', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-onoff-field-wrapper">
		<div class="wb-ajax-filter-onoff-container ">
			<input type="checkbox" class="on_off wb-input wb-filter-type-tax" name="filters[multiple]" value="yes" <?php echo ( isset( $filters['multiple'] ) && 'yes' === $filters['multiple'] ) ? 'checked' : ''; ?>>
			<span class="wb-ajax-filter-onoff" data-text-on="YES" data-text-off="NO"></span>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Enable if the user can select multiple terms when filtering products', 'wb-ajax-filter' ); ?></span>
</div>
<div class="wb-ajax-filter-toggle-content-row wb-tax-toggle" style="<?php echo esc_attr( $style ); ?>">
	<label><?php esc_html_e( 'Multiselect relation', 'wb-ajax-filter' ); ?></label>
	<div class="wb-ajax-filter-field-wrapper wb-ajax-filter-radio-field-wrapper">
		<div class="wb-ajax-filter-radio " data-value="and" data-type="radio">
			<div class="wb-ajax-filter-radio__row">
				<input type="radio" class="wb-input wb-filter-type-tax" name="filters[relation]" value="and" <?php echo ( isset( $filters['relation'] ) && 'and' === $filters['relation'] ) ? 'checked' : ''; ?>>
				<label><?php esc_html_e( 'AND - Results need to match all selected terms at the same time.', 'wb-ajax-filter' ); ?></label>
			</div>
			<div class="wb-ajax-filter-radio__row">
				<input type="radio" class="wb-input wb-filter-type-tax" name="filters[relation]" value="or" <?php echo ( isset( $filters['relation'] ) && 'or' === $filters['relation'] ) ? 'checked' : ''; ?>>
				<label><?php esc_html_e( 'OR - Results need to match at least one of the selected terms.', 'wb-ajax-filter' ); ?></label>
			</div>
		</div>
	</div>
	<span class="description"><?php esc_html_e( 'Choose how multiple terms selection should behave.', 'wb-ajax-filter' ); ?></span>
</div>

