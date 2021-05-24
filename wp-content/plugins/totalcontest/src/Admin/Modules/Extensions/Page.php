<?php

namespace TotalContest\Admin\Modules\Extensions;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Admin\Pages\Page as TotalCoreAdminPage;
use TotalContestVendors\TotalCore\Helpers\Tracking;

/**
 * Class Page
 * @package TotalContest\Admin\Modules\Extensions
 */
class Page extends TotalCoreAdminPage {
	/**
	 * Page assets.
	 */
	public function assets() {
		/**
		 * @asset-script totalcontest-admin-modules
		 */
		wp_enqueue_script( 'totalcontest-admin-modules' );
		/**
		 * @asset-style totalcontest-admin-modules
		 */
		wp_enqueue_style( 'totalcontest-admin-modules' );
	}

	/**
	 * Page content.
	 */
	public function render() {
        Tracking::trackScreens('extensions');
		include __DIR__ . '/views/index.php';
	}
}