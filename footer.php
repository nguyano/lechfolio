<?php
/**
 * Closing layout and document footer for LechFolio.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
		</main>

		<?php get_template_part( 'template-parts/layout/site-footer' ); ?>
	</div>

	<?php wp_footer(); ?>
</body>
</html>
