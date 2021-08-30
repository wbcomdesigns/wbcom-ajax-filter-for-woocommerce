<?php
/**
 * The template for filter design checkbox.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

?>
<div class="wb-ajax-filter filter-tax">
	<ul class="filter-items filter-radio  level-0">
		<?php
		foreach ( $filters['terms'] as $tm ) {
			$term_data = get_term( $tm->id, $filters['taxonomy'] );
			?>
			<li class="filter-item radio level-0">
				<label>
					<input type="checkbox" name="filter[<?php echo esc_attr( $preset_id ); ?>][<?php echo esc_attr( $tm->id ); ?>]" class="wb-ajax-filter-selectible" value="<?php echo esc_attr( $term_data->slug ); ?>" data-filter="<?php echo esc_attr( $filter_taxonomy ); ?>" <?php echo ( isset( $params[ $filter_taxonomy ] ) && in_array( $term_data->slug, (array) $params[ $filter_taxonomy ], true ) ) ? 'checked' : ''; ?> <?php echo ( 0 === $term_data->count ) ? 'disabled' : ''; ?>>
					<a href="<?php echo esc_attr( site_url() ); ?>?wb_ajax=1&product_cat=<?php echo esc_attr( $term_data->slug ); ?>" class="wb-term-label wb-tooltip-added" data-title="<?php echo esc_attr( $term_data->name ); ?>"><?php echo esc_html( $term_data->name ); ?><span class="wb-ajax-filter-tooltip-text"><?php echo esc_html( $term_data->name ); ?></span></a>
				</label>
			</li>
		<?php } ?>
	</ul>
</div>

