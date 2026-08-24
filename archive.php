<?php
/**
 * Generic archive template.
 *
 * @package LechFolio
 */

get_header();
?>
<header class="header">
	<h1 class="entry-title" itemprop="name"><?php the_archive_title(); ?></h1>
	<div class="archive-meta" itemprop="description">
		<?php echo esc_html( get_the_archive_description() ); ?>
	</div>
</header>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/entry' );
	endwhile;
endif;

get_template_part( 'template-parts/navigation/posts' );
get_footer();
