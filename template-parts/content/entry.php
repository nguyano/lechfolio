<?php
/**
 * Standard post/content card.
 *
 * @package LechFolio
 */

$heading_tag = is_singular() ? 'h1' : 'h2';
$entry_part  = ( is_front_page() || is_home() || is_archive() || is_search() ) ? 'summary' : 'content';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<<?php echo tag_escape( $heading_tag ); ?> class="entry-title"<?php echo is_singular() ? ' itemprop="headline"' : ''; ?>>
			<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</<?php echo tag_escape( $heading_tag ); ?>>

		<?php edit_post_link(); ?>

		<?php
		if ( ! is_search() ) {
			get_template_part( 'template-parts/content/entry-meta' );
		}
		?>
	</header>

	<?php get_template_part( 'template-parts/content/entry', $entry_part ); ?>

	<?php
	if ( is_singular() ) {
		get_template_part( 'template-parts/content/entry-footer' );
	}
	?>
</article>
