<?php
/**
 * Author archive template.
 *
 * @package LechFolio
 */

get_header();
the_post();
?>
<header class="header">
	<h1 class="entry-title author" itemprop="name"><?php the_author_link(); ?></h1>
	<div class="archive-meta" itemprop="description">
		<?php echo esc_html( get_the_author_meta( 'user_description' ) ); ?>
	</div>
</header>
<?php
rewind_posts();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content/entry' );
endwhile;

get_template_part( 'template-parts/navigation/posts' );
get_footer();
