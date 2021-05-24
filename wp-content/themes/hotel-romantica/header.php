<?php
/**
 * The header for our theme
 *
 * @package Hotel_Romantica
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'hotel-romantica' ); ?></a>

	<?php do_action( 'hotel_romantica_top_bar' ); ?>

	<header id="masthead" class="site-header">
		<div class="container">
			<div class="head-wrap">
				<div class="site-branding">
					<?php the_custom_logo(); ?>

					<div class="title-wrapper">
						<?php
						$show_site_title   = hotel_romantica_get_option( 'show_site_title' );
						$show_site_tagline = hotel_romantica_get_option( 'show_site_tagline' );
						?>

						<?php if ( true === $show_site_title ) : ?>
							<?php if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( true === $show_site_tagline ) : ?>
							<?php
							$hotel_romantica_description = get_bloginfo( 'description', 'display' );
							if ( $hotel_romantica_description || is_customize_preview() ) :
								?>
								<p class="site-description"><?php echo $hotel_romantica_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>
						<?php endif; ?>
                    </div><!-- .title-wrapper -->
				</div><!-- .site-branding -->

				<div class="navigation-wrap">
					<button class="menu-toggle" aria-controls="main-navigation" aria-expanded="false" type="button">
						<span aria-hidden="true"><?php esc_html_e( 'Menu', 'hotel-romantica' ); ?></span>
						<span class="ticon" aria-hidden="true"></span>
					</button>

					<nav id="main-navigation" class="site-navigation primary-navigation" role="navigation">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'container'      => 'ul',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'primary-menu menu',
							'fallback_cb'    => 'hotel_romantica_primary_menu_fallback',
						) );
						?>
					</nav><!-- #site-navigation -->

					<?php
					$book_button_text = hotel_romantica_get_option( 'book_button_text' );
					$book_button_url  = hotel_romantica_get_option( 'book_button_url' );
					?>
					<?php if ( ! empty( $book_button_text ) && ! empty( $book_button_url ) ) : ?>
						<a href="<?php echo esc_url( $book_button_url ); ?>" class="branding-button"><?php echo esc_html( $book_button_text ); ?></a>
					<?php endif; ?>
				</div><!-- .navigation-wrap -->
			</div><!-- .head-wrap -->
		</div><!-- .container -->

	</header><!-- #masthead -->

	<?php

	if ( ! is_page_template( 'elementor_header_footer' ) ) {
		$banner       = get_header_image();
		$banner_title = apply_filters( 'hotel_romantica_filter_banner_title', '' );
		$header_style = '';

		if ( ! empty( $banner ) ) {
			$header_style = 'background-image:url(' . esc_url( $banner ) . ')';
		}
		?>

		<div id="custom-header" style="<?php echo esc_attr( $header_style ); ?>">
			<div class="container">
				<?php if ( ! empty( $banner_title ) ) : ?>
						<h1 class="page-title"><?php echo esc_html( $banner_title ); ?></h1>
				<?php endif; ?>
				<?php do_action( 'hotel_romantica_breadcrumb' ); ?>
			</div><!-- .container -->

		</div><!-- #custom-header -->

	<?php } ?>

	<div id="content" class="site-content">

		<?php if ( ! is_page_template( 'elementor_header_footer' ) ) { ?>

			<div class="container">

				<div class="inner-wrapper">

			<?php
		}
