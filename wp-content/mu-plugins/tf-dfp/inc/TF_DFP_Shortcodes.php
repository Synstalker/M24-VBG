<?php

/*
 * @class: TF_DFP_Shortcodes
 * @author: Jared Rethman <jared.rethman@24.com>
 */


class TF_DFP_Shortcodes
{

    private $front_end_data;

    function __construct()
    {

        //Add ShortCode
        add_shortcode( '24_dfp', array($this, 'add_shortcode' ));

        if( class_exists( 'TF_DFP_Data_Factory' )){
            $available_slots = new TF_DFP_Data_Factory();
            $this->front_end_data = $available_slots->get_front_data( 'detect' );
        }
    }

    function add_shortcode( $atts )
    {
        $sc_atts = shortcode_atts(
                array(
                    'id'            => '',
                    'size'          => '',
                    'set_target'    => '',
                ),
            $atts
        );

        $id         = $sc_atts['id'];
        $size       = $sc_atts['size'];
        $set_target = !empty( $sc_atts['set_target'] ) ? $sc_atts['set_target'] : '';

        $available_slots = $this->front_end_data;
        $output = '';

        if( !empty( $available_slots['ads'] ) ) {

            foreach ( $available_slots['ads'] as $isactive ) {

                if ( $isactive !== null && in_array( $id, $isactive ) ) {

                    if ( $size === '10x10' ||  $size === '200x400' ) {

                        wp_print_scripts( TF_DFP_NAME . 'jquery-template' );

                    }

                    //$csssize = false !== strpos( $size, 'x' ) ? explode( 'x', $size ) : $size;
                    //$csssize = $size !== '1000x1000' && $size !== 'oop' && $size !== '10x10' && $size !== '1x1'  && $size !== 'fluid' ? ' style="height: ' . esc_attr( $csssize[1] ) . 'px;"' : '';
                    if ( $id !== '' && $size !== '' ) {

                        $output .= '<div class="post tf-dfp-advert tf-dfp-advert-' . $size . '" id="' . $id . '" data-type="tf-dfp-advert" data-ad-size="' . $size . '" data-ad-is-mobile="0" data-ad-is-tablet="0" data-ad-is-desktop="1" data-set-target="' . $set_target . '">';
                        $output .= '</div>';

                    }
                }
            }
        }
        return $output;
    }
}