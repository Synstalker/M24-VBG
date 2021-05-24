<?php
//Load WordPress
ob_start();
include_once '../../../wp-load.php';

//Get current protocol
$protocol = strtolower( substr( $_SERVER["SERVER_PROTOCOL"], 0, strpos( $_SERVER["SERVER_PROTOCOL"],'/') ) ) . '://';
//Get Uploads dir
$uploads = wp_upload_dir();
//tf-dfp-cache directory
$uploads_dir = trailingslashit( $uploads['basedir'] ) . 'tf-dfp-cache';
//If tf-dfp-cache dir does not exist in uploads, create it.
if( ! is_dir( $uploads_dir ) ){
    wp_mkdir_p( $uploads_dir );
}
//RetailAd.xml
$cache_name = trailingslashit( $uploads_dir ) . 'RetailAd.xml';
//Cache expiry
$cache_expires = 60;
$time_now = time();
$file_age_plus_cache = filemtime( $cache_name ) + $cache_expires;

if( !file_exists( $cache_name ) ) {
    $retail_bar = file_get_contents( $protocol . 'www.news24.com' . $_SERVER['REQUEST_URI'] );
    file_put_contents( $cache_name, $retail_bar );
}else{
    if( $time_now >= $file_age_plus_cache ){
        $retail_bar = file_get_contents( $protocol . 'www.news24.com' . $_SERVER['REQUEST_URI'] );
        file_put_contents( $cache_name, $retail_bar );
    }
}
//Output XML
if( file_exists( $cache_name ) ) {
    header ( "Content-type: text/xml" );
    $xml = file_get_contents ( $cache_name );
    ob_end_clean();
    echo $xml;
}
