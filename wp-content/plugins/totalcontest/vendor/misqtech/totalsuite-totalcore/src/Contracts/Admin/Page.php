<?php

namespace TotalContestVendors\TotalCore\Contracts\Admin;
! defined( 'ABSPATH' ) && exit();


/**
 * Class Page
 * @package TotalContestVendors\TotalCore\Admin\Pages
 */
interface Page {
	/**
	 * Enqueue assets.
	 *
	 * @return mixed
	 */
	public function assets();

	/**
	 * Save page content or settings.
	 *
	 * @return mixed
	 */
	public function save();

	/**
	 * Render page.
	 *
	 * @return mixed
	 */
	public function render();
}