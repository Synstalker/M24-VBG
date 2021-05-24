<?php


/**
 * Class TF_Forms
 * TF Core Helper Class for Gravity Forms
 */
class TF_Forms {

	static $exclude_gf_field_types_choices_in_customizer = array(
		'section'
	);

	static $uikit_css_classes_mapping = array(
		'gform_button'                  => 'uk-button uk-button-primary uk-text-uppercase uk-button-large uk-width-small-1-1 uk-width-large-1-3 uk-width-medium-1-3',
		'gfield'                        => 'uk-form-row',
		'gform_wrapper'                 => '',
		'gfield_label'                  => 'uk-form-label uk-text-left',
		'ginput_container'              => 'uk-form-controls',
		'gfield_description'            => 'uk-form-help-block uk-margin-large-bottom',
		'gform_confirmation_message'    => 'uk-alert uk-alert-success',
		'validation_error'              => 'uk-alert uk-alert-danger',
		'validation_message'            => 'uk-alert uk-alert-danger',
		'gform_fields'                  => 'uk-padding-remove',
		'gform'                         => 'uk-form uk-form-stacked',
		'gfield_list_container'         => 'uk-width-1-1',
		'gfield_list_icons'             => 'uk-text-center',
		'large'                         => 'uk-width-1-1',
		'gsection_title'                => 'uk-form-label',
		'gfield_checkbox'               => 'uk-list'
	);

	static $form_defaults = array('fields'=>array());


	public function __construct(){

		update_option( 'rg_gforms_disable_css', true );
		add_filter( 'gform_ajax_spinner_url', array( __CLASS__, 'gform_ajax_spinner_url' ) );
		add_filter( 'gform_pre_render', array( __CLASS__, 'gform_pre_render' ), null, 3 );

		//map css classes
		add_filter( 'gform_submit_button', array( __CLASS__, 'gform_submit_button_map_css_classes' ), null, 2 );
		add_filter( 'gform_confirmation', array( __CLASS__, 'gform_confirmation_map_css_classes' ), null, 4);
		add_filter( 'gform_validation_message', array( __CLASS__, 'gform_validation_message_map_css_classes' ), 10, 2);
		add_filter( 'gform_field_container', array( __CLASS__, 'gform_field_container_map_css_classes' ), 11, 6 );
		add_filter( 'gform_get_form_filter', array( __CLASS__, 'gform_get_form_filter_map_css_classes' ), null, 2 );
		add_filter( 'gform_field_content', array( __CLASS__, 'gform_field_content' ), null, 5 );

		$this::load_fields();
	}


	/**
	 *
	 * @return string   $path       uri of the ajax spinner
	 */
	public static function gform_ajax_spinner_url(){
		$path = get_theme_file_uri('images/loading.svg');
		return $path;
	}


	/**
	 * Helper function
	 * so that it can be called even when gravity forms is disabled
	 *
	 * @param $id       form id
	 *
	 * @return bool|mixed
	 */
	public static function get_form_object( $id ){

		if( ! class_exists( 'GFAPI' ) ) return null;

		$form = GFAPI::get_form( $id );
		$form = wp_parse_args( $form, self::$form_defaults  );

		return $form;
	}


	/**
	 *
	 * @see wp-content/plugins/gravityforms/form_display.php:2910
	 *
	 * @param string        $field_content
	 * @param GF_Field      $field
	 * @param string        $value
	 * @param int           $entry_id
	 * @param int           $form_id
	 *
	 * @return string       $field_content
	 */
	public static function gform_field_content( $field_content = '', $field , $value = '', $entry_id = 0, $form_id = 0 ){
		$field_content    = TF_Template::modify_css_class( 'gfield_label', self::$uikit_css_classes_mapping[ 'gfield_label' ], $field_content );
		$field_content    = TF_Template::modify_css_class( 'gfield_description', self::$uikit_css_classes_mapping[ 'gfield_description' ], $field_content );
		$field_content    = TF_Template::modify_css_class( 'gfield_list_container', self::$uikit_css_classes_mapping[ 'gfield_list_container' ], $field_content );
		$field_content    = TF_Template::modify_css_class( 'gfield_list_icons', self::$uikit_css_classes_mapping[ 'gfield_list_icons' ], $field_content );
		$field_content    = TF_Template::modify_css_class( 'gsection_title', self::$uikit_css_classes_mapping[ 'gsection_title' ], $field_content );
		$field_content    = TF_Template::modify_css_class( 'gfield_checkbox', self::$uikit_css_classes_mapping[ 'gfield_checkbox' ], $field_content );
		$field_content    = $field->failed_validation === true ? TF_Template::modify_css_class( 'validation_message', self::$uikit_css_classes_mapping[ 'validation_message' ], $field_content ) : $field_content;
		return $field_content;
	}


	/**
	 *
	 * @link https://www.gravityhelp.com/documentation/article/gform_get_form_filter/
	 *
	 * @param string    $form_string
	 * @param mixed     $form
	 *
	 * @return string   $form_string
	 */
	public static function gform_get_form_filter_map_css_classes( $form_string = '', $form){
		return TF_Template::modify_css_class( 'gform_fields', self::$uikit_css_classes_mapping[ 'gform_fields' ], $form_string );
	}


	/**
	 * Sets the css class for ALL gravity forms
	 *
	 * @see plugins/gravityforms/form_list.php:776
	 *
	 * @param array     $form
	 * @param bool      $ajax
	 * @param mixed     $field_values
	 *
	 * @return array
	 */
	public static function gform_pre_render( $form = array(), $ajax = false, $field_values ){

		if ( ! is_array( $form ) ) return $form;

		$form[ 'cssClass' ] = array_key_exists( 'cssClass', $form ) ? $form[ 'cssClass' ] : '';
		$form[ 'cssClass' ] .= ' '.self::$uikit_css_classes_mapping['gform'];
		return $form;
	}


	/**
	 * @param string    $button_html   button html string
	 * @param array     $form
	 *
	 * @return mixed
	 */
	public static function gform_submit_button_map_css_classes( $button_html = '', $form = array() ){
		$button_html = TF_Template::modify_css_class( 'gform_button', self::$uikit_css_classes_mapping['gform_button'], $button_html );
		$button_html = '<div class="uk-text-center">'.$button_html.'</div>';
		return $button_html;
	}


	/**
	 * @param int $form_id
	 * @return array
	 */
	public static function get_form_fields( $form_id = 0 ){

		$form_fields = array();
		$form = TF_Forms::get_form_object( $form_id );
		if( !empty( $form ) ){
			foreach( $form['fields'] as $key => $field ){
				if( ! in_array( $field->type, self::$exclude_gf_field_types_choices_in_customizer ) && !empty( $field->label ) )
					$form_fields[ $field->id ] = $field->label;
			}
		}

		return $form_fields;
	}


	public static function get_form_fields_named_array( $form_id = 0, $field_name = '' ){

		$form = self::get_form_object( $form_id );

		/**
		 * Get submitted form fields as an associative array
		 * label -> id | array of id's
		 * @todo decouple this
		 */
		$form_fields_formatted = array();
		$form_fields = $form['fields'];
		foreach( $form_fields as $key => $field ){
			if( ! $field->label ) continue;
			$field_input_ids = array();
			$field_entry_inputs = $field->get_entry_inputs() ;

			if( is_array($field_entry_inputs) ){
				foreach($field_entry_inputs as $k => $input ){
					$field_input_ids[] = $input['id'];
				}
			}

			$form_fields_formatted[$field->label] = count( $field_input_ids ) == 0 ? $field->id : $form_fields_formatted ;
		}

		return $form_fields_formatted;
	}


	/**
	 * Adds the uk-form-row class to the field wrapper
	 * on ALL gravity forms
	 * displayed on the front end
	 *
	 * NOTE: gravity forms html uses single quotes and NOT double quotes
	 * @see /wp-content/plugins/gravityforms/form_display.php:2731
	 *
	 * @param string        $field_container
	 * @param GF_Field      $field
	 * @param $form
	 * @param $css_class
	 * @param $style
	 * @param $field_content
	 *
	 * @return string       HTML formatted string
	 */
	public static function gform_field_container_map_css_classes( $field_container, $field, $form, $css_class, $style, $field_content ) {

		if( is_admin() ) return $field_container;

		/**
		 * Change the form field container element
		 * from li tag -> div tag
		 */
		$field_container    = str_replace( '<li', '<div', $field_container );
		$field_container    = str_replace( '</li>', '</div>', $field_container);

		$field_container    = TF_Template::modify_css_class( 'gfield ', self::$uikit_css_classes_mapping[ 'gfield' ], $field_container );
		$field_container    = TF_Template::modify_css_class( 'ginput_container', self::$uikit_css_classes_mapping[ 'ginput_container' ], $field_container );
		$field_container    = TF_Template::modify_css_class( 'gfield_description', self::$uikit_css_classes_mapping[ 'gfield_description' ], $field_container );

		return $field_container;
	}


	/**
	 * @param string $confirmation_html
	 * @param $form
	 * @param $lead
	 * @param $ajax
	 *
	 * @return string
	 */
	public static function gform_confirmation_map_css_classes( $confirmation_html = '', $form, $lead, $ajax ){
		return TF_Template::modify_css_class( 'gform_confirmation_message', self::$uikit_css_classes_mapping[ 'gform_confirmation_message' ], $confirmation_html );;
	}


	/**
	 * @param string    $validation_message_html
	 * @param array     $form
	 *
	 * @return string
	 */
	public static function gform_validation_message_map_css_classes( $validation_message_html = '', $form = array() ){
		return TF_Template::modify_css_class( 'validation_error', self::$uikit_css_classes_mapping[ 'validation_error' ], $validation_message_html );
	}


	/**
	 * Get the submitted value in an entry by it's field type
	 *
	 * @todo Clean this bitch up
	 *
	 * @param array     $entry
	 * @param string    $field_type
	 *
	 * @return string   $value
	 */
	public static function get_entry_field_type_value( $entry = array(), $field_type = ''){

		$form = self::get_form_object( $entry['form_id'] );
		$form_fields_entry_input_ids = array();
		$form_fields = $form['fields'];
		foreach( $form_fields as $key => $field ){

			if( $field_type != $field->get_input_type() ) continue;

			if( ! $field->label ) continue;
			$field_input_ids = array();
			$field_entry_inputs = $field->get_entry_inputs() ;

			if( is_array($field_entry_inputs) ){
				foreach($field_entry_inputs as $k => $input ){
					$field_input_ids[] = $input['id'];
				}
			}

			$form_fields_entry_input_ids[$field->label] = count( $field_input_ids ) == 0 ? $field->id : $form_fields_entry_input_ids ;
		}

		$entry_form_field_values = array();
		foreach( $entry as $key => $value ){
			$int_val_key = intval( $key );
			if( intval( $int_val_key ) > 0 ){
				foreach( $form_fields_entry_input_ids as $label => $id ){
					if( is_array( $id ) ){
						if( in_array( $int_val_key, $id ) ){
							$entry_form_field_values[ $label ] = $value;
						}
					}else if ( $id == $key ) {
						$entry_form_field_values[ $label ] = $value;
					}
				}
			}
		}
		$value = array_shift( $entry_form_field_values );
		return $value;
	}


	public static function update_entry( $entry, $entry_id){

		if( ! class_exists( 'GFAPI' ) ) return null;

		return GFAPI::update_entry($entry, $entry_id );
	}


	public static function get_entries_count( $form_id, $search_criteria, $paging ){
		return count( self::get_entries( $form_id, $search_criteria, $paging ) );
	}


	public static function get_entries( $form_id, $search_criteria, $paging ){

		if( ! class_exists( 'GFAPI' ) ) return null;

		return GFAPI::get_entries( $form_id, $search_criteria, null, $paging );

	}


	public static function get_forms( $active = true, $trash = false ){

		if( !class_exists( 'GFAPI') ) return null;

		return GFAPI::get_forms( $active, $trash );
	}


	/**
	 * Looks into the fields directory and loads all the files in their,
	 * or in the folder and looks for a file with the same name as the folder.
	 */
	public static function load_fields(){
		foreach (new DirectoryIterator(__DIR__.'/fields') as $file) {
			if ( $file->isFile() ){
				require_once( $file->getFileInfo()->getPathname() );
			}
			else if( $file->isDir() && file_exists( $file->getPathname().'/'.$file->getFilename().'.php') ){
				require_once( $file->getPathname().'/'.$file->getFilename().'.php' );
			}

		}
	}


	/**
	 * Gets first instance of field type from fields array
	 * @param string $field_type
	 * @param array $fields
	 *
	 * @return bool|GF_Field
	 */
	public static function get_field( $field_type = 'text', $fields = array() ){

		foreach($fields as $key => $field){

			if( $field_type == $field->type ){
				$field->index = $key;
				return $field;
			}

		}

		return false;
	}


	/**
	 * Finds the first instance of a specific field type
	 * and returns it's form field ID
	 *
	 * @param string $field_type
	 * @param array $fields
	 *
	 * @return bool|int
	 */
	public static function get_field_id( $field_type = 'text', $fields = array() ){
		$field = self::get_field( $field_type, $fields );
		if( $field ){
			return $field->id;
		}else{
			return $field;
		}
	}


	/**
	 * Helper function
	 * Gets the first instance field type and returns its index
	 *
	 * @param string $field_type
	 * @param array $fields array
	 *
	 * @return bool
	 */
	public static function get_field_index( $field_type = 'text', $fields = array() ){
		$field = self::get_field( $field_type, $fields );
		if( $field ){
			return $field->index;
		}else{
			return $field;
		}
	}

}



function remove_field_container_for_photo_uploads( $field_container, $field, $form, $css_class, $style, $field_content ) {

	if ( $field->get_input_type() == 'post_image' && !is_admin() ){
		$field_container = '{FIELD_CONTENT}';
	}

	return $field_container;
}
add_filter( 'gform_field_container', 'remove_field_container_for_photo_uploads', null, 6 );


function set_template_for_file_uploads_control( $content, $field, $value, $lead_id, $form_id ){

	if( 'post_image' != $field->get_input_type() || is_admin() ) return $content;

	$content_temp = $content;
	$content = TF_Template::return_template_part( 'templates/gf_field_post_image', 'uikit' );
	$content = str_replace( '{FIELD_CONTENT}', $content_temp, $content );
	$content = str_replace( '{FIELD_ID}', $field->id, $content );
	$content = str_replace( '{FORM_ID}', $field->formId, $content );
	$content = str_replace( '{FIELD_CLASS}', $field->cssClass, $content );


	/**
	 * If a file was already selected but the form is still showing,
	 * show the temp file uploaded on the overlay
	 * i.e. in the event of validation errors on forms
	 */
	$temp_file_upload_url = null;
	$input_name     = "input_{$field->id}";
	$temp_details = RGFormsModel::get_temp_filename( $form_id, $input_name );
	if( !empty( $temp_details) && is_array( $temp_details ) && array_key_exists( 'temp_filename', $temp_details ) ){
		$temp_file_upload_url = 'url('.GFFormsModel::get_upload_url( $form_id ) . '/tmp/' . $temp_details['temp_filename'].')';
	}
	$content = str_replace( '{TEMP_FILE_URL}', $temp_file_upload_url, $content );
	$overlay_class = empty( trim( $temp_file_upload_url ) ) ? 'uk-hidden' : '';
	$content = str_replace( '{OVERLAY_CLASS}', $overlay_class, $content );

	return $content;
}


add_action( 'wp_enqueue_scripts', function(){
	wp_localize_script( 'tf_gf_addons', 'TF_GF_Field_Post_Image', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'drag_and_drop_action' => 'upload_dropped_post_image_to_temp'
	));
} );

add_filter( 'gform_field_content', 'set_template_for_file_uploads_control', null, 5);



/**
 * Changes the Gravity forms Section h2 tag -> h6 tag
 *
 * @param string        $content
 * @param GF_Field      $field
 * @param string        $value
 * @param int           $lead_id
 * @param int           $form_id
 *
 * @return string       $content
 */
function change_section_element_tag( $content = '', $field, $value, $lead_id, $form_id ){
	return $content = ( 'section'  == $field->get_input_type() && !is_admin() ) ? TF_Template::modify_html_tags( 'h2', 'h6', $content ) : $content;
}
add_filter( 'gform_field_content', 'change_section_element_tag', null, 5);


/**
 *
 * @link https://www.gravityhelp.com/documentation/article/gform_register_init_scripts/
 *
 * @todo only output if the form contains the post image upload
 *
 * @param $form
 */
function tf_gf_modify_post_image_uploads_script( $form ) {

	$file = __DIR__.'/js/functions.js';
	if( is_admin() || !file_exists( $file ) ) return;

	$script = file_get_contents( $file );

    GFFormDisplay::add_init_script( $form['id'], 'tf_uk_photo_select_drop_zone_scripts', GFFormDisplay::ON_PAGE_RENDER, $script );
}

/**
* @todo Refactor this action
* add_action( 'gform_register_init_scripts', 'tf_gf_modify_post_image_uploads_script' );
*/


/**
 * Adds two new columns to the Entry Custom Post Type Table
 *
 * @todo move to the class in tf-core that registers the custom post type
 * @link https://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
 *
 * @param $defaults
 *
 * @return mixed
 */
function ST4_columns_book_head($defaults) {
	$defaults[ 'vote_count' ]  = 'Votes';
	return $defaults;
}


/**
 * Adds content to the two new columns for the Entry WP List Table
 *
 * @link https://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
 *
 * @param $column_name
 * @param $post_ID
 */
function ST4_columns_book_content($column_name, $post_id) {
	if ($column_name == 'vote_count') {
		echo get_post_meta( $post_id, 'votes', true); //some posts may not
	}
}


/**
 *
 * https://code.tutsplus.com/articles/quick-tip-make-your-custom-column-sortable--wp-2{5095
 *
 * @param $query
 */
function maybe_orderby_votes( $query ) {
	if( ! is_admin() )
		return;

	$orderby = $query->get( 'orderby');

	if( 'Votes' == $orderby ){
		$query->set('meta_key','votes');
		$query->set('orderby','meta_value_num');
	}
}
add_action( 'pre_get_posts', 'maybe_orderby_votes' );



function register_taxes(){
	$labels = array(
		'name' => _x('Entries', 'post type general name'),
		'singular_name' => _x('Entry', 'post type singular name'),
		'add_new' => _x('Add Entry', 'Issue'),
		'add_new_item' => __('Add Entry'),
		'edit_item' => __('Edit Entry'),
		'new_item' => __('New Entry'),
		'view_item' => __('View Entry'),
		'search_items' => __('Search Entries'),
		'not_found' =>  __('No Entries found'),
		'not_found_in_trash' => __('No Entries found in Trash'),
		'parent_item_colon' => '>',
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu'=>true,
		'query_var' => true,
		'rewrite'  => array('slug' => date('Y').'-'.__('entries')),
		'capability_type' => 'post',
		'exclude_from_search' => false,
		'has_archive' => true,
		'hierarchical' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor','excerpt','thumbnail','comments', 'custom-fields'),
		'can_export'    => true,
		'taxonomies'  => array( 'category' ),
	);
	register_post_type( 'entry', $args );

}

add_action('init','register_taxes');



/**
 * Set the post type to 'entry' for the enter form
 * @link https://www.gravityhelp.com/documentation/article/gform_post_data/
 */
function tf_modify_post_data( $post_data, $form, $entry ){
	$enter_form_id = TF_Customizer::get_option( 'entry_form_id' );

	if ( $form['id'] !=  $enter_form_id ) return $post_data;

	$post_data['post_type'] = 'entry';
	return $post_data;
}
add_filter( 'gform_post_data', 'tf_modify_post_data', null, 3 );


spl_autoload_register(function ($class_name) {
	$paths_to_check = array();
	$paths_to_check[] = __DIR__.'/'.$class_name.'/'.$class_name.'.php';
	foreach( $paths_to_check as $path ){
		if( file_exists( $path ) ){
			require_once( $path );
			break;
		}
	}
});

new TF_Forms();
