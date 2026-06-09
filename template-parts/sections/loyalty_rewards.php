<?php
/**
 * Loyalty reward QR cards.
 *
 * @package bubble-stop
 */

$cards = get_sub_field( 'cards' );

if ( ! $cards || ! is_array( $cards ) ) {
	return;
}
?>

<section class="loyalty-rewards layout-padding">
	<div class="loyalty-rewards__grid">
		<?php foreach ( $cards as $card ) : ?>
			<?php
			$eyebrow         = $card['eyebrow'] ?? '';
			$heading         = $card['heading'] ?? '';
			$qr_code         = $card['qr_code'] ?? false;
			$reward_artwork  = $card['reward_artwork'] ?? false;
			$reward_value    = $card['reward_value'] ?? '';
			$reward_condition = $card['reward_condition'] ?? '';
			$instructions    = $card['instructions'] ?? '';

			if ( ! $eyebrow && ! $heading && ! $qr_code && ! $reward_artwork && ! $reward_value && ! $instructions ) {
				continue;
			}
			?>

			<article class="loyalty-rewards__card">
				<?php if ( $eyebrow ) : ?>
					<p class="loyalty-rewards__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<h2 class="loyalty-rewards__title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( $qr_code || $reward_artwork ) : ?>
					<div class="loyalty-rewards__media">
						<?php if ( $qr_code ) : ?>
							<div class="loyalty-rewards__qr">
								<?php
								bubble_stop_render_responsive_picture(
									$qr_code,
									[
										'class' => 'loyalty-rewards__qr-image',
										'sizes' => '120px',
									]
								);
								?>
							</div>
						<?php endif; ?>

						<?php if ( $reward_artwork ) : ?>
							<div class="loyalty-rewards__artwork" aria-hidden="true">
								<?php
								bubble_stop_render_responsive_picture(
									$reward_artwork,
									[
										'class' => 'loyalty-rewards__artwork-image',
										'alt'   => '',
										'sizes' => '140px',
									]
								);
								?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $reward_value || $reward_condition ) : ?>
					<div class="loyalty-rewards__reward">
						<?php if ( $reward_value ) : ?>
							<strong><?php echo esc_html( $reward_value ); ?></strong>
						<?php endif; ?>
						<?php if ( $reward_condition ) : ?>
							<span><?php echo esc_html( $reward_condition ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $instructions ) : ?>
					<div class="loyalty-rewards__instructions"><?php echo wp_kses_post( $instructions ); ?></div>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	</div>
</section>
