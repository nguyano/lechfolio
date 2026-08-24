<?php
/**
 * Full entry content markup.
 *
 * @package LechFolio
 */

$thumbnail_id = get_post_thumbnail_id();
?>
<div class="entry-content" itemprop="mainEntityOfPage">
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" title="<?php echo esc_attr( get_the_title( $thumbnail_id ) ); ?>">
			<?php the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); ?>
		</a>
	<?php endif; ?>

	<meta itemprop="description" content="<?php echo esc_attr( wp_strip_all_tags( get_the_excerpt(), true ) ); ?>">
	<?php the_content(); ?>
	<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
