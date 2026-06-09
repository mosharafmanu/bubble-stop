<?php
/**
 * @package bubble-stop
 */

?>

<footer id="colophon" class="site-footer">

	<div class="footer-top layout-padding">

		<?php if ( function_exists( 'bubble_stop_render_footer_logo' ) ) : ?>
			<?php bubble_stop_render_footer_logo(); ?>
		<?php endif; ?>

		<?php if ( function_exists( 'bubble_stop_render_footer_menu' ) ) : ?>
			<?php bubble_stop_render_footer_menu( [ 'location' => 'footerMenu', 'show_title' => false ] ); ?>
		<?php endif; ?>

	</div>

	<div class="footer-bottom layout-padding">

		<?php if ( function_exists( 'bubble_stop_render_footer_copyright' ) ) : ?>
			<?php bubble_stop_render_footer_copyright(); ?>
		<?php endif; ?>

		<?php if ( function_exists( 'bubble_stop_render_social_medias' ) ) : ?>
			<?php bubble_stop_render_social_medias(); ?>
		<?php endif; ?>

	</div>

</footer>

</div><!-- #page -->

<?php bubble_stop_render_mobile_navigation(); ?>

<button class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'bubble-stop' ); ?>" aria-hidden="true">
	<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg>
</button>

<?php wp_footer(); ?>

</body>
</html>
