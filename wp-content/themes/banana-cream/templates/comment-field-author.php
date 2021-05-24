<?php
	$req        = get_option( 'require_name_email' );
	$label_req  = $req ? ' <span class="required">*</span>' : '';
	$aria_req   = $req ? " aria-required='true'" : null;
	$html_req   = $req ? " required='required'" : null;
	$commenter  = wp_get_current_commenter();
?>

<div class="uk-form-row">
	<label class="uk-form-label" for="author">
		<?php _e( 'Name', 'twentyfourdotcom' ); ?>
		<?php _e( $label_req ) ?>
	</label>
	<div class="uk-form-controls">
		<input name="author" type="text" class="uk-width-1-1" <?php _e( $aria_req ); ?> <?php _e( $html_req ); ?> value="<?php _e( esc_attr( $commenter['comment_author'] ) ); ?>" />
	</div>
</div>