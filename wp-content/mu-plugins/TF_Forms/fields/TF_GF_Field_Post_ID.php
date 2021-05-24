<?php


if ( class_exists( 'GFForms' ) ) {

	/**
	 * Class TF_GF_Field_Post_ID
	 *
	 */
	class TF_GF_Field_Post_ID extends GF_Field_Hidden{

		public $type = 'post_id';
		public $label = 'Post ID';
		static $css_class = 'uk-margin-remove';


		public function __construct( $data = array() ){
			add_filter( 'gform_field_container', array( $this, 'gform_field_container' ), null, 6 );
			parent::__construct( $data );
		}


		public function get_form_editor_field_title() {
			return esc_attr__( $this->label, 'twentyfourdotcom' );
		}


		function get_form_editor_field_settings() {
			return array(
				'label_setting'
			);
		}

		public function get_form_editor_button() {
			return array(
				'group' => 'post_fields',
				'text'  => $this->get_form_editor_field_title()
			);
		}


		public function get_field_input( $form, $value = '', $entry = null ) {

			global $post;

			if($post){
				$value = $post->ID;
			}

			return parent::get_field_input($form, $value, $entry);
		}


		public function gform_field_container( $field_container, $field, $form, $css_class, $style, $field_content ) {

			if ( $field->type == $this->type ){

				$re = '/(?<opening_tag><li)(?<attributes_before_class>.*)(?<class_attribute_start>class=\')(?<class_value>.*?)(?<class_attribute_end>\')(?<attributes_after_class>.*)(?<closing_tag><\/li>)/';
				$subst = '${1}${2}${3}${4} '.self::$css_class.'${5}${6}${7}';
				$field_container = preg_replace( $re, $subst, $field_container );

				$field_container    = str_replace( '{FIELD_CONTENT}', $field_content, $field_container );

			}

			return $field_container;
		}


		public function validate( $value, $form ){
			$validation_result = true;
			return $validation_result;
		}
	}

	GF_Fields::register( new TF_GF_Field_Post_ID() );
}

