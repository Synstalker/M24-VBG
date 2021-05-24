<?php
get_header();
the_post();
?>

<article class='uk-article uk-width'>

	<div class=" tf-container-inner uk-container-center">

		<?php get_template_part('templates/entries/single', 'header'); ?>

		<?php get_template_part('templates/entries/single', 'featured-content'); ?>

		<hr class="uk-article-divider uk-width-1-1" />

		<?php get_template_part('templates/entries/single', 'summary'); ?>

		<div class="uk-margin-large-top">
			<?php get_template_part('templates/voting', 'form'); ?>
		</div>

	</div>

</article>


<?php //closes off the main tag from header.php?>
</div>
</main>

<?php get_template_part('templates/comments/post', get_post_type()); ?>

<?php //open the main tag here again so that it can be closed in the footer?>
<div>
<main>

<?php get_footer();
