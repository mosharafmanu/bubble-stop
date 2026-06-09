<?php
/**
 * @package bubble-stop
 */

?>

<footer id="colophon" class="site-footer">
	<div class="footer-card layout-padding">
		<div class="footer-brand-column">
			<?php bubble_stop_render_footer_logo(); ?>
			<?php bubble_stop_render_footer_tagline(); ?>
		</div>

		<?php
bubble_stop_render_footer_menu(
    [
        'location'   => 'footerMenu',
        'show_title' => true,
    ]
);
?>

		<div class="footer-hours-column">
			<h2 class="footer-column-title"><?php esc_html_e('Hours', 'bubble-stop'); ?></h2>
			<?php bubble_stop_render_footer_hours(); ?>
		</div>

		<div class="footer-social-column">
			<h2 class="footer-column-title"><?php esc_html_e('Follow Us', 'bubble-stop'); ?></h2>
			<?php bubble_stop_render_social_medias(); ?>
		</div>
	</div>

	<div class="footer-bottom layout-padding">
		<?php bubble_stop_render_footer_copyright(); ?>
	</div>
</footer>

</div><!-- #page -->

<?php bubble_stop_render_mobile_navigation(); ?>

<?php wp_footer(); ?>

</body>
</html>
