<?php
/**
 * The template for displaying the footer
 *
 * @package Hotel_Romantica
 */

?>
	<?php if ( ! is_page_template( 'elementor_header_footer' ) ) { ?>
			</div><!-- .inner-wrapper -->
		</div><!-- .container -->
	<?php } ?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container">
			<?php get_template_part( 'template-parts/footer-widgets' ); ?>
		</div><!-- .container -->

		<div class="footer-site-info">
			<div class="container">
				<?php $copyright_message = hotel_romantica_get_option( 'copyright_message' ); ?>
				<?php if ( ! empty( $copyright_message ) ) : ?>
					<div class="credits">
						<?php echo wp_kses_post( $copyright_message ); ?>
					</div><!-- .credits -->
				<?php endif; ?>

				<?php
				$powered_message = esc_html__( 'Powered by WordPress', 'hotel-romantica' ) . ' | ' . sprintf( esc_html__( 'Theme: Hotel Romantica by %1$sLumber Themes%2$s', 'hotel-romantica' ), '<a href="https://lumberthemes.com/">', '</a>' );
				?>
				<?php if ( ! empty( $powered_message ) ) : ?>
					<div class="site-info">
						<?php echo wp_kses_post( $powered_message ); ?>
					</div><!-- .site-info -->
				<?php endif; ?>
			</div><!-- .container -->
		</div><!-- .footer-site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<a href="#page" class="scrollup" id="btn-scrollup">&#8593;</a>
<?php wp_footer(); ?>

</body>
</html>
