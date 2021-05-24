<?php

/*
 * @class: TF_DFP_Admin_Post
 * @author: Jared Rethman <jared.rethman@24.com>
 */

class TF_DFP_Admin_Post
{
    public $pagenow;

    function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'load_js'));
        add_action('wp_ajax_tf_dfp_update', array($this, 'ajax_action'));
        add_action('wp_ajax_search_posts', array($this, 'search_posts'));
        $this->pagenow = isset($_GET['page']) ? preg_replace('/^tf_dfp_/', '', $_GET['page']) : '';
    }

    //TODO: Move this into TF_DFP_Admin_Fields
    function load_js()
    {
        if ($this->pagenow === 'configuration') {
            wp_register_script(TF_DFP_NAME . '-' . $this->pagenow . '-script', TF_DFP_URL . 'assets/js/' . $this->pagenow . '-script.js', array('jquery'), TF_DFP_VER);
        } else if ($this->pagenow === 'ad_units') {
            wp_register_script(TF_DFP_NAME . '-' . $this->pagenow . '-script', TF_DFP_URL . 'assets/js/' . $this->pagenow . '-script.js', array(
                'jquery',
                'jquery-ui-sortable'
            ), TF_DFP_VER);
        } else if ($this->pagenow === 'zones') {
            //Select 2 JS
            wp_enqueue_script('select2', TF_DFP_URL . 'assets/js/libs/select2/dist/js/select2.min.js', array('jquery'), TF_DFP_VER);
            wp_register_script(TF_DFP_NAME . '-' . $this->pagenow . '-script', TF_DFP_URL . 'assets/js/' . $this->pagenow . '-script.js', array(
                'jquery',
                'select2'
            ), TF_DFP_VER);
            wp_enqueue_style('select2', TF_DFP_URL . 'assets/js/libs/select2/dist/css/select2.min.css', array(), TF_DFP_VER);
        } else if ($this->pagenow === 'import') {
            wp_register_script(TF_DFP_NAME . '-' . $this->pagenow . '-script', TF_DFP_URL . 'assets/js/' . $this->pagenow . '-script.js', array('jquery'), TF_DFP_VER);
        }

        wp_enqueue_style(TF_DFP_NAME . '-style', TF_DFP_URL . 'assets/css/style.css', array(), TF_DFP_VER);
        wp_enqueue_script(TF_DFP_NAME . '-' . $this->pagenow . '-script');

        wp_localize_script(TF_DFP_NAME . '-' . $this->pagenow . '-script', 'dfp24Vars', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'appName' => 'tf-dfp',
            'loadingMessage' => __('Sending data...', TF_DFP_NAME),
            'errorMessages' => array(
                'default' => __('Please correct any errors. And click \'Save settings\' again.', TF_DFP_NAME),
                'configuration' => __('\'Desktop prefix\' cannot be empty!', TF_DFP_NAME),
                'unsavedChanges' => __('You have unsaved changes, Leave this page?', TF_DFP_NAME),
                'adUnits' => array(
                    'oop' => __('Please include a Out of Page ad ID!', TF_DFP_NAME),
                    'adIds' => __('Ad Slot ID cannot be empty!', TF_DFP_NAME),
                    'adUnits' => __('Please \'Select Ad Unit\'!', TF_DFP_NAME),
                    'devices' => __('Please select at least one device!', TF_DFP_NAME)
                ),
                'zones' => array(
                    'search' => __('Please search for a content type in either; Post, Page or Category.', TF_DFP_NAME),
                    'tag' => __('You must add a custom tag!', TF_DFP_NAME),
                    'adUnits' => __('Please \'Select Ad Unit\'!', TF_DFP_NAME)
                )
            ),
            'statusMessages' => array(
                'fileUpload' => sprintf(__('%s items loaded...', TF_DFP_NAME), ''),
            ),
            'pageNow' => $this->pagenow
        ));
    }

    /**
     * Process the AJAX request
     */
    function ajax_action()
    {
        //Maybe overkill
        $security_check_passes = (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
            && isset($_POST['security'])
            && check_ajax_referer('tf_dfp_settings', 'security', false)
            && current_user_can('manage_dfp')
        );

        if ($security_check_passes) {

            $page = $_POST['page'];
            $field_data = $_POST['field_data'];
            $post_request = isset($_POST['post_request']) ? $_POST['post_request'] : 'default';

            global $tf_dfp;
            $option = $tf_dfp;
            $clean_data = esc_attr($field_data);

            if ($post_request === 'default') {

                if ($option[$page] !== $clean_data) {
                    $option[$page] = $clean_data;
                    update_option('tf_dfp_settings', $option);
                    wp_send_json(array('notice' => ucwords(str_replace('_', ' ', $page)) . __(' updated.', TF_DFP_NAME)));
                } else {
                    wp_send_json(array('notice' => __('No changes made!', TF_DFP_NAME)));
                }

            } else if ($post_request === 'search_content') {

                $search = !empty($_POST['q']['term']) ? sanitize_text_field($_POST['q']['term']) : '';
                $post_type = !empty($_POST['post_type']) ? $_POST['post_type'] : 'post';

                if ('category' !== strtolower($post_type)) {
                    $results = array();
                    if ('page' === strtolower($post_type) && false !== strpos('homepage', strtolower($search))) {
                        $results[] = array(
                            'id' => 'home',
                            'text' => 'Homepage'
                        );
                    } else {
                        $select2_query_args = array(
                            's' => $search,
                            'fields' => 'id',
                            'post_type' => $post_type,
                            'post_status ' => 'published',
                            'post_per_page' => 3
                        );

                        $search_query = new WP_Query($select2_query_args);

                        while ($search_query->have_posts()) : $search_query->the_post();
                            $results[] = array(
                                'id' => $search_query->post->ID,
                                'text' => get_the_title($search_query->post->ID)
                            );
                        endwhile;
                        wp_reset_postdata();
                    }

                } else {
                    $results = array();
                    $term_query = get_terms('category', array(
                        'search' => $search,
                        'fields' => 'all'
                    ));
                    foreach ($term_query as $id) {
                        $results[] = array(
                            'id' => $id->term_id,
                            'text' => html_entity_decode($id->name . ($id->parent ? ' (' . __('in ', TF_DFP_NAME) . trim(get_category_parents($id->parent, false, ' > '), ' > ') . ')' : ''))
                        );
                    }
                }

                wp_send_json($results);

            } else {
                wp_send_json(array('notice' => __('Post Request \'' . $post_request . '\' not found!', TF_DFP_NAME)));
            }
        } else {
            wp_send_json(array('notice' => __('Security check failed', TF_DFP_NAME)));
        }
    }
}