<?php
/**
 * Helper functions for optional Coshelters integrations.
 *
 * These wrappers keep the theme usable without the companion plugin while
 * preserving richer behavior when Coshelters is active.
 *
 * @package LechFolio
 */

/**
 * Checks whether the current user belongs to the Coshelters front-end flow.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function lechfolio_is_coshlt_user() {
	if ( function_exists( 'coshlt_is_coshlt_user' ) ) {
		return (bool) coshlt_is_coshlt_user();
	}

	if ( function_exists( 'coshlt_is_front_user' ) && coshlt_is_front_user() ) {
		return true;
	}

	$user = wp_get_current_user();

	return $user instanceof WP_User && (bool) array_intersect(
		(array) $user->roles,
		array( 'coshelters_user', 'coshelters_admin_user', 'fnehousing_user', 'fnehousing_admin_user' )
	);
}

/**
 * Checks whether the current request is handled by the front-end context.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function lechfolio_is_frontend_request() {
	if ( function_exists( 'coshlt_is_frontend_request' ) ) {
		return (bool) coshlt_is_frontend_request();
	}

	return ! is_admin();
}

/**
 * Renders the Coshelters footer icon when available.
 *
 * @since 1.0.0
 *
 * @param int $size Icon size in pixels.
 * @return string
 */
function lechfolio_coshlt_icon( $size = 20 ) {
	if ( ! function_exists( 'coshlt_icon' ) ) {
		return '';
	}

	return wp_kses( coshlt_icon( absint( $size ) ), lechfolio_allowed_icon_markup() );
}

/**
 * Checks whether the user owns or manages shelter organization content.
 *
 * @since 1.0.0
 *
 * @param int|null $user_id User ID to inspect.
 * @return bool
 */
function lechfolio_is_shelter_org( $user_id = null ) {
	return function_exists( 'coshlt_is_shelter_org' ) && coshlt_is_shelter_org( $user_id );
}

/**
 * Returns a Coshelters frontend URL with a legacy endpoint fallback.
 *
 * @since 1.0.0
 *
 * @param string $page_key        Coshelters page key.
 * @param string $fallback_slug   Fallback page slug.
 * @param string $legacy_endpoint Legacy endpoint query value.
 * @param array  $args            Additional URL query arguments.
 * @return string
 */
function lechfolio_coshlt_frontend_url( $page_key, $fallback_slug, $legacy_endpoint, $args = array() ) {
	if ( function_exists( 'coshlt_frontend_page_url' ) ) {
		return (string) coshlt_frontend_page_url( $page_key, $fallback_slug, $args );
	}

	return add_query_arg( array_merge( array( 'endpoint' => $legacy_endpoint ), $args ), home_url( '/' ) );
}

/**
 * Renders a user avatar through Coshelters when available.
 *
 * @since 1.0.0
 *
 * @param string $src   Avatar source URL.
 * @param int    $size  Avatar size.
 * @param string $class Additional image class.
 * @return string
 */
function lechfolio_coshlt_image( $src, $size, $class = '' ) {
	$size = absint( $size );

	if ( function_exists( 'coshlt_image' ) ) {
		return wp_kses_post( coshlt_image( $src, $size, $class ) );
	}

	$image = $src ? esc_url( $src ) : get_avatar_url( get_current_user_id(), array( 'size' => $size ) );

	return sprintf(
		'<img src="%s" class="%s" width="%d" height="%d" alt="" />',
		esc_url( $image ),
		esc_attr( $class ),
		$size,
		$size
	);
}

/**
 * Returns safe markup rules for trusted theme/plugin icon fragments.
 *
 * @since 1.0.0
 *
 * @return array
 */
function lechfolio_allowed_icon_markup() {
	return array(
		'img'  => array(
			'alt'      => true,
			'class'    => true,
			'height'   => true,
			'loading'  => true,
			'src'      => true,
			'srcset'   => true,
			'width'    => true,
			'decoding' => true,
		),
		'span' => array(
			'class'       => true,
			'aria-hidden' => true,
		),
		'svg'  => array(
			'aria-hidden' => true,
			'class'       => true,
			'fill'        => true,
			'focusable'   => true,
			'height'      => true,
			'role'        => true,
			'viewbox'     => true,
			'width'       => true,
			'xmlns'       => true,
		),
		'path' => array(
			'd'    => true,
			'fill' => true,
		),
	);
}
