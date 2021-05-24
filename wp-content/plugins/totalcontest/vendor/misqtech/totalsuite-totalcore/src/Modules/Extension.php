<?php

namespace TotalContestVendors\TotalCore\Modules;
! defined( 'ABSPATH' ) && exit();


/**
 * Class Extension
 * @package TotalContestVendors\TotalCore\Modules
 */
abstract class Extension extends Module {
	/**
	 * Run the extension.
	 *
	 * @return mixed
	 */
	abstract public function run();
}