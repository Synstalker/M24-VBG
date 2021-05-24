<?php
//Load More requirements
//$cat_id 	=   get_query_var( 'cat' ) ? get_query_var( 'cat' ) : ( array_key_exists(0, get_the_category() ) ? get_the_category()[0]->term_id : post_type_archive_title() ) ;
$ppp 		=   get_query_var( 'posts_per_page' ) ? (int) get_query_var( 'posts_per_page' ) : 5;
$c          =   0;

//if( $c >= $ppp ){?>

	<div id="tf-core-load-more-container" class="row default-layout"></div>

	<div style="display:none" id="tf-core-load-more-done-msg" class="lm-alert">
		<?php _e( 'No more posts to load.', 'daily-news' ); ?>
	</div>
	<div class="col-xs-12 text-center">
		<button
			id="daily-news-load-more"
			class="btn btn-default"

			data-tfcore-lm-type="category"
			data-tfcore-lm-image="post-thumbnail"
			data-tfcore-lm-mimic="category-article"
			data-tfcore-lm-ppp="<?php echo $ppp; ?>"
<!--			data-tfcore-lm-id="--><?php //echo $cat_id; ?><!--">-->

			<?php _e( 'Load More', 'daily-news' ); ?>
			<div style="display:none" id="tf-core-load-more-btn-preloader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>

		</button>
	</div>
<?php //} ?>