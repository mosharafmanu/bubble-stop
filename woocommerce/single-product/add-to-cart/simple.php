<?php
/**
 * Bubble Stop simple drink add-to-cart form.
 *
 * @package bubble-stop
 * @version 10.2.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

if ( $product->is_in_stock() ) :
	do_action( 'woocommerce_before_add_to_cart_form' );
	?>
	<form class="cart drink-order-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="bubble_drink_configurator" value="1">
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		<?php bubble_stop_render_drink_customizations(); ?>

		<input type="hidden" name="quantity" value="1">
		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>
	<?php
	do_action( 'woocommerce_after_add_to_cart_form' );
endif;
