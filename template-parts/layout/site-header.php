<?php
/**
 * Site header with an accessible mobile navigation toggle.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$logo_class = is_user_logged_in() && lechfolio_is_frontend_request() ? 'lechfolio-logo' : 'lechfolio-logo-loggedin';
// Coshelters pages replace the dropdown with a drawer that floats in from the left.
$has_drawer = (bool) apply_filters( 'coshlt_theme_mobile_drawer', false );
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

			<?php if ( $has_drawer ) : ?>
				<button type="button" class="lechfolio-menu-toggle lechfolio-menu-toggle--drawer" id="lechfolio-menu-toggle" aria-controls="coshlt-m-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'lechfolio' ); ?>" data-coshlt-m-menu-open>
					<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h10"/></svg>
				</button>
			<?php else : ?>
				<button type="button" class="lechfolio-menu-toggle" id="lechfolio-menu-toggle" aria-controls="lechfolio-main-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle main menu', 'lechfolio' ); ?>">
					<span></span>
					<span></span>
					<span></span>
				</button>
			<?php endif; ?>
		</div>
	</div>
</header>
<?php
if ( $has_drawer ) {
	do_action( 'coshlt_theme_mobile_menu' );
}
