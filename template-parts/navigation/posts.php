<?php
/**
 * Archive/search pagination links.
 *
 * @package LechFolio
 */

the_posts_navigation(
	array(
		'prev_text' => sprintf(
			/* translators: %s: Left arrow indicator. */
			esc_html__( '%s older', 'lechfolio' ),
			'<span class="meta-nav">&larr;</span>'
		),
		'next_text' => sprintf(
			/* translators: %s: Right arrow indicator. */
			esc_html__( 'newer %s', 'lechfolio' ),
			'<span class="meta-nav">&rarr;</span>'
		),
	)
);
