<?php

namespace TotalContest\Form\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Contracts\Form\Page;

/**
 * Class ImageField
 * @package TotalContest\Form\Fields
 */
class ImageField extends MediaField {
	public function getType() {
		return 'image';
	}

	public function onAttach( Page $page ) {
		return;
	}
}