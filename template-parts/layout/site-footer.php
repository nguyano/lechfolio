<?php
/**
 * Site footer markup.
 *
 * @package LechFolio
 */
?>
<footer id="footer" role="contentinfo" class="lechfolio-footer">
	<div class="lechfolio-footer-inner">
		<p class="lechfolio-footer-copy">
			<span class="lechfolio-coshlt-icon"><?php echo lechfolio_coshlt_icon( 20 ); ?></span>
			&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
			<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			<?php esc_html_e( ' All rights reserved | Shelters Connect Colorado | Developed by ', 'lechfolio' ); ?>
			<a href="https://ngunyiyannick.com" target="_blank" rel="noopener noreferrer">&nbsp;<?php esc_html_e( 'Ngunyi Yannick L.', 'lechfolio' ); ?></a>
			<span class="lechfolio-footer-links">
				<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'lechfolio' ); ?></a> /
				<a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>"><?php esc_html_e( 'Contact', 'lechfolio' ); ?></a>
			</span>
		</p>
	</div>
</footer>
