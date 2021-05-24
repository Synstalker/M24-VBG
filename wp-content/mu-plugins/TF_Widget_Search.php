<?php

/**
 * 24 Search Widget, which improves on the
 * default WordPress Search Widget
 *
 * adds more fields
 * extends the Helper TF_Widget class
 *
 * @package     24dotcom
 * @subpackage  tf-core
 * @since       2.0.0
 *
 * @see WP_Widget_Search
 * @see WP_Widget
 */
class TF_Widget_Search extends TF_Widget {

	var $fields = array(
		array(
			'id'    => 'title',
		),
		'placeholder',
		'button_text'   => array(
			'label'     => 'Button Text',
			'default'   => 'Search'
		),
		'post_type' => array(
			'label' => 'Search by Post Type',
			'default'   => 'Auto Detect',
			'disabled'  => true,
		)
	);

	var $name = 'Search';
	var $description = 'Search Widget, enhanced by 24.com';


	public function __construct() {

		/**
		 * Remove the original Search Widget, make use of this one
		 */
		add_action( 'widgets_init', function(){
			unregister_widget( 'WP_Widget_Search' );
			register_widget( __CLASS__ );
		} );

		parent::__construct();
	}


	/**
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		// Use current theme search form if it exists
		$search_form_template = locate_template( 'searchform.php' );
		if ( '' != $search_form_template ){
			include( $search_form_template );
		}else{
			//otherwise default to the normal behaviour
			get_search_form();

		}

	}

}

new TF_Widget_Search();
