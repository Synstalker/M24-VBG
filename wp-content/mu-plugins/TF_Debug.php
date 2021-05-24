<?php

/**
 * Class TF_Debug
 *
 * @todo indicate that there are issues in the debug log
 */
class TF_Debug {

	public static function log( $log ){

		if ( defined( 'WP_DEBUG' ) && true == WP_DEBUG ) {

            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }

	}


	/**
	 * @link http://php.net/manual/en/function.trigger-error.phps
	 * @param string $message
	 */
	public static function warn( $message = '' ){
		trigger_error( $message, E_USER_ERROR );
	}
}