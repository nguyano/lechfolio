<?php
/**
 * Empty search/archive result message.
 *
 * @package LechFolio
 */
?>
<article id="post-0" class="post no-results not-found">
	<header class="header">
		<h1 class="entry-title" itemprop="name"><?php esc_html_e( 'Nothing Found', 'lechfolio' ); ?></h1>
	</header>
	<div class="entry-content" itemprop="mainContentOfPage">
		<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again.', 'lechfolio' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</article>
