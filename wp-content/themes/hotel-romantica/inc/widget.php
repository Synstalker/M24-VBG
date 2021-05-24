<?php
/**
 * Widget
 *
 * @package Hotel_Romantica
 */

/**
 * Register widgets.
 *
 * @since 1.0.0
 */
function hotel_romantica_load_abc_widgets() {
	// Check if ABC plugin is active.
	if ( hotel_romantica_is_abc_active() ) {
		register_widget( 'Hotel_Romantica_Availability_Widget' );
	}
}

add_action( 'widgets_init', 'hotel_romantica_load_abc_widgets' );

/**
 * Availability Widget Class.
 *
 * @since 1.0.0
 */
class Hotel_Romantica_Availability_Widget extends WP_Widget {

	/**
	 * Sets up a new widget instance.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'hotel-romantica-availability-form',
			'description' => esc_html__( 'Availability Form. Suitable for home page.', 'hotel-romantica' ),
		);
		parent::__construct( 'hotel-romantica-availability-form', esc_html__( 'HR: Availability Form', 'hotel-romantica' ), $widget_ops );
	}

	/**
	 * Output the settings update form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 */
	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => esc_html__( 'Availability', 'hotel-romantica' ),
			)
		);
		?>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'hotel-romantica' ); ?></label>
		  <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<?php if ( 0 === absint( getAbcSetting( 'bookingpage' ) ) ) : ?>
			<p><b><?php esc_html_e( 'There is no booking page configured. Check the settings and select a page with the booking form.', 'hotel-romantica' ); ?></b></p>
			<?php
		endif;
	}

	/**
	 * Update widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 * @return array Modified widget instance.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Echo the widget content.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Display arguments.
	 * @param array $instance Widget instance.
	 */
	function widget( $args, $instance ) {
		global $abcUrl;

		$this->load_assets();

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		echo '<div class="widget-text">';
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
		echo '<div class="widget-textarea">';
		echo hotel_romantica_abc_render_booking_form();
		echo '</div></div>';

		echo $args['after_widget'];
	}

	/**
	 * Load assets.
	 *
	 * @since 1.0.0
	 */
	function load_assets() {
		// Global variable from plugin.
		global $abcUrl;

		wp_enqueue_style( 'abc-styles-css', $abcUrl . 'frontend/css/styles.css' );
		wp_enqueue_style( 'font-awesome', $abcUrl . 'frontend/css/font-awesome.min.css' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'abc-widget', $abcUrl . 'frontend/js/abc-widget.js', array( 'jquery' ) );
		$dateformat = abc_booking_dateFormatToJS( getAbcSetting( 'dateformat' ) );
		wp_localize_script(
			'abc-widget',
			'abc_functions_vars',
			array(
				'dateformat' => $dateformat,
				'firstday'   => getAbcSetting( 'firstdayofweek' ),
			)
		);
		wp_enqueue_style( 'abc-datepicker', $abcUrl . '/frontend/css/jquery-ui.min.css' );
		$datepickerLang = array(
			'af', 'ar-DZ', 'ar', 'az', 'be', 'bg', 'bs', 'ca', 'cs', 'cy-GB', 'da', 'de', 'el', 'en-AU', 'en-GB', 'en-NZ', 'eo', 'es', 'et', 'eu', 'fa', 'fi', 'fo', 'fr-CA', 'fr-CH', 'fr', 'gl', 'he', 'hi', 'hr', 'hu', 'hy', 'id', 'is', 'it-CH', 'it', 'ja', 'ka', 'kk', 'km', 'ko', 'ky', 'lb', 'lt', 'lv', 'mk', 'ml', 'ms', 'nb', 'nl-BE', 'nl', 'nn', 'no', 'pl', 'pt-BR', 'pt', 'rm', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr-SR', 'sr', 'sv', 'ta', 'th', 'tj', 'tr', 'uk', 'vi', 'zh-CN', 'zh-HK', 'zh-TW',
		);
		if ( substr( get_locale(), 0, 2 ) != 'en' && in_array( get_locale(), $datepickerLang ) ) {
			wp_enqueue_script( 'jquery-datepicker-lang', $abcUrl . 'frontend/js/datepicker_lang/datepicker-' . get_locale() . '.js', array( 'jquery-ui-datepicker' ) );
		} elseif ( substr( get_locale(), 0, 2 ) != 'en' && in_array( substr( get_locale(), 0, 2 ), $datepickerLang ) ) {
			wp_enqueue_script( 'jquery-datepicker-lang', $abcUrl . 'frontend/js/datepicker_lang/datepicker-' . substr( get_locale(), 0, 2 ) . '.js', array( 'jquery-ui-datepicker' ) );
		}
	}
}

/**
 * Return availability form.
 *
 * @since 1.0.0
 *
 * @return string Form content.
 */
function hotel_romantica_abc_render_booking_form() {
	// Global variable from plugin.
	global $abcUrl;

	$output = '';

	$abcPersonValue = 1;
	if ( isset( $_POST['abc-persons'] ) ) { // Checking for cookies
		$abcPersonValue = intval( $_POST['abc-persons'] );
	} elseif ( isset( $_COOKIE['abc-persons'] ) ) { // Checking for cookies
		$abcPersonValue = intval( $_COOKIE['abc-persons'] );
	}
	$optionPersons = '';
	for ( $i = 1; $i <= getAbcSetting( 'personcount' ); $i++ ) {
		$optionPersons .= '<option value="' . $i . '"';
		if ( $i == $abcPersonValue ) {
			$optionPersons .= ' selected';
		}
		$optionPersons .= '>' . $i . '</option>';
	}
	$abcFromValue = '';
	$abcToValue   = '';
	if ( isset( $_POST['abc-from'] ) && isset( $_POST['abc-to'] )
			&& abc_booking_validateDate( $_POST['abc-from'], getAbcSetting( 'dateformat' ) )
			&& abc_booking_formatDateToDB( $_POST['abc-from'] ) >= date( 'Y-m-d' )
			) { // Checking for POST variables (via single calendar)
				$abcFromValue = sanitize_text_field( $_POST['abc-from'] );
				$abcToValue   = sanitize_text_field( $_POST['abc-to'] );
	} elseif ( isset( $_COOKIE['abc-from'] ) && isset( $_COOKIE['abc-to'] )
			&& abc_booking_validateDate( $_COOKIE['abc-from'], getAbcSetting( 'dateformat' ) )
			&& abc_booking_formatDateToDB( $_COOKIE['abc-from'] ) >= date( 'Y-m-d' ) ) { // Checking for cookies and checking if "from date" is in the past
		$abcFromValue = sanitize_text_field( $_COOKIE['abc-from'] );
		$abcToValue   = sanitize_text_field( $_COOKIE['abc-to'] );
	}
	if ( getAbcSetting( 'bookingpage' ) > 0 ) {
		$output .= abcEnqueueCustomCss() . '<div id="abc-widget-wrapper" class="hotel-romantica-form-wrapper">
				<div id="abc-widget-content">
					<form class="abc-form" method="post" action="' . esc_url( get_permalink( getAbcSetting( 'bookingpage' ) ) ) . '">
					<div class="abc-widget">
						<div class="input-wrap">
						<div class="abc-input-fa">
							<span class="fa fa-calendar"></span>
							<input id="abc-widget-from" name="abc-from" readonly="true" value="' . esc_attr( $abcFromValue ) . '" placeholder="' . esc_attr( abc_booking_getCustomText( 'checkin' ) ) . '" />
						</div></div>
						<div class="input-wrap">
						<div class="abc-input-fa">
							<span class="fa fa-calendar"></span>
							<input id="abc-widget-to" name="abc-to" readonly="true" value="' . esc_attr( $abcToValue ) . '"  placeholder="' . esc_attr( abc_booking_getCustomText( 'checkout' ) ) . '">
						</div></div>
						<div class="input-wrap">
						<div class="abc-input-fa">
							<span class="fa fa-female abc-guest1"></span>
							<span class="fa fa-male abc-guest2"></span>
							<select id="abc-persons" name="abc-persons">
								' . $optionPersons . '
							</select>
						</div></div>
						<input id="abc-trigger" type="hidden" name="abc-trigger" value="1">
						<input id="abc-calendarId" type="hidden" name="abc-calendarId" value="0">
						<div class="input-wrap abc-widget-row">
							<button type="submit" class="abc-submit" id="abc-widget-check-availabilities">
								<span class="abc-submit-text">' . esc_html( abc_booking_getCustomText( 'checkAvailabilities' ) ) . '</button>
						</div>
						</div>
					</form>
				</div>
			</div>';
	} else {
		$output .= '<p>' . esc_html__( 'There is no booking page configured. Check the settings of the Advanced Booking Calendar.', 'hotel-romantica' ) . '</p>';
	}

	return $output;
}
