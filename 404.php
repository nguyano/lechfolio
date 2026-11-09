<?php
/**
 * Not found template for the LechFolio container theme.
 *
 * A plugin can supply its own not-found view through the `lechfolio_not_found`
 * action (Coshelters renders its redesigned page there); otherwise the theme's
 * default message and search form are shown.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( has_action( 'lechfolio_not_found' ) ) :
	do_action( 'lechfolio_not_found' );
else :
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
endif;

get_footer();
