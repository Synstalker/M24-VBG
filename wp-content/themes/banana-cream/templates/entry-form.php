<?php

$entry_form_id = intval( function_exists( 'carbon_get_post_meta' ) ? carbon_get_post_meta( get_the_ID(), 'tf_entry_form' ) : 0 );
$entry_form_id = !$entry_form_id ? ( TF_Customizer::get_option( 'entry_form_id' ) ? TF_Customizer::get_option( 'entry_form_id' ) : 0 ) : $entry_form_id;

if( $entry_form_id  <= 0 ){
	get_template_part( 'templates/entry-form', 'unavailable' );
}else{
	echo do_shortcode('[gravityform id="'.$entry_form_id.'" title="false" description="false" ajax="'.TF_Customizer::get_option( 'entry_form_is_ajax', 'boolean_string' ).'"]');
}