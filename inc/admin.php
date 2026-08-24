<?php
/**
 * Admin-only helpers for the LechFolio theme.
 *
 * Adds internal developer documentation entry points to WordPress admin screens.
 *
 * @package LechFolio
 */

/**
 * Returns the internal LechFolio developer documentation URL.
 *
 * @since 1.0.0
 *
 * @return string
 */
function lechfolio_documentation_url() {
	return 'https://dev.sheltersconnectcolorado.com/docs/lechfolio';
}

/**
 * Adds the documentation link to WordPress theme action link lists.
 *
 * @since 1.0.0
 *
 * @param array $actions Existing theme action links.
 * @return array
 */
function lechfolio_theme_action_links( $actions ) {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return $actions;
	}

	$actions['lechfolio_documentation'] = sprintf(
		'<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>',
		esc_url( lechfolio_documentation_url() ),
		esc_html__( 'Documentation', 'lechfolio' )
	);

	return $actions;
}

/**
 * Prints a small themes-screen fallback link for the grid interface.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_print_themes_screen_docs_link() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$documentation_url = lechfolio_documentation_url();
	$stylesheet        = get_stylesheet();
	$theme_name        = wp_get_theme()->get( 'Name' );
	?>
	<script>
	(function () {
		var docsUrl = <?php echo wp_json_encode( esc_url_raw( $documentation_url ) ); ?>;
		var docsLabel = <?php echo wp_json_encode( __( 'Documentation', 'lechfolio' ) ); ?>;
		var stylesheet = <?php echo wp_json_encode( $stylesheet ); ?>;
		var themeName = <?php echo wp_json_encode( $theme_name ); ?>;

		function buildLink(className) {
			var link = document.createElement('a');

			link.className = className || 'button button-secondary lechfolio-documentation-link';
			link.href = docsUrl;
			link.target = '_blank';
			link.rel = 'noopener noreferrer';
			link.textContent = docsLabel;

			return link;
		}

		function hasDocsLink(container) {
			return container && container.querySelector('.lechfolio-documentation-link');
		}

		function addLinkToThemeCard() {
			var theme = document.querySelector('.theme.active[data-slug="' + stylesheet + '"]') || document.querySelector('.theme.active');
			var actions = theme ? theme.querySelector('.theme-actions') : null;

			if (actions && !hasDocsLink(actions)) {
				actions.appendChild(buildLink());
			}
		}

		function addLinkToThemeDetails() {
			var overlay = document.querySelector('.theme-overlay');
			var actions = overlay ? overlay.querySelector('.theme-actions') : null;
			var name = overlay ? overlay.querySelector('.theme-name') : null;

			if (!actions || hasDocsLink(actions) || !name || name.textContent.trim() !== themeName) {
				return;
			}

			actions.appendChild(buildLink('button button-secondary lechfolio-documentation-link'));
		}

		addLinkToThemeCard();
		addLinkToThemeDetails();

		new MutationObserver(function () {
			addLinkToThemeCard();
			addLinkToThemeDetails();
		}).observe(document.body, { childList: true, subtree: true });
	}());
	</script>
	<?php
}
