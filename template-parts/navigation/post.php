<?php
/**
 * Single post pagination links.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

the_post_navigation(
	array(
		'prev_text' => '<span class="meta-nav">&larr;</span> %title',
		'next_text' => '%title <span class="meta-nav">&rarr;</span>',
	)
);
