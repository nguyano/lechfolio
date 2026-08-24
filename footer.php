<?php
/**
 * Site footer for the LechFolio container theme.
 *
 * Closes the shared content area and renders a compact footer.
 */
?>
</main>

<footer id="footer" role="contentinfo" class="lechfolio-footer">
  <div class="lechfolio-footer-inner">
    <p class="lechfolio-footer-copy">
     <span class="lechfolio-coshlt-icon"><?php echo lechfolio_coshlt_icon(20); ?></span> &copy; <?php echo  esc_html( date_i18n( __( 'Y', 'lechfolio' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ) . esc_html__( ' All rights reserved | Shelters Connect Colorado | Developed by ', 'lechfolio' ); ?> <a href="https://ngunyiyannick.com" target="_blank" rel="noopener noreferrer"> &nbsp;Ngunyi Yannick L.</a> <span class="lechfolio-footer-links"><a href="<?= esc_url( home_url( '/about' ) ); ?>"><?= esc_html__( 'About', 'lechfolio' ); ?></a> / <a href="<?= esc_url( home_url( '/contact-us' ) ); ?>"><?= esc_html__( 'Contact', 'lechfolio' ); ?></a></span>
    </p>
  </div>
</footer>

</div> <!-- End of #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
