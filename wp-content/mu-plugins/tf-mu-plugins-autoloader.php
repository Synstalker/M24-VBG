<?php

/**
 * Don't run any MU Plugins if the site is not installed yet
 */
if( (defined('WP_INSTALLING') && WP_INSTALLING) || !is_blog_installed() ) return;


/**
 * Disable all plugin update notifications
 * unless you have wordpress debugging on
 */
if( !defined('WP_DEBUG') || !WP_DEBUG ){
	add_filter( 'site_transient_update_plugins', function( $value ) {
		return false;
	});
}

require_once( WPMU_PLUGIN_DIR.'/Kirki_Field_Tf_Gf_Entry_Form_Fields_Multicheck/Kirki_Field_Tf_Gf_Entry_Form_Fields_Multicheck.php' );
require_once( WPMU_PLUGIN_DIR.'/Kirki_Field_Tf_Gf_Form_Dropdown.php' );

spl_autoload_register(function ($class_name) {
	$paths_to_check = array();
	$paths_to_check[] = WPMU_PLUGIN_DIR.'/'.$class_name.'.php';
	$paths_to_check[] = WPMU_PLUGIN_DIR.'/'.$class_name.'/'.$class_name.'.php';
	foreach( $paths_to_check as $path ){
		if( file_exists( $path ) ){
			require_once( $path );
			break;
		}
	}
});


/**
 * Only load this class if gravity forms is active
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if( is_plugin_active('gravityforms') )
	require_once( WPMU_PLUGIN_DIR.'/TF_Forms/TF_Forms.php');