<p class="uk-alert uk-alert-danger uk-text-center">
<?php
	$message = get_query_var( 's' ) ?
		'Sorry, but nothing matched your search terms. Please try again with some different keywords.'
		: 'Unfortunately there is no content available at this time.';

		_e( $message, 'twentyfourdotcom' );
?>
</p>

