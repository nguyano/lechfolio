<?php
/**
 * Site footer with a single copyright line and the information page links.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer id="footer" role="contentinfo" class="lechfolio-footer">
	<div class="lechfolio-footer-inner">
		<p class="lechfolio-footer-copy">
			<span class="lechfolio-footer-copyright">
				&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				<span aria-hidden="true">&middot;</span>
				<?php esc_html_e( 'All rights reserved', 'lechfolio' ); ?>
				<span aria-hidden="true">&middot;</span>
			</span>
			<span class="lechfolio-footer-credit">
				<?php esc_html_e( 'Developed by', 'lechfolio' ); ?>
				<a href="https://ngunyiyannick.com" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Ngunyi Yannick L.', 'lechfolio' ); ?></a>
			</span>
		</p>
		<nav class="lechfolio-footer-links" aria-label="<?php esc_attr_e( 'Footer', 'lechfolio' ); ?>">
			<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'lechfolio' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/faqs' ) ); ?>"><?php esc_html_e( 'FAQs', 'lechfolio' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/contributors' ) ); ?>"><?php esc_html_e( 'Contributors', 'lechfolio' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>"><?php esc_html_e( 'Contact', 'lechfolio' ); ?></a>
		</nav>
	</div>
</footer>
