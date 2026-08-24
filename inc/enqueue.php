<?php
/**
 * Asset enqueueing for LechFolio.
 *
 * Uses WordPress enqueue APIs and file modification versions to keep the theme
 * lightweight without a build step.
 *
 * @package LechFolio
 */

/**
 * Returns a cache-busting version for a theme-relative asset.
 *
 * @since 1.0.0
 *
 * @param string $relative_path Theme-relative asset path.
 * @return string
 */
function lechfolio_asset_version( $relative_path ) {
	$path = trailingslashit( get_template_directory() ) . ltrim( $relative_path, '/' );

	return file_exists( $path ) ? (string) filemtime( $path ) : LECHFOLIO_VERSION;
}

/**
 * Enqueues the theme stylesheet and public interaction script.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_enqueue() {
	wp_enqueue_style( 'lechfolio-style', get_stylesheet_uri(), array(), lechfolio_asset_version( 'style.css' ) );
	wp_enqueue_script( 'lechfolio-public', LECHFOLIO_URI . '/assets/js/public-scripts.js', array(), lechfolio_asset_version( 'assets/js/public-scripts.js' ), true );
}

/**
 * Adds browser/device helper classes without requiring a UI framework.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_footer_device_classes() {
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var deviceAgent = navigator.userAgent.toLowerCase();
		if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
			document.documentElement.classList.add('ios', 'mobile');
		}
		if (deviceAgent.match(/(android)/)) {
			document.documentElement.classList.add('android', 'mobile');
		}
		if (navigator.userAgent.indexOf("MSIE") >= 0) {
			document.documentElement.classList.add('ie');
		} else if (navigator.userAgent.indexOf("Chrome") >= 0) {
			document.documentElement.classList.add('chrome');
		} else if (navigator.userAgent.indexOf("Firefox") >= 0) {
			document.documentElement.classList.add('firefox');
		} else if (navigator.userAgent.indexOf("Safari") >= 0 && navigator.userAgent.indexOf("Chrome") < 0) {
			document.documentElement.classList.add('safari');
		} else if (navigator.userAgent.indexOf("Opera") >= 0) {
			document.documentElement.classList.add('opera');
		}
	});
	</script>
	<?php
}
