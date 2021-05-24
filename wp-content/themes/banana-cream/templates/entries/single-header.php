<?php
	$voting_form_id = intval( TF_Customizer::get_option( 'voting_form_id' ) );
    $vote_count = BananaCream::get_entrant_votes_count( get_the_ID() );
?>

<div class="uk-grid uk-panel">
	<div class='uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-1'>
		<span class="uk-text-left uk-hidden-small">
			<?php the_title('<h2 class="uk-article-title uk-margin-bottom-remove">','</h2>'); ?>
			<?php if( $voting_form_id > 0 ): ?>
				<p class="uk-margin-remove"><?php _e( 'Votes' ); ?>: <?php _e($vote_count); ?></p>
			<?php endif; ?>
		</span>
		<span class="uk-text-center uk-hidden-large uk-hidden-medium">
			<?php the_title('<h2 class="uk-article-title">','</h2>'); ?>
			<?php if( $voting_form_id > 0 ): ?>
				<p><?php _e( 'Votes' ); ?>: <?php _e($vote_count); ?></p>
			<?php endif; ?>
		</span>
	</div>
	<div class='uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1'>

        <div>
            <?php get_template_part( 'templates/rating', 'form' ); ?>
        </div>
		<div class="uk-clearfix">
			<span class="uk-text-right uk-hidden-small">
				<?php get_template_part( 'templates/social/sharing', get_post_type() ); ?>
			</span>
			<span class="uk-text-center uk-hidden-large uk-hidden-medium">
				<?php get_template_part( 'templates/social/sharing', get_post_type() ); ?>
			</span>
		</div>
	</div>
</div>