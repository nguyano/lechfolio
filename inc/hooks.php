<?php
/**
 * WordPress hook registrations for LechFolio.
 *
 * Keeps action and filter wiring in one place while implementations live in
 * focused include files.
 *
 * @package LechFolio
 */

add_action( 'after_setup_theme', 'lechfolio_setup' );
add_action( 'admin_init', 'lechfolio_notice_dismissed' );
add_action( 'wp_enqueue_scripts', 'lechfolio_enqueue', 30 );
add_action( 'wp_footer', 'lechfolio_footer_device_classes' );
add_action( 'widgets_init', 'lechfolio_widgets_init' );
add_action( 'wp_head', 'lechfolio_pingback_header' );
add_action( 'comment_form_before', 'lechfolio_enqueue_comment_reply_script' );
add_action( 'wp_body_open', 'lechfolio_skip_link', 5 );
add_action( 'admin_footer-themes.php', 'lechfolio_print_themes_screen_docs_link' );

add_filter( 'document_title_separator', 'lechfolio_document_title_separator' );
add_filter( 'the_title', 'lechfolio_title' );
add_filter( 'nav_menu_link_attributes', 'lechfolio_schema_url' );
add_filter( 'the_content_more_link', 'lechfolio_read_more_link' );
add_filter( 'excerpt_more', 'lechfolio_excerpt_read_more_link' );
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'lechfolio_image_insert_override' );
add_filter( 'get_comments_number', 'lechfolio_comment_count', 0 );
add_filter( 'theme_action_links_' . get_template(), 'lechfolio_theme_action_links' );
add_filter( 'theme_action_links_' . get_stylesheet(), 'lechfolio_theme_action_links' );
