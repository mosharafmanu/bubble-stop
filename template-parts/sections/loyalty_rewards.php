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
			$eyebrow          = $card['eyebrow'] ?? '';
			$heading          = $card['heading'] ?? '';
			$join_button      = $card['join_button'] ?? false;
			$reward_value     = $card['reward_value'] ?? '';
			$reward_condition = $card['reward_condition'] ?? '';
			$instructions     = $card['instructions'] ?? '';

			if ( ! $eyebrow && ! $heading && ! $join_button && ! $reward_value && ! $instructions ) {
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

				<?php if ( $join_button && is_array( $join_button ) ) : ?>
					<div class="loyalty-rewards__actions">
						<a href="<?php echo esc_url( $join_button['url'] ); ?>" 
						   class="site-btn btn-secondary loyalty-rewards__button" 
						   <?php echo ! empty( $join_button['target'] ) ? 'target="' . esc_attr( $join_button['target'] ) . '"' : ''; ?>>
							<?php echo esc_html( $join_button['title'] ?: __( 'Join for Free', 'bubble-stop' ) ); ?>
						</a>
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
