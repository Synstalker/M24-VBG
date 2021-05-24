<?php
/**
 * Template for displaying search forms
 *
 * @package 24dotcom
 * @subpackage banana-cream0theme
 * @since 0.0.1
 */

$placeholder = is_array( $instance ) && array_key_exists( 'placeholder', $instance ) ? $instance['placeholder'] : '';
$button_text = is_array( $instance ) && array_key_exists( 'button_text', $instance ) ? $instance['button_text'] : 'Search';
$post_type  = is_array( $instance ) && array_key_exists( 'post_type' , $instance ) ? $instance['post_type'] : 'entry';
?>

<form role="search" method="get" class="uk-form uk-grid uk-container-center uk-width-large-2-3 uk-width-medium-2-3 uk-margin-large-bottom" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="uk-width-large-2-3 uk-width-medium-2-3 uk-width-small-1-2" placeholder="<?php echo esc_attr_x( $placeholder, 'placeholder', 'twentyfourdotcom' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="uk-button uk-button-primary uk-text-center uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-2"><?php _e( $button_text, 'twentyfourdotcom' ); ?></button>
	<input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
</form>
