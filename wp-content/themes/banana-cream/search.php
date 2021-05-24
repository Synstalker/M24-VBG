<?php get_header(); ?>
<header>
	<h1><?php _e( 'Search Results for', 'twentyfourdotcom' ) ?>:&nbsp;<span><?php _e( esc_html( get_search_query() ) ); ?></span></h1>
</header>
<?php get_template_part( 'templates/content', 'controller' ); ?>

<?php get_footer(); ?>