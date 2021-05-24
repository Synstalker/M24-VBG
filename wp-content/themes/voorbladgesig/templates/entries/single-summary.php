<?php
    $name = get_post_meta(get_the_ID(), 'NAME') ? get_post_meta(get_the_ID(), 'NAME')[0] : '';
    $surname = get_post_meta(get_the_ID(), 'SURNAME') ? get_post_meta(get_the_ID(), 'SURNAME')[0] : '';
    $age = get_post_meta(get_the_ID(), 'AGE') ? get_post_meta(get_the_ID(), 'AGE')[0] : '';
    $where_from = get_post_meta(get_the_ID(), 'PLACE') ? get_post_meta(get_the_ID(), 'PLACE')[0] : '';
?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<span class="uk-text-bold uk-margin-small-right"><?php _e('Name', 'twentyfourdotcom'); ?>:</span><span><?php _e($name); ?></span>
	</div>
	<div class="uk-width-1-1 uk-margin-small-top">
		<span class="uk-text-bold uk-margin-small-right"><?php _e('Surname', 'twentyfourdotcom'); ?>:</span><span><?php _e($surname); ?></span>
	</div>
	<div class="uk-width-1-1 uk-margin-small-top">
		<span class="uk-text-bold uk-margin-small-right"><?php _e('Age', 'twentyfourdotcom'); ?>:</span><span><?php _e($age); ?></span>
	</div>
	<div class="uk-width-1-1 uk-margin-small-top">
		<span class="uk-text-bold uk-margin-small-right"><?php _e('Where Are You From', 'twentyfourdotcom'); ?>:</span><span><?php _e($where_from); ?></span>
	</div>
</div>