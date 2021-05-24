<div id="before_after_images" class="uk-grid uk-panel uk-margin-top uk-margin-large-bottom uk-grid-match" data-uk-grid-match="{target:'.uk-panel'}">
    <?php 
    if ($gallery = get_post_gallery(get_the_ID(), false)) :
        if( $imageIdArray = explode( ",", $gallery['ids'] ) ){
            foreach ( $imageIdArray as $imageId ) {
                $image = wp_get_attachment_image_src( $imageId, 'tf_portrait_small' );
                $imageLarge = wp_get_attachment_image_src( $imageId, 'tf_portrait_medium' );
                ?>
                    <div class="uk-width-large-1-3 uk-width-medium-1-2 uk-width-small-1-1 uk-text-center ">
                        <div href="<?php echo $imageLarge[0] ?>" data-uk-lightbox="{group:'before_after'}">
                            <img class="uk-panel uk-container-center uk-align-center" src="<?php echo $image[0] ?>" />
                        </div>
                    </div>
            
                <?php
            }
        }
    endif; 
    ?>
</div>