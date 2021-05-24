<?php if ( is_active_sidebar( 'frontpage-footer-sidebar' ) && is_front_page() ) : ?>
<div  class="uk-container uk-container-center uk-text-center uk-text-uppercase ">
	<?php dynamic_sidebar( 'frontpage-footer-sidebar' ); ?>
</div>

<?php endif; ?>
</main>
	</div>
	<?php get_template_part( 'templates/footer/text', get_post_type() ); ?>
	<?php wp_footer(); ?>
</body>
</html>
