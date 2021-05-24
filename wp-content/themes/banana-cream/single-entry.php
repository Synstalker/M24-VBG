<?php
get_header();
the_post();
?>

<article class='uk-article uk-width'>

	<div class=" tf-container-inner uk-container-center">

		<?php get_template_part( 'templates/entries/single', 'header' ); ?>

		<?php get_template_part( 'templates/entries/single', 'featured-content' ); ?>

		<hr class="uk-article-divider uk-width-1-1" />


		<?php get_template_part( 'templates/entries/single', 'summary' ); ?>

		<h5><?php _e( 'About the Project', 'twentyfourdotcom'); ?></h5>


		<div id="the_excerpt" class="uk-width-1-1 toggle-me">
			<?php the_excerpt(); ?>
		</div>

		<div id="the_content" class="uk-width-1-1 uk-hidden toggle-me">
			<?php _e( strip_shortcodes( get_the_content() ) ); ?>
		</div>

		<div class="uk-margin-large-top">
			<?php _e( get_post_gallery( get_the_ID() ) ); ?>
		</div>

		<div class="uk-margin-large-top">
			<?php get_template_part( 'templates/voting', 'form' ); ?>
		</div>

	</div>

</article>


<?php //closes off the main tag from header.php ?>
</div>
</main>

<?php get_template_part( 'templates/comments/post', get_post_type() ); ?>

<?php //open the main tag here again so that it can be closed in the footer ?>
<div>
<main>

<?php get_footer();
