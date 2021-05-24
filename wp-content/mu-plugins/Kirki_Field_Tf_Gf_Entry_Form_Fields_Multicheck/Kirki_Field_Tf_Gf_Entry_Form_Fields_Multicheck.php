<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Field_Tf_Gf_Entry_Form_Fields_Multicheck' ) && class_exists('Kirki_Field_Select') ) {

	class Kirki_Field_Tf_Gf_Entry_Form_Fields_Multicheck extends Kirki_Field_Multicheck {

		var $default_args = array(
			'description' => ''
		);

		public function __construct( $config_id, array $args ) {

			$form_fields = TF_Forms::get_form_fields( BananaCream::get_entry_form_id() );
			$args['choices'] = $form_fields;

			parent::__construct( $config_id, $args );
		}

		public static function get_field_name_values( $ids ){

			$ids = !is_array( $ids ) ? array( $ids ) : $ids;

			/**
			 * Fail first if requirements are not met
			 */
			$form_id = BananaCream::get_entry_form_id();
			if( !$form_id ) return null;

			$field_name_values = array();
			$form = GFAPI::get_form( $form_id );
			foreach( $ids as $k => $id ){
				foreach( $form['fields'] as $key => $field ){
					if( $field->id == intval( $id ) ){
						$field_name_values[ $field->label ][] = $id;
					}
				}
			}

			return $field_name_values;
		}
	}
}
