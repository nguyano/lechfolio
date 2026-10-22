<?php
/**
 * Loader overlay markup.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="lechfolio-loader" class="lechfolio-loader-overlay">
	<div class="lechfolio-loader-spinner" role="status">
		<span class="screen-reader-text"><?php esc_html_e( 'Loading...', 'lechfolio' ); ?></span>
	</div>
</div>
