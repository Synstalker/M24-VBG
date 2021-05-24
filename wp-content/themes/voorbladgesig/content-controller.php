<?php


    if (is_singular() || is_page()) {
        if (show_page_title()) {
            the_title('<h2 class="uk-text-center">', '</h2>');
        }
    }

    if (is_archive()) {
        $title = is_category() ? single_cat_title(null, false) : post_type_archive_title(null, false); ?><h2 class='uk-text-center uk-text-uppercase uk-margin-large-bottom'><?php echo __( $title, 'twentyfourdotcom' ); ?></h2><?php

    }


    if (is_archive()) {
        ?><div class="uk-container uk-container-center"><?php
            dynamic_sidebar('archive-content-header'); ?></div><?php

    }

    if (is_page() || is_single()) {
        the_post();
        the_content();
    }
    
    if (is_category() || is_archive()) {
        get_template_part('templates/archive-content', get_post_type());
    }

