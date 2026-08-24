<?php
/**
 * Default template for posts and fallback views.
 *
 * @package LechFolio
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/entry' );
		comments_template();
	endwhile;
endif;

get_template_part( 'template-parts/navigation/posts' );
get_footer();
