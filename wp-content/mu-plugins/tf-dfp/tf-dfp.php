<?php
/**
 * @package TF DFP
 */
/*
Plugin Name: 24 DFP
Plugin URI: https://bitbucket.org/24dotcom/tf-dfp
Description: 24 Plugin for GoogleDoubleClick for Publishers.
Version: 0.0.5
Author: OpenSource Team
Author URI: http://wp.24.com
License: GPLv2 or later
Text Domain: tf_dfp
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!defined('ABSPATH'))
    die('-1');

//Constants
define('TF_DFP_NAME', 'tf_dfp');
define('TF_DFP_VER', '0.0.3');
define('TF_DFP_URL', plugin_dir_url(__FILE__));
define('TF_DFP_PATH', plugin_dir_path(__FILE__));
define('TF_DFP_CLASS_PATH', TF_DFP_PATH . 'inc' . DIRECTORY_SEPARATOR);
define('TF_DFP_AD_UNITS', serialize(array(
    array('one-by-one', '1x1', 'Tracking Pixel 1x1'),
    array('ten-by-ten', '10x10', 'Transitional 10x10'),
    array('fluid', 'fluid', 'Fluid'),
    array('lb-mobile-xs', '300x50', 'Leaderboard 300x50'),
    array('lb-mobile', '320x50', 'Leaderboard 320x50'),
    array('lb-mobile-med', '278x76', 'Leaderboard 278x76'),
    array('lb-mobile-big', '468x60', 'Leaderboard 468x60'),
    array('lb-desk', '728x90', 'Leaderboard 728x90'),
    array('lb-desk-big', '980x90', 'Leaderboard 980x90'),
    array('rec-sml', '300x150', 'Small Rectangle 300x150'),
    array('rec-med', '300x250', 'Medium Rectangle 300x250'),
    array('rec-lrg', '336x280', 'Large Rectangle 336x280'),
    array('hp', '200x400', 'Half Page 200x400'),
    array('hp-big', '300x600', 'Half Page 300x600'),
    array('take-over', '1000x1000', 'Take Over 1000x1000')
)));

define('TF_DFP_DATA', serialize(array(
        'configuration' => array(),
        'ad_units' => array(),
        'zones' => array(),
        //'import' => array()
    )
));

define('TF_DFP_DEBUG', true);

//Plugin loader class
if ( !class_exists('TF_DFP_Load') ) {
    require_once(  TF_DFP_CLASS_PATH . 'TF_DFP_Load.php' );
    function tf_df_init()
    {
        //Start her up...
        $tf_dfp_load = new TF_DFP_Load();
        $tf_dfp_load->init();
        $tf_dfp_load->get_data();

        //Activation / Deactivation hooks
        register_activation_hook( __FILE__, array( $tf_dfp_load, 'activate_plugin' ) );
        register_deactivation_hook(__FILE__, array( $tf_dfp_load, 'deactivate_plugin' ) );
    }

    add_action('plugins_loaded', 'tf_df_init', 81 );

    //Contribution: DM
} else {
    $current_user = wp_get_current_user();
    wp_die( __( '<div class="wrap"><h1>' . __('24 DFP Plugin error:', TF_DFP_NAME) . '</h1><div class="notice notice-error"><p>' . __('DFP could not be loaded, please contact ', TF_DFP_NAME) . ' <a href="mailto:24.COMOpenSourceDevTeam@ds.naspers.com?subject=DFP failed to load for - ' . site_url() . ' / by ' . $current_user->user_login . '">' . __('Admin', TF_DFP_NAME) . '</a>.</p></div></div>' ) );
}