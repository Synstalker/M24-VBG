<?php $voting_form_id = intval( TF_Customizer::get_option( 'voting_form_id' ) );
	if( $voting_form_id <= 0 || !TF_Customizer::get_option( 'voting_is_enabled' ) ) return;
?>
<div class="uk-text-center">
	<a href="#voting_modal" class='uk-button uk-button-primary uk-text-uppercase uk-button-large uk-width-small-1-1 uk-width-large-1-3 uk-width-medium-1-3' data-uk-modal><?php _e('Vote','twentyfourdotcom'); ?></a>
</div>
<div id="voting_modal" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<?php
			if( $voting_form_id <= 0 ){
				get_template_part( 'templates/voting-form', 'unavailable' );
			}else{
				echo do_shortcode('[gravityform id="'.$voting_form_id.'" title="false" description="false" ajax="'.TF_Customizer::get_option( 'voting_form_is_ajax', 'boolean_string' ).'"]');
			}
		?>
	</div>
</div>
