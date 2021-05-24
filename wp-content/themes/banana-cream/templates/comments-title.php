<?php
	$comments_number = get_comments_number();

	if ( 1 === $comments_number ) {
		$comments_title = sprintf(
			_x(
				'1 thought on &ldquo;%s&rdquo;',
				'comments title',
				'twentyfourdotcom'
			), get_the_title()
		);
	} else {
		$comments_title = sprintf(
			_nx(
				'%1$s thought on &ldquo;%2$s&rdquo;',
				'%1$s thoughts on &ldquo;%2$s&rdquo;',
				$comments_number,
				'comments title',
				'twentyfourdotcom'
			),
			number_format_i18n( $comments_number ),
			get_the_title()
		);
	}
?>

<h5 class="uk-margin-remove">
	<?php _e( $comments_title ); ?>
</h5>
<hr class="uk-margin-small-top uk-margin-bottom"/>
