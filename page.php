<?php
/**
 * Standard page template for the LechFolio container theme.
 *
 * @package LechFolio
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/page' );

		if ( comments_open() && ! post_password_required() ) :
			?>
			<div class="lechfolio-comments">
				<?php comments_template( '', true ); ?>
			</div>
			<?php
		endif;
	endwhile;
endif;

get_footer();
