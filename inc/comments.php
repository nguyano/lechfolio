<?php
/**
 * Comment helpers for LechFolio.
 *
 * @package LechFolio
 */

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
 * @param int $count Existing comment count.
 * @return int
 */
function lechfolio_comment_count( $count ) {
	if ( is_admin() ) {
		return $count;
	}

	$get_comments     = get_comments(
		array(
			'status'  => 'approve',
			'post_id' => get_the_ID(),
		)
	);
	$comments_by_type = separate_comments( $get_comments );

	return isset( $comments_by_type['comment'] ) ? count( $comments_by_type['comment'] ) : 0;
}
