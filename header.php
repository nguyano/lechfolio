<?php
/**
 * Site document head and opening layout for LechFolio.
 *
 * @package LechFolio
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php lechfolio_schema_type(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php get_template_part( 'template-parts/layout/loader' ); ?>

	<div id="wrapper" class="hfeed">
		<?php get_template_part( 'template-parts/layout/site-header' ); ?>

		<main id="content" class="lechfolio-site-main lechfolio-content-wrapper" role="main">
