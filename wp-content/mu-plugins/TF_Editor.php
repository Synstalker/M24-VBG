<?php

/**
 * Class TF_Editor
 * Adds onto the existing WordPress _WP_Editors functionality
 *
 * @see _WP_Editors
 */
class TF_Editor{


	public function __construct(){
		add_filter( 'tiny_mce_before_init', array( __CLASS__, 'tiny_mce_allow_div_tags' ) );
	}


	/**
	 * stop Tiny MCE editor from removing div tags
	 *
	 * @see _WP_Editors::editor_settings()
	 *
	 * @link https://ikreativ.com/stop-wordpress-removing-html/
	 **/
	public static function tiny_mce_allow_div_tags( $init ) {
		$init['extended_valid_elements'] = 'div[*]';
		return $init;
	}

}
