<?php
/**
 * Search results template for the LechFolio container theme.
 *
 * @package LechFolio
 */

get_header();

if ( have_posts() ) :
	?>
	<header class="header">
		<h1 class="entry-title" itemprop="name">
			<?php
			printf(
				/* translators: %s: Search query. */
				esc_html__( 'Search Results for: %s', 'lechfolio' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
	</header>
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/entry' );
	endwhile;

	get_template_part( 'template-parts/navigation/posts' );
else :
	get_template_part( 'template-parts/content/none' );
endif;

get_footer();
