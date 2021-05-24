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
$thumbnail_class = 'uk-thumbnail';
$thumbnail_size = 'medium';
$thumbnail_url = get_the_post_thumbnail_url(null, $thumbnail_size) ?: BananaCream::get_missing_image_url();
?>

widget preview ?
<div class="uk-text-center uk-margin-small-bottom">
	<div id='post-<?php the_ID(); ?>' <?php post_class('uk-article uk-overlay uk-overlay-hover uk-cover-background'); ?> style='background-image:url("<?php _e($thumbnail_url); ?>");'>
		<img class='uk-thumbnail uk-invisible' src='<?php _e($thumbnail_url); ?>' />
		<div class='uk-overlay-panel uk-overlay-fade uk-overlay-background uk-text-center uk-padding-remove'>
			<span>
				<span class='uk-h4'><?php the_title(null, null, true); ?></span>
				<div class='uk-contrast'>
					<hr class='uk-margin-small-top'/>
				</div>
			</span>
		</div>
		<a class='uk-position-cover' href='<?php the_permalink(); ?>'></a>
	</div>
</div>
