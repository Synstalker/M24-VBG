<?php
/**
 * Plugin recommendations
 *
 * @package Hotel_Romantica
 */

if ( ! function_exists( 'hotel_romantica_register_recommended_plugins' ) ) :

	/**
	 * Register recommended plugins.
	 *
	 * @since 1.0.0
	 */
	function hotel_romantica_register_recommended_plugins() {
		$plugins = array(
			array(
				'name' => esc_html__( 'Advanced Booking Calendar', 'hotel-romantica' ),
				'slug' => 'advanced-booking-calendar',
			),
			array(
				'name' => esc_html__( 'Elementor', 'hotel-romantica' ),
				'slug' => 'elementor',
			),
			array(
				'name' => esc_html__( 'One Click Demo Import', 'hotel-romantica' ),
				'slug' => 'one-click-demo-import',
			),
		);

		$config = array();

		tgmpa( $plugins, $config );
	}

endif;

add_action( 'tgmpa_register', 'hotel_romantica_register_recommended_plugins' );
