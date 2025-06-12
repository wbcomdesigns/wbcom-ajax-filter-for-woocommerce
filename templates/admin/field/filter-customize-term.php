<?php
/**
 * The template for customize terms field.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin/field
 */

/**
 * Variables available
 *
 * @var $term_id
 * @var $text
 */

?>
<div id="wb_term_<?php echo esc_attr( $term_id ); ?>" class="term-box" data-term_id="<?php echo esc_attr( $term_id ); ?>">
	<h4><?php echo esc_html( $text ); ?></h4>
	<p class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper term-label">
		<label for="term_label"><?php echo esc_html__( 'Label', 'wb-ajax-filter' ); ?></label>
		<input id="term_label" type="text" name="filters[terms_text][<?php echo esc_html( $term_id ); ?>][label]" value="<?php echo esc_attr( $text ); ?>">
	</p>
	<p class="wb-ajax-filter-field-wrapper wb-ajax-filter-text-field-wrapper term-tooltip">
		<label for="term_tooltip"><?php echo esc_html__( 'Tooltip', 'wb-ajax-filter' ); ?></label>
		<input id="term_tooltip" type="text" name="filters[terms_text][<?php echo esc_html( $term_id ); ?>][tooltip]" value="<?php echo esc_attr( $tooltip ); ?>">
	</p>
</div>
