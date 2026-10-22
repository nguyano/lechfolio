<?php
/**
 * Comment rendering and bounded, post-specific counts for LechFolio.
 *
 * @package LechFolio
 */

// Theme files must only run inside WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues threaded comment replies when enabled.
 *
 * @since 1.0.0
 *
 * @return void
 */
function lechfolio_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Renders a compact pingback list item.
 *
 * @since 1.0.0
 *
 * @param WP_Comment $comment Current comment object.
 * @return void
 */
function lechfolio_custom_pings( $comment ) {
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?></li>
	<?php
}

/**
 * Counts only approved regular comments on the front end.
 *
 * @since 1.0.0
 *
 * @param int $count   Existing comment count.
 * @param int $post_id Post whose comments are being counted.
 * @return int
 */
function lechfolio_comment_count( $count, $post_id = 0 ) {
	$post_id = absint( $post_id ?: get_the_ID() );
	if ( is_admin() || ! $post_id ) {
		return $count;
	}

	return (int) get_comments(
		array(
			'status'  => 'approve',
			'post_id' => $post_id,
			'type'    => 'comment',
			'count'   => true,
		)
	);
}
