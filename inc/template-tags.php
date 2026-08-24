<?php
/**
 * Template tag helpers and display filters for LechFolio.
 *
 * @package LechFolio
 */

/**
 * Sets a concise document title separator.
 *
 * @since 1.0.0
 *
 * @param string $sep Existing separator.
 * @return string
 */
function lechfolio_document_title_separator( $sep ) {
	return '|';
}

/**
 * Provides a fallback title for untitled content.
 *
 * @since 1.0.0
 *
 * @param string $title Post title.
 * @return string
 */
function lechfolio_title( $title ) {
	return '' === $title ? esc_html__( '...', 'lechfolio' ) : $title;
}

/**
 * Prints schema.org attributes for the current template context.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_schema_type() {
	$schema = 'https://schema.org/';
	$type   = 'WebPage';

	if ( is_single() ) {
		$type = 'Article';
	} elseif ( is_author() ) {
		$type = 'ProfilePage';
	} elseif ( is_search() ) {
		$type = 'SearchResultsPage';
	}

	echo 'itemscope itemtype="' . esc_url( $schema . $type ) . '"';
}

/**
 * Adds schema metadata to menu links.
 *
 * @since 1.0.0
 *
 * @param array $atts Menu link attributes.
 * @return array
 */
function lechfolio_schema_url( $atts ) {
	$atts['itemprop'] = 'url';

	return $atts;
}

if ( ! function_exists( 'lechfolio_wp_body_open' ) ) {
	/**
	 * Backfills wp_body_open for older WordPress installs.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function lechfolio_wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Prints a screen-reader skip link.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_skip_link() {
	echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'lechfolio' ) . '</a>';
}

/**
 * Replaces the content more link with accessible text.
 *
 * @since 1.0.0
 *
 * @return string|null
 */
function lechfolio_read_more_link() {
	if ( is_admin() ) {
		return null;
	}

	return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf(
		/* translators: %s: Screen-reader post title. */
		esc_html__( '...%s', 'lechfolio' ),
		'<span class="screen-reader-text"> ' . esc_html( get_the_title() ) . '</span>'
	) . '</a>';
}

/**
 * Replaces the excerpt more text with an accessible permalink.
 *
 * @since 1.0.0
 *
 * @param string $more Existing excerpt more text.
 * @return string|null
 */
function lechfolio_excerpt_read_more_link( $more ) {
	if ( is_admin() ) {
		return null;
	}

	return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf(
		/* translators: %s: Screen-reader post title. */
		esc_html__( '...%s', 'lechfolio' ),
		'<span class="screen-reader-text"> ' . esc_html( get_the_title() ) . '</span>'
	) . '</a>';
}

/**
 * Removes oversized generated image sizes for this lightweight theme.
 *
 * @since 1.0.0
 *
 * @param array $sizes Registered intermediate image sizes.
 * @return array
 */
function lechfolio_image_insert_override( $sizes ) {
	unset( $sizes['medium_large'], $sizes['1536x1536'], $sizes['2048x2048'] );

	return $sizes;
}

/**
 * Prints a pingback URL for singular posts that allow pings.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
