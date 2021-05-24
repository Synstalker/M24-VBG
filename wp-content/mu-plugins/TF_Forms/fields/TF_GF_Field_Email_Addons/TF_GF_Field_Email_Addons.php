<?php

/**
 * Created by PhpStorm.
 * User: craigwayne
 * Date: 2017/02/21
 * Time: 9:07 AM
 */

if ( class_exists( 'GFForms' ) && class_exists( 'GFAddOn' ) ) {

	class TF_GF_Field_Email_Addons extends GFAddOn {

		protected $_version = '0.1.0';
		protected $_min_gravityforms_version = '2.1.2.1';
		protected $_slug = 'tf_gf_field_email_addons';
		protected $_full_path = __FILE__;
		protected $_title = 'Email Field Addons for Gravity Forms';
		protected $_short_title = 'Email Field Addons';

		static $business_rules = array(
			'business_rules_restrict_email_per_entry' => array(
				'tooltip' => '<h6>Voting Example</h6>Mike can vote for any number of entrants he wants with the same email address, but only x Number of times.'
			),
			'business_rules_restrict_email_per_entry_per_day' => array(
				'tooltip' => '<h6>Prize Example</h6>Jared can enter for the prize of the week with his email address, but only x number of times per day using that email address.'
			),
			'business_rules_restrict_email_total_casts' => array(
				'tooltip' => '<h6>Voting Example</h6>Thulani is allowed (x Number) of votes he may cast for the day... after which he will be stopped from voting'
			)
		);


		public function __construct() {
			add_action( 'gform_field_standard_settings', array( __CLASS__, 'gform_field_standard_settings' ), 10, 2 );
			add_filter( 'gform_validation', array( __CLASS__, 'validate_email_count_per_entry' ) );
			add_filter( 'gform_validation', array( __CLASS__, 'validate_email_count_per_entry_per_day' ) );
			add_filter( 'gform_validation', array( __CLASS__, 'validate_email_total_casts' ) );
			parent::__construct();
		}


		public function scripts() {
			$min     = ( defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG ) ? '' : '.min';
			$src  = $this->get_base_url().'/TF_GF_Field_Email_Addons'."{$min}".'.js';
			$version = 1;
			$scripts = array(
				array(
					'handle'    => 'tf_gf_field_email_addons_admin',
					'src'       => $src,
					'version'   => $version,
					'deps'      => array( 'jquery' ),
					'in_footer' => true,
					'enqueue' => array(
						array(
							'field_types' => array( 'email' ),
						),
					),
				)
			);

			return array_merge( parent::scripts(), $scripts );
		}


		public static function gform_field_standard_settings( $position, $form_id ) {
			if ( 1600 != $position )  return;
			?>
				<li class='business_email_rules_settings field_setting'>
					<hr/>
					<br/>
					<div></div>
						<label class="section_label"><?php _e( 'Post ID Rules' ); ?></label>
						<label><i>NOTE: these rules only work if a Post ID Control is used...</i></label>
						<ul>
							<li>
								<a href="#" onclick="return false;" onkeypress="return false;" class="gf_tooltip tooltip" title="<h6>Voting Example</h6>Mike can vote for any number of entrants he wants with the same email address, but only x Number of times."><i class="fa fa-question-circle"></i></a>
								<input type="checkbox" id="toggle_business_rules_restrict_email_per_entry" onchange="SetFieldProperty( this.id, this.checked);"/>&nbsp;Restrict to <input type="number" min="1" style="width:50px;" value="1" id="business_rules_restrict_email_per_entry" onchange="SetFieldProperty( this.id, this.value);"/> duplicate email address(es) per entry
							</li>
							<li>
								<a href="#" onclick="return false;" onkeypress="return false;" class="gf_tooltip tooltip" title="<h6>Prize Example</h6>Jared can enter for the prize of the week with his email address, but only x number of times per day using that email address."><i class="fa fa-question-circle"></i></a>
								<input type="checkbox" id="toggle_business_rules_restrict_email_per_entry_per_day" onchange="SetFieldProperty( this.id, this.checked);">&nbsp;Restrict to <input type="number" min="1" style="width:50px;" value="1" id="business_rules_restrict_email_per_entry_per_day" onchange="SetFieldProperty( this.id, this.value);" /> duplicate email address(es) per entry per day
							</li>
							<li>
								<a href="#" onclick="return false;" onkeypress="return false;" class="gf_tooltip tooltip" title="<h6>Voting Example</h6>Thulani is allowed (x Number) of votes he may cast for the day... after which he will be stopped from voting"><i class="fa fa-question-circle"></i></a>
								<input type="checkbox" id="toggle_business_rules_restrict_email_total_casts" onchange="SetFieldProperty( this.id, this.checked);">&nbsp;Restrict to <input type="number" min="1" style="width:50px;" value="1" id="business_rules_restrict_email_total_casts" onchange="SetFieldProperty( this.id, this.value);"/> duplicate email address(es) irrespective of entry
							</li>
						</ul>
					<hr/>
				</li>
			<?php
		}


		/**
		 * Validates if the toggle_business_rules_restrict_email_per_entry setting is on
		 *
		 * Checks number of entries for this email and for this post id
		 * and validates according to the business_rules_restrict_email_per_entry value
		 * set in the Email Business Rules Setting
		 *
		 * @see /plugins/gravityforms/form_display.php:1603
		 *
		 * @param array     $validation_result
		 *
		 * @return array    $validation_result
		 */
		public static function validate_email_count_per_entry( $validation_result = array() ) {

			if ( true != $validation_result['is_valid'] ) return $validation_result;

			$form = $validation_result['form'];
			$email_field_index = TF_Forms::get_field_index( 'email', $form['fields'] );

			/**
			 * Checks if this Business Rule setting is enabled
			 */
			if ( rgar( $validation_result['form']['fields'][$email_field_index], 'toggle_business_rules_restrict_email_per_entry' ) != true ) return $validation_result;


			$post_id_field_index = TF_Forms::get_field_index( 'post_id', $form['fields'] );

			if( !$post_id_field_index ){
				error_log( 'Form is not configured correctly. These email validation rules require a Post ID control as stated on the setting itself.');
				$validation_result['is_valid'] = false;
				$form['fields'][$email_field_index]->failed_validation = true;
				$form['fields'][$email_field_index]->validation_message = __('Something went wrong. Contact the Site Administrator.');
				$form['fields'][$email_field_index]->errorMessage = $form['fields'][$email_field_index]->validation_message;
				return $validation_result;
			}


			$post_id_form_field_id = TF_Forms::get_field_id( 'post_id', $form['fields'] );
			$post_id_value = rgpost('input_'.$post_id_form_field_id);

			$email_form_field_id = TF_Forms::get_field_id( 'email', $form['fields'] );
			$email_value_submitted = rgpost('input_'.$email_form_field_id );


			$search_criteria['field_filters'][] = array( 'key' => $email_form_field_id, 'value' => $email_value_submitted );
			$search_criteria['field_filters'][] = array( 'key' => $post_id_form_field_id, 'value' => $post_id_value );
			$paging = array( 'offset' => 0, 'page_size' => 1 );

			$max_allowed = rgar( $validation_result['form']['fields'][$email_field_index], 'business_rules_restrict_email_per_entry' ) ?: 1;
			$count = TF_Forms::get_entries_count( $form['id'], $search_criteria, null, $paging );

			if( $count >= $max_allowed ){
				$validation_result['is_valid'] = false;
				$form['fields'][$email_field_index]->failed_validation = true;
				$form['fields'][$email_field_index]->validation_message = $form['fields'][$email_field_index]->errorMessage ?: __('Failed Business Rule Validation. <br/> Exceeded number of votes on this entry. <br/>You should changed this message. ');
				$form['fields'][$email_field_index]->errorMessage = $form['fields'][$email_field_index]->validation_message;
			}


			return $validation_result;
		}


		/**
		 * Validates if the toggle_business_rules_restrict_email_per_entry_per_day setting is on
		 *
		 * Checks number of entries for this email and for this post id
		 * and validates according to the business_rules_restrict_email_per_entry_per_day value
		 * set in the Email Business Rules Setting
		 *
		 * @see /plugins/gravityforms/form_display.php:1603
		 *
		 * @param array     $validation_result
		 *
		 * @return array    $validation_result
		 */
		public static function validate_email_count_per_entry_per_day( $validation_result = array() ) {

			if ( true != $validation_result['is_valid'] ) return $validation_result;

			$form = $validation_result['form'];
			$email_field_index = TF_Forms::get_field_index( 'email', $form['fields'] );


			/**
			 * Checks if this Business Rule setting is enabled
			 */
			if ( rgar( $validation_result['form']['fields'][$email_field_index], 'toggle_business_rules_restrict_email_per_entry_per_day' ) != true ) return $validation_result;

			$post_id_field_index = TF_Forms::get_field_index( 'post_id', $form['fields'] );

			if( !$post_id_field_index ){
				error_log( 'Form is not configured correctly. These email validation rules require a Post ID control as stated on the setting itself.');
				$validation_result['is_valid'] = false;
				$form['fields'][$email_field_index]->failed_validation = true;
				$form['fields'][$email_field_index]->validation_message = __('Something went wrong. Contact the Site Administrator.');
				$form['fields'][$email_field_index]->errorMessage = $form['fields'][$email_field_index]->validation_message;
				return $validation_result;
			}


			$post_id_form_field_id = TF_Forms::get_field_id( 'post_id', $form['fields'] );
			$post_id_value = rgpost('input_'.$post_id_form_field_id);

			$email_form_field_id = TF_Forms::get_field_id( 'email', $form['fields'] );
			$email_value_submitted = rgpost('input_'.$email_form_field_id );


			$search_criteria['field_filters'][] = array( 'key' => $email_form_field_id, 'value' => $email_value_submitted );
			$search_criteria['field_filters'][] = array( 'key' => $post_id_form_field_id, 'value' => $post_id_value );
			$search_criteria['start_date']      = date( 'Y-m-d', time() );
			$search_criteria['end_date']        = date( 'Y-m-d', time() );
			$paging = array( 'offset' => 0, 'page_size' => 1 );

			$max_allowed = rgar( $validation_result['form']['fields'][$email_field_index], 'business_rules_restrict_email_per_entry_per_day' ) ?: 1;
			$count = TF_Forms::get_entries_count( $form['id'], $search_criteria, null, $paging );

			if( $count >= $max_allowed ){
				$validation_result['is_valid'] = false;
				$form['fields'][$email_field_index]->failed_validation = true;
				$form['fields'][$email_field_index]->validation_message = $form['fields'][$email_field_index]->errorMessage ?: __('Failed Business Rule Validation. <br/> Exceeded number of votes on this entry for today. <br/>You should changed this message. ');
				$form['fields'][$email_field_index]->errorMessage = $form['fields'][$email_field_index]->validation_message;
			}



			return $validation_result;
		}


		/**
		 * Validates if the toggle_business_rules_restrict_email_total_casts setting is on
		 *
		 * Checks number of entries for this email and for this post id
		 * and validates according to the business_rules_restrict_email_total_casts value
		 * set in the Email Business Rules Setting
		 *
		 * @see /plugins/gravityforms/form_display.php:1603
		 *
		 * @param array     $validation_result
		 *
		 * @return array    $validation_result
		 */
		public static function validate_email_total_casts( $validation_result = array() ) {

			if ( true != $validation_result['is_valid'] ) return $validation_result;

			$form = $validation_result['form'];
			$email_field_index = TF_Forms::get_field_index( 'email', $form['fields'] );


			/**
			 * Checks if this Business Rule setting is enabled
			 */
			if ( rgar( $validation_result['form']['fields'][$email_field_index], 'toggle_business_rules_restrict_email_total_casts' ) != true ) return $validation_result;

			$post_id_field_index = TF_Forms::get_field_index( 'post_id', $form['fields'] );

			if( !$post_id_field_index ){
				error_log( 'Form is not configured correctly. These email validation rules require a Post ID control as stated on the setting itself.');
				$validation_result['is_valid'] = false;
				$form['fields'][$email_field_index]->failed_validation = true;
				$form['fields'][$email_field_index]->validation_message = __('Something went wrong. Contact the Site Administrator.');
				$form['fields'][$email_field_index]->errorMessage = $form['fields'][$email_field_index]->validation_message;
				return $validation_result;
			}


			$post_id_form_field_id = TF_Forms::get_field_id( 'post_id', $form['fields'] );
			$post_id_value = rgpost('input_'.$post_id_form_field_id);

			$email_form_field_id = TF_Forms::get_field_id( 'email', $form['fields'] );
			$email_value_submitted = rgpost('input_'.$email_form_field_id );

			$search_criteria['field_filters'][] = array( 'key' => $email_form_field_id, 'value' => $email_value_submitted );
			$search_criteria['field_filters'][] = array( 'key' => $post_id_form_field_id, 'value' => $post_id_value );
			$search_criteria['start_date']      = date( 'Y-m-d', time() );
			$search_criteria['end_date']        = date( 'Y-m-d', time() );
			$paging = array( 'offset' => 0, 'page_size' => 1 );

			$max_allowed = rgar( $validation_result['form']['fields'][$email_field_index], 'business_rules_restrict_email_total_casts' ) ?: 1;
			$count = TF_Forms::get_entries_count( $form['id'], $search_criteria, null, $paging );

			if( $count >= $max_allowed ){
				$validation_result['is_valid'] = false;
				$form['fields'][$email_field_index]->failed_validation = true;
				$form['fields'][$email_field_index]->validation_message = $form['fields'][$email_field_index]->errorMessage ?: __('Failed Business Rule Validation. <br/> Exceeded number of votes on this entry for today. <br/>You should changed this message. ');
				$form['fields'][$email_field_index]->errorMessage = $form['fields'][$email_field_index]->validation_message;
			}


			return $validation_result;
		}

	}

	new TF_GF_Field_Email_Addons();
}