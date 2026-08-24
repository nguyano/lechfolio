<?php
/**
 * Search results template for the LechFolio container theme.
 *
 * Renders search results inside the shared content area without framework classes.
 */
get_header();
?>
		<?php if ( have_posts() ) : ?>
		<header class="header">
		<h1 class="entry-title" itemprop="name"><?php printf( esc_html__( 'Search Results for: %s', 'lechfolio' ), get_search_query() ); ?></h1>
		</header>
		<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'entry' ); ?>
		<?php endwhile; ?>
		<?php get_template_part( 'nav', 'below' ); ?>
		<?php else : ?>
		<article id="post-0" class="post no-results not-found">
		<header class="header">
		<h1 class="entry-title" itemprop="name"><?php esc_html_e( 'Nothing Found', 'lechfolio' ); ?></h1>
		</header>
		<div class="entry-content" itemprop="mainContentOfPage">
		<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again.', 'lechfolio' ); ?></p>
		<?php get_search_form(); ?>
		</div>
		</article>
		<?php endif; ?>
		
<?php get_footer(); ?>
