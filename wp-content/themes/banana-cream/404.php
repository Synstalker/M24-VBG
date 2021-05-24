<?php get_header(); ?>

    <div class="uk-text-center">
	    <?php

	        $title = TF_Customizer::get_option( 'not_found_page_title' );

	        if( !empty( $title) ){
		     ?><h1><?php _e( $title ) ?></h1><?php
	        }

            _e( wpautop( TF_Customizer::get_option( 'not_found_page_content' ) ) );

        ?>
    </div>

<?php get_footer(); ?>
