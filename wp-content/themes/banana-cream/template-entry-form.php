<?php
/*
	Template Name: Entry Form Page
 */
get_header();
the_post();
?>

<div class="tf-container-inner uk-container-center">
	<?php  the_content(); ?>
</div>

	<?php //closes off the main tag from header.php ?>
	</div></main>
	<div class="uk-container uk-container-center uk-block-muted">
		<div class='uk-block uk-width-1-1'>
			<div class="tf-container-inner uk-container-center">
				<?php get_template_part( 'templates/entry-form' ); ?>
			</div>
		</div>
	</div>
	<?php //open the main tag here again so that it can be closed in the footer ?>
	<div><main>

<?php get_footer();
