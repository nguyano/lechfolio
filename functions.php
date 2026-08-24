<?php
/**
 * Theme Functions for LechFolio.
 *
 * Keeps the theme lightweight and guards optional Coshelters plugin integrations.
 */


// -----------------------------
// Constants
// -----------------------------
define( 'LECHFOLIO_VERSION', '1.0.0' );
define( 'LECHFOLIO_DIR', get_template_directory() );
define( 'LECHFOLIO_URI', get_template_directory_uri() );
define( 'LECHFOLIO_INC', trailingslashit( LECHFOLIO_DIR ) . 'inc/' );

// -----------------------------
// Hooks: Actions
// -----------------------------

add_action( 'after_setup_theme', 'lechfolio_setup' );
add_action( 'admin_init', 'lechfolio_notice_dismissed' );
add_action( 'wp_enqueue_scripts', 'lechfolio_enqueue', 30 );
add_action( 'wp_footer', 'lechfolio_footer' );
add_action( 'widgets_init', 'lechfolio_widgets_init' );
add_action( 'wp_head', 'lechfolio_pingback_header' );
add_action( 'comment_form_before', 'lechfolio_enqueue_comment_reply_script' );
add_action( 'wp_body_open', 'lechfolio_skip_link', 5 );

// -----------------------------
// Hooks: Filters
// -----------------------------

add_filter( 'document_title_separator', 'lechfolio_document_title_separator' );
add_filter( 'the_title', 'lechfolio_title' );
add_filter( 'nav_menu_link_attributes', 'lechfolio_schema_url', 10 );
add_filter( 'the_content_more_link', 'lechfolio_read_more_link' );
add_filter( 'excerpt_more', 'lechfolio_excerpt_read_more_link' );
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'lechfolio_image_insert_override' );
add_filter( 'get_comments_number', 'lechfolio_comment_count', 0 );


// -----------------------------
// Theme Setup
// -----------------------------

/**
 * Registers theme supports, content width, and menus.
 */
function lechfolio_setup() {
	load_theme_textdomain( 'lechfolio', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
	add_theme_support( 'appearance-tools' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 
		'custom-logo', array(
		  'height'      => 40,
		  'width'       => 200,
		  'flex-height' => true,
		  'flex-width'  => true,
		)
	);


	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1920;
	}

	register_nav_menus( array(
		'main-menu' => esc_html__( 'Main Menu', 'lechfolio' )
	) );
}


/**
 * Stores the user's dismissal preference for theme notices.
 */
function lechfolio_notice_dismissed() {
	$user_id = get_current_user_id();
	if ( isset( $_GET['dismiss'] ) ) {
		add_user_meta( $user_id, 'lechfolio_notice_dismissed_11', 'true', true );
	}
}

// -----------------------------
// Scripts & Styles
// -----------------------------

/**
 * Enqueues the theme stylesheet and small public interaction script.
 */
function lechfolio_enqueue() {
	$style_path  = get_stylesheet_directory() . '/style.css';
	$script_path = get_stylesheet_directory() . '/assets/js/public-scripts.js';
	$style_ver   = file_exists( $style_path ) ? (string) filemtime( $style_path ) : LECHFOLIO_VERSION;
	$script_ver  = file_exists( $script_path ) ? (string) filemtime( $script_path ) : LECHFOLIO_VERSION;

	wp_enqueue_style( 'lechfolio-style', get_stylesheet_uri(), array(), $style_ver );
	wp_enqueue_script( 'lechfolio-pub-js', LECHFOLIO_URI . '/assets/js/public-scripts.js', array(), $script_ver, true );
}

/**
 * Adds browser/device helper classes without requiring a UI framework.
 */
function lechfolio_footer() {
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

// -----------------------------
// Helpers & Filters
// -----------------------------

/**
 * Checks whether the current user belongs to the Coshelters front-end flow.
 */
function lechfolio_is_coshlt_user() {
	if ( function_exists( 'coshlt_is_coshlt_user' ) ) {
		return coshlt_is_coshlt_user();
	}

	if ( function_exists( 'coshlt_is_front_user' ) && coshlt_is_front_user() ) {
		return true;
	}

	$user = wp_get_current_user();

	return $user && (bool) array_intersect(
		(array) $user->roles,
		array( 'coshelters_user', 'coshelters_admin_user', 'fnehousing_user', 'fnehousing_admin_user' )
	);
}

/**
 * Checks whether the current request is handled by the Coshelters plugin.
 */
function lechfolio_is_frontend_request() {
	if ( function_exists( 'coshlt_is_frontend_request' ) ) {
		return coshlt_is_frontend_request();
	}

	return ! is_admin();
}

/**
 * Renders the Coshelters footer icon when available.
 */
function lechfolio_coshlt_icon( $size = 20 ) {
	return function_exists( 'coshlt_icon' ) ? coshlt_icon( $size ) : '';
}

/**
 * Checks whether the user owns or manages shelter organization content.
 */
function lechfolio_is_shelter_org( $user_id = null ) {
	return function_exists( 'coshlt_is_shelter_org' ) && coshlt_is_shelter_org( $user_id );
}

/**
 * Returns a Coshelters frontend URL with a legacy endpoint fallback.
 */
function lechfolio_coshlt_frontend_url( $page_key, $fallback_slug, $legacy_endpoint, $args = array() ) {
	if ( function_exists( 'coshlt_frontend_page_url' ) ) {
		return coshlt_frontend_page_url( $page_key, $fallback_slug, $args );
	}

	return add_query_arg( array_merge( array( 'endpoint' => $legacy_endpoint ), $args ), home_url( '/' ) );
}

/**
 * Renders a user avatar through Coshelters when available.
 */
function lechfolio_coshlt_image( $src, $size, $class = '' ) {
	if ( function_exists( 'coshlt_image' ) ) {
		return coshlt_image( $src, $size, $class );
	}

	$image = $src ? esc_url( $src ) : get_avatar_url( get_current_user_id(), array( 'size' => $size ) );

	return sprintf(
		'<img src="%s" class="%s" width="%d" height="%d" alt="" />',
		esc_url( $image ),
		esc_attr( $class ),
		(int) $size,
		(int) $size
	);
}

if ( ! function_exists( 'lechfolio_loged_in_menu' ) ) {
	/**
	 * Renders the LechFolio logged-in shelter navigation menu.
	 */
	function lechfolio_loged_in_menu() {
		$user_id  = get_current_user_id();
		$user     = $user_id ? get_user_by( 'ID', $user_id ) : null;
		$username = $user ? $user->user_login : '';
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
		?>
		<ul class="lechfolio-menu-list">
			<?php foreach ( $nav_items as $item ) : ?>
				<?php if ( ( $item['type'] ?? 'link' ) === 'link' ) : ?>
					<?php
					$item_path = trim( (string) parse_url( $item['href'], PHP_URL_PATH ), '/' );
					$is_active = ( isset( $item['endpoint'] ) && $item['endpoint'] === $current_endpoint ) || ( $item_path && $item_path === $current_path );
					?>
					<li class="lechfolio-menu-item" id="<?php echo esc_attr( $item['id'] ); ?>">
						<a
							id="<?php echo esc_attr( $item['id'] . 'Link' ); ?>"
							class="lechfolio-menu-link <?php echo $is_active ? 'active' : ''; ?>"
							href="<?php echo esc_url( $item['href'] ); ?>"
							<?php echo $is_active ? 'aria-current="page"' : ''; ?>
						>
							<i class="fa-solid <?php echo esc_attr( $item['icon'] ); ?> fa-lg"></i>
							<?php echo esc_html( $item['label'] ); ?>
						</a>
					</li>
				<?php elseif ( $item['type'] === 'add_shelter' ) : ?>
					<li class="lechfolio-menu-item">
						<a class="lechfolio-menu-button lechfolio-add-shelter-btn" href="<?php echo esc_url( $item['href'] ); ?>">
							<i class="fa-solid <?php echo esc_attr( $item['icon'] ); ?> fa-lg"></i>
							<?php echo esc_html( $item['label'] ); ?>
						</a>
					</li>
				<?php elseif ( $item['type'] === 'dropdown' ) : ?>
					<li class="lechfolio-nav-item lechfolio-dropdown coshlt-dropdown" id="<?php echo esc_attr( $item['id'] ); ?>">
						<a class="lechfolio-dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" href="#">
							<?php echo lechfolio_coshlt_image( $item['user_img'], 35, 'lechfolio-avatar' ); ?>
							<?php echo esc_html( $item['username'] ); ?>
							<i class="fa-solid fa-chevron-down lechfolio-dropdown-icon"></i>
						</a>

						<div class="lechfolio-dropdown-menu coshlt-dropdown-menu">
							<?php foreach ( $item['items'] as $subitem ) : ?>
								<?php if ( ! empty( $subitem['divider'] ) ) : ?>
									<div class="lechfolio-dropdown-divider"></div>
								<?php else : ?>
									<a
										class="lechfolio-dropdown-item coshlt-dropdown-item"
										href="<?php echo esc_url( $subitem['href'] ); ?>"
										<?php echo isset( $subitem['id'] ) ? 'id="' . esc_attr( $subitem['id'] ) . '"' : ''; ?>
									>
										<i class="<?php echo esc_attr( $subitem['icon'] ); ?>"></i>
										<?php echo esc_html( $subitem['label'] ); ?>
									</a>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php

		return ob_get_clean();
	}
}

/**
 * Prints the public theme menu or LechFolio logged-in app navigation.
 */
function lechfolio_primary_menu() {
	if ( is_user_logged_in() && lechfolio_is_frontend_request() && function_exists( 'lechfolio_loged_in_menu' ) ) {
		echo lechfolio_loged_in_menu();
		return;
	}

	wp_nav_menu(array(
		'theme_location' => 'main-menu',
		'container' => false,
		'items_wrap' => '<ul class="lechfolio-menu-list">%3$s</ul>',
		'fallback_cb' => false
	));
}

/**
 * Sets a concise document title separator.
 */
function lechfolio_document_title_separator( $sep ) {
	return esc_html( '|' );
}

/**
 * Provides a fallback title for untitled content.
 */
function lechfolio_title( $title ) {
	return ( $title == '' ) ? esc_html( '...' ) : wp_kses_post( $title );
}

/**
 * Prints schema.org attributes for the current template context.
 */
function lechfolio_schema_type() {
	$schema = 'https://schema.org/';
	$type = 'WebPage';

	if ( is_single() ) {
		$type = "Article";
	} elseif ( is_author() ) {
		$type = 'ProfilePage';
	} elseif ( is_search() ) {
		$type = 'SearchResultsPage';
	}

	echo 'itemscope itemtype="' . esc_url( $schema . $type ) . '"';
}

/**
 * Adds schema metadata to menu links.
 */
function lechfolio_schema_url( $atts ) {
	$atts['itemprop'] = 'url';
	return $atts;
}

if ( ! function_exists( 'lechfolio_wp_body_open' ) ) {
	/**
	 * Backfills wp_body_open for older WordPress installs.
	 */
	function lechfolio_wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Prints a screen-reader skip link.
 */
function lechfolio_skip_link() {
	echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'lechfolio' ) . '</a>';
}

/**
 * Replaces the content more link with accessible text.
 */
function lechfolio_read_more_link() {
	if ( ! is_admin() ) {
		return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'lechfolio' ), '<span class="screen-reader-text"> ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
	}
}

/**
 * Replaces the excerpt more text with an accessible permalink.
 */
function lechfolio_excerpt_read_more_link( $more ) {
	if ( ! is_admin() ) {
		global $post;
		return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'lechfolio' ), '<span class="screen-reader-text"> ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
	}
}

/**
 * Removes oversized generated image sizes for this lightweight theme.
 */
function lechfolio_image_insert_override( $sizes ) {
	unset( $sizes['medium_large'], $sizes['1536x1536'], $sizes['2048x2048'] );
	return $sizes;
}

/**
 * Registers the optional sidebar widget area.
 */
function lechfolio_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Widget Area', 'lechfolio' ),
		'id'            => 'primary-widget-area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

/**
 * Prints a pingback URL for singular posts that allow pings.
 */
function lechfolio_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

/**
 * Enqueues threaded comment replies when enabled.
 */
function lechfolio_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Renders a compact pingback list item.
 */
function lechfolio_custom_pings( $comment ) {
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
	<?php
}

/**
 * Counts only approved regular comments on the front end.
 */
function lechfolio_comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$get_comments = get_comments( array(
			'status'   => 'approve',
			'post_id'  => $id,
		) );
		$comments_by_type = separate_comments( $get_comments );
		return count( $comments_by_type['comment'] );
	}
	return $count;
}
