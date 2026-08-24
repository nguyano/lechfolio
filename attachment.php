<?php
/**
 * Attachment detail template.
 *
 * @package LechFolio
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$parent_id = wp_get_post_parent_id( get_the_ID() );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="header">
				<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
				<?php edit_post_link(); ?>
				<?php get_template_part( 'template-parts/content/entry-meta' ); ?>

				<?php if ( $parent_id ) : ?>
					<a href="<?php echo esc_url( get_permalink( $parent_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'Return to %s', 'lechfolio' ), get_the_title( $parent_id ) ) ); ?>" rev="attachment">
						<?php
						printf(
							/* translators: %s: Left arrow indicator. */
							esc_html__( '%s Return to ', 'lechfolio' ),
							'<span class="meta-nav">&larr;</span>'
						);
						echo wp_kses_post( get_the_title( $parent_id ) );
						?>
					</a>
				<?php endif; ?>

				<nav id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_image_link( false, '&lsaquo;' ); ?></div>
					<div class="nav-next"><?php next_image_link( false, '&rsaquo;' ); ?></div>
				</nav>
			</header>

			<div class="entry-content" itemprop="mainContentOfPage">
				<div class="entry-attachment">
					<?php if ( wp_attachment_is_image( get_the_ID() ) ) : ?>
						<?php $att_image = wp_get_attachment_image_src( get_the_ID(), 'full' ); ?>
						<p class="attachment">
							<a href="<?php echo esc_url( wp_get_attachment_url( get_the_ID() ) ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
								<img src="<?php echo esc_url( $att_image[0] ); ?>" width="<?php echo esc_attr( $att_image[1] ); ?>" height="<?php echo esc_attr( $att_image[2] ); ?>" class="attachment-full" alt="<?php echo esc_attr( get_the_excerpt() ); ?>" itemprop="image">
							</a>
						</p>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_get_attachment_url( get_the_ID() ) ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
							<?php echo esc_html( wp_basename( get_attached_file( get_the_ID() ) ) ); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="entry-caption"><?php the_excerpt(); ?></div>
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
				}
				?>
			</div>
		</article>
		<?php
		comments_template();
	endwhile;
endif;

get_footer();
