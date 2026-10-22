<?php
/**
 * Theme constants for LechFolio.
 *
 * Centralizes filesystem and URL references used by the theme includes.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LECHFOLIO_VERSION' ) ) {
	define( 'LECHFOLIO_VERSION', '1.0.0' );
}

if ( ! defined( 'LECHFOLIO_DIR' ) ) {
	define( 'LECHFOLIO_DIR', get_template_directory() );
}

if ( ! defined( 'LECHFOLIO_URI' ) ) {
	define( 'LECHFOLIO_URI', get_template_directory_uri() );
}

if ( ! defined( 'LECHFOLIO_INC' ) ) {
	define( 'LECHFOLIO_INC', trailingslashit( LECHFOLIO_DIR ) . 'inc/' );
}
