<?php

require_once(get_template_directory().'/BananaCream.php');


if (class_exists('TF_Media')) {
    new TF_Media();
}
if (class_exists('TF_Comment')) {
    new TF_Comment();
}
if (class_exists('TF_Forms')) {
    new TF_Forms();
}
if (class_exists('TF_Formatting')) {
    new TF_Formatting();
}
if (class_exists('TF_Widget_Search')) {
    new TF_Widget_Search();
}
if (class_exists('BananaCream')) {
    new BananaCream();
}
if (class_exists('TF_UIKit')) {
    new TF_UIKit();
}
if (file_exists(get_template_directory() . '/MostRecentWidget.php')) {
    require_once(get_template_directory() . '/MostRecentWidget.php');
}
if (file_exists(get_template_directory() . '/DashboardWidgets.php')) {
    require_once(get_template_directory() . '/DashboardWidgets.php');
}

if (!function_exists('the_header')) {
    function the_header()
    {
        $header_href = TF_Customizer::get_option('header_href') ? get_permalink(TF_Customizer::get_option('header_href')) : null;
        $is_slideshow = '1' === TF_Customizer::get_option('use_slideshow');


        $the_header = '';
        if ($is_slideshow) {
            if (class_exists('TF_Media_Load') && 'yes' === tf_core_get_option('media_active', 'addons')) {
                $the_header .= do_shortcode('[24_slider id="' . TF_Customizer::get_option('slideshow_select') . '" size="large"]');
            } else {
                $the_header .= __('TF Core Media Addon is required to be active.', 'twentyfourdotcom');
            }
        } else {
            $mobile_header = TF_Customizer::get_option('header_image_mobile');

            $the_header .= $header_href ? '<a class="header_image_link" href="' . $header_href . '">' : '';
            $the_header .= get_header_image_tag(array(
                    'alt' => __('Header Image', 'twentyfourdotcom'),
                    'class' => !empty($mobile_header) ? 'uk-hidden-small': null
                )
            );


            $the_header .= $mobile_header ? '<img class=\'uk-hidden-large uk-hidden-medium uk-width\' src=\'' . $mobile_header . '\'/>' : '';
            $the_header .= $header_href ? '</a>' : '';
        }


        echo $the_header;
    }

    add_action('the_header', 'the_header');
}

if( ! function_exists( 'modify_wp_search_where' ) ) {

function modify_wp_search_where($where)
{
    global $wp;

    if (is_search() && $wp->query_vars['s']) {
        global $wpdb;

        $where = preg_replace(
            "/($wpdb->posts.post_title (LIKE '%{$wp->query_vars['s']}%'))/i",
            "$0 OR ( $wpdb->postmeta.meta_value LIKE '%{$wp->query_vars['s']}%' AND $wpdb->postmeta.meta_key IN ('". implode("','", array_keys(BananaCream::get_search_meta_field_names()))."') )",
            $where
        );

        add_filter('posts_join_request', 'modify_wp_search_join');
        add_filter('posts_distinct_request', 'modify_wp_search_distinct');
    }

    return $where;
}

}
add_action('posts_where_request', 'modify_wp_search_where');


function modify_wp_search_join($join)
{
    global $wpdb;

    return $join .= " LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) ";
}


function modify_wp_search_distinct($distinct)
{
    return 'DISTINCT';
}


/**
 * Create a Meta Box for the page options
 *
 * @link https://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
 * @param $post
 */
function page_options_meta_box($post)
{
    $values = get_post_custom($post->ID);
    $values = wp_parse_args($values, array( 'page_options_show_title' => array( 'on' ) ));
    $checked = $values['page_options_show_title'][0] == 'on' ? 'checked=checked' : null;
    wp_nonce_field('page_options_meta_box', 'meta_box_nonce'); ?>
	<p>
		<input name="page_options_show_title" type="checkbox" id="page_options_show_title" <?php _e($checked); ?> /><label for="page_options_show_title"><?php _e('Show Title'); ?></label>
	</p>
<?php

}


/**
 * Save our custom field value
 * @link https://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
 */
function save_page_options_cb($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'page_options_meta_box')) {
        return;
    }

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post')) {
        return;
    }

    // Make sure your data is set before trying to save it
    $chk = isset($_POST['page_options_show_title']) && $_POST['page_options_show_title'] ? 'on' : 'off';

    update_post_meta($post_id, 'page_options_show_title', $chk);
}
add_action('add_meta_boxes', function () {
    add_meta_box('page_options', 'Page Options', 'page_options_meta_box', 'page', 'side', 'core');
});
add_action('save_post', 'save_page_options_cb');

function show_page_title()
{
    $values = get_post_custom(get_the_ID());
    $values = wp_parse_args($values, array( 'page_options_show_title' => array( 'on' ) ));
    $show = $values['page_options_show_title'][0] != 'on' ? false : true;

    return $show;
}
