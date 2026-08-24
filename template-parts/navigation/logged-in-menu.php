<?php
/**
 * Logged-in Coshelters navigation menu.
 *
 * @package LechFolio
 */

$nav_items        = isset( $args['nav_items'] ) && is_array( $args['nav_items'] ) ? $args['nav_items'] : array();
$current_endpoint = isset( $args['current_endpoint'] ) ? sanitize_key( $args['current_endpoint'] ) : '';
$current_path     = isset( $args['current_path'] ) ? trim( (string) $args['current_path'], '/' ) : '';
?>
<ul class="lechfolio-menu-list">
	<?php foreach ( $nav_items as $item ) : ?>
		<?php if ( ( $item['type'] ?? 'link' ) === 'link' ) : ?>
			<?php
			$item_path = trim( (string) parse_url( $item['href'], PHP_URL_PATH ), '/' );
			$is_active = ( isset( $item['endpoint'] ) && $item['endpoint'] === $current_endpoint ) || ( $item_path && $item_path === $current_path );
			?>
			<li class="lechfolio-menu-item" id="<?php echo esc_attr( $item['id'] ); ?>">
				<a
					id="<?php echo esc_attr( $item['id'] . 'Link' ); ?>"
					class="lechfolio-menu-link <?php echo $is_active ? 'active' : ''; ?>"
					href="<?php echo esc_url( $item['href'] ); ?>"
					<?php echo $is_active ? 'aria-current="page"' : ''; ?>
				>
					<i class="fa-solid <?php echo esc_attr( $item['icon'] ); ?> fa-lg"></i>
					<?php echo esc_html( $item['label'] ); ?>
				</a>
			</li>
		<?php elseif ( isset( $item['type'] ) && 'add_shelter' === $item['type'] ) : ?>
			<li class="lechfolio-menu-item">
				<a class="lechfolio-menu-button lechfolio-add-shelter-btn" href="<?php echo esc_url( $item['href'] ); ?>">
					<i class="fa-solid <?php echo esc_attr( $item['icon'] ); ?> fa-lg"></i>
					<?php echo esc_html( $item['label'] ); ?>
				</a>
			</li>
		<?php elseif ( isset( $item['type'] ) && 'dropdown' === $item['type'] ) : ?>
			<li class="lechfolio-nav-item lechfolio-dropdown" id="<?php echo esc_attr( $item['id'] ); ?>">
				<a class="lechfolio-dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" href="#">
					<?php echo lechfolio_coshlt_image( $item['user_img'], 35, 'lechfolio-avatar' ); ?>
					<?php echo esc_html( $item['username'] ); ?>
					<i class="fa-solid fa-chevron-down lechfolio-dropdown-icon"></i>
				</a>

				<div class="lechfolio-dropdown-menu">
					<?php foreach ( $item['items'] as $subitem ) : ?>
						<?php if ( ! empty( $subitem['divider'] ) ) : ?>
							<div class="lechfolio-dropdown-divider"></div>
						<?php else : ?>
							<a
								class="lechfolio-dropdown-item"
								href="<?php echo esc_url( $subitem['href'] ); ?>"
								<?php echo isset( $subitem['id'] ) ? 'id="' . esc_attr( $subitem['id'] ) . '"' : ''; ?>
							>
								<i class="<?php echo esc_attr( $subitem['icon'] ); ?>"></i>
								<?php echo esc_html( $subitem['label'] ); ?>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
