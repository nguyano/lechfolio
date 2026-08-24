<?php
/**
 * Comments and pingbacks template.
 *
 * @package LechFolio
 */
?>
<div id="comments">
	<?php
	if ( have_comments() ) :
		global $comments;

		$lechfolio_comments_by_type = separate_comments( $comments );

		if ( ! empty( $lechfolio_comments_by_type['comment'] ) ) :
			?>
			<section id="comments-list" class="comments">
				<h2 class="comments-title"><?php comments_number(); ?></h2>

				<?php if ( get_comment_pages_count() > 1 ) : ?>
					<nav id="comments-nav-above" class="comments-navigation" role="navigation">
						<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
					</nav>
				<?php endif; ?>

				<ul>
					<?php wp_list_comments( 'type=comment' ); ?>
				</ul>

				<?php if ( get_comment_pages_count() > 1 ) : ?>
					<nav id="comments-nav-below" class="comments-navigation" role="navigation">
						<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
					</nav>
				<?php endif; ?>
			</section>
			<?php
		endif;

		if ( ! empty( $lechfolio_comments_by_type['pings'] ) ) :
			$ping_count = count( $lechfolio_comments_by_type['pings'] );
			?>
			<section id="trackbacks-list" class="comments">
				<h2 class="comments-title">
					<?php
					printf(
						'<span class="ping-count">%1$s</span> %2$s',
						esc_html( $ping_count ),
						esc_html(
							_nx(
								'Trackback or Pingback',
								'Trackbacks and Pingbacks',
								$ping_count,
								'comments count',
								'lechfolio'
							)
						)
					);
					?>
				</h2>
				<ul>
					<?php wp_list_comments( 'type=pings&callback=lechfolio_custom_pings' ); ?>
				</ul>
			</section>
			<?php
		endif;
	endif;

	if ( comments_open() ) {
		comment_form();
	}
	?>
</div>
