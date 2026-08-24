<?php
/**
 * Bootstrap file for the LechFolio theme.
 *
 * Loads small, purpose-based includes so theme behavior stays easy to scan.
 *
 * @package LechFolio
 */

$lechfolio_includes = array(
	'inc/constants.php',
	'inc/theme-setup.php',
	'inc/admin.php',
	'inc/enqueue.php',
	'inc/helpers.php',
	'inc/navigation.php',
	'inc/template-tags.php',
	'inc/comments.php',
	'inc/hooks.php',
);

foreach ( $lechfolio_includes as $lechfolio_include ) {
	require_once get_template_directory() . '/' . $lechfolio_include;
}
