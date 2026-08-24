<?php
/**
 * Not found template for the LechFolio container theme.
 *
 * @package LechFolio
 */

get_header();
?>
<article id="post-0" class="post not-found">
	<header class="header">
		<h1 class="entry-title" itemprop="name"><?php esc_html_e( 'Page Not Found', 'lechfolio' ); ?></h1>
	</header>
	<div class="entry-content" itemprop="mainContentOfPage">
		<p><?php esc_html_e( 'Nothing found for the requested page. Try a search instead?', 'lechfolio' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</article>

<?php
get_footer();
