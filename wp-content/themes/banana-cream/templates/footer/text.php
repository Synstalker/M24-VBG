<?php
/**
 * @since 3.25.0
 */
$show_footer = TF_Customizer::get_option( 'show_footer', 'boolean' );
if ($show_footer): ?>
	<div class="uk-container uk-container-center uk-padding-remove">
		<footer id="footer" class="uk-block uk-block-primary uk-contrast uk-text-center" role="contentinfo">
			<?php _e((TF_Customizer::get_option( 'footer_text' ))); ?>
		</footer>
	</div>
<?php endif; ?>