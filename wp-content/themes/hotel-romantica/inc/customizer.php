<?php
/**
 * Theme Customizer
 *
 * @package Hotel_Romantica
 */

/**
 * Customizer configuration.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hotel_romantica_customize_register( $wp_customize ) {
	// Load custom controls.
	require trailingslashit( get_template_directory() ) . 'inc/customizer/control.php';

	// Load customizer partials callback.
	require trailingslashit( get_template_directory() ) . 'inc/customizer/partials.php';

	// Load customize sanitize.
	require trailingslashit( get_template_directory() ) . 'inc/customizer/sanitize.php';

	// Register custom controls and sections.
	$wp_customize->register_control_type( 'Hotel_Romantica_Heading_Control' );
	$wp_customize->register_control_type( 'Hotel_Romantica_Message_Control' );
	$wp_customize->register_section_type( 'Hotel_Romantica_Customize_Section_Upsell' );

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'hotel_romantica_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'hotel_romantica_customize_partial_blogdescription',
			)
		);
	}

	// Load customize option.
	require get_template_directory() . '/inc/customizer/option.php';

	$wp_customize->add_section(
		new Hotel_Romantica_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Hotel Romantica Pro', 'hotel-romantica' ),
				'pro_text' => esc_html__( 'Buy Pro', 'hotel-romantica' ),
				'pro_url'  => 'https://lumberthemes.com/downloads/hotel-romantica-pro/',
				'priority' => 1,
			)
		)
	);
}

add_action( 'customize_register', 'hotel_romantica_customize_register' );

/**
 * Customizer scripts and styles.
 *
 * @since 1.0.0
 */
function hotel_romantica_customizer_control_scripts() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'hotel-romantica-customize-controls', get_template_directory_uri() . '/js/customize-controls' . $min . '.js', array( 'customize-controls' ), HOTEL_ROMANTICA_VERSION, true );
	wp_enqueue_style( 'hotel-romantica-customize-controls', get_template_directory_uri() . '/css/customize-controls' . $min . '.css', '', HOTEL_ROMANTICA_VERSION );
}

add_action( 'customize_controls_enqueue_scripts', 'hotel_romantica_customizer_control_scripts', 0 );
