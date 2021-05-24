<?php

/*
 * @class: TF_DFP_Admin_Fields
 * @author: Jared Rethman <jared.rethman@24.com>
 */

if (!defined('ABSPATH'))
    die('-1');

class TF_DFP_Admin_Fields
{
    /**
     * @param $page
     */
    function page_fields_render( $page )
    {
        global $tf_dfp;

        //Data field - get generated by jQuery
        $data_field = '<input class="' . $page . '_field" type="hidden"';
        $data_field .= ' name="' . $page . '_field" value="">';

        //SUBMIT
        $submit = get_submit_button($text = 'Save settings', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null);

        if ( class_exists( 'TF_DFP_Data_Factory' ) ) {
            $get_data = new TF_DFP_Data_Factory();
        }

        //TODO: Add error checking
        switch ($page) {
            case 'configuration':

                $config_object = $get_data->get_data( array( '&' ) );

	            //Remove encoding from esc_attr()
                $config_object[0][0] = !empty($config_object[0][0]) && $config_object[0][0] !== '' ? urldecode( $config_object[0][0] ) : '';
                $config_object[0][1] = !empty($config_object[0][0]) && $config_object[0][1] !== '' ? urldecode( $config_object[0][1] ) : '';
                $config_object[0][2] = !empty($config_object[0][0]) && $config_object[0][2] !== '' ? urldecode( $config_object[0][2] ) : '';
	            //Check if cxense set via TF Tracking plugin or TF Core
	            global $tf_core;
	            if ( ( class_exists( '\\TF_Core\\Core\\Helpers\\Base' ) || class_exists( '\TF_Core' ) ) && isset( $tf_core['addons']['tracking_cxense_code'] ) ) {
		            // Use TF Core tracking
		            $config_object[0][3]       = $tf_core['addons']['tracking_cxense_code'];
		            $cxense_siteid_description = __( 'Set in <a href="/wp-admin/admin.php?page=addons.php#!tracking">TF Core</a>, cannot be changed here.', 'tf-dfp' );

	            } else if ( class_exists( 'TF_Tracking' ) && $tf_tracking_options = get_option( 'tf_tracking_options' ) ) {
		            // Use TF Tracking
		            $config_object[0][3]       = $tf_tracking_options['cxense']['value'];
		            $cxense_siteid_description = __( 'Set in <a href="/wp-admin/options-general.php?page=tracking-options-admin">TF Tracking</a>, cannot be changed here.', 'tf-dfp' );
	            } else {
		            // Inject Cxense code
		            $config_object[0][3]       =  isset($config_object[0][3]) && $config_object[0][3] !== '' ? urldecode( $config_object[0][3] ) : '';
		            $cxense_siteid_description = __( '<a href="https://wiki.cxense.com/display/cust/How+to+Obtain+the+Site+Group+and+the+Site+Id">How to get the Cxense Site Id</a>', 'tf-dfp' );
	            }
	            $config_object[0][4] = isset( $config_object[0][4] ) ? urldecode( $config_object[0][4] ) : '';

	            //GENERAL
                $fields = '<h2>' . __('General Settings:', 'tf-dfp') . '</h2>';

                $fields .= '<div class="tf-dfp-form">';

                $is_slot_active = !empty($config_object[0][0]) && $config_object[0][5] !== null ? (string)$config_object[0][5] : '0';

                $fields .= '<div class="field-set grid">';
                //Admin mode
                $fields .= '<div class="col-6-12 mobile-col-1-1">';
                $fields .= $is_slot_active === '1' ? '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-on"></a>' : '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-off"></a>';
                $fields .= $this->field_generator('tf-dfp-active', 'hidden', '', $is_slot_active);
                $fields .= '<span>&nbsp;&nbsp;&nbsp;' . __('Enable Admin mode?', 'tf-dfp') . '</span>';
                $fields .= '<p class="description">' . __('Ad\'s generated will only be visible to logged in Admins and DFP Admins.', 'tf-dfp') . '</p>';
                $fields .= '</div>';
                //RetailBar
                /*$fields .= '<div class="col-6-12 mobile-col-1-1">';
                $fields .= $is_slot_active === '1' ? '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-on"></a>' : '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-off"></a>';
                $fields .= $this->field_generator('tf-dfp-retailbar', 'hidden', '', $is_slot_active);
                $fields .= '<span>&nbsp;&nbsp;&nbsp;' . __('Retail Bar', 'tf-dfp') . '</span>';
                $fields .= '<p class="description">' . __('Do you require Retail Bar? Database Entry will be created.', 'tf-dfp') . '</p>';
                $fields .= '</div>';
                //TransAd
                $fields .= '<div class="col-4-12 mobile-col-1-1">';
                $fields .= $is_slot_active === '1' ? '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-on"></a>' : '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-off"></a>';
                $fields .= $this->field_generator('tf-dfp-transad', 'hidden', '', $is_slot_active);
                $fields .= '<span>&nbsp;&nbsp;&nbsp;' . __('Enable Transitional Ad', 'tf-dfp') . '</span>';
                $fields .= '<p class="description">' . __('Will require loading of jQuery template.', 'tf-dfp') . '</p>';
                $fields .= '</div>';*/

                $fields .= '</div>';

                $fields .= '<div class="grid">';
                $fields .= '<div class="field-set col-1-1 mobile-col-1-1">';
                $fields .= '<label><h2>' . __('Desktop Prefix.', 'tf-dfp') . '</h2>';
                $fields .= $this->field_generator('tf-dfp-d-prefix', 'text', '', $config_object[0][0], 'large-text ' . str_replace('_', '-', 'tf-dfp'), false);
                $fields .= '<p class="description">' . __('For example: /8900/24.com/Web/Themes24/SiteName', 'tf-dfp') . '</p>';
                $fields .= '</label>';
                $fields .= '</div>';

                $fields .= '<div class="field-set col-1-1 mobile-col-1-1">';
                $fields .= '<label><h2>' . __('Tablet Prefix.', 'tf-dfp') . '</h2>';
                $fields .= $this->field_generator('tf-dfp-t-prefix', 'text', '', $config_object[0][1], 'large-text ' . str_replace('_', '-', 'tf-dfp'), false);
                $fields .= '<p class="description">' . __('If left empty, values will be inherited from \'Desktop Prefix\'. For example: /8900/24.com/Mobile-Web/Themes24/SiteName', 'tf-dfp') . '</p>';
                $fields .= '</label>';
                $fields .= '</div>';

                $fields .= '<div class="field-set col-1-1 mobile-col-1-1">';
                $fields .= '<label><h2>' . __('Mobile Prefix.', 'tf-dfp') . '</h2>';
                $fields .= $this->field_generator('tf-dfp-m-prefix', 'text', '', $config_object[0][2], 'large-text ' . str_replace('_', '-', 'tf-dfp'), false);
                $fields .= '<p class="description">' . __('If left empty, there will be no device specific tagging. For example: /8900/24.com/Mobile-Web/Themes24/SiteName', 'tf-dfp') . '</p>';
                $fields .= '</label>';
                $fields .= '</div>';

	            $fields .= '<div class="field-set col-1-1 mobile-col-1-1">';
				$fields .= '<label><h2>' . __('Cxense Site Id.', 'tf-dfp') . '</h2>';
	            $fields .= $this->field_generator('tf-dfp-cxense-siteid', 'text', '', $config_object[0][3], 'large-text ' . str_replace('_', '-', 'tf-dfp'), false);
	            $fields .= '<p class="description">' . $cxense_siteid_description . '</p>';
				$fields .= '</label>';
				$fields .= '</div>';

	            $fields .= '<div class="field-set col-1-1 mobile-col-1-1">';
	            $fields .= '<label><h2>' . __('Cxense Persisted Query Id.', 'tf-dfp') . '</h2>';
	            $fields .= $this->field_generator('tf-dfp-cxense-persistedqueryid', 'text', '', $config_object[0][4], 'large-text ' . str_replace('_', '-', 'tf-dfp'), false);
	            $fields .= '<p class="description">' . __('No Csense targetting if left blank. You can create one on <a href="https://admin.cxense.com/#/cx/api/persisted-queries">https://admin.cxense.com/#/cx/api/persisted-queries</a> (<a href="https://wiki.cxense.com/pages/viewpage.action?pageId=28837626#DMPsegmentshelperfunction-getUserSegmentIds()-Step1:Createapersistedquery">how to create a Cxense Persisted Query Id</a>)', 'tf-dfp') . '</p>';
	            $fields .= '</label>';
	            $fields .= '</div>';

                $fields .= '</div>';
                $fields .= '</div>';

                echo $fields;
                wp_nonce_field('tf_dfp_settings', 'security'); //Security
                echo $submit;

                break;
            case 'ad_units':
                if( empty( $tf_dfp['configuration'] ) ){
                    wp_die( '<div class="notice notice-error"><p>' . __( 'You have to provide a \'Desktop prefix\' ', 'tf-dfp'  ) . ' - <a href="' . admin_url( 'admin.php?page=tf_dfp_configuration' ) . '">' . __('Click Here', 'tf-dfp') . '</a>' . '</p></div>' );
                }

                $section_data = $get_data->get_data( array( '|', '&' ), 5 );
                $section_data = $section_data !== null ? $section_data : array('');

                $oop_slot = !empty( $section_data[0] ) ? $section_data[0][1] : '';
                $each_slot = $section_data[1] !== null ? $section_data[1] : '';
                $is_oop_active = $oop_slot !== '' ? $section_data[0][0] : '0';

                //OOP
                $fields = '<h2>' . __('Out of Page:', 'tf-dfp') . '</h2>';
                $fields .= '<div class="tf-dfp-slot-oop grid">';
                $fields .= '<span class="code-box"></span>';

                $fields .= '<div class="field-set col-1-12 mobile-col-3-12">';
                $fields .= $is_oop_active === '1' ? '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-on"></a>' : '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-off"></a>';
                $fields .= $this->field_generator('tf-dfp-use-oop', 'hidden', '', $is_oop_active);
                $fields .= '</div>';

                $fields .= '<div class="field-set col-11-12 mobile-col-9-12">';
                $fields .= '<label>';
                //$fields .= '<span>div-gpt-ad-</span>';
                $fields .= '<input class="large-text tf-dfp-oop-id" type="text" placeholder="div-gpt-ad-" name="tf-dfp-oop-id" value="' . $oop_slot . '">';
                $fields .= '</label>';
                $fields .= '</div>';
                $fields .= '</div>';

                $fields .= '<h2>' . __('Available Ad Units:', 'tf-dfp') . '</h2>';
                $fields .= '<ul id="tf-dfp-repeater-wrap" class="grid">';
                for ($i = 0; $i < count($each_slot); $i++) {
                    $fields .= '<li class="tf-dfp-slot">';
                    $fields .= '<span class="code-box"></span>';
                    //Mover
                    $fields .= '<div class="field-set col-1-12 mobile-col-3-12">';
                    $fields .= '<span class="sort-slot"><div class="tf-dfp-i-drag"></div></span>';
                    $fields .= '</label></div>';
                    //Codes
                    $fields .= '<div class="field-set col-7-12 mobile-col-6-12">';
                    $fields .= $this->field_generator('tf-dfp-codes-id', 'text', 'div-gpt-ad-', $each_slot[$i][0], 'large-text ' . str_replace('_', '-', 'tf-dfp'), false);
                    $fields .= '</div>';
                    //Index
                    $fields .= '<div class="field-set col-1-12 mobile-col-3-12">';
                    $fields .= '<label>';
                    $index = isset($each_slot[$i][4]) ? $each_slot[$i][4] : $devices = '0';
                    $fields .= '<input class="tf-dfp-codes-index tf-dfp" style="width:100%; text-align:center;" type="text" value="' . $index . '">';
                    $fields .= '</label></div>';

                    //DEVICES
                    $devices = isset($each_slot[$i][2]) ? explode('-', $each_slot[$i][2]) : $devices = array('0', '0', '1');

                    $fields .= $devices[0] === '1' ? '<a class="tf-dfp-i-device field-set col-1-12 mobile-col-4-12"><div class="tf-dfp-i-device-mobile active"></div></a>' : '<a class="tf-dfp-i-device field-set col-1-12 mobile-col-4-12"><div class="tf-dfp-i-device-mobile"></div></a>';
                    $fields .= $this->field_generator('tf-dfp-device-mobile', 'hidden', '', $devices[0]);

                    $fields .= $devices[1] === '1' ? '<a class="tf-dfp-i-device field-set col-1-12 mobile-col-4-12"><div class="tf-dfp-i-device-tablet active"></div></a>' : '<a class="tf-dfp-i-device field-set col-1-12 mobile-col-4-12"><div class="tf-dfp-i-device-tablet"></div></a>';
                    $fields .= $this->field_generator('tf-dfp-device-tablet', 'hidden', '', $devices[1]);

                    $fields .= $devices[2] === '1' ? '<a class="tf-dfp-i-device field-set col-1-12 mobile-col-4-12"><div class="tf-dfp-i-device-desktop active"></div></a>' : '<a class="tf-dfp-i-device field-set col-1-12 mobile-col-4-12"><div class="tf-dfp-i-device-desktop"></div></a>';
                    $fields .= $this->field_generator('tf-dfp-device-desktop', 'hidden', '', $devices[2]);

                    $ad_unit_select = !empty( $each_slot[$i][1] ) ? $each_slot[$i][1] : '';
                    //Ad Units
                    $fields .= '<div class="field-set col-10-12 mobile-col-9-12">';
                    $fields .= $this->field_generator('tf-dfp-ad-units', 'select', '', $ad_unit_select, str_replace('_', '-', 'tf-dfp'), true, unserialize(TF_DFP_AD_UNITS));
                    $fields .= '</div>';

                    $is_slot_active = isset( $each_slot[$i][3] ) ? $each_slot[$i][3] : '0';

                    $fields .= $is_slot_active === '1' ? '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-on field-set col-2-12 mobile-col-3-12"></a>' : '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-off field-set col-2-12 mobile-col-3-12"></a>';
                    $fields .= $this->field_generator('tf-dfp-active', 'hidden', '', $is_slot_active);

                    $fields .= '<a class="remove remove-slot field-set"><span class="tf-dfp-i-remove"></span></a>';
                    $fields .= $data_field;
                    $fields .= '</li>';
                }
                $fields .= '<br><a id="add-slot" class="button-secondary" style="height: auto">' . __('Add Slot +', 'tf-dfp') . '</a>';
                $fields .= '</ul>';

                echo $fields;
                wp_nonce_field('tf_dfp_settings', 'security'); //Security
                echo $submit;

                break;
            case 'zones':

                if( empty( $tf_dfp['configuration'] ) ){
                    wp_die( '<div class="notice notice-error"><p>' . __( 'You have to provide a \'Desktop prefix\' ', 'tf-dfp'  ) . ' - <a href="' . admin_url( 'admin.php?page=tf_dfp_configuration' ) . '">' . __('Click Here', 'tf-dfp') . '</a>' . '</p></div>' );
                }

                $each_slot = $get_data->get_data( array( '&' ), 3);
                $each_slot = $each_slot !== null ? $each_slot : array('');

                $fields  = '<h2>' . __('Active Zones:', 'tf-dfp') . '</h2>';
                $fields .= '<ul id="tf-dfp-repeater-wrap" class="grid">';

                /* Clone - start */
                $fields .= '<li class="tf-dfp-slot clone">';

                $post_select_args = array(
                    'type' => 'select2_content_search',
                    'classes' => '',
                    'wrap_class' => 'select2_field col-6-12 mobile-col-1-2',
                    'current' => '',
                    'post_type' => array('page', 'post', 'category')
                );

                $cpt_radio = array(
                    'type' => 'radio',
                    'classes' => 'radio tf-dfp-validate',
                    'current' => 'category',
                    'wrap_class' => 'col-2-12 mobile-col-1-2',
                );

                foreach( $post_select_args['post_type'] as $k => $type){

                    $cpt_radio['post_type'] = $type;
                    $cpt_radio['label'] = $type;
                    $fields .= $this->field_generator_2('tf-dfp-content-select', $cpt_radio);

                    $post_select_args['post_type'] = $type;
                    $fields .= $this->field_generator_2('tf-dfp-' . $type . '-search', $post_select_args);

                }

                $post_select_args['options'] = array( 'page', 'post', 'category');

                $fields .= '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-on field-set col-2-12 mobile-col-3-12"></a>';
                $fields .= $this->field_generator('tf-dfp-active', 'hidden', '', '1');

                $custom_tag = array(
                    'type'  => 'text',
                    'label' => __( '/CustomTag', 'tf-dfp' ),
                    'wrap_class' => 'col-10-12 mobile-col-9-12',
                    'classes' => 'large-text tf-dfp-validate'
                );

                $fields .= $this->field_generator_2('tf-dfp-custom-tag', $custom_tag);

                $slot  = '<a class="remove remove-slot field-set"><span class="tf-dfp-i-remove"></span></a>';
                $slot .= $data_field;

                $fields .= $slot;
                $fields .= '</li>';

                /* Clone - end */

                for ($i = 0; $i < count($each_slot); $i++) {

                    $fields .= '<li class="tf-dfp-slot">';
                    $post_select_args['post_type'] = array( 'page', 'post', 'category');

                    foreach( $post_select_args['post_type'] as $k => $type){

                        $selected_type = '';
                        $post_select_args['post_type'] = $type;
                        $cpt_radio['post_type'] = $type;

                        if($each_slot[$i][0] !== ''){

                            //Match type and selection
                            $content_selected = substr( $each_slot[$i][0], 0, strpos($each_slot[$i][0], '-') );
                            $post_select_args['current'] = $content_selected === $type ? $each_slot[$i][0] : '';
                            $selected_type = $content_selected;

                        }

                        $cpt_radio['label'] = $type;
                        $cpt_radio['current'] = $selected_type !== '' ? $selected_type : $post_select_args['post_type'];

                        //If no current and select2 is category, display it.
                        $post_select_args['wrap_class'] = $each_slot[$i][0] === '' && $cpt_radio['current'] === 'category' ? $post_select_args['wrap_class'] .= ' select2_display' : $post_select_args['wrap_class'];

                        $fields .= $this->field_generator_2('tf-dfp-content-select-' . $i, $cpt_radio);
                        $fields .= $this->field_generator_2('tf-dfp-' . $type . '-search', $post_select_args);

                    }

                    $is_slot_active = !empty($each_slot[$i][2]) ? $each_slot[$i][2] : '0';

                    $fields .= '<br class="clearfix">';
                    $fields .= $is_slot_active === '1' ? '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-on field-set col-2-12 mobile-col-3-12"></a>' : '<a class="tf-dfp-i-toggle tf-dfp-i-toggle-off field-set col-2-12 mobile-col-3-12"></a>';
                    $fields .= $this->field_generator('tf-dfp-active', 'hidden', '', $is_slot_active);

                    $custom_tag['current'] = !empty( $each_slot[$i][1] ) ? urldecode( $each_slot[$i][1] ) : '';

                    $fields .= $this->field_generator_2('tf-dfp-custom-tag', $custom_tag);

                    $fields .= $slot;
                    $fields .= '</li>';

                }

                $fields .= '<br><a id="add-slot" class="button-secondary" style="height: auto">' . __('Add Zone +', 'tf-dfp') . '</a>';
                $fields .= '</ul>';

                echo $fields;
                wp_nonce_field('tf_dfp_settings', 'security'); //Security
                echo $submit;

                break;
            default :
                echo __('- Page not found!', 'tf-dfp');
        }
    }

    //TODO: Merge the two field_generator functions, using field_generator_2 parameter structure.
    /**
     * @param $name
     * @param string $type
     * @param string $label
     * @param $current_val
     * @param string $classes
     * @param bool|false $required
     * @param array $options
     * @return string
     */
    function field_generator($name, $type = 'text', $label = '', $current_val, $classes = '', $required = false, $options = array())
    {
        $required = $required ? ' required' : '';

        switch ($type) {
            case 'text':
            case 'number':
                //$field  = $label !== '' ? '<label><h2>' . __( $label, 'tf-dfp' ) . '</h2>' : '';
                $field = '<input class="' . $classes . ' ' . $name . '" type="' . $type . '" name="' . $name . '" placeholder="' . __($label, 'tf-dfp') . '" value="' . $current_val . '" ' . $required . '>';
                //$field .= $label !== '' ? '</label>' : '';
            return $field;
                break;
            case 'hidden':
                $field = '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" value="' . $current_val . '">';
                return $field;
                break;
            case 'select':
                $field = '<label>';
                $field .= '<span>' . __($label, 'tf-dfp') . '</span>';
                $field .= '<select type="' . $type . '" class="' . $classes . ' ' . $name . '" name="' . $name . '" id="' . $name . '" ' . $required . '>';
                if (!empty($options)) {
                    $field .= '<option value="none">' . __('&mdash; Select Ad Unit ' . $label . '&mdash;', 'tf-dfp') . '</option>';
                    foreach ($options as $option) {
                        $field .= '<option ' . selected( $option[1], $current_val, false) . ' value="' . $option[1] . '">' . $option[2] . '</option>';
                    }
                }
                $field .= '</select>';
                $field .= '</label>';
                return $field;
                break;
            case 'radio':

                break;
            default :

                break;
        }
    }

    /**
     * @param $name
     * @param array $args
     * @return string
     */
    function field_generator_2($name, array $args)
    {
        $type =         !empty($args['type'])        ? $args['type'] : '';
        $current =      !empty($args['current'])     ? $args['current'] : '';
        $classes =      !empty($args['classes'])     ? $name . ' ' . $args['classes'] : $name;
        $wrap_classes = !empty($args['wrap_class'])  ? $args['wrap_class'] : ' col-1-10';
        $select2_wrap_classes = $current !== '' && $type === 'select2_content_search' ? ' select2_display' : '' ;
        $label =        !empty($args['label'])       ? '<label><span>' . ucfirst($args['label']) . '</span>' : '';
        $label =        $type === 'select' || $type === 'text' ? $args['label'] : $label;
        $post_type =    !empty($args['post_type']) ? $args['post_type'] : 'post';
        $options =      !empty($args['options']) && is_array( $args['options'] ) ? $args['options'] : '';

        $field = '<div class="field-set ' . $wrap_classes . $select2_wrap_classes . '">';
        switch ($type) {
            case 'text':
                $field .= '<input placeholder="' . $label . '" class="' . $classes . '" type="' . $type . '" name="' . $name . '" value="' . $current . '">';
                break;
            case 'radio':
                $value = !empty( $args['label']) ? $args['label'] : '';
                $is_checked = $value === $current ? ' checked': '' ;
                $field .= $label . '&nbsp;&nbsp;&nbsp;';
                $field .= '<input class="' . $classes . '" type="' . $type . '" name="' . $name . '" value="' . $value . '"' . $is_checked . '>';
                $field .= $label !== '' ? '</label>' : '';
                break;
            case 'select':
                $field .= '<select class="' . $classes . '" name="' . $name . '">';
                $field .= '<option value="none">' . $label . '</option>';
                if($options !== '') {
                    foreach($options as $option) {
                        $is_selected = $current === $option[0] ? ' selected="selected"': '' ;
                        $field .= '<option value="' . $option[0] . '" ' . $is_selected . '>' . $option[2] . '</option>';
                    }
                }
                $field .= '</select>';
                break;
            case 'select2_content_search':
                $field .= $label;
                $field .= '<select data-post-type="' . ucfirst( $post_type ) . '" class="' . $classes . '" name="' . $name . '">';
                if($current !== '') {
                    $content_id = trim( substr($current, strrpos($current, '-') + 1 ) );
                    //var_dump($current, (int)$content_id);
                    if( 0 !== (int)$content_id ) {
                        $title = $post_type === 'category' ? get_cat_name($content_id) : get_the_title($content_id);
                    }else{
                        $title = $post_type === 'page' && $content_id === 'home' ? __('Homepage', 'tf-dfp') : '';
                    }
                    $field .= '<option value="' . $content_id . '" selected="selected">' . $title . '</option>';
                }

                $field .= '</select>';
                $field .= $label !== '' ? '</label>' : '';
                break;
            default :

                break;
        }
        $field .= '</div>';
        return $field;
    }
}