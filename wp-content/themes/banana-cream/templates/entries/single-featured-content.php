<?php
$before_photo_1 = get_the_post_thumbnail( get_the_ID(), 'medium', array( 'class' => 'uk-panel uk-container-center' ) );

// added in check
// cause in some cases the featured image is not being set when the post is created
if( !$before_photo_1) {
	$before_photo_1_html    = '<img class="uk-panel uk-container-center wp-post-image" src="%1$s" />';
	$before_photo_1_url     = get_post_meta( get_the_ID(), 'Before Photo 1' ) ? get_post_meta( get_the_ID(), 'Before Photo 1' )[0] : BananaCream::get_missing_image_url();
	$before_photo_1         = sprintf( $before_photo_1_html, $before_photo_1_url );
}

$after_photo_1 = get_post_meta( get_the_ID(), 'After Photo 1' ) ? get_post_meta( get_the_ID(), 'After Photo 1' )[0] : BananaCream::get_missing_image_url();
?>
<div id="before_after_images" class="uk-grid uk-panel uk-margin-top uk-margin-large-bottom uk-grid-match" data-uk-grid-match="{target:'.uk-panel'}">
	<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-text-center">
		<div href="<?php the_post_thumbnail_url( 'full' ); ?>" data-uk-lightbox="{group:'before_after'}">
			<?php _e( $before_photo_1 ); ?>
			<div class="uk-h4 uk-text-bold uk-margin-top uk-text-uppercase">
				<?php _e( 'Before', 'twentyfourdotcom' ); ?>
				<div class="uk-hidden-large uk-hidden-medium uk-margin-large-bottom"></div>
			</div>
		</div>
	</div>

	<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-text-center">
		<div href="<?php _e( $after_photo_1 ); ?>" data-uk-lightbox="{group:'before_after'}">
			<img class="uk-panel uk-container-center" src="<?php _e( $after_photo_1 ); ?>" />
			<div class="uk-h4 uk-text-bold uk-margin-top uk-text-uppercase"><?php _e( 'After', 'twentyfourdotcom' ); ?></div>
		</div>
	</div>
</div>