<?php
/**
 * Bubble Stop drink order page.
 *
 * @package bubble-stop
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	global $product;

	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		continue;
	}

	$image_id = $product->get_image_id();
	?>
	<main class="drink-order-page layout-padding">
		<?php do_action( 'woocommerce_before_single_product' ); ?>

		<header class="drink-order-page__header">
			<h1><?php esc_html_e( 'Create Your Drink', 'bubble-stop' ); ?></h1>
		</header>

		<article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'drink-order-card', $product ); ?>>
			<div class="drink-order-card__media">
				<?php
				if ( $image_id && function_exists( 'bubble_stop_render_responsive_picture' ) ) {
					bubble_stop_render_responsive_picture(
						[
							'ID'  => $image_id,
							'url' => wp_get_attachment_url( $image_id ),
							'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: $product->get_name(),
						],
						[
							'class' => 'drink-order-card__image',
							'sizes' => '(max-width: 767px) 100vw, 50vw',
						]
					);
				} else {
					echo wp_kses_post( wc_placeholder_img( 'woocommerce_single', [ 'class' => 'drink-order-card__image' ] ) );
				}
				?>
			</div>

			<div class="drink-order-card__content">
				<h2 class="drink-order-card__title"><?php echo esc_html( $product->get_name() ); ?></h2>

				<?php if ( ! $product->is_type( 'variable' ) && $product->get_price_html() ) : ?>
					<div class="drink-order-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				<?php endif; ?>

				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
		</article>
	</main>
	<?php
	if ( WC()->structured_data ) {
		WC()->structured_data->generate_product_data( $product );
	}
	do_action( 'woocommerce_after_single_product' );
endwhile;

get_footer();
