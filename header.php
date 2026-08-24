<?php
/**
 * Site header for the LechFolio container theme.
 *
 * Outputs the document head, compact navigation shell, and shared content area.
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

  <!-- LechFolio Loader -->
  <div id="lechfolio-loader" class="lechfolio-loader-overlay">
    <div class="lechfolio-loader-spinner" role="status">
      <span class="screen-reader-text"><?php esc_html_e( 'Loading...', 'lechfolio' ); ?></span>
    </div>
  </div>

  <div id="wrapper" class="hfeed">
    <header class="lechfolio-header" role="banner">
  <div class="lechfolio-nav-container">
    <!-- Logo / Site Title -->
	<?php $logo_class = is_user_logged_in() && lechfolio_is_frontend_request() ? 'lechfolio-logo' : 'lechfolio-logo-loggedin'; ?>
    <a class="<?php echo esc_attr( $logo_class ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
      <?php
      if ( has_custom_logo() ) {
        echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'custom-logo' ) );
      } else {
        echo esc_html( get_bloginfo( 'name' ) );
      }
      do_action( 'coshlt_theme_header_logo_after' );
      ?>
    </a>

    <div class="lechfolio-header-actions">
      <!-- Menu -->
      <nav id="lechfolio-main-menu" class="lechfolio-menu">
        <?php lechfolio_primary_menu(); ?>
      </nav>

      <?php do_action( 'coshlt_theme_header_controls' ); ?>

      <!-- Hamburger Toggler -->
      <div class="lechfolio-menu-toggle" id="lechfolio-menu-toggle">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
</header>

<main id="content" class="lechfolio-site-main lechfolio-content-wrapper" role="main">
