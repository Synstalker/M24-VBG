<?php
	$name = get_post_meta( get_the_ID(), 'NAME' ) ? get_post_meta( get_the_ID(), 'NAME' )[0] : '';
	$surname = get_post_meta( get_the_ID(), 'SURNAME' ) ? get_post_meta( get_the_ID(), 'SURNAME' )[0] : '';
	$budget = get_post_meta( get_the_ID(), 'BUDGET TOTAL' ) ? get_post_meta( get_the_ID(), 'BUDGET TOTAL' )[0] : '';
?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<span class="uk-text-bold uk-margin-small-right"><?php _e( 'Name', 'twentyfourdotcom' ); ?>:</span><span><?php _e( $name ); ?></span>
	</div>
	<div class="uk-width-1-1 uk-margin-small-top">
		<span class="uk-text-bold uk-margin-small-right"><?php _e( 'Surname', 'twentyfourdotcom' ); ?>:</span><span><?php _e( $surname ); ?></span>
	</div>
	<div class="uk-width-1-1 uk-margin-small-top">
		<span class="uk-text-bold uk-margin-small-right"><?php _e( 'Budget', 'twentyfourdotcom' ); ?>:</span><span><?php _e( $budget ); ?></span>
	</div>
	<div class="uk-width-1-1 uk-margin-small-top">
		<span class="uk-text-bold uk-margin-small-right"><?php _e( 'Entry Date', 'twentyfourdotcom' ); ?>:</span><span><?php the_date(); ?></span>
	</div>
	<div class="uk-width-1-1 uk-margin-small-top">
		<span class="uk-text-bold uk-margin-small-right"><?php _e( 'Category' ); ?>:</span><span><?php the_category(', '); ?></span>
	</div>
</div>