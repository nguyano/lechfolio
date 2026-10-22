<?php
/**
 * Template Name: Blank Page.
 * Description: A minimal full-width page with no sidebar, title, or extra content.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	the_content();
endwhile;

get_footer();
