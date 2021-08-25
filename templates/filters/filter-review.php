<?php
/**
 * The template for filter by review.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/filters
 */

$args = array(
	'status'      => 'approve',
	'post_status' => 'publish',
	'post_type'   => 'product',
);

$commnts = get_comments( $args );
$ratings = array();
foreach ( $commnts as $commnt ) {
	$rating = get_comment_meta( $commnt->comment_ID, 'rating', true );
	if ( ! in_array( $rating, $ratings, true ) ) {
		$ratings[] = $rating;
	}
}
sort( $ratings );
?>
<div class="wb-ajax-filter wb-ajax-filter-review" id="filter_<?php echo esc_attr( $preset_id . '_' . $filter_count ); ?>" data-filter-type="<?php echo esc_attr( $filters['type'] ); ?>" data-filter-id="<?php echo esc_attr( $filter_count ); ?>" >
	<h4 class="filter-title"><?php echo esc_html( $filters['filter_title'] ); ?></h4>
	<div class="filter-content">
		<div class="wb-ajax-filter filter-review">
			<select>
				<option value=""><?php esc_html_e( 'Any rating', 'wb-ajax-filter' ); ?></option>
			<?php
			foreach ( $ratings as $val ) {
				?>
				<option value="<?php echo esc_attr( $val ); ?>">
				<?php printf( 'Rated %1$s out of 5', esc_html( $val ) ); ?>
			</option>
			<?php } ?>
			</select>
		</div>
	</div>
</div>
