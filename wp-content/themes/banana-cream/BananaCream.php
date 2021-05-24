<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

if ( ! class_exists( 'GFForms' ) ) {
    TF_Theme::admin_notice( 'This theme requires Gravity Forms' );
}

/**
 * Class BananaCream
 *
 * @author  24.com <24.COMOpenSourceDevTeam@ds.naspers.com>
 * @package BananaCream
 * @version 3.27.1
 *
 * @since   1.0.0
 */
class BananaCream extends TF_Theme{


    var $help_html = 'For help setting up this Theme, visit the README @ https://bitbucket.org/24dotcom/banana-cream/overview';


    var $sidebars = array(
        array(
            'name'          => 'Archive Content Header',
            'description'   => 'Widget area just above the main content on Archive Pages',
            'id'            => 'archive-content-header'
        ),
        array(
            'name'          => 'Front Page Footer Sidebar',
            'description'   => 'FrontPage Widget area just above the footer',
            'id'            => 'frontpage-footer-sidebar'
        )
    );


    var $categories = array( 'Semi Finalists','Finalists' );

    var $customizer_options = [
        'nav_menus' => array(
            'title' => 'Menus',
            'priority'=> 22,
            'sections'  => array(
                'below_header_menu'       => array(
                    'title' => 'Below Header Menu Width',
                    'fields' => array(
                        array(
                            'label' => 'Below Header Menu Width',
                            'type' => 'select',
                            'settings' => 'below_header_menu_width',
                            'choices' => array(
                                'uk-width-1-1' => 'Match Container Width',
                                'window' => 'Match Window Width',
                                'uk-width-large-5-6'   => '5/6 of Container'
                            )
                        )
                    )
                ),
            )
        ),

        'header_image' => array(
            'priority'=> 21,
            'fields' => array(
                array(
                    'label' => 'Header Link',
                    'type' => 'dropdown-pages',
                    'settings' => 'header_href'
                ),
                array(
                    'label' => 'Header Image Mobile',
                    'type' => 'image',
                    'settings' => 'header_image_mobile'
                ),
                //  <jared.rethman@24.com> - start  //
                array(
                    'label' => 'Use Slideshow',
                    'type' => 'toggle',
                    'settings' => 'use_slideshow'
                ),
                array(
                    'label' => 'Select a header slideshow',
                    'type' => 'dropdown-posts',
                    'query' => [
                        'post_type' => 'tf-slider'
                    ],
                    'settings' => 'slideshow_select',
                    'active_callback'    => array(
                        array(
                            'setting'  => 'use_slideshow',
                            'operator' => '==',
                            'value'    => 1,
                        ),
                    ),
                )
                //  <jared.rethman@24.com> - end  //
            )
        ),

        'footer'            => array(
            'title' => 'Footer',
            'priority' => 24,
            'fields' => array(
                array(
                    'settings'  => 'show_footer',
                    'label' => 'Show Footer',
                    'type'  => 'toggle',
                    'default' => 1
                ),
                array(
                    'settings'  => 'footer_text',
                    'label' => 'Footer Text',
                    'type'  => 'text',
                    'default' => '© 2017 24.com'
                )

            )
        ),

        'search'            => array(
            'title'     => 'Search',
            'priority'  => 140,
            'fields'    => array(
                array(
                    'label' => 'Searchable Fields',
                    'settings' => 'searchable_fields',
                    'type' => 'tf_gf_entry_form_fields_multicheck'
                )
            )
        ),

        'miscellaneous'     => array(
            'title'         => 'Miscellaneous',
            'priority'      => 120,
            'sections'  => array(
                'not_found' => array(
                    'title' => '404 Page',
                    'fields' => array(
                        array(
                            'label'         => 'Page Title',
                            'description'   => 'This is the title that will display on the 404 page',
                            'settings'      => 'not_found_page_title',
                            'default'       => '404'

                        ),
                        array(
                            'label'         => 'Display Text',
                            'description'   => 'This is the text that will display on the 404 page',
                            'settings'      => 'not_found_page_content',
                            'type'          => 'textarea',
                            'default'       => 'The page you are looking for could not be found.'

                        )
                    )
                ),
                'post_galleries' => array(
                    'title' => 'Post Galleries',
                    'fields' => array(
                        array(
                            'label' => 'Default Size',
                            'description' => 'This is size that the post galleries uses as default for its images',
                            'settings' => 'tf_kiki_post_gallery_sizes',
                            'choices' => array(
                                ''
                            )
                        )
                    )
                ),
            )
        ),

        'comments'          => array(
            'title'     => 'Comments',
            'priority'  => 125,
            'fields'    => array(
                array(
                    'label'         => 'Enable',
                    'description'   => 'Placeholder text for the comment block area...',
                    'settings'      => 'comments_globally_enabled',
                    'default'       => false,
                    'type'          => 'toggle'

                ),
                array(
                    'label'         => 'Textarea Placeholder text',
                    'description'   => 'Placeholder text for the comment block area...',
                    'settings'      => 'comment_field_placeholder',
                    'default'       => 'Enter your comment here...',

                )
            )
        ),

        'background_image' => array(
            'title'=>'Background',
            'priority'  => 23,
            'fields' => array(
                array(
                    'label' => 'Background Link',
                    'type'  => 'dropdown-pages',
                    'settings'  => 'background_href'
                )
            )
        ),

        'image_overlay' => array(
            'title'     => 'Image Overlay',
            'priority'  => 125,
            'fields'    => array(
                array(
                    'label'     => 'Overlay Image ',
                    'type'      => 'image',
                    'settings'  => 'image_overlay'
                ),
            )
        ),

        'social' => array(
            'title'     => 'Social',
            'priority'  => 110,
            'sections'  => array(
                array(
                    'title'         => 'Open Graph Tags',
                    'description'   => 'Modify the Open Graph tag values',
                    'fields' => array(
                        array(
                            'label'     => 'Front Page Description',
                            'type'      => 'textarea',
                            'settings'  => 'social_og_front_page_description'
                        ),
                        array(
                            'label'     => 'Default Description',
                            'type'      => 'textarea',
                            'settings'  => 'social_og_default_description'
                        ),

                        array(
                            'label'     => 'Static Front Page Image',
                            'type'      => 'image',
                            'settings'  => 'social_og_static_front_page_image'
                        ),
                    )
                ),
                array(
                    'title'         => 'AddThis',
                    'description'   => 'The addthis plugin is a bit too convoluted... so here we go',
                    'fields'        => array(
                        array(
                            'label'     => 'Enable',
                            'settings'  => 'addthis_status',
                            'type'      => 'toggle'
                        ),
                        array(
                            'label'     => 'Profile ID',
                            'settings'  => 'addthis_profile_id',
                            'active_callback'    => array(
                                array(
                                    'setting'  => 'addthis_status',
                                    'operator' => '==',
                                    'value'    => true,
                                )
                            )
                        )
                    )
                )
            ),
        ),

        'competitions'      => array(
            'priority'      => 100,
            'sections'      => array(
                array(
                    'title'         => 'Entries',
                    'description'   => 'Customize the Main Entry Form experience',
                    'fields' => array(
                        array(
                            'label' => 'Entry Form',
                            'settings' => 'entry_form_id',
                            'type' => 'tf_gf_form_dropdown',
                        ),
                        array(
                            'label'     => 'Ajax Enabled',
                            'settings'  => 'entry_form_is_ajax',
                            'type'      => 'toggle',
                            'default'   => 1
                        ),
                        array(
                            'label' => 'Masonry on Entries Category',
                            'settings' => 'entries_category_masonry',
                            'type' => 'toggle',
                            'default' => 1
                        )
                    )
                ),
                array(
                    'title'         => 'Voting',
                    'description'   => 'Customize the Voting experience',
                    'fields' => array(
                        array(
                            'label' => 'Voting Form',
                            'settings' => 'voting_form_id',
                            'type' => 'tf_gf_form_dropdown',
                        ),
                        array(
                            'label'     => 'Voting Enabled?',
                            'settings'  => 'voting_is_enabled',
                            'type'      => 'toggle',
                            'default'   => 0
                        ),
                        array(
                            'label'     => 'Ajax Enabled',
                            'settings'  => 'voting_form_is_ajax',
                            'type'      => 'toggle',
                            'default'   => 1
                        )
                    )
                ),
                array(
                    'title'         => 'Rating',
                    'description'   => 'Customize the Rating experience',
                    'fields' => array(
                        array(
                            'label'     => 'Rating Form',
                            'settings'  => 'rating_form_id',
                            'type'      => 'tf_gf_form_dropdown',
                        ),
                        array(
                            'label'     => 'Rating Enabled?',
                            'settings'  => 'rating_is_enabled',
                            'type'      => 'toggle',
                            'default'   => 0
                        ),
                        array(
                            'label'     => 'Ajax Enabled',
                            'settings'  => 'rating_form_is_ajax',
                            'type'      => 'toggle',
                            'default'   => 1
                        )
                    )

                )
            )
        ),
    ];


    var $defaults = array(
        'pages' => array(
            'HOME',
            'ABOUT',
            'ENTER',
            'ENTRIES',
            'RULES',
            'SPONSORS',
            'CONTACT',

        ),
        'menus' => array(
            'below_header' => [
                'HOME',
                'ENTER',
                'ENTRIES',
                'RULES',
                'SPONSORS',
                'CONTACT',
            ],
            'header_overlay' => [
                'HOME',
                'ABOUT',
                'ENTER',
                'ENTRIES',
                'RULES',
                'SPONSORS',
                'CONTACT',
            ],
            'off_canvas_mobile' => [
                'HOME',
                'ABOUT',
                'ENTER',
                'ENTRIES',
                'RULES',
                'SPONSORS',
                'CONTACT',
            ],

        )
    );


    var $supports = [
        'custom-header' => array(
            'width'         => 980,
            'height'        => 320,
            'flex-height'   => true,
            'video'         => true,
            'default-image' => 'https://placehold.it/980x320/222222',

        ),
        'menus',
        'html5' => array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ),
        'custom-background' => array(
            'width'                 => 1400,
            'height'                => 900,
            'default-image'         => 'https://placehold.it/1400x900/616161',
            'default-repeat'        => 'no-repeat',
            'default-position-x'    => 'center',
            'default-attachment'    => 'fixed'
        ),
        'post-thumbnails',
        'title-tag',
        'widgets',
        'customize-selective-refresh-widgets',
        'custom-logo',
        'starter-content'
    ];


    var $menu_locations = [
        'below_header' => 'Below Header',
        'header_overlay' => 'Header Overlay (Web Only)',
        'off_canvas_mobile' => 'Off Canvas (Mobile Only)'
    ];

    static $voting_form_id = null;
    static $rating_form_id = null;
    static $entry_form_id = null;

    static $rating_form = null;
    static $entry_form = null;
    static $voting_form = null;

    static $rating_form_post_id_control = null;
    static $voting_form_post_id_control = null;


    static $total_entrants_count = null;
    static $total_ratings_count = null;


    /**
     * @since 1.0.0
     */
    public function __construct(){

        add_filter( 'gform_ajax_spinner_url', array( __CLASS__, 'gform_ajax_spinner_url' ) );
        add_filter( 'wpseo_opengraph_desc', array( __CLASS__, 'override_yoast_og_description' ) );

        foreach( $this->menu_locations as $slug => $description ){
            add_action( "{$slug}_menu", array( __CLASS__, "{$slug}_menu" ) );
        }

        add_action( 'get_background_branding', array( __CLASS__, 'get_background_branding' ) );
        add_filter( 'wpseo_og_og_image', array( __CLASS__, 'set_home_og_image' ), null, 1 );

        add_action('carbon_register_fields', array(__CLASS__, 'tf_register_custom_entry_meta_box') );

        add_action( 'init', array( __CLASS__, 'tf_image_sizes' ) );

        parent::__construct();
    }

    /**
     * @since 2.26.0
     */
    public static function tf_image_sizes(){
        add_image_size( 'tf-portrait-small', 240, 320, true );
        add_image_size( 'tf-portrait-medium', 480, 640, true );
        add_image_size( 'tf-portrait-large', 960, 1280, true );
    }


    /**
     * @since 3.25.0
     */
    public static function get_background_branding(){
        $background_href = TF_Customizer::get_option( 'background_href' ) ? get_permalink( TF_Customizer::get_option( 'background_href' ) ) : null;
        if($background_href):
            ?>
            <style>body{ cursor:pointer; } body *{ cursor:default; }</style>
            <script>
                jQuery(document).ready(function(){
                    jQuery(document).click(function(e){
                        if( "BODY" === e.srcElement.tagName){
                            document.location = "<?php echo $background_href; ?>";
                        }
                    });
                });
            </script>
            <?php
        endif;
    }

    /**
     * @since 3.26.0
     * @return void
     * Register custom meta box for entry page template, allowing for dynamic entry form selection on sites where more than one entry form may be required. Safely falls back to the customizer entry form if none is selected...
     */

    public static function tf_register_custom_entry_meta_box() {

        add_filter( 'crb_gravity_form_options', function ( $options ) {
            $options[0] = 'None';
            return $options;
        } );

        if( class_exists( 'Carbon_Fields\\Container' ) && class_exists( 'Carbon_Fields\\Field' ) ){

            Container::make( 'post_meta', 'Entry Form' )
                -> show_on_post_type( 'page' )
                -> show_on_template( 'template-entry-form.php' )
                -> set_context( 'side' )
                -> add_fields(array(
                    Field::make( 'gravity_form', 'tf_entry_form', 'Select an Entry Form' )
                ));

        }

    }


    /**
     * @since 3.25.0
     */
    public function enqueue_scripts() {

        if( TF_Customizer::get_option('addthis_status','boolean') == true ) {
            $profile_id = TF_Customizer::get_option( 'addthis_profile_id' );
            wp_enqueue_script( 'addthis-embed-code', '//s7.addthis.com/js/300/addthis_widget.js#pubid='.$profile_id, array( 'jquery' ), null, true);
        }

        parent::enqueue_scripts();
    }


    /**
     * @since 3.25.0
     */
    public static function set_home_og_image( $content ){

        if( ! is_home() && !is_front_page() ) return $content;

        $option = TF_Customizer::get_option('social_og_static_front_page_image');
        $content = $option ?: $content;

        return $content;
    }


    /**
     * @since 3.25.0
     */
    public static function below_header_menu(){

        $locations = get_nav_menu_locations();
        $desired_location = 'below_header';

        if( ! array_key_exists( $desired_location, $locations ) ) return false;

        $menu_object = get_term( $locations[$desired_location], 'nav_menu' );

        if( is_wp_error( $menu_object ) ) return false;

        $menu_args = array (
            'menu'              => $desired_location,
            'menu_class'        => 'uk-text-center uk-navbar-nav uk-width',
            'container'         => 'div',
            'container_id'      => 'site_menu',
            'container_class'   => TF_Customizer::get_option( 'below_header_menu_width' ).' uk-hidden-small uk-hidden-medium uk-width-small-1-1 uk-width-medium-1-1 uk-container uk-container-center uk-padding-remove uk-text-center',
            'fallback_cb'       => null,
            'theme_location'    => $desired_location,
            'depth'             => 1,
            'slug'              => $menu_object->name
        );

        $menu_item_count = count( wp_get_nav_menu_items( $menu_args['slug'] ) ) ?: 1;
        $menu_args[ 'menu_class' ] .= ' uk-grid-width-large-1-'.$menu_item_count.' uk-grid-width-medium-1-1 uk-grid-small-1-1';

        if ( has_nav_menu ( $menu_args['menu'] ) ) {
            get_template_part( 'templates/menu', 'mobile-toggle' );
            ?><nav class='uk-tab uk-navbar uk-container uk-container-center uk-padding-remove'><?php
            wp_nav_menu ( $menu_args ) ;
            ?></nav><?php
        }

    }


    /**
     * @since 3.25.0
     */
    public static function header_overlay_menu(){

        $locations = get_nav_menu_locations();
        $desired_location = 'header_overlay';

        if( ! array_key_exists( $desired_location, $locations ) ) return false;

        $menu_object = get_term( $locations[$desired_location], 'nav_menu' );

        if( is_wp_error( $menu_object ) ) return false;

        add_filter( 'nav_menu_css_class', function( $classes , $item, $args, $depth ){

            if( !is_object( $args) ) return; $classes;

            if( !key_exists( 'theme_location', $args ) ) return $classes;

            if( $args->theme_location != 'header_overlay' ) return $classes;

            if( in_array( 'current-menu-item', $item->classes ) ){
                $classes[] = 'uk-nav-header';
                $classes[] = 'uk-padding-top-remove';
            }

            if( has_custom_logo() ){
                $classes[] = 'uk-padding-remove';
            }

            return $classes;

        }, null, 4 );

        $menu_args = array (
            'menu'              => $desired_location,
            'menu_class'        => 'uk-text-center uk-navbar-nav uk-width',
            'container'         => 'nav',
            'container_id'      => $desired_location.'_menu',
            'container_class'   => 'tf-overlay-menu-bar uk-width-1-1 uk-position-top uk-navbar uk-container uk-container-center uk-hidden-small uk-hidden-medium uk-overflow-hidden',
            'fallback_cb'       => null,
            'theme_location'    => $desired_location,
            'depth'             => 1,
            'slug'              => $menu_object->name,
            'active_class'      => false
        );


        /**
         * Prepend the Site logo to the menu for this specific menu
         * if one has been uploaded
         */
        add_filter( 'wp_nav_menu_'.$menu_object->name.'_items', [__CLASS__, 'prepend_site_logo_as_menu_item' ], null, 2 );

        if( !has_custom_logo() ){
            $menu_item_count = count( wp_get_nav_menu_items( $menu_args['slug'] ) ) ?: 1;
            $menu_args[ 'menu_class' ] .= ' uk-grid-width-large-1-'.$menu_item_count.' uk-grid-width-medium-1-'.$menu_item_count.' uk-grid-small-1-'.$menu_item_count;
        }

        if ( has_nav_menu ( $menu_args['menu'] ) ) {
            wp_nav_menu ( $menu_args );
        }
    }


    /**
     * @since 3.25.0
     */
    public static function off_canvas_mobile_menu(){

        $locations = get_nav_menu_locations();
        $desired_location = 'off_canvas_mobile';

        if( ! array_key_exists( $desired_location, $locations ) ) return false;

        $menu_object = get_term( $locations[$desired_location], 'nav_menu' );

        if( is_wp_error( $menu_object ) ) return false;

        $menu_args = array (
            'menu'              => $desired_location,
            'menu_class'        => 'uk-nav uk-nav-offcanvas uk-nav-parent-icon',
            'container'         => 'nav',
            'container_id'      => $desired_location.'_menu',
            'container_class'   => 'uk-offcanvas-bar',
            'fallback_cb'       => null,
            'theme_location'    => $desired_location,
            'depth'             => 1,
            'slug'              => $menu_object->name,
        );


        if ( has_nav_menu ( $menu_args['menu'] ) ) {
            ?>
            <div id="<?php echo $desired_location; ?>_toggle_bar" class="tf-overlay-menu-bar uk-position-top uk-width-1-1 uk-hidden-large uk-navbar">
                <a href="#uk-offcanvas-menu-container" class="uk-icon uk-icon-medium uk-navbar-toggle" data-uk-offcanvas ></a>
                <?php
                if(has_custom_logo()):
                    ?><div class="uk-navbar-content uk-navbar-center"><?php
                    the_custom_logo();
                    ?></div><?php
                endif;
                ?>
            </div>
            <div class="uk-offcanvas" id="uk-offcanvas-menu-container">
            <?php

            /**
             * Prepend the Site logo to the menu for this specific menu
             * if one has been uploaded
             */
            add_filter( 'wp_nav_menu_'.$menu_object->name.'_items', function( $items, $args ){
//					$items = has_custom_logo() ? TF_Template::modify_css_class( 'custom-logo-link', 'uk-margin-large uk-display-block uk-text-center', get_custom_logo() ). $items : $items;


                if( !has_custom_logo() ) return $items;

                $custom_logo_id = get_theme_mod( 'custom_logo' );

                $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

                $logo[ 'src' ]    = false !== $image ? $image[0] : 'http://placehold.it/220x160?text=logo+110x80';
                $logo[ 'width' ]  = false !== $image ? $image[1] : 220;
                $logo[ 'height' ] = false !== $image ? $image[2] : 160;


                $image  = '<li class="uk-margin-large uk-display-block uk-text-center">';
                $image .= '<a class="uk-display-inline-block" href="' . home_url() . '">';
                $image .= '<img src="' . $logo['src'] . '" width="' . (int)$logo['width'] / 2 . '" height="' . (int)$logo['height'] / 2 . '" />';
                $image .= '</a>';
                $image .= '</li>';

                $items = $image.$items;

                return $items;
            }, null, 2 );
            wp_nav_menu ( $menu_args );
            ?></div><?php
        }
    }


    /**
     * Override Yoast Seo's og tag description value
     *
     * @see: wp-content/plugins/wordpress-seo/frontend/class-opengraph.php
     *
     * @param string $og_description
     *
     * @return string|void
     */
    public static function override_yoast_og_description( $og_description = '' ){
        $description    = is_front_page() ? TF_Customizer::get_option('social_og_front_page_description') : TF_Customizer::get_option('social_og_default_description');
        $og_description = empty(trim($description)) ? $og_description : $description;
        return $og_description;
    }


    /**
     * Sets the Gravity Forms Spinner / Loading icon
     * only for forms that are using ajax
     *
     * @since 3.25.0
     *
     * @return string
     */
    public static function gform_ajax_spinner_url(){
        return get_theme_file_uri('images/loading.svg');
    }


    /**
     * @since 3.25.0
     */
    public static function get_entry_form_id(){
        $entry_form_id = intval( TF_Customizer::get_option( 'entry_form_id' ) );
        $entry_form_id = $entry_form_id == 0 ? false : $entry_form_id;
        return $entry_form_id;
    }


    /**
     * @since 3.25.0
     */
    public static function get_search_meta_field_names(){
        $searchable_gf_form_field_ids = TF_Customizer::get_option('searchable_fields');
        $searchable_field_names = Kirki_Field_Tf_Gf_Entry_Form_Fields_Multicheck::get_field_name_values( $searchable_gf_form_field_ids );
        $searchable_field_names = !is_array( $searchable_field_names ) ? array() : $searchable_field_names;
        return $searchable_field_names;
    }


    /**
     * @since 3.25.0
     */
    public static function get_missing_image_url(){
        return get_parent_theme_file_uri( 'images/missing.svg' );
    }


    /**
     * Get the Total Votes for an Entry
     *
     * @since 3.25.0
     *
     * @param int $entry_id     Post ID of the Entry Custom Post Type
     *
     * @return int $total_votes
     */
    public static function get_total_votes( $entry_id = null ){

        /**
         * Fail safely if a voting form has not been selected via the customizer
         */
        $entry_id = $entry_id ?: get_the_ID();
        return self::get_entrant_votes_count( $entry_id );
    }

    /**
     * Get the Total Number of Ratings for an Entry
     *
     * @since 3.26.0
     *
     * @param int $entry_id Post ID of the Entry Custom Post Type
     *
     * @return array $total_ratings [ count, sum, average ]
     */
    public static function get_total_ratings( $entry_id = null ){

        /**
         * Fail safely if a voting form has not been selected via the customizer
         */
        $entry_id = $entry_id ?: get_the_ID();
        return self::get_entrant_ratings_count( $entry_id );
    }


    /**
     *
     * @since 3.25.2
     * @param $items
     * @param $args
     *
     * @return string
     */
    public static function prepend_site_logo_as_menu_item( $items, $args ){
        if( !has_custom_logo() ) return $items;

        $custom_logo_id = get_theme_mod( 'custom_logo' );

        $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

        $logo[ 'src' ]    = false !== $image ? $image[0] : 'http://placehold.it/220x160?text=logo+110x80';
        $logo[ 'width' ]  = false !== $image ? $image[1] : 220;
        $logo[ 'height' ] = false !== $image ? $image[2] : 160;


        $image  = '<li class="uk-navbar-brand uk-width-1-4 uk-pull-left">';
        $image .= '<a class="uk-display-inline-block" href="' . home_url() . '">';
        $image .= '<img src="' . $logo['src'] . '" width="' . (int)$logo['width'] / 2 . '" height="' . (int)$logo['height'] / 2 . '" />';
        $image .= '</a>';
        $image .= '</li>';

        $items = $image.$items;

        return $items;
    }


    /**
     *
     * @since 4.2.0
     * @return int
     */
    public static function get_rating_form_id(){

        if( isset( self::$rating_form_id ) ){
            return self::$rating_form_id;
        }

        $form_id = TF_Customizer::get_option( 'rating_form_id' );
        $form_id = intval($form_id);
        self::$rating_form_id = $form_id;

        return self::$rating_form_id;
    }


    public static function get_voting_form_id(){

        if( isset( self::$voting_form_id ) ){
            return self::$voting_form_id;
        }

        $form_id = TF_Customizer::get_option( 'voting_form_id' );
        $form_id = intval($form_id);
        self::$voting_form_id = $form_id;
        return self::$voting_form_id;
    }


    public static function get_rating_form(){

        if( isset(self::$rating_form) ){
            return self::$rating_form;
        }

        self::$rating_form = TF_Forms::get_form_object( self::get_rating_form_id() );

        return self::$rating_form;
    }


    public static function get_voting_form(){

        if( isset(self::$voting_form) ){
            return self::$voting_form;
        }

        self::$voting_form = TF_Forms::get_form_object( self::get_voting_form_id() );

        return self::$voting_form;
    }


    public static function get_rating_form_post_id_control(){

        if( isset( self::$rating_form_post_id_control ) ){
            return self::$rating_form_post_id_control;
        }

        $form = self::get_rating_form();
        $fields = $form['fields'];
        foreach($fields as $key => $field){

            if( $field->type == get_class_vars('TF_GF_Field_Post_ID')['type'] ){
                self::$rating_form_post_id_control = $field->id;
                break;
            }

        }

        return self::$rating_form_post_id_control;
    }


    public static function get_voting_form_post_id_control(){

        if( isset( self::$voting_form_post_id_control ) ){
            return self::$voting_form_post_id_control;
        }

        $form = self::get_voting_form();
        $fields = $form['fields'];
        foreach($fields as $key => $field){

            if( $field->type == get_class_vars('TF_GF_Field_Post_ID')['type'] ){
                self::$voting_form_post_id_control = $field->id;
                break;
            }

        }

        return self::$voting_form_post_id_control;
    }


    /**
     * Fetches the rating count for an individual entrant
     * if it is validated, it fetches straight from post meta
     *
     * if not it runs the gravity form count
     *
     * @since 4.2.0
     *
     * @param int       $post_id
     * @param boolean   $use_cache
     * @return int
     */
    final public static function get_entrant_ratings_count( $post_id = 0, $use_cache = true ){

        $ratings_count = intval( get_post_meta( $post_id, 'ratings_count', true ) );
        if( true == get_post_meta( $post_id, 'ratings_count_validated', true ) && $use_cache === true ){
            return $ratings_count;
        }

        $ratings_count = 0;
        $post_id_field_control_form_id = self::get_rating_form_post_id_control();
        $search_criteria['field_filters'][] = array( 'key' => $post_id_field_control_form_id, 'value' => $post_id );
        $search_criteria['status'] = 'active';
        $entrant_rating_leads = GFAPI::get_entries( self::get_rating_form_id(), $search_criteria , null, null, $ratings_count );

        $ratings_count = intval( $ratings_count );

        update_post_meta( $post_id, 'ratings_count',  $ratings_count );
        update_post_meta( $post_id, 'ratings_count_validated',  'true' );

        return $ratings_count;
    }


    final public static function get_entrant_votes_count( $post_id = 0, $use_cache = true ){

        $votes = intval( get_post_meta( $post_id, 'votes', true ) );
        if( true == get_post_meta($post_id, 'votes_validated', true ) && $use_cache === true ){
            return $votes;
        }

        $search_criteria['field_filters'][] = array( 'key' => self::get_voting_form_post_id_control(), 'value' => $post_id );
        $search_criteria['status'] = 'active';
        $entrant_voting_leads = GFAPI::get_entries( self::get_voting_form_id(), $search_criteria , null, null, $votes );
        $votes = intval( $votes );
        update_post_meta( $post_id, 'votes',  $votes );
        update_post_meta( $post_id, 'votes_validated',  'true' );

        return $votes;
    }


    final public static function get_entrant_ratings_average( $post_id = 0, $use_cache = true ){

        $ratings_average = round( get_post_meta( $post_id, 'ratings_average', true ), 2 );

        if( $use_cache === true && true == get_post_meta( $post_id, 'ratings_average_validated', true ) ){
            return $ratings_average;
        }

        $entrant_ratings_count = self::get_entrant_ratings_count( $post_id, $use_cache );

        /**
         * Entrant has no ratings
         * set the average to zero
         * ... prevents division by zero
         */
        if( $entrant_ratings_count < 1 ){
            $ratings_average = 0;
            update_post_meta( $post_id, 'ratings_average', $ratings_average );
            update_post_meta( $post_id, 'ratings_average_validated', 'true' );
            return $ratings_average;
        }


        $ratings_average = self::get_entrant_ratings_sum( $post_id, $use_cache ) / self::get_entrant_ratings_count( $post_id, $use_cache );
        $ratings_average = round( $ratings_average, 2 );

        update_post_meta( $post_id, 'ratings_average', $ratings_average );
        update_post_meta( $post_id, 'ratings_average_validated', 'true' );

        return $ratings_average;

    }


    final public static function get_entrant_ratings_sum( $post_id = 0, $use_cache = true ){

        $entrant_ratings_sum_time_start = microtime(true);

        $ratings_sum = intval( get_post_meta( $post_id, 'ratings_sum', true ) );

        if( $use_cache === true && true == get_post_meta( $post_id, 'ratings_sum_validated', true ) ){
            return $ratings_sum;
        }

        $form = self::get_rating_form();
        $fields = $form['fields'];
        $post_id_field_control_form_id = null;
        foreach($fields as $key => $field){

            /**
             * This needs to change,
             * what if there are more than one dropdown fields on the form?
             * @todo create a 'rating' field control
             *
             */
            if( $field->type == 'select' ){
                $rating_field_control_form_id = $field->id;
                break;
            }

        }

        $post_id_field_control_form_id = self::get_rating_form_post_id_control();
        $search_criteria['field_filters'][] = array( 'key' => $post_id_field_control_form_id, 'value' => $post_id );
        $search_criteria['status'] = 'active';
        $ratings_count = 0;

        /**
         * Count the total ratings for this entrant
         * @uses $ratings_count
         */
        GFAPI::get_entries( self::get_rating_form_id(), $search_criteria , null, null, $ratings_count );
        $ratings_count = intval($ratings_count);

        /**
         * Sum ALL the rating entries for this entrant
         * @uses $search_criteria
         */
        $paging['page_size'] = $ratings_count;
        $entrant_rating_leads = GFAPI::get_entries( self::get_rating_form_id(), $search_criteria, null, $paging );

        $ratings_sum = 0;
        foreach( $entrant_rating_leads as $k => $value ){

            /**
             * Can't find the rating value for this rating
             * Move along
             */
            if( !isset( $value[ $rating_field_control_form_id ] ) ){
                continue;
            }

            $ratings_sum += intval( $value[ $rating_field_control_form_id ] );
        }

        update_post_meta( $post_id, 'ratings_sum', $ratings_sum );
        update_post_meta( $post_id, 'ratings_sum_validated', 'true' );

        $entrant_ratings_sum_time_elapsed = microtime(true) - $entrant_ratings_sum_time_start;

        return $ratings_sum;
    }


    final private static function get_entry_count_per_form( $form_name = '' ){

        /**
         * Get all entries per gravity form
         * Reads from a cache first, which is great
         */
        $view_count_per_form = GFFormsModel::get_entry_count_per_form();
        $desired_form_id = null;

        if( $form_name != '' ){
            $desired_form_id = intval( TF_Customizer::get_option( "{$form_name}_form_id" ) );
        }

        if( !isset( $desired_form_id ) ){
            return $view_count_per_form;
        }

        foreach( $view_count_per_form as $key => $data ) {

            if ( $desired_form_id != $data->form_id ) {
                continue;
            }

            return intval( $data->lead_count );
        }

        return $view_count_per_form;
    }


    final public static function get_total_ratings_count(){

        if( isset( self::$total_ratings_count ) ){
            return self::$total_ratings_count;
        }

        self::$total_ratings_count = self::get_entry_count_per_form( 'rating' );
        return self::$total_ratings_count;
    }


    final public static function get_total_entrants_count(){

        if( isset( self::$total_entrants_count ) ){
            return self::$total_entrants_count;
        }

        self::$total_entrants_count = self::get_entry_count_per_form( 'entry' );
        return self::$total_entrants_count;
    }


    final public static function get_total_ratings_sum(){

        $total_ratings_sum = get_transient( 'total_ratings_sum' );

        if( $total_ratings_sum !== false ){
            return intval( $total_ratings_sum );
        }

        $args = array(
            'post_type'         => 'entry',
            'meta_key'          => 'ratings_sum',
            'post_status'       => 'publish',
            'posts_per_page'    => -1
        );
        $loop = new WP_Query($args);

        if ( ! $loop->have_posts() ){
            return $total_ratings_sum ?: 0;
        }

        global $post;
        while ($loop->have_posts()){
            $loop->the_post();
            $total_ratings_sum += isset( $post->ratings_sum ) ? intval( $post->ratings_sum ) : 0;
        }
        $total_ratings_sum = intval( $total_ratings_sum );

        /**
         * Expire after 1 week
         */
        set_transient( 'total_ratings_sum', $total_ratings_sum, 604800 );
        return $total_ratings_sum;
    }


    /**
     * Calculate the bayesian average
     *
     * @param int       $post_id
     * @param boolean   $use_cache
     * @return float
     */
    final public static function get_entrant_bayesian_average( $post_id = 0, $use_cache = true ){

        $bayesian_average = round( get_post_meta( $post_id, 'bayesian_average', true ), 3 );

        if( true == get_post_meta( $post_id, 'bayesian_average_validated', true ) && $use_cache === true ){
            return $bayesian_average;
        }

        $total_entrants_count   = self::get_total_entrants_count();
        $total_ratings_count    = self::get_total_ratings_count();


        /**
         * No Entries or ratings captured yet, so no need to continue
         */
        if( $total_entrants_count == 0 || $total_ratings_count == 0 ){
            $bayesian_average = 0;
            update_post_meta( $post_id, 'bayesian_average', $bayesian_average );
            update_post_meta( $post_id, 'bayesian_average_validated', 'true' );
            return $bayesian_average;
        }

        $total_ratings_sum      = self::get_total_ratings_sum();

        $entrant_ratings_count  = self::get_entrant_ratings_count( $post_id, $use_cache );

        /**
         * This entrant has no ratings, no need to continue
         */
        if( $total_ratings_sum  == 0 ){
            $bayesian_average = 0;
            update_post_meta( $post_id, 'bayesian_average', $bayesian_average );
            update_post_meta( $post_id, 'bayesian_average_validated', 'true' );
            return $bayesian_average;
        }

        $entrant_ratings_sum    = self::get_entrant_ratings_sum( $post_id, $use_cache );


        /**
         * Edge case where an entrant has an undefined value of ratings
         */
        if( $entrant_ratings_sum == 0 ){
            $bayesian_average = 0;
            update_post_meta( $post_id, 'bayesian_average', $bayesian_average );
            update_post_meta( $post_id, 'bayesian_average_validated', 'true' );
            return $bayesian_average;
        }


        $bayesian_average_p1 = $total_ratings_count / $total_entrants_count;
        $bayesian_average_p1 = $bayesian_average_p1 * ( $total_ratings_sum / $total_entrants_count );
        $bayesian_average_p1 = $bayesian_average_p1 + ( $entrant_ratings_count * $entrant_ratings_sum );

        $bayesian_average_p2 = $total_ratings_count / $total_entrants_count;
        $bayesian_average_p2 = $bayesian_average_p2 + $entrant_ratings_count;

        $bayesian_average = round( ( $bayesian_average_p1 / $bayesian_average_p2 ), 3 );

        update_post_meta( $post_id, 'bayesian_average', $bayesian_average );
        update_post_meta( $post_id, 'bayesian_average_validated', 'true' );

        return $bayesian_average;
    }


    /**
     * Force the refresh of bayesian ratings across all entrants
     * append ?cache=true string to the admin url
     */
    public static function use_cache(){
        $use_cache = isset( $_GET[ 'cache' ] ) && $_GET['cache'] == 'false' ? false : true;
        return $use_cache;
    }
}


/**
 * Append the Post Gallery to the post content
 * for all submissions via the enter form
 *
 *
 *
 * @link https://www.gravityhelp.com/documentation/article/gform_after_create_post/
 *
 * @param int $post_identry
 * @param $entry
 * @param $form
 */
function tf_gform_after_create_post( $post_id, $entry, $form ){

    apply_filters('tf_gform_after_create_post_auto_create_gallery',$post_id);


    /**
     * Get the after photo image
     * and add it to the meta data for the post
     */
    /**
     * Get submitted form fields as an associative array
     * label -> id | array of id's
     */
    $after_photo_field_id = null;
    $form_fields_entry_input_ids = array();
    $form_fields = $form['fields'];
    foreach( $form_fields as $key => $field ){

        if( $field->get_input_type() != 'post_image' ) continue;
        if( ! $field->label ) continue;
        if( $field->label != 'After Photo 1' ) continue;

        $field_input_ids = array();
        $field_entry_inputs = $field->get_entry_inputs() ;

        if( is_array( $field_entry_inputs) ){
            foreach($field_entry_inputs as $k => $input ){
                $field_input_ids[] = $input['id'];
            }
        }

        $form_fields_entry_input_ids[$field->label] = count( $field_input_ids ) == 0 ? $field->id : $form_fields_entry_input_ids ;
        $after_photo_field_id = $field->id;
        break;
    }

    /**
     * This adds the meta key 'After Photo 1'
     */
    if( isset( $after_photo_field_id) ){
        $_after_photo_url = explode( '|:|', $entry[$after_photo_field_id] );
        $after_photo_url = $_after_photo_url[0];
        update_post_meta( $post_id, 'After Photo 1', $after_photo_url );
    }


    /**
     * Get submitted form fields as an associative array
     * label -> id | array of id's
     */
    $youtube_website_field_id = null;
    $form_fields_entry_input_ids = array();
    $form_fields = $form['fields'];
    foreach( $form_fields as $key => $field ){

        if( $field->get_input_type() != 'youtube_website' ) continue;
        if( ! $field->label ) continue;

        $field_input_ids = array();
        $field_entry_inputs = $field->get_entry_inputs() ;

        if( is_array( $field_entry_inputs) ){
            foreach($field_entry_inputs as $k => $input ){
                $field_input_ids[] = $input['id'];
            }
        }

        $form_fields_entry_input_ids[$field->label] = count( $field_input_ids ) == 0 ? $field->id : $form_fields_entry_input_ids ;
        $youtube_website_field_id = $field->id;
        break;
    }


    /**
     * This adds the meta key 'youtube_website'
     */
    if( isset( $youtube_website_field_id) ){
        $youtube_url = $entry[$youtube_website_field_id];
        update_post_meta( $post_id, 'youtube_website', $youtube_url );
    }

}


$entry_form_id = abs( TF_Customizer::get_option( 'entry_form_id' ) );
if($entry_form_id > 0){
    add_action( 'gform_after_create_post_'.$entry_form_id, 'tf_gform_after_create_post', null, 3);
}

new BananaCream();


function tf_gform_after_create_post_auto_create_gallery( $post_id ){

    $attached_images = get_attached_media( 'image', $post_id );
    if( count( $attached_images ) <= 0 ) return;

    /**
     * Generate a gallery from the images uploaded
     */
    $post = get_post( $post_id );
    $post_content = $post->post_content;

    $post_gallery_short_code = '[gallery size="large" ids="%s"]';
    $attachment_ids = array_keys($attached_images);
    $post_gallery_short_code = sprintf($post_gallery_short_code, implode(',',$attachment_ids) );


    $new_post_content = $post_content.'
'.$post_gallery_short_code;
    wp_update_post(array(
        'ID'            => $post_id,
        'post_content'  => $new_post_content
    ));
}


add_filter( 'tf_gform_after_create_post_auto_create_gallery','tf_gform_after_create_post_auto_create_gallery' );