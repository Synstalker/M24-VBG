<?php

/*
 * @class: TF_DFP_Load
 * @author: Jared Rethman <jared.rethman@24.com>
 */

if ( !defined( 'ABSPATH' ) )
    die( '-1' );

class TF_DFP_Load
{
    public function init()
    {
        //TODO: Add to TF Core - Need to remove
        global $tf_device_detect;
        if( !class_exists('Mobile_Detect') ){
            require_once( TF_DFP_CLASS_PATH . 'Mobile-Detect' . DIRECTORY_SEPARATOR . 'Mobile_Detect.php');
            $tf_device_detect = class_exists( 'Mobile_Detect' ) ? new Mobile_Detect : wp_is_mobile();
        }else{
            $tf_device_detect = new Mobile_Detect;
        }

        //Admin
        if(is_admin()) {
            require_once( TF_DFP_CLASS_PATH . 'TF_DFP_Admin.php');
            if (class_exists('TF_DFP_Admin')) {
                new TF_DFP_Admin();
            }
        }else {
            require_once(  TF_DFP_CLASS_PATH . 'TF_DFP_Front.php' );
            if (class_exists('TF_DFP_Front')) {
                new TF_DFP_Front();
            }
        }

        //Remove admin bar items
        if( !current_user_can('manage_options') && current_user_can('manage_dfp' )) {
            add_action('admin_bar_menu', array( $this,'admin_bar'), 9999);

        }

        add_action('widgets_init', array($this, 'widget_sidebar'));
        add_action('admin_init', array($this, 'add_role'));
    }

    public function activate_plugin(){}

    public function deactivate_plugin(){
        remove_role('dfp_admin');
    }

    static function add_role(){

        add_role('dfp_admin', 'DFP Admin', array('edit_theme_options' => true, 'read' => true, 'level_0' => true));
        $dfp_role = get_role('dfp_admin');
        $admin_role = get_role('administrator');

        //Add capabilities
        $dfp_role->add_cap('manage_dfp');
        $admin_role->add_cap('manage_dfp');
    }

    function get_data(){
        include( TF_DFP_CLASS_PATH . 'TF_DFP_Data_Factory.php' );
        if ( class_exists('TF_DFP_Data_Factory') ) {
            new TF_DFP_Data_Factory();
        }
    }
    function widget_sidebar(){

        require_once( TF_DFP_CLASS_PATH . 'TF_DFP_Widget.php' );

        if( class_exists('TF_DFP_Widget') ) {

            //Register Widget
            register_widget('TF_DFP_Widget');

            //Register special ads Sidebar
            register_sidebar(array(
                'name' => __('24 DFP Special Ads', TF_DFP_NAME),
                'id' => 'tf_dfp_sb',
                'class' => 'tf_dfp_sb',
                'description' => __('This sidebar is specifically for DFP Ads that do not require exact placement i.e. Out of Page, Take Over or Transitional ad.', TF_DFP_NAME),
                'before_widget' => '<div id="%1$s" class="%2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widgettitle">',
                'after_title' => '</h2>',
            ));
            //Register header ad
            register_sidebar(array(
                'name' => __('24 DFP Header', TF_DFP_NAME),
                'id' => 'tf_dfp_head_sb',
                'class' => 'tf_dfp_head_sb',
                'description' => __('This sidebar is specifically for Leaderboard DFP Ads i.e. 728x90 or 980x90.', TF_DFP_NAME),
                'before_widget' => '<div id="%1$s" class="%2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widgettitle">',
                'after_title' => '</h2>',
            ));
            //Register header ad
            register_sidebar(array(
                'name' => __('24 DFP Articles listing', TF_DFP_NAME),
                'id' => 'tf_dfp_artlist_sb',
                'class' => 'tf_dfp_artlist_sb',
                'description' => __('This sidebar is specifically for DFP ads that will appear after every \'nth\' article when listing articles.', TF_DFP_NAME),
                'before_widget' => '<div class="post">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widgettitle">',
                'after_title' => '</h2>',
            ));

        }else{

            $current_user = wp_get_current_user();
            wp_die( __( '<div class="wrap"><h1>' . __('24 DFP:', TF_DFP_NAME) . '</h1><div class="notice notice-error"><p>' . __(' Widget and Sidebar could not be loaded, please contact ', TF_DFP_NAME) . ' <a href="mailto:24.COMOpenSourceDevTeam@ds.naspers.com?subject=24 DFP widgets/sidebar error - ' . site_url() . ' / by ' . $current_user->user_login . '">' . __('Admin', TF_DFP_NAME) . '</a>.</p></div></div>' ) );

        }
    }
    function admin_bar( $wp_admin_bar ){

        $nodes = $wp_admin_bar->get_nodes();
        foreach( $nodes as $node )
        {
            if( !$node->parent || 'top-secondary' == $node->parent )
            {
                $wp_admin_bar->remove_menu( $node->id );
            }
        }

        $wp_admin_bar->add_menu(array('id' => 'tf_dfp_admin_bar', 'title' => '<img src="' . TF_DFP_URL . 'assets/images/doubleclick.svg" style="padding:9px 5px 0 0; float:left;"> 24 DFP', 'href' => admin_url('admin.php?page=' . TF_DFP_NAME . '_configuration')));

        $wp_admin_bar->add_menu( array(
            'parent' => TF_DFP_NAME . '_admin_bar',
            'id' => TF_DFP_NAME . '_configuration',
            'title' => __('Config', TF_DFP_NAME),
            'href' => admin_url('admin.php?page=' . TF_DFP_NAME . '_configuration')
        ));
        $wp_admin_bar->add_menu( array(
            'parent' => TF_DFP_NAME . '_admin_bar',
            'id' => TF_DFP_NAME . '_codes',
            'title' => __('Codes', TF_DFP_NAME),
            'href' => admin_url('admin.php?page=' . TF_DFP_NAME . '_ad_units')
        ));
        $wp_admin_bar->add_menu( array(
            'parent' => TF_DFP_NAME . '_admin_bar',
            'id' => TF_DFP_NAME . '_zones',
            'title' => __('Zones', TF_DFP_NAME),
            'href' => admin_url('admin.php?page=' . TF_DFP_NAME . '_zones')
        ));
        $wp_admin_bar->add_menu( array(
            'parent' => TF_DFP_NAME . '_admin_bar',
            'id' => TF_DFP_NAME . '_import',
            'title' => __('Import', TF_DFP_NAME),
            'href' => admin_url('admin.php?page=' . TF_DFP_NAME . '_import')
        ));

        //Standard WP profile/admin helpers
        if( is_admin() ) {
            $wp_admin_bar->add_menu(array(
                'id' => 'go_to_site_or_admin',
                'title' => __( 'Visit Site', TF_DFP_NAME ),
                'href' => site_url()
            ));
        }
        $title_logout = is_admin() ? 'Logout' : 'Profile';
        $url_logout = is_admin() ? wp_logout_url() : get_edit_profile_url( get_current_user_id() );
        $wp_admin_bar->add_menu( array(
            'id'    => 'wp-custom-logout',
            'title' => $title_logout,
            'href'  => $url_logout
        ) );
    }
}