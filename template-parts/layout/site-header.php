<?php
/**
 * Site header with an accessible mobile navigation toggle.
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
			<nav id="lechfolio-main-menu" class="lechfolio-menu" aria-label="<?php esc_attr_e( 'Main menu', 'lechfolio' ); ?>" data-submenu-label="<?php esc_attr_e( 'Submenu for', 'lechfolio' ); ?>">
				<?php lechfolio_primary_menu(); ?>
			</nav>

			<?php do_action( 'coshlt_theme_header_controls' ); ?>

			<button type="button" class="lechfolio-menu-toggle" id="lechfolio-menu-toggle" aria-controls="lechfolio-main-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle main menu', 'lechfolio' ); ?>">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</div>
</header>
