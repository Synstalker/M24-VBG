<?php
/**
 * Color implementation
 *
 * @package Hotel_Romantica
 */

/**
 * Add custom styles.
 *
 * @return void
 */
function hotel_romantica_add_custom_styles() {
	$default       = hotel_romantica_get_default_colors();
	$color_options = hotel_romantica_get_color_theme_settings_options();

	$custom_style    = '';
	$required_colors = array();

	if ( ! empty( $color_options ) ) {
		foreach ( $color_options as $key => $val ) {
			$option_value = hotel_romantica_get_option( $key );
			if ( ! empty( $option_value ) && $default[ $key ] !== $option_value ) {
				$required_colors[ $key ] = $option_value;
			}
		}
	}

	if ( empty( $required_colors ) ) {
		return;
	}

	foreach ( $required_colors as $key => $color ) {
		switch ( $key ) {
			case 'color_primary':
				$custom_style .= '
					button,
					.button,
					input[type="button"],
					input[type="reset"],
					input[type="submit"],
					.comment-reply-link,
					.branding-button,
					.branding-button:visited,
					.menu-toggle,
					.more-link,
					.read-more-btn,
					.slick-arrow,
					.site-navigation .menu ul a:hover,
					.site-navigation .menu ul a:focus,
					#secondary form input[type="submit"],
					#secondary .widget .widget-title:after,
					#custom-header,
					#abc-widget-wrapper .abc-form .abc-widget-row .abc-submit,
					#abc-form-wrapper #abc-form-content .abc-form-row .abc-submit,
					#abc-bookingresults form .abc-submit,
					.pagination .nav-links .page-numbers.current,
					.pagination .nav-links a.page-numbers:hover,
					#footer-widgets .widget-title:after,
					.mobile-menu-wrap,
					.slider-caption-wrap .slide-item-buttons .slide-button,
					.scrollup {background-color:' . esc_attr( $color ) . '}' . "\n";

				$custom_style .= '
					a,
					.main-navigation ul li a:hover,
					.main-navigation ul li.menu-item-has-children ul.sub-menu li a:hover,
					.social-menu li a:hover::before,
					.elementor-widget-hotel-romantica-rooms-slider .room-item-caption a:hover,
					.elementor-widget-hotel-romantica-rooms-carousel .room-item-caption a:hover,
					.elementor-widget-hotel-romantica-testimonials-slider .testimonials-slider .testimonial-item .testimonial-item-text-content .testimonial-text:after,
					.testimonial-content-wrapper .client-rating,
					#abc-form-wrapper #abc-form-content #abc-bookingresults form .abc-fullcolumn #abc-bookingform-totalprice b,
					#secondary .widget ul li a:hover,
					.elementor-widget-hotel-romantica-rooms-grid .lumber-grid article .room-grid-text-wrap .room-price,
					#footer-navigation ul li a:hover,
					#footer-widgets ul li:hover a,
					#footer-widgets ul li:hover,
					#footer-widgets ul li:hover:before {color:' . esc_attr( $color ) . '}' . "\n";

				$custom_style .= '
						.pagination .nav-links .page-numbers {
						    border-color: ' . esc_attr( $color ) . ';
						}';

				$custom_style .= '
					@media screen and (min-width: 1199px) {
						.site-navigation a:hover {
						    color: ' . esc_attr( $color ) . ';
						}
					}';
				break;

			case 'color_primary_hover':
				$custom_style .= '
					button:hover,
					.button:hover,
					input[type="button"]:hover,
					input[type="reset"]:hover,
					input[type="submit"]:hover,
					button:active,
					button:focus,
					input[type="button"]:active,
					input[type="button"]:focus,
					input[type="reset"]:active,
					input[type="reset"]:focus,
					input[type="submit"]:active,
					input[type="submit"]:focus,
					#respond .comment-reply-title a:hover,
					a.comment-reply-link:hover,
					.branding-button:focus,
					.branding-button:hover,
					.slider-caption-wrap .slide-item-buttons .slide-button:hover,
					.read-more-btn:hover,
					#abc-widget-wrapper .abc-form .abc-widget-row .abc-submit:hover,
					#abc-form-wrapper #abc-form-content .abc-form-row .abc-submit:hover,
					#abc-widget-wrapper .abc-form .abc-widget-row .abc-submit:focus,
					#abc-form-wrapper #abc-form-content .abc-form-row .abc-submit:focus,
					#abc-bookingresults form .abc-submit:hover,
					#secondary form input[type="submit"]:hover,
					#secondary form input[type="submit"]:focus,
					.scrollup:hover,
					.scrollup:focus{background-color:' . esc_attr( $color ) . '}' . "\n";
				break;

			case 'color_content_background':
				$custom_style .= '
					#main,
					.blog #main article,
					.archive #main article,
					.search #main article,
					#secondary .widget{background-color:' . esc_attr( $color ) . '}' . "\n";
				break;

			default:
				break;
		}

		if ( ! empty( $custom_style ) ) {
			echo '<style type="text/css">';
			echo $custom_style; // phpcs:ignore WordPress.Security.EscapeOutput
			echo '</style>';
		}
	}

}

add_filter( 'wp_head', 'hotel_romantica_add_custom_styles', 11 );
