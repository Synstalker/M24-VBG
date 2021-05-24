<?php
/**
 * Top bar
 *
 * @package Hotel_Romantica
 */

$contact_phone = hotel_romantica_get_option( 'contact_phone' );
$contact_email = hotel_romantica_get_option( 'contact_email' );
?>

<div id="top-bar" class="top-header-bar">
	<div class="container">
		<div class="top-left">
			<div class="top-left-inner">
				<?php if ( ! empty( $contact_phone ) ) : ?>
					<span class="phone"><?php echo esc_html( $contact_phone ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $contact_email ) ) : ?>
					<span class="email"><?php echo esc_html( $contact_email ); ?></span>
				<?php endif; ?>
			</div><!-- .top-left-inner -->
		</div><!-- .top-left -->
		<div class="top-right">
			<div class="top-right-inner">
				<?php
				wp_nav_menu( array(
					'theme_location'  => 'social',
					'depth'           => 1,
					'menu_class'      => 'social-menu',
					'container_class' => 'social-menu-wrapper',
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'fallback_cb'     => false,
				) );
				?>
			</div><!-- .top-right-inner -->
		</div><!-- .top-right -->
	</div><!-- .container -->
</div><!-- #top-bar -->
