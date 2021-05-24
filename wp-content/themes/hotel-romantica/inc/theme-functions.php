<?php
/**
 * Theme functions
 *
 * @package Hotel_Romantica
 */

if ( ! function_exists( 'hotel_romantica_customize_banner_title' ) ) :

	/**
	 * Customize banner title.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title Title.
	 * @return string Modified title.
	 */
	function hotel_romantica_customize_banner_title( $title ) {
		if ( is_home() ) {
			$title = hotel_romantica_get_option( 'blog_title' );
		} elseif ( is_singular() ) {
			$title = single_post_title( '', false );
		} elseif ( is_category() || is_tag() ) {
			$title = single_term_title( '', false );
		} elseif ( is_archive() ) {
			$title = wp_strip_all_tags( get_the_archive_title() );
		} elseif ( is_search() ) {
			$title = sprintf( esc_html__( 'Search Results for: %s', 'hotel-romantica' ), get_search_query() );
		} elseif ( is_404() ) {
			$title = esc_html__( '404!', 'hotel-romantica' );
		}

		return $title;
	}

endif;

add_filter( 'hotel_romantica_filter_banner_title', 'hotel_romantica_customize_banner_title' );

if ( ! function_exists( 'hotel_romantica_add_top_bar' ) ) :

	/**
	 * Add top bar.
	 *
	 * @since 1.0.0
	 */
	function hotel_romantica_add_top_bar() {
		$top_bar_status = apply_filters( 'hotel_romantica_top_bar_status', false );

		if ( true !== $top_bar_status ) {
			return;
		}

		get_template_part( 'template-parts/top-bar' );
	}

endif;

add_action( 'hotel_romantica_top_bar', 'hotel_romantica_add_top_bar' );

if ( ! function_exists( 'hotel_romantica_custom_top_bar_status' ) ) :

	/**
	 * Custom top bar status.
	 *
	 * @since 1.0.0
	 */
	function hotel_romantica_custom_top_bar_status( $status ) {
		$enable_top_bar = hotel_romantica_get_option( 'enable_top_bar' );

		if ( true === $enable_top_bar ) {
			$status = true;
		} else {
			$status = false;
		}

		return $status;
	}

endif;

add_filter( 'hotel_romantica_top_bar_status', 'hotel_romantica_custom_top_bar_status' );

if ( ! function_exists( 'hotel_romantica_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function hotel_romantica_add_breadcrumb() {
		hotel_romantica_simple_breadcrumb();
	}

endif;

add_action( 'hotel_romantica_breadcrumb', 'hotel_romantica_add_breadcrumb' );
