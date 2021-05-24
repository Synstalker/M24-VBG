<?php

/**
 * Dashboard Widgets
 *
 * Showing widgets in the back end dashboard.
 *
 * @package     24dotcom
 * @subpackage  BananaCream
 * @version 3.26
 * @since 3.26
 */

add_action('wp_dashboard_setup', array('DasboardWidgets', 'init'));

/**
 * Class DasboardWidgets
 * @todo create a tf-core helper class to create dashboard widgets
 */
class DasboardWidgets
{
    /**
     * The ids of the widgets.
     * @since 3.26
     */
    const wid_top_voted = 'top_voted_dashboard_widget';
    const wid_top_rated = 'top_rated_dashboard_widget';
    const wid_finalists = 'finalists_dashboard_widget';

    /**
     * Hook to wp_dashboard_setup to add the widget.
     * @since 3.26
     */
    public static function init()
    {
        wp_add_dashboard_widget(
            self::wid_top_voted,        // Widget slug.
            'Top Voted Entries',        // Title.
            array(__CLASS__, 'top_voted_entries_widget')  // Display function.
        );

        wp_add_dashboard_widget(
            self::wid_top_rated,        // Widget slug.
            'Top Rated Entries',        // Title.
            array(__CLASS__, 'top_rated_entries_widget')  // Display function.
        );

        $finalists_widget_title = 'Entries (Configure left of &#x25B2;)';
        $cat = get_option('dash_widget_cat');
        if ($cat) {
            $finalists_widget_title = get_cat_name($cat) . ' Entries';
        }
        wp_add_dashboard_widget(
            self::wid_finalists,        // Widget slug.
            $finalists_widget_title,    // Title.
            array(__CLASS__, 'finalists_widget'),         // Display function.
            array(__CLASS__, 'finalists_widget_config')   // Configuration function
        );
    }

    /**
     * Dashboard widget showing the top 10 entries sorted by voting
     * @since 3.26
     */
    public static function top_voted_entries_widget()
    {
        /**
         * Force the refresh of bayesian ratings across all entrants
         * append ?voting_cache=false string to the admin url
         */
        $use_cache = isset($_GET['voting_cache']) && $_GET['voting_cache'] == 'false' ? false : true;

        global $post;
        $args = array(
            'post_type' => 'entry',
            'meta_key' => 'votes',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'posts_per_page' => $use_cache === true ? 10 : -1,
            'post_status' => 'publish'
        );
        $loop = new WP_Query($args);
        if ($loop->have_posts()):?>
            <table class="wp-list-table widefat fixed striped pages">
            <thead>
            <tr>
                <th scope="col" id="entry"><?php _e('Entry', 'twentyfourdotcom'); ?></th>
                <th scope="col" id="votes"><?php _e('Votes', 'twentyfourdotcom'); ?></th>
            </tr>
            </thead>
            <tbody><?php
            while ($loop->have_posts()) : $loop->the_post(); ?>
                <tr>
                    <td><a href="<?php echo get_permalink(); ?>" target="_blank"
                           title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?>
                        </a></td>
                    <td>
                        <?php echo BananaCream::get_entrant_votes_count( $post->ID, $use_cache ); ?>
                    </td>
                </tr> <?php
            endwhile; ?>
            </tbody>
            </table><?php
        else:
            _e('No Entries', 'twentyfourdotcom');
        endif;
    }

    /**
     * Dashboard widget showing the top 10 entries sorted by rating
     * @since 3.26
     * @since 4.1.0         Uses rating_average meta_key
     */
    public static function top_rated_entries_widget(){

        $use_cache = isset( $_GET['bayesian_cache'] ) && $_GET['bayesian_cache'] == 'false' ? false : true;

        $args = array(
            'post_type'         => 'entry',
            'orderby'           => 'meta_value_num',
            'meta_key'          => 'ratings_count',
            'order'             => 'DESC',
            'post_status'       => 'publish',
            'posts_per_page'    => 10,
            'paged'             => isset($_GET['bayesian_page']) ? $_GET['bayesian_page'] : null
        );


        $loop = new WP_Query($args);
        if ($loop->have_posts()):
            ?>
            <table class="wp-list-table widefat fixed striped pages">
            <thead>
            <tr>
                <th scope="col" id="entry"><?php _e('Entry', 'twentyfourdotcom'); ?></th>
                <th scope="col" id="rating-average"><?php _e('Rating average', 'twentyfourdotcom'); ?></th>
                <th scope="col" id="rating-count"><?php _e('Rating count', 'twentyfourdotcom'); ?></th>
                <th scope="col" id="beyesian-rating"><?php _e('Bayesian Rating', 'twentyfourdotcom'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            global $post;
            while ($loop->have_posts()) : $loop->the_post();
            ?>
                <tr>
                <td>
                    <a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </td>
                <td>
                    <?php echo BananaCream::get_entrant_ratings_average( $post->ID, $use_cache ); ?>
                </td>
                <td>
                    <?php echo BananaCream::get_entrant_ratings_count( $post->ID, $use_cache ); ?>
                </td>
                <td>
                    <?php echo BananaCream::get_entrant_bayesian_average( $post->ID, $use_cache ) ; ?>
                </td>
                </tr><?php
            endwhile; ?>
            </tbody>
            </table><?php
            echo paginate_links();
        else:
            _e('No Entries', 'twentyfourdotcom');
        endif;
    }

    /**
     * Dashboard widget showing the entries checked as (semi-)finalist
     * @since 3.26
     */
    public static function finalists_widget()
    {
        $cat = get_option('dash_widget_cat');
        $args = array(
            'post_type' => 'entry',
            'orderby' => array( 'votes' => 'DESC', 'ratings_average' => 'DESC' ),
            'posts_per_page' => 10,
            'post_status' => 'publish'
        );
        if ($cat) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $cat,
                ),
            );
        }
        $loop = new WP_Query($args);
        if ($loop->have_posts()):?>
            <table class="wp-list-table widefat fixed striped pages">
            <thead>
            <tr>
                <th scope="col" id="entry"><?php _e('Entry', 'twentyfourdotcom'); ?></th>
            </tr>
            </thead>
            <tbody><?php
            while ($loop->have_posts()) : $loop->the_post(); ?>
                <tr>
                    <td><a href="<?php echo get_permalink(); ?>" target="_blank"
                           title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?>
                        </a></td>
                </tr> <?php
            endwhile; ?>
            </tbody>
            </table><?php
        else:
            _e('No Entries', 'twentyfourdotcom');
        endif;
    }


    /**
     * Configuration of the dashboard widget showing the entries checked as (semi-)finalist
     * @since 3.26
     */
    public static function finalists_widget_config()
    {
        $cat = isset($_POST['cat']) ? $_POST['cat'] : null;
        if ($cat) {
            update_option('dash_widget_cat', $cat);
        } else {
            $cat = get_option('dash_widget_cat');
        }

        $args = array(
            'show_count' => 1,
            'selected' => $cat,
        );
        wp_dropdown_categories($args);
    }
}