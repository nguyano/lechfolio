<?php
/**
 * Entry byline and publish date metadata.
 *
 * @package LechFolio
 */
?>
<div class="entry-meta">
	<span class="author vcard"<?php echo is_single() ? ' itemprop="author" itemscope itemtype="https://schema.org/Person"' : ''; ?>>
		<span<?php echo is_single() ? ' itemprop="name"' : ''; ?>><?php the_author_posts_link(); ?></span>
	</span>
	<span class="meta-sep"> | </span>
	<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" title="<?php echo esc_attr( get_the_date() ); ?>"<?php echo is_single() ? ' itemprop="datePublished" pubdate' : ''; ?>>
		<?php echo esc_html( get_the_time( get_option( 'date_format' ) ) ); ?>
	</time>
	<?php if ( is_single() ) : ?>
		<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
	<?php endif; ?>
</div>
