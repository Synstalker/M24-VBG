<?php
$recaptcha_for_comments_site_key = get_option( 'recaptcha_for_comments_site_key' );
$recaptcha_css_class = '';
if( isset( $_GET['submission'] ) && 'security_recaptcha' === $_GET['submission'] ) {
	$recaptcha_css_class = 'security_fail';
	echo '<div class="uk-alert uk-alert-danger">' . __( 'Security check fail - you appear to be a bot', 'twenytfourdotcom' ) . '</div>';
}
echo '<div class="uk-form-row uk-text-right">
		<div class="uk-display-inline-block g-recaptcha ' . $recaptcha_css_class . '" data-sitekey="'.$recaptcha_for_comments_site_key.'" ></div>
	</div>';