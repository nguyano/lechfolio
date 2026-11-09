<?php
/**
 * Asset enqueueing for LechFolio.
 *
 * Uses WordPress enqueue APIs and file modification versions to keep the theme
 * lightweight without a build step.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
 * Google Fonts request for the theme typeface (Jost, plus the Instrument Serif
 * italic accent the Coshelters screens use) so one shared stylesheet serves
 * every frontend page.
 *
 * @since 1.0.4
 *
 * @return string
 */
function lechfolio_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&family=Instrument+Serif:ital@1&display=swap';
}

/**
 * Loads the theme typeface on every frontend page.
 *
 * Runs early so plugins enqueueing later can reuse the `lechfolio-fonts`
 * handle instead of requesting the same stylesheet again.
 *
 * @since 1.0.4
 *
 * @return void
 */
function lechfolio_enqueue_fonts() {
	wp_enqueue_style( 'lechfolio-fonts', lechfolio_fonts_url(), array(), null );
}

/**
 * Opens connections to Google Fonts early so text renders in Jost sooner.
 *
 * @since 1.0.4
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function lechfolio_font_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && wp_style_is( 'lechfolio-fonts', 'enqueued' ) ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}

/**
 * Enqueues the theme stylesheet and public interaction script.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_enqueue() {
	wp_enqueue_style( 'lechfolio-style', get_stylesheet_uri(), array( 'lechfolio-fonts' ), lechfolio_asset_version( 'style.css' ) );
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
