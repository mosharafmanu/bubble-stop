<?php
/**
 * Flexible content hero section.
 *
 * @package bubble-stop
 */

$heading             = get_sub_field( 'heading' );
$first_line_artwork  = get_sub_field( 'first_line_artwork' );
$second_line_artwork = get_sub_field( 'second_line_artwork' );
$description         = get_sub_field( 'description' );
$button_link         = get_sub_field( 'button_link' );

if ( ! $heading && ! $first_line_artwork && ! $second_line_artwork && ! $description ) {
	return;
}
?>

<section class="hero-section layout-padding">
	<div class="hero-section__inner">
		<?php if ( $heading ) : ?>
			<h1 class="screen-reader-text"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $first_line_artwork || $second_line_artwork ) : ?>
			<div class="hero-section__artwork" aria-hidden="true">
				<?php if ( $first_line_artwork ) : ?>
					<div class="hero-section__artwork-line hero-section__artwork-line--first">
						<?php
						bubble_stop_render_responsive_picture(
							$first_line_artwork,
							[
								'class'         => 'hero-section__artwork-image',
								'alt'           => '',
								'sizes'         => '(max-width: 767px) calc(100vw - 80px), 570px',
								'lazy'          => false,
								'fetchpriority' => 'high',
							]
						);
						?>
					</div>
				<?php endif; ?>

				<?php if ( $second_line_artwork ) : ?>
					<div class="hero-section__artwork-line hero-section__artwork-line--second">
						<?php
						bubble_stop_render_responsive_picture(
							$second_line_artwork,
							[
								'class'         => 'hero-section__artwork-image',
								'alt'           => '',
								'sizes'         => '(max-width: 767px) calc(100vw - 60px), 620px',
								'lazy'          => false,
								'fetchpriority' => 'high',
							]
						);
						?>
					</div>
				<?php endif; ?>
			</div>
		<?php elseif ( $heading ) : ?>
			<h1 class="hero-section__title"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<div class="hero-section__description">
				<?php echo wp_kses_post( $description ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $button_link && function_exists( 'bubble_stop_render_button' ) ) : ?>
			<div class="hero-section__actions">
				<?php
				bubble_stop_render_button(
					$button_link,
					[
						'style'     => 'btn-primary',
						'show_icon' => false,
						'class'     => 'hero-section__button',
					]
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
