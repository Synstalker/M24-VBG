<?php

/**
 * Class TF_Comment
 *
 * @todo make the recaptcha script url customizable
 * @todo recpatcha error message should be configurable... think of the afrikaans sites
 */
class TF_Comment {

	const recaptcha_js_url = 'https://www.google.com/recaptcha/api.js';


	public function __construct(){
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		self::maybe_enable_recaptcha();
	}


	/**
	 * Checks if reCAPTCHA settings are present
	 * then performs the necessary operations to implement the recapture field into forms
	 */
	private static function maybe_enable_recaptcha(){

		$recaptcha_for_comments_toggle      = get_option( 'recaptcha_for_comments_toggle' );
		$recaptcha_for_comments_site_key    = get_option( 'recaptcha_for_comments_site_key' );
		$recaptcha_for_comments_site_secret = get_option( 'recaptcha_for_comments_site_secret' );

		if( $recaptcha_for_comments_toggle == true && ! empty( $recaptcha_for_comments_site_key ) && ! empty( $recaptcha_for_comments_site_secret ) ){
			add_action( 'wp_enqueue_scripts', function(){
				wp_register_script( 'recaptcha_external', self::recaptcha_js_url );
				wp_enqueue_script( 'recaptcha_external' );
			}) ;

			add_action( 'comment_form_after_fields', function(){

				$template = locate_template('templates/comment-field-recaptcha.php');

				if( $template != '' ){
					get_template_part( 'templates/comment-field','recaptcha' );
				}else{

					$recaptcha_for_comments_site_key = get_option( 'recaptcha_for_comments_site_key' );
					$recaptcha_css_class = '';
					if( isset( $_GET['submission'] ) && 'security_recaptcha' === $_GET['submission'] ) {
						$recaptcha_css_class = 'security_fail';
						echo '<div style="color:red">' . __( 'Security check fail - you appear to be a bot', 'twenytfourdotcom' ) . '</div>';
					}
					echo '<div class="g-recaptcha ' . $recaptcha_css_class . '" data-sitekey="'.$recaptcha_for_comments_site_key.'" ></div>';
				}

			} );

			//only add the reCaptcha validation for logged out users
			if( !is_user_logged_in() ){
				add_filter( 'preprocess_comment', array( __CLASS__, 'validate_recaptcha' ) );
			}

		}
	}



	static function display_recaptcha_toggle_setting( $args ) {
		$option_name = 'recaptcha_for_comments_toggle';
		$data = esc_attr( get_option( $option_name, '' ) );
		$checked = $data == true ? 'checked=checked' : '';
		printf(
			'<input type="checkbox" name="%1$s" id="%2$s" %3$s/>',
			$option_name,
			$args['label_for'],
			$checked
		);
	}


	static function display_recaptcha_site_key_setting( $args ) {
		$option_name = 'recaptcha_for_comments_site_key';
		$data = esc_attr( get_option( $option_name, '' ) );
		printf(
			'<input class="widefat" type="text" name="%1$s" id="%2$s" value="%3$s"/>',
			$option_name,
			$args['label_for'],
			$data
		);
	}


	static function display_recaptcha_site_secret_setting( $args ) {
		$option_name = 'recaptcha_for_comments_site_secret';
		$data = esc_attr( get_option( $option_name, '' ) );
		printf(
			'<input class="widefat" type="text" name="%1$s" id="%2$s" value="%3$s"/>',
			$option_name,
			$args['label_for'],
			$data
		);
	}


	static function recaptcha_for_comments_description() {
		?>
		<p class="description">Integrate reCAPTCHA into WordPress comments. For more info, visit <a href="https://www.google.com/recaptcha" target="_blank">reCAPTCHA's website</a>.<br/><span style="color:red"><strong>Note:</strong></span> that reCaptcha will not appear for logged in users.</p>
		<?php
	}


	/**
	 * Server side validation for reCAPTCHA
	 *
	 * @param $comment_data
	 *
	 * @return mixed
	 */
	static function validate_recaptcha( $comment_data ) {
		$secret     = get_option( 'recaptcha_for_comments_site_secret' );
		$response   = array_key_exists( 'g-recaptcha-response', $_POST ) ?  $_POST['g-recaptcha-response'] : '';
		$verify     = file_get_contents( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response );
		$captcha_success = json_decode( $verify );

		if ( ! $captcha_success->success ) {
			wp_die( __( 'Error: reCAPTCHA failed... Go Back and try again...' ) );
			exit();
		}

		return $comment_data;
	}


	/**
	 * Based on the example used here
	 *
	 * @link http://wordpress.stackexchange.com/questions/97212/add-settings-fields-on-options-discussion-admin-page
	 */
	static function register_settings(){
		//this function should maybe reference the TF_Settings class
		add_settings_section(
			'recaptcha_for_comments_id',
			'reCAPTCHA',
			array( __CLASS__, 'recaptcha_for_comments_description' ),
			'discussion'
		);

		// Register a callback
		register_setting(
			'discussion',
			'recaptcha_for_comments_toggle',
			'trim'
		);

		register_setting(
			'discussion',
			'recaptcha_for_comments_site_key',
			'trim'
		);

		register_setting(
			'discussion',
			'recaptcha_for_comments_site_secret',
			'trim'
		);

		// Register the field for the "avatars" section.
		add_settings_field(
			'recaptcha_for_comments_toggle',
			'Turn On / Off',
			array( __CLASS__, 'display_recaptcha_toggle_setting' ),
			'discussion',
			'recaptcha_for_comments_id',
			array ( 'label_for' => 'recaptcha_for_comments_id' )
		);

		add_settings_field(
			'recaptcha_for_comments_site_key',
			'Site Key',
			array( __CLASS__, 'display_recaptcha_site_key_setting' ),
			'discussion',
			'recaptcha_for_comments_id',
			array ( 'label_for' => 'recaptcha_for_comments_id' )
		);

		add_settings_field(
			'recaptcha_for_comments_site_secret',
			'Site Secret',
			array( __CLASS__, 'display_recaptcha_site_secret_setting' ),
			'discussion',
			'recaptcha_for_comments_id',
			array ( 'label_for' => 'recaptcha_for_comments_id' )
		);
	}

}