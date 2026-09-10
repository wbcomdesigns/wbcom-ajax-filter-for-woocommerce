<?php
/**
 * The template for filter preset modal.
 *
 * @link       https://wbcomdesigns.com/
 * @since      1.0.0
 *
 * @package    Wb_Ajax_Filter
 * @subpackage Wb_Ajax_Filter/template/admin
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="wb-ajax-filter-modal-container wbcom-admin"><?php // wbcom-admin: this modal prints on admin_footer, OUTSIDE the shell's .wbcom-admin wrapper. The shell design tokens (--wbcom-accent, --wbcom-surface, --wbcom-border, --wbcom-text) are scoped to .wbcom-admin, not :root, so without this class every shell component inside the modal (toggle ON state, primary button, inputs, selects) renders un-tokened - the toggle goes white, the Save button transparent. ?>
	<div class="wb-ajax-filter-modal-body">
		<div class="wb-ajax-filter-close-modal">
			<span class="wb-ajax-filter-close">&times;</span>
		</div>
		<div class="wb-ajax-filter-modal-content wbcom-settings-body">
		</div>
	</div>
</div>
