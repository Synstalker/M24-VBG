<?php

/**
 * Voorblad Gesig functions.php
 *
 * @since   0.0.1
 */

//Constants
define( 'VBG_VER', '0.5.1' );

add_filter( 'tf_preview_image_args', function( $args ){
    $args['width'] = 240;
    $args['height'] = 320;
    return $args;
} );

//This is a filter to change the default validation message that Gravity Forms generates
add_filter('gform_validation_message', 'change_validation_message', 10, 2);
function change_validation_message($message, $form)
{
    return "<div class='validation_error uk-alert uk-alert-danger'>" . __("Daar was ’n probleem met jou inskrywing. Foute word hieronder uitgelig.", 'twentyfourdotcom') . "</div>";
}

// Portrait Image Sizes for Entries
// Moved them out of after_setup_theme hook, had issues
add_theme_support('post-thumbnails');
add_image_size( 'tf_portrait_xsmall', 120, 160, true );
add_image_size( 'tf_portrait_small', 240, 320, true );
add_image_size( 'tf_portrait_medium', 480, 640, true );
add_image_size( 'tf_portrait_large', 960, 1280, true );

add_filter( 'image_size_names_choose', 'tf_custom_image_sizes' );

/**
 * Add custom image sizes to select box in media manager
 * @param $sizes
 * @return array
 * @since 0.2.0
 */
function tf_custom_image_sizes( $sizes ) {
    $custom_sizes = array(
        'tf_portrait_small' => 'Portrait Small',
        'tf_portrait_medium' => 'Portrait Medium',
        'tf_portrait_large' => 'Portrait Large'
    );
    return array_merge( $sizes, $custom_sizes );
}

/**
 * Converts a decimal value to a fraction. Used to check aspect ration in this case
 * @param $fraction
 * @return float|string
 * @since 0.2.1
 * @author Simon Dowdles - simon.dowdles@24.com
 */
function decimal_to_fraction($fraction) {
    $base = floor($fraction);
    $fraction -= $base;
    if( $fraction == 0 ) return $base;
    list($ignore, $numerator) = preg_split('/\./', $fraction, 2);
    $denominator = pow(10, strlen($numerator));
    $gcd = gcd($numerator, $denominator);
    $fraction = ($numerator / $gcd) . '/' . ($denominator / $gcd);
    if( $base > 0 ) {
        return $base . ' ' . $fraction;
    } else {
        return $fraction;
    }
}

/**
 * Recursively divide until we arrive at 1/x
 * @param $a
 * @param $b
 * @return mixed
 * @since 0.2.1
 * @author Simon Dowdles - simon.dowdles@24.com
 */
function gcd($a,$b) {
    return ($a % $b) ? gcd($b,$a % $b) : $b;
}

// Apply a global filter to submitted GForms
add_filter( 'gform_validation', 'tf_enter_form_validate_images' );

/**
 * Filter to validate entry images based on the presence of class "validate-portrait-image"
 * @param $validation_result
 * @return mixed
 * @author Simon Dowdles - simon.dowdles@24.com
 */
function tf_enter_form_validate_images( $validation_result ){
    $form = $validation_result['form'];
    foreach( $form['fields'] as &$field ) {
        // We never validate hidden images
        $is_hidden = RGFormsModel::is_field_hidden( $form, $field, array() );
        if ( strpos( $field->cssClass, 'validate-portrait-image' ) === false || $is_hidden ) {
            continue;
        }

        $input_name = "input_{$field['id']}";
        $uploadedFile = RGFormsModel::get_temp_filename( $form,$input_name );

        if( !$uploadedFile ){
            continue;
        }

        // Try to get the temp file path first
        $file_temp_path = RGFormsModel::get_upload_path( $form['id'] ) . "/tmp/" . $uploadedFile['temp_filename'];

        if ( file_exists( $file_temp_path ) ) {
            $image_size_bytes = filesize( $file_temp_path );
            $image_dimensions = @getimagesize( $file_temp_path );
        }
        // If the tmp file is not there, use the temp location as indicated in the $_FILES superglobal
        elseif ( isset( $_FILES[$input_name] ) && !empty( $_FILES[$input_name] ) )  {
            $image_size_bytes = $_FILES[$input_name]['size'];
            $image_dimensions = @getimagesize( $_FILES[$input_name]['tmp_name'] );
        }

        // If we can not ge the dimensions, there is not more we can do, and we really should not get to this point!
        if( !$image_dimensions ){
            continue;
        }

        // Get width and height
        list($width, $height) = $image_dimensions;

        $ratio = decimal_to_fraction( $width / $height );

        // If we want to validate size, we can get the size in Kb or Mb:
        // $image_size_bytes / 1024 --> Kb
        // $image_size_bytes / 1024 / 1024 --> Mb

        // Check to see that our ratio is 3/4 based on the allowable sizes
        // Validate min width and min height
        // Validate max size of 2MB
        if( ( $width < 120 || $height <  160 ) || ( ceil( $image_size_bytes / 1024 / 1024 ) > 8 ) ){
            $validation_result['is_valid'] = false;
            $field->failed_validation = true;
            $field->validation_message = "Laai asseblief ’n portret-foto van ten minste 480 x 640 px en wat nie groter as 4 MB is nie.";
        }else{
            // If all is well, continue
            continue;
        }

    }
    // Important, we HAVE to return the form instance or GF will fail and say that it can not find our field
    $validation_result['form'] = $form;
    return $validation_result;

}


/**
 * Filter to validate entry images based on the presence of class "validate-portrait-image"
 * @param $validation_result
 * @return mixed
 */
function custom_search_method( $query ) {

    if ( !is_admin() && $query->is_search )
    {
       $query->set('post_type', 'entry');  // added
       $meta_query = array();  //edited

        // Only check these form fields
        $fields = array( 'name', 'surname', 'city');

         if(isset($_GET['cat'])){
             $cat_id = $_GET['cat'];
             $meta_query[] = array( 'category__in' => array( $cat_id ) );
         }

        foreach( $fields as $field ) {
           if( isset($_GET[$field]) AND $_GET[$field] != '' ) {
               $meta_query[] = array(
                   'key' => $field,
                   'value' => sanitize_text_field ( $_GET[$field] ),
                   'compare' => 'LIKE',
               );
           }
       }
       $meta_query['relation'] = 'OR';   // ADDED

       $query->set('meta_query',$meta_query);

    }

    return;
}
add_action( 'pre_get_posts', 'custom_search_method');

/**
 * Set the post type to 'entry' for the nominate form
 * @link https://www.gravityhelp.com/documentation/article/gform_post_data/
 * @since 1.0.0
 */
function vbg_modify_post_data($post_data, $form, $entry)
{
    $nominate_form_id = get_option('nominate_form_id');

    if ($form['id'] != $nominate_form_id) return $post_data;

    $post_data['post_type'] = 'entry';
    return $post_data;
}

add_filter('gform_post_data', 'vbg_modify_post_data', null, 4);

/**
 * If we are using a nominate form, make sure we are generating correct images for it
 */
$nominate_form_id = abs( get_option( 'nominate_form_id' ) );
if($nominate_form_id > 0){
    add_action( 'gform_after_create_post_'.$nominate_form_id, 'tf_gform_after_create_post', null, 3);
}

/**
 * Add cutomizer options
 * @param $wp_customize
 * @since 1.0.0
 */
function vbg_customize_register($wp_customize)
{
    $wp_customize->add_section('nominate', array(
        'title' => 'Nominate Entries',
        'description' => 'Customize the Nominate Entry Form experience',
        'priority' => 101,
    ));

    $wp_customize->add_setting('nominate_form_id', array(
        'default' => null,
        'capability' => 'edit_theme_options',
        'type' => 'option',

    ));

    $wp_customize->add_control('nominate_form', array(
        'label' => 'Nominate Form',
        'section' => 'nominate',
        'settings' => 'nominate_form_id',
        'type' => 'tf_gf_form_dropdown',
    ));
}

add_action('customize_register', 'vbg_customize_register');

// Enqueue Child Theme Styles
add_action( 'wp_enqueue_scripts', 'tf_enqueue_child_style', 99 );

/**
 * Enqueue Child Theme Styles Correctly
 * @since 0.2.1
 * @return void
 */
function tf_enqueue_child_style(){
    wp_enqueue_style( 'child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('TF_Theme_theme_style'), VBG_VER, 'all' );
}


/**
 * gets uploaded images from saved_post and sends them to the overlay generator
 */
add_action( 'save_post', 'set_post_content', 10, 3 );
function set_post_content( $post_id, $post, $update ) {

    if( !get_post_type( $post_id ) === 'entry' ){
        return;
    }

    if( 'trash' === $post->post_status ){
        return;
    }

    // Does it have a thumbnail? It should...
    if ( has_post_thumbnail( $post_id )  ){

        $thumbnail_src_large = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'tf_portrait_large' );
        $thumbnail_src_medium = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'tf_portrait_medium' );
        $thumbnail_src_small = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'tf_portrait_small' );
        $thumbnail_src_xsmall = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'tf_portrait_xsmall' );

        $uploads = wp_upload_dir();

        $image_url_large = $thumbnail_src_large[0]; // URL lives at index 0
        $image_path_large = str_replace( $uploads['baseurl'], $uploads['basedir'], $image_url_large );

        $image_url_medium = $thumbnail_src_medium[0]; // URL lives at index 0
        $image_path_medium = str_replace( $uploads['baseurl'], $uploads['basedir'], $image_url_medium );

        $image_url_small = $thumbnail_src_small[0]; // URL lives at index 0
        $image_path_small = str_replace( $uploads['baseurl'], $uploads['basedir'], $image_url_small );

        $image_url_xsmall = $thumbnail_src_xsmall[0]; // URL lives at index 0
        $image_path_xsmall = str_replace( $uploads['baseurl'], $uploads['basedir'], $image_url_xsmall );

        $overlayLarge = make_overlay_image($image_path_large, $thumbnail_src_large);
        $overlayMedium = make_overlay_image($image_path_medium, $thumbnail_src_medium);
        $overlaySmall = make_overlay_image($image_path_small, $thumbnail_src_small);
        $overlayXsmall = make_overlay_image($image_path_xsmall, $thumbnail_src_xsmall);

        if( !$overlayLarge || !$overlayMedium || !$overlaySmall || !$overlayXsmall ){
            // One of them failed, not sure how you want to handle that?
        }

    }
}


/**
 * Generates individual image.
 * @param type $var destination image path.
 * @param type $var atts dimention attributes
 */
function make_overlay_image($destination_img = false, $atts = []){

    if( !$destination_img || empty( $atts ) || !class_exists( 'Imagick' ) ){
        return false;
    }

    $image_overlay = TF_Customizer::get_option('image_overlay');

    if(!$image_overlay){
        return false;
    }

    // Get width and height dynamically
    $width = $atts[1];
    $height = $atts[2];

    $uploads = wp_upload_dir();
    $image_overlay_path = str_replace( $uploads['baseurl'], $uploads['basedir'], $image_overlay );

    // If they uplaoded a file but it has been removed from the uploads folder, catch that error...
    if( !file_exists( $image_overlay_path ) ) return false;

    // Destination Image
    $image = new Imagick();
    $image->readImage( $destination_img );

    // Watermark Image
    $imageWatermark = new Imagick();
    $imageWatermark->readImage( $image_overlay_path );

    // Dimensions of Watermark
    $geo = $imageWatermark->getImageGeometry();

    // Set watermark to fit destination image
    if(($geo['width']/$width) < ($geo['height']/$height))
    {
        $imageWatermark->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
    }
    else
    {
        $imageWatermark->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
    }

    // Set resized thumbnail image in memory
    $imageWatermark->ThumbnailImage($width,$height,true);

    // Overlay in memory watermark image over original image
    $image->compositeImage($imageWatermark, imagick::COMPOSITE_OVER, 0, 0);
    $image->setImageCompression(true);

    return $image->writeImage($destination_img);

    // NB, destroy the images after use, do not keep them in memory
    imagedestroy( $image );
    imagedestroy( $imageWatermark ) ;

}

// Try set this global as soon as possible
add_action( 'wp_head', 'tf_override_gf_drop_zones_set_flag', 0 );

/**
 * Set the necessary flag so that TF_Forms knows not to act on photo drop zones just yet
 * @return void
 * @since 0.3.2
 * @author Simon Dowdles - 24.com Open Source Team [simon.dowdles@24.com]
 */
function tf_override_gf_drop_zones_set_flag(){
    ?>
    <script type="text/javascript">
        window.TF_OVERRIDE_IMAGE_DROP_ZONES = true;
    </script>
    <?php
}

// Override the actual photo drop zone functionality, extending off what TF_Forms has done
// For more info, see around line 113 of mu-plugins/TF_Forms/js/functions.js

add_action( 'wp_footer', 'tf_override_gf_drop_zones_js', 999 );

/**
 * Override the actual logic, extending from window.TF_GF_Field_Post_Image
 * @return void
 * @since 0.3.2
 * @author Simon Dowdles - 24.com Open Source Team [simon.dowdles@24.com]
 */
function tf_override_gf_drop_zones_js(){
    ?>
    <script src="<?php echo get_stylesheet_directory_uri() . '/assets/js/exif.js'; ?>"></script>
    <script type = "text/javascript">

        // Create a spinner element for each overlay box. We show / hide it much further down in the ajax logic
        $('.tf-gf-photo-upload .uk-overlay').append( '<div class="tf-cover-mockup-loader uk-hidden" style="position:absolute;top:70%;left:0;width:100%;height:100%; z-index:999;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ajax_spinner.svg" data-uk-svg></div>' );

        // Set the cover image URL, or false if there is not one
        window.TF_COVER_IMAGE = <?php echo TF_Customizer::get_option('image_overlay') ? "\"" . TF_Customizer::get_option('image_overlay') . "\""  : "false"; ?>;

        // Function that correctly redraws the canvas after rotation
        function drawToFitRotated(ctx, angle, image){
            var dist = Math.sqrt(Math.pow(ctx.canvas.width /2, 2 ) + Math.pow(ctx.canvas.height / 2, 2));
            var imgDist = image.width < image.height ? Math.max(image.width, image.height) / 2 : Math.min(image.width, image.height) / 2;
            var minScale = dist / imgDist;
            var dx = Math.cos(angle) * minScale;
            var dy = Math.sin(angle) * minScale;
            ctx.setTransform(dx, dy, -dy, dx, ctx.canvas.width / 2, ctx.canvas.height / 2);
            ctx.drawImage(image, (-image.width / 2), (-image.height / 2) );
            ctx.setTransform(1, 0, 0, 1, 0, 0);
        }

        // Function to convert the Base64 data of the readfile() function into ArrayBuffer, required for the EXIF library
        function base64ToArrayBuffer (base64) {
            base64 = base64.replace(/^data\:([^\;]+)\;base64,/gmi, '');
            var binaryString = atob(base64);
            var len = binaryString.length;
            var bytes = new Uint8Array(len);
            for (var i = 0; i < len; i++) {
                bytes[i] = binaryString.charCodeAt(i);
            }
            return bytes.buffer;
        }

        jQuery( document ).ready( function(){

            // Init the drop zone using our extended object
            // The openFile is experimental and aims to solve our issue of images not uploading correctly in mobile.
            var openFile = function( event, index ) {

                $(event.currentTarget).find('.uk-overlay-panel').append( '<canvas class="tf-canvas-placeholder uk-hidden"></canvas>' );

                var input = event.target.files[0];
                var reader = new FileReader();
                var preview_container = $(event.currentTarget).find('.uk-overlay-panel');
                var canvasContainer = $(preview_container).find('.tf-canvas-placeholder');
                var canvas = canvasContainer[0];

                if( [ 'image/jpeg', 'image/png' ].indexOf( input.type ) < 0 ) {
                    alert("Lêerformaat moet van JPEG of PNG wees");
                    return;
                }

                // We set the width and height to match the same cropped value we know we are after in our PHP processing
                canvas.width = 480;
                canvas.height = 640;
                // Set the context to 2D
                var ctx = canvas.getContext("2d");

                reader.onload = function( file_upload_result ){

                    // Store our file image data in an actual DOM image element, makes life much easier
                    var i = new Image();
                    i.src = file_upload_result.target.result;
                    i.onload = function() {

                        // If the image does not meet the minimum requirements, bail like a snail
                        if (i.width < 120 || i.height < 160) {
                            alert("Laai asseblief ’n portret-foto van ten minste 120 x 160 px en wat nie groter as 4 MB is nie.");
                            return;
                        }

                        // Get the Exif data from the file resource. We use exif.js for this.
                        var exif = EXIF.readFromBinaryFile(base64ToArrayBuffer(file_upload_result.target.result));

                        // If we have a Make and Model Exif key, proceed to check it
                        if (typeof(exif.Make) !== 'undefined' && typeof(exif.Model) !== 'undefined') {
                            switch (exif.Make) {
                                // iPhone seems to be the cuplrit, so act on it...
                                case "Apple" :
                                case "Android":
                                    switch (exif.Orientation) {
                                        case 8:
                                            drawToFitRotated(ctx, -90 * Math.PI / 180, i);
                                            break;
                                        case 3:
                                            drawToFitRotated(ctx, 180 * Math.PI / 180, i);
                                            break;
                                        case 6: // This is the one that caused most problems for us
                                            drawToFitRotated(ctx, 90 * Math.PI / 180, i);
                                            break;
                                        default:
                                            drawToFitRotated(ctx, 0, i);
                                            break;
                                    }
                                    break;
                                default:
                                    drawToFitRotated(ctx, 0, i);
                                    break;
                            }
                        } else {
                            drawToFitRotated(ctx, 0, i);
                        }

                        if (index === 1) {
                            $(event.currentTarget).find('.uk-overlay-panel').append('<div id="tf-cover-mockup" style="position:absolute;top:0;left:0;width:100%;height:100%;background:url(' + window.TF_COVER_IMAGE + ') center center no-repeat;background-size:contain;z-index:99;"></div>');
                        }

                        var ajaxURL = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
                        jQuery.ajax({
                            url: ajaxURL,
                            data: {
                                action: 'tf_preview_image',
                                img_data: file_upload_result.target.result
                            },
                            method: 'POST',
                            dataType: 'json',
                            beforeSend: function () {
                                $(event.currentTarget).find('.tf-cover-mockup-loader').removeClass('uk-hidden');
                            },
                            success: function (data) {
                                $(event.currentTarget).find('.tf-cover-mockup-loader').addClass('uk-hidden');
                                if (data.img_data) {
                                    // jQuery( 'body' ).prepend( '<img src="data:image/png;base64,' +  data.img_data +'" />' );
                                    jQuery(preview_container).css('background', 'url(data:image/png;base64,' + data.img_data + ') center center no-repeat #eee');
                                    jQuery(preview_container).css('background-size', 'contain');
                                }
                            }
                        });

                        $(preview_container).removeClass('uk-hidden');

                    }

                };

                reader.readAsDataURL(input);

            };

            $( '.tf-gf-photo-upload' ).each(function( index ){
                $(this).on( 'change', function(e){
                    if( e.target.files.length < 1 )
                        return;
                    openFile(e, index + 1);
                } );

                //new TF_UK_Photo_Drop_Zone( jQuery(this) );

            });

        } )
    </script>
    <?php
}

/**
* Override the individual entrant og image
* and set it to the first image from the post gallery = the overlayed image
**/
add_filter( 'wpseo_og_og_image', 'set_individual_entrant_og_image', null, 1 );
function set_individual_entrant_og_image( $content ){

  /**
  * If this is not the individual entrant page, do nothing extra
  **/
  if( ! is_single() || get_post_type() != 'entry' )
    return $content;

    $gallery = get_post_gallery(get_the_ID(), false);
    $gallery_ids = explode( ",", $gallery['ids'] );

    /**
    * If no galleries found, do nothing extra
    **/
    if( count( $gallery_ids ) < 1 )
    return $content;

    $image = wp_get_attachment_image_src( $gallery_ids[0], 'tf_portrait_small' );
    $content = $image[0]; //0 index = url of the image, 1 = width dimension, 2 = height dimension

  return $content;
}

/**
 * Overwrite Banana Cream modify_wp_search_where()
 *
 * @see modify_wp_search_where()
 *
 * @param $where
 *
 * @return null|string|string[]
 */
function modify_wp_search_where( $where ) {

	if ( ! class_exists( 'Kirki_Field_Tf_Gf_Entry_Form_Fields_Multicheck' ) ) {
		return $where;
	}

	global $wp;

	if ( is_search() && $wp->query_vars['s'] ) {
		global $wpdb;

		$where = preg_replace(
			"/($wpdb->posts.post_title (LIKE '%{$wp->query_vars['s']}%'))/i",
			"$0 OR ( $wpdb->postmeta.meta_value LIKE '%{$wp->query_vars['s']}%' AND $wpdb->postmeta.meta_key IN ('" . implode( "','", array_keys( BananaCream::get_search_meta_field_names() ) ) . "') )",
			$where
		);

		add_filter( 'posts_join_request', 'modify_wp_search_join' );
		add_filter( 'posts_distinct_request', 'modify_wp_search_distinct' );
	}

	return $where;
}
