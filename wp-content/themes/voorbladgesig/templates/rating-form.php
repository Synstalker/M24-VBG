<?php

if( ! class_exists( 'TF_GF_Field_Star_Rating' ) ) return;

/**
 * Check if a rating form is selected
 * to facilitate the rating functionality
 */
$rating_form_id = intval( TF_Customizer::get_option( 'rating_form_id' ) );
if( $rating_form_id <= 0 || !TF_Customizer::get_option( 'rating_is_enabled' ) ) return;

add_action( 'wp_footer', 'tf_rating_logic', 99 );
function tf_rating_logic(){
    ?>
        <script>
            jQuery( document ).on( 'click', '.rating', function( e ){
                console.log( jQuery( e.currentTarget ).data( 'rating' ) );
                jQuery( e.currentTarget ).parent().attr( 'data-stars', jQuery( e.currentTarget ).data( 'rating' ) );
                jQuery( '#rating_modal select option[selected]').removeAttr( 'selected' );
                jQuery( '#rating_modal select option[value="' + ( jQuery( e.currentTarget ).data( 'rating' ) ) +'"]' ).attr( 'selected', 'selected' );
                UIkit.modal( '#rating_modal' ).show();
            } );
        </script>
    <?php
};

global $rating_count_total;
global $rating_count_average;

?>
<div class="uk-grid">

    <div class="uk-width-medium-4-10 tf_rating_stars_container uk-margin-small-top">
        <div data-uk-modal="{ target: '#xrating_modal' }" class="tf_rating_stars uk-float-left" data-stars="<?php echo ( $rating_count_average && $rating_count_average > 0 ) ? $rating_count_average : 1; ?>">
            <svg height="30" width="28" class="star rating" data-rating="1">
                <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
            </svg>
            <svg height="30" width="28" class="star rating" data-rating="2">
                <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
            </svg>
            <svg height="30" width="28" class="star rating" data-rating="3">
                <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
            </svg>
            <svg height="30" width="28" class="star rating" data-rating="4">
                <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
            </svg>
            <svg height="30" width="28" class="star rating" data-rating="5">
                <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
            </svg>
        </div>
    </div>

    <div class="uk-width-medium-6-10 uk-vertical-align tf_rating_instruction">
        <div class="uk-vertical-align-middle">
        <p class="uk-text-small uk-margin-top"><?php _e('Klik op die sterre om jou ondersteuning te wys.'); ?></p>
        </div>
    </div>

    <!-- <div class="uk-width-1-1">
        <span class="uk-float-right">
            <?php echo _e( 'Ratings') . ": " . ( $rating_count_total ? $rating_count_total : 0 ); ?>
        </span>
    </div> -->

</div>

<div id="rating_modal" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<?php echo do_shortcode('[gravityform id="'.$rating_form_id.'" title="false" description="false" ajax="'.TF_Customizer::get_option( 'rating_form_is_ajax', 'boolean_string' ).'"]'); ?>
	</div>
</div>
