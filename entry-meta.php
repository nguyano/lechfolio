<?php
/**
 * Backward-compatible wrapper for entry metadata.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'template-parts/content/entry-meta' );
