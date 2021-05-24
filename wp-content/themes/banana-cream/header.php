<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset='<?php bloginfo('charset'); ?>'>
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo( 'name' ); ?></title>
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<meta name='description' content='<?php bloginfo( 'description' ); ?>'>
	<?php wp_head(); ?>
</head>

	<body <?php body_class(); ?>>
		<?php do_action( 'get_background_branding' ); ?>

		<?php
	        if( class_exists( 'TF_DFP_Widget' ) &&  is_active_sidebar( 'tf_dfp_head_sb' ) ) {
	            echo '<div class="tf-dfp-header">';
		        dynamic_sidebar('tf_dfp_head_sb');
		        echo '</div>';
	        }
        ?>

	<?php get_template_part( 'templates/header/banner', get_post_type() ); ?>

<div class="uk-block-default uk-container uk-container-center">
	<main id="content" class="uk-block">
