<?php

/*
 * @class: TF_DFP_Data_Factory
 * @author: Jared Rethman <jared.rethman@24.com>
 */


if (!defined('ABSPATH'))
    die('-1');

if( !class_exists( 'TF_DFP_Data_Factory' ) ) {
    class TF_DFP_Data_Factory {

        public $data;

        function __construct () {
            global $tf_dfp;
            $tf_dfp = get_option ( 'tf_dfp_settings' );

            //create option if no option cell
            if ( false === $tf_dfp ) {
                $data = unserialize ( TF_DFP_DATA );
                unset( $data['import'] );
                add_option ( 'tf_dfp_settings', $data );
                $tf_dfp = get_option ( 'tf_dfp_settings' );
            }

            //Full data
            $tf_dfp['pagenow'] = isset( $_GET['page'] ) ? preg_replace ( '/^tf_dfp_/', '', $_GET['page'] ) : '';
            $this->data        = $tf_dfp;

        }

        /**
         * @param array $delimiter
         * @param int $iteration
         * @param string $pagenow
         *
         * @return array|bool
         */
        function get_data ( $delimiter = array (), $iteration = 0, $pagenow = '' ) {

            $pagenow = $pagenow !== '' ? $pagenow : $this->data['pagenow'];
            $data    = $this->data[ $pagenow ];

            if ( is_array ( $delimiter ) ) {
                //Ad Units
                if ( count ( $delimiter ) > 1 ) {

                    $slot_one  = array ();
                    $slot_two  = array ();
                    $array_one = array ();
                    $array_two = array ( '' );
                    $counter   = 1;
                    $key       = $counter - 1;

                    if ( ! empty( $data ) ) {

                        $main      = explode ( $delimiter[0], $data );
                        $array_one = explode ( $delimiter[1], $main[0] );
                        $array_two = explode ( $delimiter[1], $main[1] );

                    }

                    foreach ( $array_two as $slot ) {

                        $slot_one[ $key ][] = preg_replace ( '/^[^=]*=\s*/', '', $slot );
                        if ( $counter % $iteration == 0 ) {
                            ++ $key;
                        }
                        ++ $counter;

                    }

                    for ( $i = 0 ; $i < count ( $array_one ) ; $i ++ ) {
                        $slot_two[ $i ] = preg_replace ( '/^[^=]*=\s*/', '', $array_one[ $i ] );
                    }

                    return array ( $slot_two, $slot_one );

                } else {

                    $main = ! empty( $data ) ? explode ( $delimiter[0], $data ) : array ( '' );

                    $each_slot = array ();
                    $counter   = 1;
                    $key       = $counter - 1;
                    foreach ( $main as $slot ) {
                        $each_slot[ $key ][] = preg_replace ( '/^[^=]*=\s*/', '', $slot );
                        if ( $iteration > 0 ) {
                            if ( $counter % $iteration == 0 ) {
                                ++ $key;
                            }
                            ++ $counter;
                        }
                    }

                    return $each_slot;

                }
            } else {

                return false;

            }

        }

        /**
         * @param string $action
         *
         * @return array|bool
         */
        function get_front_data ( $action = 'all' ) {
            $data = array ();
            if ( $action === 'all' ) {

                $slots = $this->get_data ( array ( '|', '&' ), 5, 'ad_units' );

                if ( $slots[1][0][0] !== '' ) {
                    $oopActive = ! empty( $slots ) && $slots[0][0] !== '0';

                    $current_slots = array ();

                    if ( $oopActive ) {
                        $current_slots[] = array ( 'id' => $slots[0][1], 'size' => 'oop' );
                    }

                    if ( ! empty( $slots[1] ) ) {
                        foreach ( $slots[1] as $slot ) {
                            if ( $slot[3] !== '0' ) {// if inactive
                                $current_slots[] = array ( 'id' => $slot[0] . '-' . $slot[4], 'size' => $slot[1] );
                            }
                        }
                    }

                    $data['ads'] = $current_slots;

                } else {

                    $data = false;

                }

            } else if ( $action === 'detect' ) {

                $configs = $this->get_data ( array ( '&' ), 0, 'configuration' );
                if ( empty( $configs[0][0] ) ) {
                    return false;
                } //Bail if no config
                global $tf_device_detect;

                ////////////
                //Get Prefix
                ////////////

                //Default is desktop, but will select the next available (up) option if empty
                $device         = 'd'; //Set to Desktop initially
                $data['prefix'] = $configs[0][0]; //Set to Desktop initially

                if ( $tf_device_detect->isTablet () ) { //Tablet
                    $data['prefix'] = $configs[0][1] !== '' ? $configs[0][1] : $data['prefix'];
                    $device         = 't';
                } else if ( $tf_device_detect->isMobile () ) { //Mobile
                    if ( $configs[0][2] !== '' ) {
                        $data['prefix'] = $configs[0][2];
                    } else if ( $configs[0][1] !== '' ) {
                        $data['prefix'] = $configs[0][1];
                    }
                    $device = 'm';
                }

                $slots     = $this->get_data ( array ( '|', '&' ), 5, 'ad_units' );
                $oopActive = ! empty( $slots[0][0] ) && $slots[0][0] !== '0' && $device === 'd';

                $current_slots = array ();

                if ( $oopActive ) {

                    $current_slots[] = array ( 'id' => $slots[0][1], 'size' => 'oop' );

                }

                if ( ! empty( $slots[1] ) ) {
                    foreach ( $slots[1] as $slot ) {
                        if ( isset( $slot[3] ) && $slot[3] !== '0' ) {// if inactive
                            $devices = explode ( '-', $slot[2] );

                            $dSlot = $devices[2] === '1';
                            $tSlot = $devices[1] === '1';
                            $mSlot = $devices[0] === '1';

                            if ( $dSlot && $device === 'd' ) {
                                $current_slots[] = array ( 'id' => $slot[0] . '-' . $slot[4], 'size' => $slot[1] );
                            }
                            if ( $tSlot && $device === 't' ) {
                                $current_slots[] = array ( 'id' => $slot[0] . '-' . $slot[4], 'size' => $slot[1] );
                            }
                            if ( $mSlot && $device === 'm' ) {
                                $current_slots[] = array ( 'id' => $slot[0] . '-' . $slot[4], 'size' => $slot[1] );
                            }
                        }
                    }
                }

                $data['ads'] = $current_slots;

            } else if ( 'zone' ) {


            }

            return $data;
        }

        /**
         * @return bool|string
         */
        function get_zone () {

            $zones = $this->get_data ( array ( '&' ), 3, 'zones' );
            $tag   = 'none';

            if ( ! empty( $zones ) ) {
                foreach ( $zones as $zone ) {
                    $type_id = false !== strpos ( $zone[0], '-' ) ? explode ( '-', $zone[0] ) : '';
                    if ( isset( $type_id[1] ) ) {
                        if ( $type_id[1] === 'home' ) {

                            if ( $this->where ( $type_id[1] ) ) {
                                $tag = $zone[2] !== '0' ? $zone[1] : '';
                            }

                        } else {
                            if ( $this->where ( $type_id[0], $type_id[1] ) ) {
                                $tag = $zone[2] !== '0' ? $zone[1] : '';
                            }
                        }
                    }
                }
            }

            return $tag;

        }

        function is_active ( $type = 'oop' ) {
            $data      = $this->get_front_data ();
            $is_active = !empty( $data['ads'] ) ? $data['ads'][0]['size'] : null;
            $active    = "false";
            if ( $is_active !== null && $is_active === $type ) {
                $active = "true";

                return $active;
            }

            return $active;
        }

        /**
         * @param $origin
         * @param null $id
         * @return bool
         */
        function where ( $origin, $id = null ) {
            // DM: Noticed this on a few functions. May be an idea to prefix to leverage good Backwards Compatibility principles - something like tfDFP_Where. Up to you! Just an extra safegaurd.
            switch ( $origin ) {
                case 'home':
                    if ( is_front_page () && is_home () || is_front_page () || is_home () ) {
                        return true;
                    }
                    break;
                case 'category':
                    if ( is_category ( $id ) ) {
                        return true;
                    }else if( is_single() && in_category( $id ) && !is_single ( $id ) ){
                        return true;
                    }
                    break;
                case 'page':
                    if ( is_page ( $id ) ) {
                        return true;
                    }
                    break;
                case 'post':
                    if ( is_single ( $id ) ) {
                        return true;
                    }
                    break;
            }

            return false;
        }
    }
}