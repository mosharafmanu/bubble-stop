<?php
/**
 * Smart 50/50 media and content section.
 *
 * @package bubble-stop
 */

$eyebrow        = get_sub_field( 'eyebrow' );
$heading        = get_sub_field( 'heading' );
$content        = get_sub_field( 'content' );
$highlights     = get_sub_field( 'highlights' );
$button_link    = get_sub_field( 'button_link' );
$media_position = get_sub_field( 'media_position' ) ?: 'left';
$media_type     = get_sub_field( 'media_type' ) ?: 'image';
$image          = get_sub_field( 'image' );
$video          = get_sub_field( 'video' );

$has_media = ( 'image' === $media_type && $image ) || ( 'video' === $media_type && $video );

if ( ! $eyebrow && ! $heading && ! $content && ! $highlights && ! $button_link && ! $has_media ) {
	return;
}

$section_classes = [
	'smart-media-content',
	'layout-padding',
	'media-' . sanitize_html_class( $media_position ),
];
?>

<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
	<div class="smart-media-content__grid">
		<?php if ( $has_media ) : ?>
			<div class="smart-media-content__media">
				<?php if ( 'video' === $media_type && function_exists( 'bubble_stop_render_video' ) ) : ?>
					<?php
					bubble_stop_render_video(
						$video,
						[
							'behavior'        => 'onclick-popup',
							'autoplay'        => false,
							'controls'        => true,
							'class'           => 'smart-media-content__video',
							'container_class' => 'smart-media-content__video-container',
						]
					);
					?>
				<?php elseif ( $image && function_exists( 'bubble_stop_render_responsive_picture' ) ) : ?>
					<?php
					bubble_stop_render_responsive_picture(
						$image,
						[
							'class' => 'smart-media-content__image',
							'sizes' => '(max-width: 767px) calc(100vw - 60px), 50vw',
							'lazy'  => true,
						]
					);
					?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="smart-media-content__content">
			<?php if ( $eyebrow ) : ?>
				<p class="smart-media-content__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h2 class="smart-media-content__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $content ) : ?>
				<div class="smart-media-content__copy"><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>

			<?php if ( $highlights && is_array( $highlights ) ) : ?>
				<ul class="bubble-list smart-media-content__highlights">
					<?php foreach ( $highlights as $highlight ) : ?>
						<?php $highlight_text = $highlight['highlight_text'] ?? ''; ?>
						<?php if ( $highlight_text ) : ?>
							<li><?php echo esc_html( $highlight_text ); ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( $button_link && function_exists( 'bubble_stop_render_button' ) ) : ?>
				<div class="smart-media-content__actions">
					<?php
					bubble_stop_render_button(
						$button_link,
						[
							'style'     => 'btn-primary',
							'show_icon' => false,
						]
					);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
