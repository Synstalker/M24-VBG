<?php

if ( class_exists( 'GFForms' ) ) {

	/**
	 * Class TF_GF_Field_YouTube
	 * Gravity Forms YouTube URL Field
	 *
	 * Extends the Website Field Control to provide better validation
	 * based on common youtube checks
	 */
	class TF_GF_Field_YouTube extends GF_Field_Website {

		/**
		 * @var string $type The field type.
		 */
		public $type        = 'youtube_website';
		public $label       = 'YouTube URL';
		public $title       = 'YouTube URL';


		public function __construct( $data = array() ) {
			add_filter( 'gform_field_validation', array( $this, 'validation' ), null, 4 );
			parent::__construct( $data );

		}


		public function get_form_editor_button() {
			return array(
				'group' => 'advanced_fields',
				'text'  => 'YouTube'
			);
		}

		public function get_field_label( $force_frontend_label, $value ){
			return $this->label;
		}


		/**
		 *
		 * Tested with the following formats:
		 * - https://www.youtube.com/watch?v=J6vIS8jb6Fs
		 * - https://youtu.be/J6vIS8jb6Fs
		 * - https://m.youtube.com/watch?v=J6vIS8jb6Fs
		 * - http://www.youtube.com/watch?v=A_6gNZCkajU&feature=relmfu
		 *
		 * @link http://www.rubular.com/r/vNcnfitUlW
		 * @link http://stackoverflow.com/questions/5830387/how-to-find-all-youtube-video-ids-in-a-string-using-a-regex/5831191#5831191
		 *
		 * @param $result
		 * @param $value
		 * @param $form
		 * @param $field
		 *
		 * @return $result  Validation Result
		 */
		public function validation( $result, $value, $form, $field ){

			if( $this->type != $field->type ) return $result;

			/**
			 *
			 */
			$pattern = "/https?:\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube(?:-nocookie)?\.com\S*?[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'\"][^<>]*>|<\/a>))[?=&+%\w.-]*/mi";
			if( !preg_match( $pattern, $value )){
				$result['is_valid'] = false;

				/**
				 * This allows the admin user to set the error message from the backend
				 */
				$result['message']  = key_exists( 'errorMessage', $field ) ?  $field->errorMessage : null;

				/**
				 * This is the fallback error message should they not set this in the backend.
				 */
				$result['message']  = $result['message'] ?: 'Please enter a valid YouTube link & Please no PLAYLISTS';
			}

			return $result;
		}

	}
	GF_Fields::register( new TF_GF_Field_YouTube() );
}



