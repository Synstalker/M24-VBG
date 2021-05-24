<?php
/**
 * post preview block
 * Used on category pages, archive pages, search results
 *
 * @link https://getuikit.com/docs/overlay.html
 *
 * @package 24dotcom
 * @subpackage BananaCream
 * @since 3.25.2
 */
$thumbnail_class    = 'uk-thumbnail';

/**
 * The ideal image sizes we want, in order of most desired to least desired...
 */
$ideal_image_sizes  =   [
    'tf_portrait_medium' => [
        'width' => 480,
        'height' => 640
    ],
    'tf_portrait_small' => [
        'width' => 240,
        'height' => 320
    ],
    'tf_portrait_xsmall' => [
        'width' => 120,
        'height' => 160
    ]
];

// Set flag to false to start with
$image_check = false;

/**
 * Loop through the above image sizes, and compare actual src dimensions with desired dimensions. Once we have a true match, continue...
 */
foreach( $ideal_image_sizes as $image_size => $image_dimensions ){
    $image_check = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
    if( $image_check[1] == $image_dimensions['width'] && $image_check[2] == $image_dimensions['height'] ){
        $thumbnail_url = $image_check[0];
        break;
    }
};

// Finally, if we did not get a match above, set it to the missins image...
$thumbnail_url = $thumbnail_url ?: BananaCream::get_missing_image_url();

?>
<div class="uk-text-center uk-margin-small-bottom">
	<div id='post-<?php the_ID(); ?>' <?php post_class( 'uk-article uk-overlay uk-overlay-hover uk-cover-background' ); ?> style='background-image:url("<?php _e( $thumbnail_url ); ?>");'>
		<img class='uk-thumbnail uk-invisible' src='<?php _e( $thumbnail_url ); ?>' style="min-width:280px;height:auto;" />
		<div class='uk-overlay-panel uk-overlay-fade uk-overlay-background uk-text-center'>
			<span>
				<span class='uk-h4'><?php the_title( null, null, true); ?></span>
				<div class='uk-contrast'>
					<hr class='uk-margin-small-top'/>
				</div>
			</span>
		</div>
		<a class='uk-position-cover' href='<?php the_permalink(); ?>'></a>
	</div>
</div>
