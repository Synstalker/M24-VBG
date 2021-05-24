<?php

/*
 * @class: TF_DFP_Front_Body
 * @author: Jared Rethman <jared.rethman@24.com>
 */

/*
 * TODO: Make optional under configuration, Only really works when on the main query.
 */

class TF_DFP_Front_Body
{
    private $post_count = 0;
    private $iteration = 0;
    private $post_iteration = 3; //After 3rd post
    private $in_sidebar = false;

    /**
     * TF_DFP_Front_Body constructor.
     */
    function __construct()
    {
        add_action( 'loop_start', array( $this, 'get_posts_count' ) ); // Get post count
        add_action( 'the_post', array( $this, 'article_dfp' ) );
        add_action( 'loop_end', array( $this, 'sidebar' ) );
    }

    //We don't want this happening in a sidebar that uses the query
    function sidebar(){
        $this->in_sidebar = true;
    }
    function get_posts_count( $posts ){
        $this->post_count = $posts->post_count;
    }

    //Can be used to create an ad every nth article
    // DM: Interesting code. May be handy turning this into a plugin or dependancy of some kind.
    function article_dfp(){
        if( 0 !== $this->post_count && is_main_query() ) {
            if ( ( $this->post_iteration === $this->iteration && false === $this->in_sidebar ) || $this->post_iteration === $this->iteration ) {
                if ( is_active_sidebar( 'tf_dfp_category_sb' ) ) {
                    dynamic_sidebar( 'tf_dfp_category_sb' );
                }
            }
            ++$this->iteration;
        }
    }
}