<?php

namespace TotalContestVendors\TotalCore\Contracts\Restrictions;
! defined( 'ABSPATH' ) && exit();


/**
 * Interface Restriction
 * @package TotalContestVendors\TotalCore\Contracts\Restrictions
 */
interface Restriction {
	/**
	 * Check logic.
	 *
	 * @return bool
	 */
	public function check();

	/**
	 * Applying restriction logic.
	 *
	 * @return bool
	 */
	public function apply();
}