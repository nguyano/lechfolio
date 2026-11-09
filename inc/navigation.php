<?php
/**
 * Navigation rendering for LechFolio.
 *
 * Contains the public WordPress menu fallback and the optional logged-in
 * Coshelters application menu. Visitor icons decorate existing menu labels
 * without changing destinations, permissions, or disclosure behavior.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lechfolio_loged_in_menu' ) ) {
	/**
	 * Renders the LechFolio logged-in shelter navigation menu.
	 *
	 * The misspelled function name is retained for backward compatibility with
	 * older internal theme/plugin references.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function lechfolio_loged_in_menu() {
		$user_id  = get_current_user_id();
		$user     = $user_id ? get_user_by( 'ID', $user_id ) : null;
		$username = $user instanceof WP_User ? $user->user_login : '';
		$user_img = get_user_meta( $user_id, 'user_image', true ) ?: get_user_meta( $user_id, 'coshlt_user_image', true );
		$is_org   = lechfolio_is_shelter_org( $user_id );

		$shelters_link_label = $is_org ? __( 'My Shelters', 'lechfolio' ) : __( 'Shelters', 'lechfolio' );
		$shelters_endpoint   = $is_org ? 'shelters_org' : 'shelters';
		$shelters_page_key   = $is_org ? 'myShelters' : 'shelters';
		$shelters_slug       = $is_org ? 'my-shelters' : 'shelters';

		$update_links = array(
			'id'       => 'LechfolioUpdateLinksNavItem',
			'icon'     => 'link',
			'endpoint' => 'availability_update_links',
			'label'    => __( 'Update Links', 'lechfolio' ),
			'href'     => lechfolio_coshlt_frontend_url( 'availabilityUpdateLinks', 'availability-update-links', 'availability_update_links' ),
		);

		$nav_items = array(
			array(
				'id'       => 'LechfolioSheltersNavItem',
				'icon'     => 'house',
				'endpoint' => $shelters_endpoint,
				'label'    => $shelters_link_label,
				'href'     => lechfolio_coshlt_frontend_url( $shelters_page_key, $shelters_slug, $shelters_endpoint ),
			),
			array(
				'id'       => 'LechfolioMapNavItem',
				'icon'     => 'map',
				'endpoint' => 'map_view',
				'label'    => __( 'Map View', 'lechfolio' ),
				'href'     => lechfolio_coshlt_frontend_url( 'mapView', 'map-view', 'map_view' ),
			),
			array(
				'type'  => 'add_shelter',
				'icon'  => 'plus-circle',
				'label' => __( 'Add Shelter', 'lechfolio' ),
				'href'  => lechfolio_coshlt_frontend_url( 'addShelter', 'add-shelter', 'add_shelter' ),
			),
			array(
				'type'     => 'dropdown',
				'id'       => 'LechfolioUserProfileNavItem',
				'username' => $username,
				'user_img' => $user_img,
				'items'    => array(
					array(
						'href'  => lechfolio_coshlt_frontend_url( 'userProfile', 'profile', 'user_profile' ),
						'icon'  => 'user',
						'label' => __( 'My Profile', 'lechfolio' ),
					),
					array(
						'divider' => true,
					),
					array(
						'id'    => 'FnehdLogOutFrontNavItem',
						'href'  => wp_logout_url( lechfolio_coshlt_frontend_url( 'login', 'login', 'login' ) ),
						'icon'  => 'sign-out',
						'label' => __( 'Log out', 'lechfolio' ),
					),
				),
			),
		);

		if ( ! $is_org ) {
			array_splice( $nav_items, 2, 0, array( $update_links ) );
		}

		$current_endpoint = isset( $_GET['endpoint'] ) ? sanitize_key( wp_unslash( $_GET['endpoint'] ) ) : '';
		$current_path     = trim( (string) parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );

		ob_start();
		get_template_part(
			'template-parts/navigation/logged-in-menu',
			null,
			array(
				'current_endpoint' => $current_endpoint,
				'current_path'     => $current_path,
				'nav_items'        => $nav_items,
			)
		);

		return ob_get_clean();
	}
}

/**
 * Returns the design icon for a visitor menu item, or an empty string.
 *
 * Shortcut classes assigned by Coshelters win; other items match configured
 * page URLs first and then the established page-slug fallback.
 *
 * @since 1.0.4
 *
 * @param WP_Post $item Menu item object.
 * @return string Coshelters icon name.
 */
function lechfolio_frontend_menu_icon_name( $item ) {
	$classes   = (array) ( $item->classes ?? array() );
	$shortcuts = array(
		'lechfolio-home-btn'    => 'house',
		'lechfolio-about-btn'   => 'info',
		'lechfolio-faqs-btn'    => 'faq',
		'lechfolio-contact-btn' => 'mail',
	);
	foreach ( $shortcuts as $class => $icon ) {
		if ( in_array( $class, $classes, true ) ) {
			return $icon;
		}
	}

	$menu_url = wp_parse_url( html_entity_decode( (string) ( $item->url ?? '' ), ENT_QUOTES, 'UTF-8' ) );
	if ( ! is_array( $menu_url ) || empty( $menu_url['path'] )
		|| ( isset( $menu_url['host'] ) && strtolower( $menu_url['host'] ) !== strtolower( (string) wp_parse_url( home_url( '/' ), PHP_URL_HOST ) ) ) ) {
		return '';
	}
	$menu_path  = untrailingslashit( $menu_url['path'] );
	$menu_query = array();
	wp_parse_str( $menu_url['query'] ?? '', $menu_query );

	$routes = array(
		array( 'shelters', 'shelters', 'shelters', 'house' ),
		array( 'myShelters', 'my-shelters', 'shelters_org', 'house' ),
		array( 'mapView', 'map-view', 'map_view', 'map' ),
		array( 'availabilityUpdateLinks', 'availability-update-links', 'availability_update_links', 'link' ),
		array( 'addShelter', 'add-shelter', 'add_shelter', 'plus-circle' ),
		array( 'userProfile', 'profile', 'user_profile', 'user' ),
		array( 'login', 'login', 'login', 'sign-in' ),
		array( 'signup', 'signup', 'signup', 'user-plus' ),
		array( 'about', 'about', 'about', 'info' ),
		array( 'faqs', 'faqs', 'faqs', 'faq' ),
		array( 'contact', 'contact-us', 'contact', 'mail' ),
		array( 'contributors', 'contributors', 'contributors', 'users' ),
	);
	foreach ( $routes as $route ) {
		$urls = array( lechfolio_coshlt_frontend_url( $route[0], $route[1], $route[2] ), home_url( '/' . $route[1] . '/' ) );
		foreach ( $urls as $url ) {
			$candidate       = wp_parse_url( $url );
			$candidate_query = array();
			wp_parse_str( $candidate['query'] ?? '', $candidate_query );
			$matches_query = true;
			foreach ( $candidate_query as $key => $value ) {
				if ( ! array_key_exists( $key, $menu_query ) || $menu_query[ $key ] !== $value ) {
					$matches_query = false;
					break;
				}
			}
			if ( $menu_path === untrailingslashit( $candidate['path'] ?? '/' ) && $matches_query ) {
				return $route[3];
			}
		}
	}

	if ( ! $menu_query && $menu_path === untrailingslashit( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ) ) ) {
		return 'house';
	}

	return '';
}

/**
 * Adds Coshelters line icons to visitor links while preserving their titles.
 *
 * Top-level labels are wrapped so narrow headers can show icon-only links.
 * Items that already carry icon classes or markup keep their own artwork.
 * The caller attaches this filter only while rendering the frontend main menu.
 *
 * @since 1.0.4
 *
 * @param string   $title Menu item title, including its existing markup.
 * @param WP_Post  $item  Menu item object.
 * @param stdClass $args  Navigation rendering arguments.
 * @param int      $depth Menu item depth.
 * @return string
 */
function lechfolio_frontend_menu_icon( $title, $item, $args, $depth ) {
	if ( ( $args->theme_location ?? '' ) !== 'main-menu' || ! function_exists( 'coshlt_ui_icon' ) ) {
		return $title;
	}

	$classes = (array) ( $item->classes ?? array() );
	// Items that already carry their own icon markup or icon class keep it.
	if ( preg_match( '/(?:^|\s)icon-[\w-]+(?:\s|$)/', implode( ' ', $classes ) )
		|| preg_match( '/<(?:svg|img)\b|class=[\'"][^\'"]*\bicon/i', $title ) ) {
		return $title;
	}

	$icon  = lechfolio_frontend_menu_icon_name( $item );
	$label = 0 === (int) $depth ? '<span class="lechfolio-nav-txt">' . $title . '</span>' : $title;

	// The icon helper emits static plugin SVG; the title keeps WordPress escaping.
	return ( '' !== $icon ? coshlt_ui_icon( $icon, 0 === (int) $depth ? 17 : 16, 'lechfolio-visitor-icon' ) : '' ) . $label;
}

/**
 * Prints the existing menu with scoped decorative frontend visitor icons.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_primary_menu() {
	if ( is_user_logged_in() && lechfolio_is_frontend_request() && function_exists( 'lechfolio_loged_in_menu' ) ) {
		// The menu template escapes each dynamic value before buffering markup.
		echo lechfolio_loged_in_menu();
		return;
	}

	$decorate = class_exists( '\Coshelters\Enqueues\PublicPageContext' )
		&& \Coshelters\Enqueues\PublicPageContext::shouldLoadAssets();
	if ( $decorate ) {
		add_filter( 'nav_menu_item_title', 'lechfolio_frontend_menu_icon', 10, 4 );
	}

	try {
		wp_nav_menu(
			array(
				'theme_location' => 'main-menu',
				'container'      => false,
				'items_wrap'     => '<ul class="lechfolio-menu-list">%3$s</ul>',
				'fallback_cb'    => false,
			)
		);
	} finally {
		if ( $decorate ) {
			remove_filter( 'nav_menu_item_title', 'lechfolio_frontend_menu_icon', 10 );
		}
	}
}
