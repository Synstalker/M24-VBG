<?php
/**
 * Rooms Grid Widget
 *
 * @package Hotel_Romantica
 */

namespace HotelRomanticaElementorAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rooms Grid
 *
 * @since 1.0.0
 */
class Rooms_Grid extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'hotel-romantica-rooms-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Rooms Grid', 'hotel-romantica' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'theme-custom' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'hotel-romantica' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Per Page', 'hotel-romantica' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'post_thumbnail',
				'exclude'      => [ 'custom' ],
				'default'      => 'large',
				'prefix_class' => 'post-thumbnail-size-',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$args  = array(
			'number' => absint( $settings['posts_per_page'] ),
		);
		$rooms = hotel_romantica_get_rooms( $args );
		?>
		<div class="lumber-grid">
			<div class="lumber-grid-container">

				<?php if ( ! empty( $rooms ) ) : ?>
					<?php $i = 0; ?>
					<?php foreach ( $rooms as $room ) : ?>
						<?php $extra_class = ( 0 === $i % 2 ) ? 'room-odd': 'room-even'; ?>
						<article class="<?php echo esc_attr( $extra_class ); ?>">
							<div class="room-grid-inner">
								<div class="room-thumbnail">
									<?php if ( ! empty( $room['attachment_id'] ) ) : ?>
										<?php
										$image_details = wp_get_attachment_image_src( $room['attachment_id'], 'large' );
										$image_url     = array_shift( $image_details );
										?>
										<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $room['name'] ); ?>" />
									<?php else : ?>
										<img src="<?php echo esc_url( get_template_directory_uri() . '/images/no-image-large.png' ); ?>" alt="<?php echo esc_attr( $room['name'] ); ?>" />
									<?php endif; ?>
								</div><!-- .room-thumbnail -->

								<div class="room-grid-text-wrap">
									<?php if ( ! empty( $room['page_id'] ) ) : ?>
										<h4><a href="<?php echo esc_url( get_permalink( $room['page_id'] ) ); ?>"><?php echo esc_html( $room['name'] ); ?></a></h4>
									<?php else : ?>
										<h4><?php echo esc_html( $room['name'] ); ?></h4>
									<?php endif; ?>

									<?php if ( ! empty( $room['price'] ) ) : ?>
										<div class="room-price">
											<?php echo esc_html( abc_booking_formatPrice( $room['price'] ) ); ?>
										</div><!-- .room-price -->
									<?php endif; ?>

									<?php if ( ! empty( $room['description'] ) ) : ?>
										<div class="room-description">
											<?php echo esc_html( $room['description'] ); ?>
										</div><!-- .room-description -->
									<?php endif; ?>

									<?php if ( ! empty( $room['page_id'] ) ) : ?>
										<div class="room-buttons"><a href="<?php echo esc_url( get_permalink( $room['page_id'] ) ); ?>" class="button"><?php esc_html_e( 'Know More', 'hotel-romantica' ); ?></a></div>
									<?php endif; ?>
								</div><!-- .room-grid-text-wrap -->
							</div><!-- .room-grid-inner -->

						</article>
						<?php $i++; ?>
					<?php endforeach; ?>
				<?php endif; ?>

			</div><!-- .lumber-grid-container -->

		</div><!-- .lumber-grid -->
		<?php
	}
}
