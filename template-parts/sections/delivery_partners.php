<?php
/**
 * Delivery partners section.
 *
 * @package bubble-stop
 */

$heading  = get_sub_field( 'heading' );
$partners = get_sub_field( 'partners' );

if ( ! $heading && ! $partners ) {
	return;
}
?>

<section class="delivery-partners layout-padding pt-50 pt-md-70 pb-50 pb-md-70">
	<?php if ( $heading ) : ?>
		<header class="delivery-partners__header text-center mb-40 mb-md-50">
			<h2 class="delivery-partners__title"><?php echo esc_html( $heading ); ?></h2>
		</header>
	<?php endif; ?>

	<?php if ( $partners ) : ?>
		<div class="delivery-partners__grid">
			<?php foreach ( $partners as $partner ) : ?>
				<?php
				$image = $partner['image'] ?? false;
				$title = $partner['title'] ?? '';
				$link  = $partner['link'] ?? '';
				
				$tag    = $link ? 'a' : 'div';
				$href   = $link ? ' href="' . esc_url( $link ) . '" target="_blank" rel="noopener noreferrer"' : '';
				?>
				<<?php echo $tag . $href; ?> class="delivery-partner-card">
					<?php if ( $image ) : ?>
						<div class="delivery-partner-card__media">
							<?php echo wp_get_attachment_image( $image['ID'], 'large', false, [ 'class' => 'delivery-partner-card__image' ] ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( $title ) : ?>
						<h3 class="delivery-partner-card__title"><?php echo esc_html( $title ); ?></h3>
					<?php endif; ?>
				</<?php echo $tag; ?>>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
