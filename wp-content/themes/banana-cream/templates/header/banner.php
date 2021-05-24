<?php
/**
 * @since 3.25.0
 */
?>
<header id='header' class='uk-container uk-container-center uk-padding-remove uk-position-relative' role="banner">
	<?php do_action( 'the_header' ); ?>
	<?php do_action( 'header_overlay_menu' ); ?>
	<?php do_action( 'off_canvas_mobile_menu' ); ?>
</header>
<?php do_action( 'below_header_menu' ); ?>