<?php
/**
 * Shop page hero.
 *
 * @package bubble-stop
 */

defined( 'ABSPATH' ) || exit;

$shop_page_id = wc_get_page_id( 'shop' );
$heading      = bubble_stop_get_shop_field( 'shop_hero_heading', __( 'Our Menu Offers A Wide Variety Of Options', 'bubble-stop' ) );
$highlights   = bubble_stop_get_shop_field( 'shop_hero_highlights', [] );
$description  = bubble_stop_get_shop_field( 'shop_hero_description', '' );
$button       = bubble_stop_get_shop_field( 'shop_hero_button', false );
$image        = bubble_stop_get_shop_field( 'shop_hero_image', false );

if ( ! $description && $shop_page_id > 0 ) {
	$shop_page = get_post( $shop_page_id );
	if ( $shop_page && $shop_page->post_content ) {
		$description = apply_filters( 'the_content', $shop_page->post_content );
	}
}

if ( ! $image && $shop_page_id > 0 && has_post_thumbnail( $shop_page_id ) ) {
	$image_id = get_post_thumbnail_id( $shop_page_id );
	$image    = [
		'ID'  => $image_id,
		'url' => wp_get_attachment_url( $image_id ),
		'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
	];
}
?>
<section class="shop-menu-hero layout-padding">
	<div class="shop-menu-hero__inner">
		<div class="shop-menu-hero__content">
			<?php if ( $heading ) : ?><h1 class="shop-menu-hero__title"><?php echo esc_html( $heading ); ?></h1><?php endif; ?>

			<?php if ( $highlights && is_array( $highlights ) ) : ?>
				<ul class="shop-menu-hero__highlights bubble-list">
					<?php foreach ( $highlights as $highlight ) : ?>
						<?php if ( ! empty( $highlight['text'] ) ) : ?><li><?php echo esc_html( $highlight['text'] ); ?></li><?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( $description ) : ?><div class="shop-menu-hero__description"><?php echo wp_kses_post( $description ); ?></div><?php endif; ?>

			<?php if ( $button && function_exists( 'bubble_stop_render_button' ) ) : ?>
				<div class="shop-menu-hero__action"><?php bubble_stop_render_button( $button, [ 'style' => 'btn-primary', 'show_icon' => false ] ); ?></div>
			<?php endif; ?>
		</div>

		<?php if ( $image ) : ?>
			<div class="shop-menu-hero__media">
				<?php
				if ( function_exists( 'bubble_stop_render_responsive_picture' ) ) {
					bubble_stop_render_responsive_picture(
						$image,
						[
							'class' => 'shop-menu-hero__image',
							'alt'   => $image['alt'] ?? '',
							'sizes' => '(max-width: 767px) 80vw, 40vw',
						]
					);
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
