<?php

/**
 * Class TF_Formatting
 * Adds onto the existing WordPress formatting functionality
 *
 * @see wp-includes/formatting.php
 */
class TF_Formatting {

	public function __construct(){
		add_filter( 'excerpt_more', array( __CLASS__, 'excerpt_more' ) );
	}


	/**
	 * Modify the default 'READ MORE' text on excerpts
	 *
	 * If a template with the name excerpt-more-single.php exists
	 * Then it will use that and override the original read more text
	 *
	 * @link https://codex.wordpress.org/Excerpt
	 *
	 * @param string    $default
	 *
	 * @return mixed    $modified
	 */
	public static function excerpt_more( $default ) {
		$modified =  TF_Template::return_template_part( 'templates/excerpt-more', 'single' );
		$modified = empty( trim( $modified ) ) ? $default : $modified;
		return $modified;
	}

}