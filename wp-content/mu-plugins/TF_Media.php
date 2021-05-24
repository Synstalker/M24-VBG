<?php

/**
 * Class TF_Media
 * Adds onto the existing WordPress media functionality
 *
 * @see wp-includes/media.php
 */
class TF_Media {

	public function __construct(){
		add_filter( 'post_gallery', array( __CLASS__, 'post_gallery' ), null, 2 );
	}


	/**
	 * Modify's the default look and feel of the gallery html
	 * If both templates exist in the theme with the names
	 * "post-gallery" and "post-gallery-slide"
	 * Then those templates are used instead of the default gallery html
	 *
	 * @see wp-includes/media.php:1660
	 */
	public static function post_gallery( $attr, $instance ){

		$template = TF_Template::return_template_part( 'templates/post-gallery' );
		$slide_template = TF_Template::return_template_part( 'templates/post-gallery', 'slide' );

		if( empty( trim( $template ) ) || empty( trim( $slide_template ) ) ) return '';

		$slides = '';
		$slide_nav = '';
		$count = 0;

		foreach(explode(',',$instance['ids']) as $id){
			$light_box_image_url    = wp_get_attachment_image_url( $id, 'full', false, $attr ) ?: '';
			$light_box_group        = 'post_gallery';
			$slide_image            = wp_get_attachment_image( $id, 'full', false, $attr );
			$slides                .= sprintf( TF_Template::return_template_part( 'templates/post-gallery', 'slide' ), $light_box_image_url, $light_box_group, $slide_image );
			$count++;
		}

		return $template = sprintf( $template, $slides, $slide_nav );
	}

}