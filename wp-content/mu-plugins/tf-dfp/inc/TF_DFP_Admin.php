<?php

/*
 * @class TF_DFP_Admin;
 * @author: Jared Rethman <jared.rethman@24.com>
 */

if (!defined('ABSPATH'))
    die('-1');


class TF_DFP_Admin
{
    private $pages = array(
        'cap' => 'manage_dfp',
        'parent' => 'tf_dfp_configuration',
        'pages' => ''
    );

    function __construct()
    {
        $admin_pages = unserialize( TF_DFP_DATA );
        $this->pages['pages'] = $admin_pages;
        //Setup Admin menus
        add_action( 'admin_menu', array( $this, 'admin_menus' ) );


        //Remove Admin menus
        if (!current_user_can('manage_options') && current_user_can('manage_dfp')) {
            add_action( 'admin_init',  array( $this, 'filter_admin_menus' ) );
        }

        require_once(  TF_DFP_CLASS_PATH . 'TF_DFP_Admin_Post.php' );
        if (class_exists('TF_DFP_Admin_Post')) {
            $this->post_admin = new TF_DFP_Admin_Post();
        }

    }

    function admin_menus()
    {
        if (count($this->pages['pages'])) {
            foreach ($this->pages['pages'] as $key => $page) {
                if ( $key === 'configuration' ) {
                    add_menu_page(__('24 DFP:', TF_DFP_NAME) . ' ' . __('Configuration', TF_DFP_NAME), __('DFP', TF_DFP_NAME), $this->pages['cap'], $this->pages['parent'], array(
                        $this,
                        'load_pages',
                    ), TF_DFP_URL . 'assets/images/doubleclick.svg', '99.31337');
                } else {
                    $template = $key !== 'import' ? 'load_pages' : 'load_import_page';
                    add_submenu_page(
                        $this->pages['parent'],
                        ucwords(str_replace('_',' ', $key)) . ' - ' . __('24 DFP: ', TF_DFP_NAME),
                        ucwords(str_replace('_',' ', $key)),
                        $this->pages['cap'],
                        TF_DFP_NAME . '_' . $key,
                        array(
                            $this, $template
                        )
                    );
                }
            }
        }
        global $submenu;
        if (isset($submenu[$this->pages['parent']]) && current_user_can($this->pages['cap'])) {
            $submenu[$this->pages['parent']][0][0] = __( 'Config', TF_DFP_NAME );
        }
    }

    //https://gist.github.com/numediaweb/7dc94a428d0bc9d175b1
    function filter_admin_menus() {

        // If administrator then do nothing
        if ( !current_user_can('manage_dfp')) return;

        // Remove main menus
        $main_menus_to_stay = array(
            'themes.php',
            'tf_dfp_configuration',
            'tf_dfp_ad_units',
            'tf_dfp_zones',
            'tf_dfp_import',
        );

        // Remove sub menus
        $sub_menus_to_stay = array(
            'themes.php'            => array('widgets.php'),
            'tf_dfp_configuration'  => array( 'tf_dfp_configuration', 'tf_dfp_ad_units', 'tf_dfp_zones', 'tf_dfp_import' )
        );

        if ( isset( $GLOBALS['menu'] ) && is_array( $GLOBALS['menu'] ) ) {
            foreach ($GLOBALS['menu'] as $k => $main_menu_array) {
                // Remove main menu
                if (!in_array($main_menu_array[2], $main_menus_to_stay)) {
                    remove_menu_page($main_menu_array[2]);
                } else {

                    // Remove submenu
                    foreach ($GLOBALS['submenu'][$main_menu_array[2]] as $k => $sub_menu_array) {

                        if (!in_array($sub_menu_array[2], $sub_menus_to_stay[$main_menu_array[2]])) {

                            remove_submenu_page($main_menu_array[2], $sub_menu_array[2]);
                        }
                    }
                }
            }
        }
    }
    function load_pages()
    {
        require_once( TF_DFP_PATH . 'pages' . DIRECTORY_SEPARATOR . 'section-template.php' );
    }
    function load_import_page()
    {
        require_once( TF_DFP_PATH . 'pages' . DIRECTORY_SEPARATOR . 'load-import-page.php' );
    }


}