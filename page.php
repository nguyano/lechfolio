<?php
/**
 * Standard page template for the LechFolio container theme.
 *
 * Renders page content inside the shared theme content area without framework classes.
 */
get_header();
?>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'lechfolio-page-card' ); ?>>
      <header class="lechfolio-page-header">
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
        <?php edit_post_link( __( 'Edit', 'lechfolio' ), '<span class="lechfolio-edit-link">', '</span>' ); ?>
      </header>

      <div class="lechfolio-page-body entry-content" itemprop="mainContentOfPage">
        <?php if ( has_post_thumbnail() ) : ?>
          <div class="lechfolio-featured-image">
            <?php the_post_thumbnail( 'full', [ 'class' => 'lechfolio-responsive-image', 'itemprop' => 'image' ] ); ?>
          </div>
        <?php endif; ?>

        <?php the_content(); ?>

        <div class="entry-links">
          <?php wp_link_pages( [
            'before' => '<nav class="page-links">' . __( 'Pages:', 'lechfolio' ),
            'after'  => '</nav>',
          ] ); ?>
        </div>
      </div>
    </article>

    <?php if ( comments_open() && !post_password_required() ) : ?>
      <div class="lechfolio-comments">
        <?php comments_template( '', true ); ?>
      </div>
    <?php endif; ?>

  <?php endwhile; endif; ?>

<?php get_footer(); ?>
