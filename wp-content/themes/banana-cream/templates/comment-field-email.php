<?php
	$req        = get_option( 'require_name_email' );
	$label_req  = $req ? ' <span class="required">*</span>' : '';
	$aria_req   = $req ? " aria-required='true'" : null;
	$commenter  = wp_get_current_commenter();
	$html5      = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	$input_type = $html5 == 'html5' ? 'type="email"' : 'type="text"';
?>
<div class="uk-form-row">
	<label class="uk-form-label" for="email" >
		<?php _e( 'Email', 'twentyfourdotcom' ); ?><?php _e( $label_req ); ?>
	</label>
	<div class="uk-form-controls">
		<input <?php _e( $input_type ); ?> name="email" <?php _e( $aria_req ); ?> value="<?php _e( esc_attr(  $commenter['comment_author_email'] ) ); ?>" class="uk-width-1-1"/>
	</div>
</div>