<?php
/**
 * Standard page content card.
 *
 * @package LechFolio
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'lechfolio-page-card' ); ?>>
	<header class="lechfolio-page-header">
		<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
		<?php edit_post_link( __( 'Edit', 'lechfolio' ), '<span class="lechfolio-edit-link">', '</span>' ); ?>
	</header>

	<div class="lechfolio-page-body entry-content" itemprop="mainContentOfPage">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="lechfolio-featured-image">
				<?php the_post_thumbnail( 'full', array( 'class' => 'lechfolio-responsive-image', 'itemprop' => 'image' ) ); ?>
			</div>
		<?php endif; ?>

		<?php the_content(); ?>

		<div class="entry-links">
			<?php
			wp_link_pages(
				array(
					'before' => '<nav class="page-links">' . esc_html__( 'Pages:', 'lechfolio' ),
					'after'  => '</nav>',
				)
			);
			?>
		</div>
	</div>
</article>
