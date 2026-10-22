<?php
/**
 * Backward-compatible wrapper for archive pagination.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'template-parts/navigation/posts' );
