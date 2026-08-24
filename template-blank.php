<?php
/**
 * Template Name: Blank Page
 * Description: A minimal full-width page with no sidebar, title, or extra content.
 *
 * @package LechFolio
 */

get_header();

while ( have_posts() ) :
	the_post();
	the_content();
endwhile;

get_footer();
