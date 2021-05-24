<?php

class TF_Theme{

	var $front_page_title = 'Home';

	private static $default_headers = array(
		"Theme Name"    => "Theme Name",
		"Theme URI"     => "Theme URI",
		"Author"        => "Author",
		"Author URI"    => "Author URI",
		"Description"   => "Description",
		"Version"       => "Version",
		"License"       => "License",
		"License URI"   => "License URI",
		"Tags"          => "Tags",
		"Text Domain"   => "Text Domain",
		"Domain Path"   => "Domain Path",
		"Template"      => "Template",
		"Since"         => "Since"
	);

	var $headers;

	var $post_types = array();
	var $sidebars = array();
	var $categories = array();
	var $supports = array();
	var $menus = array();
	var $mods = array();
	var $menu_locations = array();
	var $help_html;

	var $customizer_options = array();

	var $defaults = array('pages'=>array(),'menus'=>array());

	static $slug;
	static $locale;
	var $name;

	static $admin_notices = array();


	function __construct(){
		$this->verify_minimum_wp_version();
		add_action( 'customize_register', array( $this, 'add_customizer_options') );
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'after_switch_theme', array( $this, 'activate' ) );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts'), 100 );
		add_action( 'admin_init', array( __CLASS__, 'integrate_theme_styles_with_editor' ) );
		add_action( 'admin_notices', array( __CLASS__ , '_admin_notices' ) );

		if( !empty( trim( $this->help_html ) ) ){
			add_action( 'load-themes.php', array( $this, 'add_theme_help_tab'), 100 );
		}

	}


	/**
	 * @link https://codex.wordpress.org/Class_Reference/WP_Screen/add_help_tab
	 */
	final public function add_theme_help_tab(){

		$theme = wp_get_theme();
		if( !$theme || get_class( $theme ) != 'WP_Theme' ) return;

		$help_id_suffix = property_exists( $theme,'template') ? $theme->template : 'unknown';

		$screen = get_current_screen();
		$screen->add_help_tab( array(
			'id'	=> 'theme_setup_'.$help_id_suffix,
			'title'	=> __('Theme Setup'),
			'content'	=> $this->help_html,
		) );
	}


	public static final function admin_notice( $notice = '' ){
		self::$admin_notices[] = $notice;
	}


	/**
	 * This is the function that actually displays the admin notices
	 */
	public static final function _admin_notices(){
		foreach( self::$admin_notices as $notice ): ?>
		<div class="notice notice-error">
			<p><?php _e( $notice, 'twentyfourdotcom' ); ?></p>
		</div>
		<?php endforeach;
	}



	/**
	 * Verifies that the minimum wordpress version is installed
	 * Safely fails if not met...
	 */
	private function verify_minimum_wp_version(){
		global $wp_version;
		$since = floatval( $this->get_headers('since') );
		if( $since  > 0 && floatval( $wp_version ) < $since ){
			self::admin_notice( 'Minimum WordPress version: '.$since.' not met' );
		}
	}


	/**
	 * Adds your theme stylesheet to the MCE Editor Preview Pane
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
	 * @todo put into customizer / tf core settings
	 */
	public static function integrate_theme_styles_with_editor() {
		add_editor_style( 'style.min.css' );
	}



	/**
	 * @todo use TF_Core_Sidebar
	 */
	final function widgets_init(){
		NP_Sidebar::register($this->sidebars);
	}


	final function create_categories(){

		foreach($this->categories as $name){
			wp_insert_term($name,'category');
		}
	}


	public function enqueue_scripts(){

		$minified_suffix = ( defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_style( __CLASS__.'_theme_style' , get_template_directory_uri().'/style'.$minified_suffix.'.css' );
		wp_enqueue_style( __CLASS__.'_theme_style' );

		wp_register_script( __CLASS__.'_theme_script', get_template_directory_uri().'/js/bundle'.$minified_suffix.'.js', array( 'jquery' ) );
		wp_enqueue_script( __CLASS__.'_theme_script' );
	}


	final function register_post_types(){

		foreach( $this->post_types as $post_type => $args ){
			register_post_type($post_type,$args);
		}

		flush_rewrite_rules();
	}


	final function after_setup_theme(){
		update_option( 'permalink_structure', '/%postname%/' );
		$this->register_menu_locations();
		$this->add_supported_features();
		$this->register_post_types();
		$this->create_categories();
	}


	/**
	 *
	 * @todo how to use this and the different flavours
	 * @todo unsanitize function to auto create title from array key
	 * @todo make this static
	 * @todo rework this, start with panels, then add the sections, then fields
	 */
	public final function add_customizer_options(){
		TF_Customizer::add_options( $this->customizer_options );
	}


	function get_headers( $header_key = '' ){
		if(empty($this->headers)){
			$headers = get_file_data(get_theme_file_path().'/style.css', self::$default_headers);
			foreach($headers as $slug => $value){
				$this->headers[sanitize_title($slug)] = $value;
			}
		}

		if( !empty($header_key) && array_key_exists($header_key,$this->headers)){
			return $this->headers[$header_key];
		}else{
			return $this->headers;
		}
	}


	final function activate(){
		$this->create_default_content();
		flush_rewrite_rules();
	}


	final function register_menu_locations(){

		$locations = array();
		foreach($this->menu_locations as $slug => $name ){

			$slug = is_int($slug) ? sanitize_title($name) : sanitize_title($slug);

			$locations[$slug] = $name;
		}
		register_nav_menus($locations);

	}


	private final function add_supported_features(){

		foreach($this->supports as $support => $args){

			if(is_array($args)){
				add_theme_support( $support , $args );
			}else{
				$support = $args;
				add_theme_support( $support );
			}

		}
	}


	private final function setup_default_pages(){
		//CREATE DEFAULT PAGES
		foreach ( $this->defaults['pages'] as $page_title => $args ) {
			if ( ! is_array( $args ) ) {
				$page_title = $args;
				$args       = array();
			}
			$page_title = __( $page_title );

			$page = get_page_by_title( $page_title );

			if ( ! $page ) {
				$default_args = array(
					'post_content' => 'This is the dummy content of ' . $page_title . ' auto created by the theme...',
					'post_title'   => $page_title,
					'post_excerpt' => 'Auto created dummy content from theme.',
					'post_status'  => 'publish',
					'post_type'    => 'page'
				);
				$args = wp_parse_args( $args, $default_args );
				wp_insert_post( $args );
			}

		}
	}


	private final function setup_front_page(){
		//CREATE DUMMY HOME PAGE
		$homepage = get_page_by_title( $this->front_page_title );
		if ( ! $homepage ) {
			$args = array(
				'post_content' => 'This is the dummy content auto created by the theme...',
				'post_title'   => $this->front_page_title,
				'post_excerpt' => 'Auto created dummy content from theme.',
				'post_status'  => 'publish',
				'post_type'    => 'page'
			);
			wp_insert_post( $args );
			$homepage = get_page_by_title( $this->front_page_title );
		}

		$page_on_front = get_option( 'page_on_front' );

		if ( $page_on_front == 0 || $page_on_front == false ) {
			update_option( 'page_on_front', $homepage->ID );
			update_option( 'show_on_front', 'page' );
		}
	}


	private final function setup_menus_default_content(){

		$locations = get_theme_mod( 'nav_menu_locations' );

		foreach( $this->defaults['menus'] as $location_slug => $pages ){

			$menu_id = null;
			$menu_slug = $location_slug.'_menu';
			$menu = wp_get_nav_menu_object( $menu_slug );

			if( !$menu ){
				$menu_id = wp_create_nav_menu( $menu_slug );
			}else{
				$menu_id = $menu->term_id;
			}

				//Assign the menu to a location
			if( is_array($locations) && array_key_exists( $location_slug, $locations ) ){
				$locations[$location_slug] = $menu_id;
			}
			set_theme_mod('nav_menu_locations', $locations);

			$page = null;
			foreach( $pages as $index => $page_title ){
				$page = get_page_by_title( $page_title );

				$menu_item_objects = wp_get_nav_menu_items( $menu_id );
				$menu_items = array();
				foreach( $menu_item_objects as $key => $object ){
					if( key_exists('title', $object) ){
						$menu_items[] = $object->title;
					}

				}

				if( $page && !in_array( $page_title, $menu_items ) ){

					wp_update_nav_menu_item( $menu_id, 0, array(
							'menu-item-object-id'   => $page->ID,
							'menu-item-parent-id'   => 0,
							'menu-item-object'      => 'page',
							'menu-item-type'        => 'post_type',
							'menu-item-status'      => 'publish',
							'menu-item-title'       => $page_title
						)
					);
				}
			}

		}
	}


	private final function create_default_content(){
		$this->register_menu_locations();
		//$this->setup_front_page();
		//$this->setup_default_pages();
		//$this->setup_menus_default_content();
		return;
	}
}