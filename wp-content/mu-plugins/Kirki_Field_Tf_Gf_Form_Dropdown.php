<?php
add_action( 'customize_register', function( $wp_customize ) {
	
	if( !class_exists( '\Kirki_Field_Select') ){
		return;
	}
	
	class Kirki_Field_Tf_Gf_Form_Dropdown extends Kirki_Field_Select {

		var $default_args = array(
			'description' => '<i>If the form is not listed here, it may be disabled or deleted...</i><br/><a href="/wp-admin/admin.php?page=gf_edit_forms">view all gravity forms here</a>'
		);

		public function __construct( $config_id, array $args ) {

			$args = wp_parse_args($args, $this->default_args);

			if ( class_exists( 'GFAPI' ) ) {
				$gf_forms          = TF_Forms::get_forms();
				$args['choices'][] = 'Select a form...';
				foreach ( $gf_forms as $key => $form ) {
					$args['choices'][ $form['id'] ] = esc_html( $form['title'] );
				}
			} else {
				$args['choices'][] = 'Please enable gravity forms...';
			}
			parent::__construct( $config_id, $args );
		}
	}

	// Register our custom control with Kirki
	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['notice'] = 'Kirki_Field_Tf_Gf_Form_Dropdown';
		return $controls;
	} );

} );



