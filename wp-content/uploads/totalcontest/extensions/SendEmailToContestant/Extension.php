<?php

namespace TotalContest\Modules\Extensions\SendEmailToContestant;

/**
 * Class Extension
 * @package TotalContest\Modules\Extensions\SendEmailToContestant
 */
class Extension extends \TotalContest\Modules\Extension {
	protected $root = __FILE__;

	/**
	 * Run the extension.
	 *
	 * @return mixed
	 */
	public function run() {
		add_filter( 'totalcontest/filters/contest/settings-item/notifications.email', function ( $value, $settings, $default, $contest ) {
			$value = str_replace( '{{contestantEmail}}', TotalContest( 'http.request' )->post( 'totalcontest.email_txt' ), $value );

			return $value;
		}, 10, 4 );
	}
}
