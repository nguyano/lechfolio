<?php
/**
 * Single post template.
 *
 * @package LechFolio
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/entry' );

		if ( comments_open() && ! post_password_required() ) {
			comments_template( '', true );
		}
	endwhile;
endif;
?>
<footer class="footer">
	<?php get_template_part( 'template-parts/navigation/post' ); ?>
</footer>
<?php
get_footer();
