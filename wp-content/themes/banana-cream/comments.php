<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package     24dotcom
 * @subpackage  BananaCream
 * @since       0.0.1
 *
 * @link http://codepen.io/kavendish/full/aOdopx/
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */

if ( get_post_status() != 'publish' ){
	get_template_part( 'templates/comments','unpublished-post' );
	return;
}

if ( post_password_required() ) {
	return;
}
?>

<aside id="comments" class="uk-width">

	<?php if ( have_comments() ) : ?>
		<?php get_template_part('templates/comments','title'); ?>

		<?php the_comments_navigation(); ?>

		<ul class='uk-comment-list uk-width'>
			<?php
			wp_list_comments( array(
				'style'         => 'ul',
				'walker'        => new TF_Walker_Comment,
			) );
			?>
		</ul>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
		get_template_part( 'templates/comments', 'closed' );
	}

	$comment_form_args = array(
		'class_form'            => 'uk-form uk-form-stacked',
		'title_reply_before'    => '<h5>',
		'title_reply_after'     => '</h5><hr class="uk-margin-small-top uk-margin-bottom"/>',
		'title_reply'           => __( 'Leave a message', 'twentyfourdotcom' ),
		'title_reply_to'        => __( 'Leave a message', 'twentyfourdotcom' ),
		'comment_notes_before'  => '<p class="uk-margin-large-bottom">'.__( 'Your e-mail address will not be publicised', 'twentyfourdotcom' ).'.</p>',
		'comment_field'         => TF_Template::return_template_part( 'templates/comment', 'field' ),
		'label_submit'          => __( 'Submit', 'twentyfourdotcom' ),
		'class_submit'          => 'uk-button uk-text-uppercase uk-button-large uk-button-primary uk-width-small-1-1 uk-width-large-1-3 uk-width-medium-1-3',
		'submit_button'         => '<div class="uk-text-center uk-margin-large-top"><span class="uk-button-primary"><input name="%1$s" type="submit" class="%3$s" value="%4$s" /></span></div>',
		'submit_field'          => '%1$s %2$s',
		'cancel_reply_link'     => '&nbsp;', //set to single whitespace to remove this feature
		'cancel_reply_before'   => '&nbsp;', //set to single whitespace to remove this feature
		'cancel_reply_after'    => '&nbsp;', //set to single whitespace to remove this feature
		'logged_in_as'          => '<p class="uk-margin-large-bottom">'.__( 'Your e-mail address will not be publicised', 'twentyfourdotcom' ).'.</p>',
		'fields'                => array(
			'author'    => TF_Template::return_template_part( 'templates/comment-field','author' ),
			'email'     => TF_Template::return_template_part( 'templates/comment-field','email' )
		)
	);

	comment_form( $comment_form_args );
	?>

</aside>
