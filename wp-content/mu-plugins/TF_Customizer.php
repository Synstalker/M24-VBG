<?php

/**
 * Helper Class for the WordPress Customizer
 *
 * Helps keep the customizer, plugin agnostic
 *
 *
 * @package 24dotcom
 * @subpackage tf-core
 * @since 0.0.1
 **/
class TF_Customizer {


	private static $panel_defaults = array(
		'id'            => null,
		'title'         => null,
		'description'   => null,
		'priority'      => 100,
		'sections'      => array()
	);


	private static $section_defaults = array(
		'id'             => null,
		'title'          => null,
		'description'    => null,
		'panel'          => null,
		'priority'       => 100,
		'capability'     => null,
		'theme_supports' => null, // Rarely needed.
	);

	private static $field_defaults = array(
		'id'        => null,
		'section'   => null,
		'label'     => null,
		'type'      => 'text'
	);


	/**
	 * Uses the Kirki plugin if it exists,
	 * else use native WordPress functionality
	 *
	 * @link https://getflywheel.com/layout/how-to-add-options-to-the-wordpress-customizer/
	 *
	 * @param string $option
	 *
	 * @return mixed|string
	 */
	final public static function get_option( $option = '', $parse_as = '' ){

		$result = class_exists( 'Kirki' ) ? Kirki::get_option( $option ) : get_option( $option );

		switch ($parse_as) {
			case 'boolean':
				$result	= $result == true ? true : false;
			break;

			case 'boolean_string':
				$result = $result == true ? 'true' : 'false';
			break;

			default:
			$result = $result;
		}

		return $result;
	}


	final public static function add_panel( $args = array() ){

		if( !class_exists( 'Kirki') ){
			return false;
		}

		$args = wp_parse_args( $args, self::$panel_defaults );

		Kirki::add_panel( $args['id'], $args);
	}

	/**
	 * Add a section to the Customizer
	 *
	 * @todo            allow chaining method      add_section()->add_field()
	 *
	 * @param string      $id
	 * @param array     $args
	 *
	 * @return bool     false if Kirki doesn't exist
	 */
	final public static function add_section( $args = array() ){

		if( !class_exists( 'Kirki') ){
			return false;
		}

		global $wp_customize;
		if( array_key_exists( $args['id'], $wp_customize->sections() ) ) return false;

		$args = wp_parse_args( $args, self::$section_defaults );

		Kirki::add_section( $args['id'], $args);

	}


	final public static function add_field( $args = array() ){

		if( !class_exists( 'Kirki') ){
			return false;
		}

		$args = wp_parse_args( $args, self::$field_defaults );
		Kirki::add_field( $args['id'], $args );

	}

    //LOVE THIS!
	final private static function parse_panel( $settings = array() ){
		$settings = wp_parse_args( $settings, self::$panel_defaults );
		$settings['id'] = is_numeric( $settings['id'] ) ? sanitize_title( $settings['title'] ) : $settings['id'];
		$settings['title'] = empty( trim( $settings['title'] ) ) ? ucwords( $settings['id'] ) : $settings['title'];
		return $settings;
	}

	//LOVE THIS!
	final private static function parse_section( $settings = array() ){
		global $wp_customize;

		$settings = wp_parse_args( $settings, self::$section_defaults );
		$settings['id'] = is_numeric( $settings['id'] ) ? sanitize_title( $settings['title'] ) : $settings['id'];

		if( array_key_exists( $settings['id'], $wp_customize->sections() ) ){
				$settings['title'] = $wp_customize->sections()[$settings['id']]->title;
		}else{
			$settings[ 'title' ] = empty( $settings[ 'title' ] ) ? ucwords( $settings['id'] ) : $settings['title'];
		}

		return $settings;
	}


	final private static function parse_field( $settings = array() ){
		$settings = wp_parse_args( $settings, self::$field_defaults );
		$settings[ 'title' ] = empty( $settings[ 'title' ] ) ? ucwords( $settings['id'] ) : $settings['title'];
		$settings['id'] = is_numeric( $settings['id'] ) ? sanitize_title( $settings['title'] ) : $settings['id'];
		return $settings;
	}


    /**
     * @param array $options
     */
    final public static function add_options( $options = array() ){
        foreach( $options as $group_id => $group_settings ){

            if( !array_key_exists( 'sections', $group_settings ) ){
				//treat this array as a section array
				$group_settings[ 'id' ] = !array_key_exists( 'id', $group_settings ) ? $group_id : $group_settings[ 'id' ];
				$group_settings = self::parse_section( $group_settings );
				self::add_section( $group_settings );

				foreach( $group_settings['fields'] as $field_id => $field_settings ) {
				    //Might need to duplicate this...
                    if( isset( $field_settings[ 'type' ] ) && isset( $field_settings['query'] ) && 'dropdown-posts' === $field_settings['type'] ){
                        $field_settings[ 'type' ] = 'select';
                        $field_settings[ 'choices' ] = self::get_posts( $field_settings['query'] );
                    }
                    $field_settings['id'] = !array_key_exists('id', $field_settings) ? $field_id : $field_settings['id'];
                    $field_settings['section'] = $group_settings['id'];
                    $field_settings = self::parse_field($field_settings);

					self::add_field( $field_settings );
				}

				unset( $group_settings );
				unset( $field_settings );

				continue; //skip to the next one
			}

			$group_settings[ 'id' ] = !array_key_exists( 'id', $group_settings ) ? $group_id : $group_settings[ 'id' ];
			$group_settings = self::parse_panel( $group_settings );
			self::add_panel( $group_settings );

			foreach( $group_settings['sections'] as $section_id => $section_settings ){
				$section_settings[ 'id' ] = !array_key_exists( 'id', $section_settings ) ? $section_id : $section_settings[ 'id' ];
				$section_settings['panel'] = $group_settings['id'];
				$section_settings = self::parse_section( $section_settings );
				self::add_section( $section_settings );

				foreach( $section_settings['fields'] as $field_id => $field_settings ){
                    $field_settings[ 'id' ] = !array_key_exists( 'id', $field_settings ) ? $field_id : $field_settings[ 'id' ];
                    $field_settings['section'] = $section_settings['id'];
                    $field_settings = self::parse_field( $field_settings );

                    self::add_field( $field_settings );


                }
			}

			unset( $group_settings );
			unset( $section_settings );
			unset( $field_settings );

		}
	}

	protected static function get_posts( $args ){
        $default_args = [
            'posts_per_page'   => 50
        ];

        $arguments = tf_core_parse_args( $args, $default_args );
        $posts = get_posts( $arguments );
        $output = [];

        if( !empty( $posts ) ){
            foreach( $posts as $post ){
                $output[ $post->ID ] = $post->post_title;
            }
        }

        return $output;

    }

}