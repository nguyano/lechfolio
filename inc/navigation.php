<?php
/**
 * Navigation rendering for LechFolio.
 *
 * Contains the public WordPress menu fallback and the optional logged-in
 * Coshelters application menu.
 *
 * @package LechFolio
 */

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
			'icon'     => 'fa-link',
			'endpoint' => 'availability_update_links',
			'label'    => __( 'Update Links', 'lechfolio' ),
			'href'     => lechfolio_coshlt_frontend_url( 'availabilityUpdateLinks', 'availability-update-links', 'availability_update_links' ),
		);

		$nav_items = array(
			array(
				'id'       => 'LechfolioSheltersNavItem',
				'icon'     => 'fa-house-chimney-user',
				'endpoint' => $shelters_endpoint,
				'label'    => $shelters_link_label,
				'href'     => lechfolio_coshlt_frontend_url( $shelters_page_key, $shelters_slug, $shelters_endpoint ),
			),
			array(
				'id'       => 'LechfolioMapNavItem',
				'icon'     => 'fa-map-location-dot',
				'endpoint' => 'map_view',
				'label'    => __( 'Map View', 'lechfolio' ),
				'href'     => lechfolio_coshlt_frontend_url( 'mapView', 'map-view', 'map_view' ),
			),
			array(
				'type'  => 'add_shelter',
				'icon'  => 'fa-house-medical-circle-check',
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
						'icon'  => 'fas fa-user',
						'label' => __( 'My Profile', 'lechfolio' ),
					),
					array(
						'divider' => true,
					),
					array(
						'id'    => 'FnehdLogOutFrontNavItem',
						'href'  => wp_logout_url( lechfolio_coshlt_frontend_url( 'login', 'login', 'login' ) ),
						'icon'  => 'fas fa-sign-out',
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
 * Prints the public theme menu or LechFolio logged-in app navigation.
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

	wp_nav_menu(
		array(
			'theme_location' => 'main-menu',
			'container'      => false,
			'items_wrap'     => '<ul class="lechfolio-menu-list">%3$s</ul>',
			'fallback_cb'    => false,
		)
	);
}
