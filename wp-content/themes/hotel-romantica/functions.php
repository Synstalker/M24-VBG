<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hotel_Romantica
 */

define( 'HOTEL_ROMANTICA_VERSION', '1.0.5' );

if ( ! function_exists( 'hotel_romantica_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hotel_romantica_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'hotel-romantica', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register menu locations.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'hotel-romantica' ),
				'social' => esc_html__( 'Social', 'hotel-romantica' ),
			)
		);

		// Add support for HTML5 markup.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'hotel_romantica_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Set up the WordPress core custom header feature.
		add_theme_support(
			'custom-header',
			apply_filters(
				'hotel_romantica_custom_header_args',
				array(
					'default-image'    => '',
					'width'            => 1200,
					'height'           => 400,
					'flex-height'      => true,
					'header-text'      => false,
					'wp-head-callback' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;

add_action( 'after_setup_theme', 'hotel_romantica_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hotel_romantica_custom_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'hotel_romantica_content_width', 790 );
}

add_action( 'after_setup_theme', 'hotel_romantica_custom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hotel_romantica_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'hotel-romantica' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'hotel-romantica' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => sprintf( esc_html__( 'Footer %d', 'hotel-romantica' ), 1 ),
			'id'            => 'footer-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => sprintf( esc_html__( 'Footer %d', 'hotel-romantica' ), 2 ),
			'id'            => 'footer-2',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => sprintf( esc_html__( 'Footer %d', 'hotel-romantica' ), 3 ),
			'id'            => 'footer-3',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => sprintf( esc_html__( 'Footer %d', 'hotel-romantica' ), 4 ),
			'id'            => 'footer-4',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'hotel_romantica_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hotel_romantica_scripts() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$min = '';

	wp_enqueue_style( 'hotel-romantica-google-fonts', hotel_romantica_fonts_url(), array(), HOTEL_ROMANTICA_VERSION );

	wp_enqueue_style( 'hotel-romantica-font-awesome', get_template_directory_uri() . '/third-party/font-awesome/css/all' . $min . '.css', '', '5.12.0' );

	wp_enqueue_style( 'hotel-romantica-style', get_stylesheet_uri(), array(), HOTEL_ROMANTICA_VERSION );

	wp_enqueue_script( 'hotel-romantica-navigation', get_template_directory_uri() . '/js/navigation' . $min . '.js', array(), '20151215', true );

	wp_enqueue_script( 'hotel-romantica-custom', get_template_directory_uri() . '/js/script' . $min . '.js', array( 'jquery' ), HOTEL_ROMANTICA_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script( 'hotel-romantica-navigation', 'hotelRomanticaScreenReaderText', array(
		'expandMain'    => esc_html__( 'Open the main menu', 'hotel-romantica' ),
		'collapseMain'  => esc_html__( 'Close the main menu', 'hotel-romantica' ),
		'expandChild'   => esc_html__( 'expand submenu', 'hotel-romantica' ),
		'collapseChild' => esc_html__( 'collapse submenu', 'hotel-romantica' ),
	) );
}

add_action( 'wp_enqueue_scripts', 'hotel_romantica_scripts' );

/**
 * Load init.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/init.php';
