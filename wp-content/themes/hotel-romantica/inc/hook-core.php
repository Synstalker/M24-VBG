<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Hotel_Romantica
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hotel_romantica_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'hotel_romantica_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function hotel_romantica_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'hotel_romantica_pingback_header' );

if ( ! function_exists( 'hotel_romantica_implement_excerpt_length' ) ) :

	/**
	 * Implement excerpt length.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length The number of words.
	 * @return int Excerpt length.
	 */
	function hotel_romantica_implement_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		$excerpt_length = hotel_romantica_get_option( 'excerpt_length' );

		if ( absint( $excerpt_length ) > 0 ) {
			$length = absint( $excerpt_length );
		}

		return $length;
	}

endif;

add_filter( 'excerpt_length', 'hotel_romantica_implement_excerpt_length', 999 );

if ( ! function_exists( 'hotel_romantica_implement_read_more' ) ) :

	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function hotel_romantica_implement_read_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$read_more_text = hotel_romantica_get_option( 'read_more_text' );

		if ( ! empty( $read_more_text ) ) {
			$more = ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . esc_html( $read_more_text ) . '</a>';
		}

		return $more;
	}

endif;

add_filter( 'excerpt_more', 'hotel_romantica_implement_read_more' );

if ( ! function_exists( 'hotel_romantica_content_more_link' ) ) :

	/**
	 * Implement read more in content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more_link Read More link element.
	 * @param string $more_link_text Read More text.
	 * @return string Link.
	 */
	function hotel_romantica_content_more_link( $more_link, $more_link_text ) {
		$read_more_text = hotel_romantica_get_option( 'read_more_text' );

		if ( ! empty( $read_more_text ) ) {
			$more_link = str_replace( $more_link_text, esc_html( $read_more_text ), $more_link );
		}

		return $more_link;
	}

endif;

add_filter( 'the_content_more_link', 'hotel_romantica_content_more_link', 10, 2 );

if ( ! function_exists( 'hotel_romantica_skip_link_focus_fix' ) ) :

	/**
	 * Fix skip link focus in IE11.
	 *
	 * This does not enqueue the script because it is tiny and because it is only for IE11,
	 * thus it does not warrant having an entire dedicated blocking script being loaded.
	 * Source file: js/skip-link-focus-fix.js
	 *
	 * @since 1.0.0
	 */
	function hotel_romantica_skip_link_focus_fix() {
		?>
		<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
		</script>
		<?php
	}

endif;

add_action( 'wp_print_footer_scripts', 'hotel_romantica_skip_link_focus_fix' );

