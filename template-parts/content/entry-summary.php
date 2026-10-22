<?php
/**
 * Entry summaries that keep protected featured media out of archive output.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="entry-summary">
	<?php if ( ! post_password_required() && has_post_thumbnail() && ! is_search() ) : ?>
		<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
	<?php endif; ?>

	<div itemprop="description"><?php the_excerpt(); ?></div>

	<?php if ( is_search() ) : ?>
		<div class="entry-links"><?php wp_link_pages(); ?></div>
	<?php endif; ?>
</div>
