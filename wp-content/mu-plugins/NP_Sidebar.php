<?php

/**
 * Class NP_Sidebar
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
class NP_Sidebar {

	static $default_args = array(
		'name'          => 'Unnamed Sidebar',
		'id'            => 'nexpress-sidebar',
		'description'   => null,
	    'class'         => null,
		'before_widget' => '<aside id="%1$s" class="widget sidebar %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>'
	);


	/**
	 * Helper function for creating sidebars
	 * can send a single sidebar args array or an array of sidebars
	 *
	 * @param array $args
	 */
	static final function register($args = array()){

		/**
		 * Handles multiple sidebars sent through the parameters
		 */
		foreach($args as $key => $sidebar){
			if(is_array($sidebar)){
				self::register($sidebar);
				unset($args[$key]);
			}
		}

		/**
		 * Check added in the event all the items in the array have been removed (unset)
		 */
		if(sizeof($args) > 0){
			$args = wp_parse_args($args, self::$default_args);
			register_sidebar($args);
		}

	}
}
