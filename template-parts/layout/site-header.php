<?php
/**
 * Site header and primary navigation shell.
 *
 * @package LechFolio
 */

$logo_class = is_user_logged_in() && lechfolio_is_frontend_request() ? 'lechfolio-logo' : 'lechfolio-logo-loggedin';
?>
<header class="lechfolio-header" role="banner">
	<div class="lechfolio-nav-container">
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
			<nav id="lechfolio-main-menu" class="lechfolio-menu">
				<?php lechfolio_primary_menu(); ?>
			</nav>

			<?php do_action( 'coshlt_theme_header_controls' ); ?>

			<div class="lechfolio-menu-toggle" id="lechfolio-menu-toggle">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
</header>
