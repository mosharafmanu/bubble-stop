<?php
/**
 * Testimonials carousel section.
 *
 * @package bubble-stop
 */

$eyebrow      = get_sub_field( 'eyebrow' );
$heading      = get_sub_field( 'heading' );
$testimonials = get_sub_field( 'testimonials' );

if ( ! $testimonials || ! is_array( $testimonials ) ) {
	return;
}

$section_id = wp_unique_id( 'testimonials-' );
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="testimonials-section layout-padding">
	<header class="testimonials-section__header">
		<?php if ( $eyebrow ) : ?>
			<p class="testimonials-section__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( $heading ) : ?>
			<h2 class="testimonials-section__title"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
	</header>

	<div class="testimonials-section__slider-wrap">
		<button type="button" class="bubble-carousel-arrow testimonials-section__arrow testimonials-section__arrow--prev" aria-label="<?php esc_attr_e( 'Previous testimonial', 'bubble-stop' ); ?>">&larr;</button>

		<div class="testimonials-section__carousel">
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<?php
				$quote  = $testimonial['quote'] ?? '';
				$author = $testimonial['author'] ?? '';
				$detail = $testimonial['author_detail'] ?? '';

				if ( ! $quote ) {
					continue;
				}
				?>
				<article class="testimonial-card">
					<span class="testimonial-card__quote-mark" aria-hidden="true">
						<?php get_template_part( 'assets/svgs/quote' ); ?>
					</span>
					<blockquote class="testimonial-card__quote">
						<?php echo wp_kses_post( $quote ); ?>
					</blockquote>

					<?php if ( $author || $detail ) : ?>
						<footer class="testimonial-card__author">
							<?php if ( $author ) : ?>
								<strong><?php echo esc_html( $author ); ?></strong>
							<?php endif; ?>
							<?php if ( $detail ) : ?>
								<span><?php echo esc_html( $detail ); ?></span>
							<?php endif; ?>
						</footer>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>

		<button type="button" class="bubble-carousel-arrow testimonials-section__arrow testimonials-section__arrow--next" aria-label="<?php esc_attr_e( 'Next testimonial', 'bubble-stop' ); ?>">&rarr;</button>
	</div>
</section>
