<?php
if ( class_exists( 'GFForms' ) ) {


	/**
	 * Class TF_GF_Field_Terms_And_Conditions
	 * Gravity Forms Terms and Conditions Form Field
	 *
	 * Allows you to create a Terms and Conditions checkbox
	 * that allows you to set the page to link through and the linking text
	 *
	 * @link https://github.com/stevegrunwell/stevegrunwell-com/blob/master/wp-content/plugins/gravityforms/includes/fields/class-gf-field-checkbox.php
	 *
	 *
	 */
	class TF_GF_Field_Terms_And_Conditions extends GF_Field_Checkbox {

		/**
		 * @var string $type The field type.
		 */
		public $type = 'terms_and_conditions';
		public $label = 'I accept the terms and conditions';
		public $title = 'Terms and Conditions';
		public $inputType = 'checkbox';


		const linked_page_field_id = 'terms_and_conditions_linked_page';
		const linking_text_field_id = 'terms_and_conditions_linking_text';

		const wp_dropdown_pages_area_id = 10;
		const custom_fields_css_class = 'fieldwidth-3'; //Gravity Forms css class


		public function __construct( $data = array() ) {
			add_action( 'gform_field_standard_settings', array( __CLASS__, 'extra_fields' ), null, 2 );
			parent::__construct( $data );
		}


		/**
		 * Return the field title, for use in the form editor.
		 *
		 * @return string
		 */
		public function get_form_editor_field_title() {
			return esc_attr__( 'Terms and Conditions', 'twentyfourdotcom' );
		}


		public function get_form_editor_button() {
			return array(
				'group' => 'advanced_fields',
				'text'  => 'T&Cs'
			);
		}


		public function get_form_editor_field_settings() {
			return array(
				'error_message_setting',
				'label_setting',
				'rules_setting',
				'terms_and_conditions_setting_linked_page',
				// this is needed to show the necessary fields extra fields for this control
				'terms_and_conditions_setting_linking_text'
				// this is needed to show the necessary fields extra fields for this control
			);
		}

		/**
		 *
		 * @return string
		 */
		public function get_field_label_class() {
			return parent::get_field_label_class() . ' uk-hidden';
		}


		/**
		 * Adds the dropdown field to the Terms and Conditions Control
		 *
		 * @param $position
		 * @param $form_id
		 */
		public static function extra_fields( $position, $form_id ) {

			if ( $position == 10 ) {
				?>

				<li class="terms_and_conditions_setting_linked_page field_setting">

					<label for="<?php _e( self::linked_page_field_id ); ?>" class="section_label">
						<?php _e( 'Linked Page', 'twentyfourdotcom' ); ?>
					</label>
					<?php
					wp_dropdown_pages(
						array(
							'id'    => self::linked_page_field_id,
							'name'  => self::linked_page_field_id,
							'class' => self::custom_fields_css_class
						)
					);
					?>
				</li>

				<li class="terms_and_conditions_setting_linking_text field_setting">
					<label for="<?php _e( self::linking_text_field_id ); ?>" class="section_label">
						<?php _e( 'Linking Text', 'twentyfourdotcom' ); ?>
					</label>
					<input type="text" class="<?php _e( self::custom_fields_css_class ); ?>"
					       id="<?php _e( self::linking_text_field_id ); ?>"
					       name="<?php _e( self::linking_text_field_id ); ?>"/>
				</li>

				<?php
			}
		}


		/**
		 * The scripts to be included in the form editor.
		 *
		 * @link https://www.gravityhelp.com/documentation/article/set-default-properties-new-field/#setting-the-default-choices
		 *
		 * @return string
		 */
		public function get_form_editor_inline_script_on_page_render() {

			$script = sprintf( "function SetDefaultValues_%s(field) {
			field.enableChoiceValue = true;
			field.isRequired        = true;
			field.label             = '" . $this->title . "';
            field.choices           = [new Choice( 'I accept the terms and conditions', 'yes' )];
            field.inputs            = [new Input(field.id + '.1', '" . $this->label . "')];
            console.debug(field);
        }", $this->type ) . PHP_EOL;

			$script .= '

		jQuery(document).ready(function($) {
			$(document).bind("gform_load_field_settings", function(event, field, form){
				jQuery("#' . self::linked_page_field_id . '").val(field["' . self::linked_page_field_id . '"]);
			});

			jQuery("#' . self::linked_page_field_id . '").change(function(){
				SetFieldProperty(\'' . self::linked_page_field_id . '\', jQuery("#' . self::linked_page_field_id . '").val() )
			});


			$(document).bind("gform_load_field_settings", function(event, field, form){
				jQuery("#' . self::linking_text_field_id . '").val(field["' . self::linking_text_field_id . '"]);
			});

			jQuery("#' . self::linking_text_field_id . '").change(function(){
				SetFieldProperty(\'' . self::linking_text_field_id . '\', jQuery("#' . self::linking_text_field_id . '").val() )
			});

		});
		';

			return $script;
		}
	}

	GF_Fields::register( new TF_GF_Field_Terms_And_Conditions() );

	function format_terms_and_conditions_gform_field_content( $content, $field, $value, $lead_id, $form_id ) {

		/**
		 * Skip if this field is not the terms and conditions field
		 */
		if ( 'terms_and_conditions' != $field->type ) {
			return $content;
		}

		/**
		 * Render normally if there is no linked page defined
		 */
		if ( empty( $field->terms_and_conditions_linked_page ) ) {
			return $content;
		}

		$content       = TF_Template::modify_css_class( 'gfield_label', 'uk-hidden', $content );
		$new_label     = $field->label;
		$_linking_text = empty( $field->terms_and_conditions_linking_text ) ? $field->label : $field->terms_and_conditions_linking_text;
		$link_tag      = sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			get_permalink( $field->terms_and_conditions_linked_page ),
			$_linking_text
		);
		$content       = str_replace( $_linking_text, $link_tag, $content );

		return $content;
	}

	add_filter( 'gform_field_content', 'format_terms_and_conditions_gform_field_content', null, 5 );

}