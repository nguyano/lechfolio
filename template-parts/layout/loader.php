<?php
/**
 * Loader overlay markup.
 *
 * Plugins can replace the default spinner with their own figure through the
 * `lechfolio_loader_markup` filter (Coshelters supplies its "build" mark).
 * The overlay, status role and hide/show behaviour stay with the theme.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lechfolio_loader_figure = (string) apply_filters( 'lechfolio_loader_markup', '' );
$lechfolio_loader_shape  = array(
	'class'       => true,
	'aria-hidden' => true,
);
$lechfolio_loader_allowed = array(
	'span'   => $lechfolio_loader_shape,
	'i'      => $lechfolio_loader_shape,
	'svg'    => $lechfolio_loader_shape + array(
		'viewbox'   => true,
		'focusable' => true,
	),
	'circle' => $lechfolio_loader_shape + array(
		'cx'           => true,
		'cy'           => true,
		'r'            => true,
		'fill'         => true,
		'stroke'       => true,
		'stroke-width' => true,
	),
	'path'   => $lechfolio_loader_shape + array(
		'd'    => true,
		'fill' => true,
	),
);
?>
<div id="lechfolio-loader" class="lechfolio-loader-overlay<?php echo '' !== $lechfolio_loader_figure ? ' lechfolio-loader-overlay--custom' : ''; ?>" role="status">
	<?php if ( '' !== $lechfolio_loader_figure ) : ?>
		<?php echo wp_kses( $lechfolio_loader_figure, $lechfolio_loader_allowed ); ?>
	<?php else : ?>
		<div class="lechfolio-loader-spinner" aria-hidden="true"></div>
	<?php endif; ?>
	<span class="screen-reader-text"><?php esc_html_e( 'Loading...', 'lechfolio' ); ?></span>
</div>
