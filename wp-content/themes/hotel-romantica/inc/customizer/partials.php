<?php
/**
 * Customizer partials
 *
 * @package Hotel_Romantica
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function hotel_romantica_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function hotel_romantica_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
