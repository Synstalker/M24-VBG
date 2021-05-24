<?php  if( !TF_Customizer::get_option( 'comments_globally_enabled', 'boolean' ) ) return;  ?>
<div class="uk-container uk-container-center uk-block-muted">
	<div class='uk-block uk-width-1-1'>
		<div class="tf-container-inner uk-container-center">
			<?php comments_template(); ?>
		</div>
	</div>
</div>