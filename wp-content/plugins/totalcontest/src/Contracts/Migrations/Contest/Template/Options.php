<?php

namespace TotalContest\Contracts\Migrations\Contest\Template;
! defined( 'ABSPATH' ) && exit();


/**
 * Interface Options
 * @package TotalContest\Contracts\Migrations\Contest\Template
 */
interface Options extends Template {
	/**
	 * @param $section
	 * @param $value
	 *
	 * @return mixed
	 */
	public function addOption( $section, $value );
}
