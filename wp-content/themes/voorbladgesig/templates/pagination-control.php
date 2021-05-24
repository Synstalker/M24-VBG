<?php
/**
 * @see https://getuikit.com/v2/docs/pagination.html
 * @see http://codepen.io/netzzwerg/pen/hfutI
 */
$pagination_html = paginate_links( array(
	'type'          => 'list',
    'prev_text'     => '« ' . __('Previous'),
    'next_text'     => __('Next') . ' »'
) );

//Add uk-pagination class to the ul element class tag
$re = '/(<ul)(.*)(class=[\'|"])(.*)([\'|"])/';
$subst = '$1$2$3uk-margin-large-top uk-pagination $4$5';
$pagination_html = preg_replace( $re, $subst, $pagination_html );

//add uk-border-rounded class to all span and a tags with
$re = '/(<[a|span])(.*)(class=[\'|"])(.*)([\'|"])/';
$subst = '$1$2$3uk-border-rounded $4$5';
$pagination_html = preg_replace( $re, $subst, $pagination_html );


//find the current class inside an li tag
$re = '/(<li)(?:.*)(><span)(.*)(class=[\'|"])(.*)(current)([\'|"])/';
$subst = '$1 class=\'uk-active\'$2$3$4$5$6$7';
$pagination_html = preg_replace( $re, $subst, $pagination_html );


_e ( $pagination_html );