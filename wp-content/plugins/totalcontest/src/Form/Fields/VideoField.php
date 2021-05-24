<?php

namespace TotalContest\Form\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Contracts\Form\Page;

/**
 * Class VideoField
 * @package TotalContest\Form\Fields
 */
class VideoField extends MediaField {
	public function getType() {
		return 'video';
	}

	public function onAttach( Page $page ) {
		parent::onAttach( $page );
		if ( $this->urlField ):
			$this->urlField->setOption( 'label', __( 'Video link', 'totalcontest' ) );
		endif;
	}
}