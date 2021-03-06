<?php

namespace TotalContest\Shortcode;
! defined( 'ABSPATH' ) && exit();


/**
 * Contest shortcode class
 * @package TotalContest\Shortcode
 * @since   1.0.0
 */
class Contest extends Base {
	/**
	 * Handle shortcode.
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public function handle() {
		$contest    = $this->getContest();
		$submission = $this->getSubmission();
		$screen     = $this->getAttribute( 'screen' );
		$menu       = wp_validate_boolean( $this->getAttribute( 'menu', ! (bool) $screen ) );
		$pageId     = $this->getAttribute( 'page-id' );

		if ( $contest ):
			if ( $contest->getAction() === 'submission' ):
				$submission = $this->getSubmission();
			endif;

			if ( $contest->getScreen() !== 'contest.thankyou' && $screen ):
				$contest->setScreen( $screen );
			endif;

			if ( $pageId ):
				$contest->setCustomPageId( $pageId );
			endif;

			$contest->setMenuVisibility( $menu );
		endif;

		return (string) ( $submission ?: $contest );
	}
}
