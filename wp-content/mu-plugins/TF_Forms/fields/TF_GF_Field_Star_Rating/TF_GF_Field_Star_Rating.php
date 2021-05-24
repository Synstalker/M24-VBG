<?php

if ( class_exists( 'GFForms' ) ) {

	class TF_GF_Field_Star_Rating extends GF_Field_Radio {

		public $type = 'star_rating';
		public $label = 'Your Rating';


		/**
		 * @see style.scss in this folder
		 *
		 * variables should match those in that file
		 */
		const star_rating_container_css_class = 'star_rating_container';
		const star_rating_label_css_class = 'star_rating_label';
		const star_rating_input_css_class = 'star_rating_input';


		public function __construct( $data = array() ) {
//		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts'));
			parent::__construct( $data );
		}

		public static function enqueue_scripts() {

			$minified_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_style( __CLASS__ . '_style', get_theme_file_uri( 'includes/TF_GF_Field_Star_Rating/style' . $minified_suffix . '.css' ) );
			wp_enqueue_style( __CLASS__ . '_style' );

		}

		public function get_form_editor_button() {
			return array(
				'group' => 'advanced_fields',
				'text'  => $this->get_form_editor_field_title()
			);
		}


		public $choices = array(
			array(
				'value'      => '5',
				'text'       => '',
				'isSelected' => false,
			),
			array(
				'value'      => '4',
				'text'       => '',
				'isSelected' => false,
			),
			array(
				'value'      => '3',
				'text'       => '',
				'isSelected' => false,
			),
			array(
				'value'      => '2',
				'text'       => '',
				'isSelected' => false,
			),
			array(
				'value'      => '1',
				'text'       => '',
				'isSelected' => false,
			),
		);

		public function get_form_editor_field_title() {
			return esc_attr__( 'Star Rating', 'gravityforms' );
		}


	}

	GF_Fields::register( new TF_GF_Field_Star_Rating() );

	function format_star_rating_gform_field_content( $content, $field, $value, $lead_id, $form_id ) {
		if ( 'star_rating' != $field->type ) {
			return $content;
		}

		$content = strip_tags( $content, '<label><div><input>' );
		$content = str_replace( '<input name=', '<input class=\'' . TF_GF_Field_Star_Rating::star_rating_input_css_class . '\' name=', $content );
		$content = str_replace( '<label for=', '<label class=\'' . TF_GF_Field_Star_Rating::star_rating_label_css_class . '\' for=', $content );
		$content = str_replace( 'ginput_container', TF_GF_Field_Star_Rating::star_rating_container_css_class . ' ginput_container', $content );

		return $content;
	}

	add_filter( 'gform_field_content', 'format_star_rating_gform_field_content', null, 5 );

}