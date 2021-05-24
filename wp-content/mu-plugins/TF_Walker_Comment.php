<?php

/**
 * Comment API: Walker_Comment class
 *
 * @package 24dotcom
 * @subpackage tf-core
 * @since 1.0.0
 */

/**
 * TF Core walker class used to create an HTML list of comments.
 * extends the original Walker Comment Class
 *
 * @see Walker_Comment
 */
class TF_Walker_Comment extends Walker_Comment {

	public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;

		ob_start();
		$this->html5_comment( $comment, $depth, $args );
		$output .= ob_get_clean();
	}

	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		//do nothing
	}


	protected function comment( $comment, $depth, $args ) {
		TF_Debug::log( 'This theme does not support html5 comments' );
	}

	protected function html5_comment( $comment, $depth, $args ) {

		$comment_reply_link = get_comment_reply_link( array_merge( $args, array(
			'depth'         => $depth,
			'max_depth'     => $args['max_depth'],
			'before'        => '',
			'after'         => '',
			'avatar_size'   => 40,
			'style'         => 'ul'
		) ) );

		$comment_reply_link = TF_Template::modify_css_class( $comment_reply_link );

		$author_avatar_url =  0 != $args['avatar_size'] ? get_avatar_url( $comment, $args['avatar_size'] ) : null;
		?>
			<li id="comment-<?php comment_ID(); ?>" class="uk-comment uk-width-1-1">
				<div class="uk-comment-avatar" style="background-image:url('<?php _e( $author_avatar_url ); ?>');"></div>
				<div class="uk-grid uk-grid-small">
					<h5 class="uk-comment-header uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
						<?php comment_author( $comment ); ?>
					</h5>
					<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-comment-meta">
						<?php printf( __( '%1$s @ %2$s %3$s' ), __( get_comment_date( 'M ', $comment ), 'twentyfourdotcom' ), get_comment_date( 'd, Y', $comment ), get_comment_time( 'h:m A' ) );?>
					</div>
				</div>

				<div class="uk-margin-large-top uk-comment-body uk-width-1-1">
					<?php comment_text(); ?>
					<div class="uk-comment-meta uk-text-right">
						<?php _e( $comment_reply_link, 'twentyfourdotcom' ); ?>
					</div>
				</div>


			</li>
		<?php
	}

}
