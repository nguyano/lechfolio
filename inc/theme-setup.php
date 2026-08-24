<?php
/**
 * Theme setup and admin-only handlers for LechFolio.
 *
 * Registers theme supports, navigation locations, sidebars, and lightweight
 * admin preferences.
 *
 * @package LechFolio
 */

/**
 * Registers theme supports, content width, translations, and menus.
 *
 * @since 1.0.0
 *
 * @return void
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
		'custom-logo',
		array(
			'height'      => 40,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	$GLOBALS['content_width'] = isset( $GLOBALS['content_width'] ) ? $GLOBALS['content_width'] : 1920;

	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Main Menu', 'lechfolio' ),
		)
	);
}

/**
 * Stores the current user's dismissal preference for LechFolio notices.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_notice_dismissed() {
	if ( ! is_admin() || ! is_user_logged_in() || ! isset( $_GET['dismiss'] ) ) {
		return;
	}

	$dismiss = sanitize_key( wp_unslash( $_GET['dismiss'] ) );

	if ( 'lechfolio_notice' !== $dismiss ) {
		return;
	}

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'lechfolio_dismiss_notice' ) ) {
		return;
	}

	add_user_meta( get_current_user_id(), 'lechfolio_notice_dismissed_11', 'true', true );
}

/**
 * Registers the optional sidebar widget area.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar Widget Area', 'lechfolio' ),
			'id'            => 'primary-widget-area',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
