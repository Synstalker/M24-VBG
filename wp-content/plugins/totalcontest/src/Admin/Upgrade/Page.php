<?php

namespace TotalContest\Admin\Upgrade;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Admin\Pages\Page as TotalCoreAdminPage;
use TotalContestVendors\TotalCore\Helpers\Tracking;

/**
 * Class Page
 * @package TotalContest\Admin\Upgrade
 */
class Page extends TotalCoreAdminPage {

	/**
	 * Page assets.
	 */
	public function assets() {
		wp_enqueue_style( 'totalcontest-admin-upgrade-to-pro' );
	}

	/**
	 * Page content.
	 */
	public function render() {
	    Tracking::trackScreens('upgrade-to-pro');
		include __DIR__ . '/views/index.php';
	}
}