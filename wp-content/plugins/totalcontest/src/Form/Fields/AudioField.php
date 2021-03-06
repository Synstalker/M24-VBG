<?php

namespace TotalContest\Form\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Contracts\Form\Page;

/**
 * Class AudioField
 * @package TotalContest\Form\Fields
 */
class AudioField extends MediaField {
	public function getType() {
		return 'audio';
	}

	public function onAttach( Page $page ) {
		parent::onAttach( $page );
		if ( $this->urlField ):
			$this->urlField->setOption( 'label', __( 'Audio link', 'totalcontest' ) );
		endif;
	}
}