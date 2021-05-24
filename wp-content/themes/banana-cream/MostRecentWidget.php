<?php

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

if (class_exists('Carbon_Fields\Widget')) {

    /**
     * Class MostRecentWidget
     *
     * @version 1.0.0
     *
     * @since 3.25.0
     */
    class MostRecentWidget extends Widget
    {


        /**
         * MostRecentWidget constructor.
         *
         * @version 1.0.0
         *
         * @since 1.0.0
         */
        public function __construct()
        {
            $this->setup('Latest Entrants', 'Displays Latest Entrants', array(

                Field::make("text", "widget_heading", "Widget Heading"),
                Field::make("text", "entrant_category", "Category Slug"),
                Field::make("text", "number_to_display", "Number of entrants to display"),
                Field::make("text", "items_per_row", "Number of entrants to display per row"),

            ));
        }


        /**
         *
         * @version 1.0.0
         *
         * @since 1.0.0
         *
         * @param array $args
         * @param array $instance
         */
        public function front_end($args, $instance)
        {
            $instance['number_to_display'] = !isset($instance['number_to_display'])   ? 5     : $instance['number_to_display'];
            $instance['entrant_category'] = !isset($instance['entrant_category'])    ? null  : $instance['entrant_category'];
            $instance['widget_heading'] = !isset($instance['widget_heading'])      ? null  : $instance['widget_heading'];
            $instance['items_per_row'] = !isset($instance['items_per_row'])       ? 5     : $instance['items_per_row'];

            $args = array(
                    'post_type' => 'entry',
                    'posts_per_page' => $instance['number_to_display']
                );

            if ($instance['entrant_category']) {
                $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => $instance['entrant_category']
                        )
                    );
            }

            $the_query = new WP_Query($args);

            echo "<div>".$instance['widget_heading']."</div>";

            if ($the_query->have_posts()) {
                echo '<div class="uk-grid uk-grid-width-large-1-'.$instance['items_per_row'].' uk-grid-width-medium-1-3 uk-grid-width-small-1-1 uk-text-center" data-uk-grid-match="{target:\'.uk-article\'}">';
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    get_template_part('templates/entries/widget-preview', is_front_page() ? 'frontpage' : null);
                }
                echo '</div>';
                wp_reset_postdata();
            }
        }
    }

    add_action('widgets_init', function () {
        register_widget('MostRecentWidget');
    });
}
