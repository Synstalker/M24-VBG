<?php

namespace TotalContestVendors\TotalCore\Contracts\Http;
! defined( 'ABSPATH' ) && exit();


/**
 * Interface Response
 * @package TotalContestVendors\TotalCore\Contracts\Http
 */
interface Response {
	/**
	 * Send response.
	 *
	 * @return $this
	 */
	public function send();
}