<?php
global $wp_query;

$post_type = get_post_type() ?: 'post';
$args = array(
	'post_type' => $post_type,
	'orderby' => 'date',
	'order' => 'DESC',
	'post_status' => 'publish'
);
$wp_query->query_vars = wp_parse_args( $args, $wp_query->query_vars );
$wp_query = new WP_Query( $wp_query->query_vars );
$enable_masonry = ( TF_Customizer::get_option( 'entries_category_masonry' ) == true && get_post_type() == 'entry' )? 'data-uk-grid' : '';
?>
<?php if ( have_posts() ) : ?>
<div class='uk-grid uk-grid-margin uk-grid-width-large-1-3 uk-grid-width-medium-1-3 uk-grid-width-small-1-1' <?php echo $enable_masonry; ?>>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'templates/content-preview', get_post_type() ); ?>
	<?php endwhile; ?>
</div>
<?php get_template_part( 'templates/more', 'results' ); ?>

<?php else :
	get_template_part( 'templates/content', 'none' );
endif;
?>

