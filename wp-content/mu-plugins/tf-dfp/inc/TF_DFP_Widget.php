<?php

/*
 * @class: TF_DFP_Widget extends WP_Widget
 * @author: Jared Rethman <jared.rethman@24.com>
 */

if (!defined('ABSPATH'))
    die('-1');

class TF_DFP_Widget extends WP_Widget
{
    private $front_end_data;

    function __construct()
    {

        parent::__construct(
            'tf_dfp_ad_slot', // Base ID
            __('24 DFP', TF_DFP_NAME), // Name
            array('description' => __('Widget used to display 24 DFP ad slots.', TF_DFP_NAME)) // Args
        );
        if (class_exists('TF_DFP_Data_Factory')) {
            $available_slots = new TF_DFP_Data_Factory();
            $this->front_end_data = $available_slots->get_front_data();
        }
    }

    /**
     * @param array $args
     * @param array $instance
     */
    function widget($args, $instance)
    {
        //extract($args);
        $before_widget  = $args['before_widget'];
        $after_widget   = $args['after_widget'];
        $ad_unit        = $instance['ad_unit'];
        $ad_unit        = false !== strpos($ad_unit, '|') ? explode('|', $ad_unit) : '';
        $shortcode_str  = '';

        echo $before_widget;

        //Build up ShortCode string
        if ( $ad_unit !== '' ) {
            $shortcode_str .= '[24_dfp id="' . $ad_unit[0] . '" size="' . $ad_unit[1] . '" ';
        }
        if ( !empty( $instance['set_target_key'] ) && !empty( $instance['set_target_value'] ) ) {
            $shortcode_str .= 'set_target="\'' . $instance['set_target_key'] . '\', \'' . $instance['set_target_value'] . '\'" ';
        }

        $shortcode_str .= ']';

        echo do_shortcode( $shortcode_str );

        echo $after_widget;

    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance[ 'ad_unit' ]            = (!empty($new_instance['ad_unit']))            ? strip_tags($new_instance['ad_unit'])          : '';
        $instance[ 'set_target_key' ]     = (!empty($new_instance['set_target_key']))     ? strip_tags($new_instance['set_target_key'])   : '';
        $instance[ 'set_target_value' ]   = (!empty($new_instance['set_target_value']))   ? strip_tags($new_instance['set_target_value']) : '';
        return $instance;
    }

    /**
     * @param array $instance
     */
    function form( $instance )
    {
        $instance = wp_parse_args((array)$instance);

        $ad_unit = '';
        $target_key = !empty( $instance['set_target_key'] ) ? esc_attr( $instance['set_target_key'] ) : '';
        $target_value = !empty( $instance['set_target_value'] ) ? esc_attr( $instance['set_target_value'] ) : '';
        if ( !empty( $instance['ad_unit'] ) ) {
            $ad_unit = $instance['ad_unit'];
        }

        $available_slots = $this->front_end_data;

        if ( false !== $available_slots && !empty( $available_slots['ads'] ) ) {

            $output = '<h4>' . __( 'Select Ad Unit:', 'tf-dfp' ) . '</h4>';
            $output .= '<select style="width:100%;" class="widfat select" id="' . $this->get_field_id('ad_unit') . '"  name="' . $this->get_field_name('ad_unit') . '">';
            foreach ( $available_slots['ads'] as $option ) {
                $selected = selected($ad_unit, $option['id'] . '|' . $option["size"], false);
                $output .= "<option value=\"" . $option["id"] . "|" . $option["size"] . "\" $selected>" . $option["size"] . " / " . $option["id"] . "</option>";
            }
            $output .= '</select>';
            $output .= '<h4>' . __( 'Set Targeting:', 'tf-dfp' ) . '</h4>';
            $output .= '<p><label for="' . $this->get_field_id('set_target_key') . '">' . __( 'Key:', 'tf-dfp' ) . '</label>';
            $output .= '<input placeholder="' . __( 'i.e. \'posno\'', 'tf-dfp' ) . '" value="' . $target_key . '" type="text" id="' . $this->get_field_id( 'set_target_key' ) . '" class="widefat" name="' . $this->get_field_name('set_target_key') . '"></p>';
            $output .= '<p><label for="' . $this->get_field_id('set_target_value') . '">' . __( 'Value:', 'tf-dfp' ) . '</label>';
            $output .= '<input placeholder="' . __( 'i.e. \'mpu-top\'', 'tf-dfp' ) . '" value="' . $target_value . '" type="text" id="' . $this->get_field_id( 'set_target_value' ) . '" class="widefat" name="' . $this->get_field_name('set_target_value') . '"></p>';

            echo $output;

        } else {

            echo '<p>';
            printf(__('Empty or inactive DFP units. Click <a href="%s">here</a> to view.', TF_DFP_NAME), admin_url('admin.php?page=tf_dfp_ad_units'));
            echo '<p>';

        }
    }
}