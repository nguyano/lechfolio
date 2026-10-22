<?php
/**
 * Backward-compatible wrapper for single post pagination.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'template-parts/navigation/post' );
