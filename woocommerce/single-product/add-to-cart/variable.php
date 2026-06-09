<?php
/**
 * Bubble Stop variable drink add-to-cart form.
 *
 * @package bubble-stop
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' );
?>
<form class="variations_form cart drink-order-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
	<input type="hidden" name="bubble_drink_configurator" value="1">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<div class="variations drink-native-variations" aria-hidden="true">
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<?php
				wc_dropdown_variation_attribute_options(
					[
						'options'   => $options,
						'attribute' => $attribute_name,
						'product'   => $product,
					]
				);
				?>
			<?php endforeach; ?>
		</div>

		<?php foreach ( $attributes as $attribute_name => $options ) : ?>
			<?php
			$select_id     = sanitize_title( $attribute_name );
			$selected      = $product->get_variation_default_attribute( $attribute_name );
			$attribute_key = 'attribute_' . sanitize_title( $attribute_name );
			if ( '' === $selected && ! empty( $options ) ) {
				$selected = reset( $options );
			}
			?>
			<fieldset class="drink-option-group drink-option-group--variation">
				<legend><?php echo esc_html( wc_attribute_label( $attribute_name ) ); ?></legend>
				<div class="drink-choice-row">
					<?php foreach ( $options as $option ) : ?>
						<?php
						$option_term  = taxonomy_exists( $attribute_name ) ? get_term_by( 'slug', $option, $attribute_name ) : false;
						$option_name  = $option_term && ! is_wp_error( $option_term ) ? $option_term->name : $option;
						$option_price = '';

						foreach ( is_array( $available_variations ) ? $available_variations : [] as $variation ) {
							$variation_value = $variation['attributes'][ $attribute_key ] ?? '';
							if ( '' === $variation_value || (string) $variation_value === (string) $option ) {
								$option_price = wc_price( $variation['display_price'] );
								break;
							}
						}
						?>
						<label class="drink-choice drink-choice--variation">
							<input type="radio" name="bubble_variation_<?php echo esc_attr( $select_id ); ?>" value="<?php echo esc_attr( $option ); ?>" data-variation-select="<?php echo esc_attr( $select_id ); ?>" <?php checked( (string) $selected, (string) $option ); ?> required>
							<span class="drink-choice__label"><?php echo esc_html( $option_name ); ?></span>
							<?php if ( $option_price ) : ?><span class="drink-choice__price"><?php echo wp_kses_post( $option_price ); ?></span><?php endif; ?>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>
		<?php endforeach; ?>

		<?php bubble_stop_render_drink_customizations(); ?>

		<div class="single_variation_wrap">
			<?php
			do_action( 'woocommerce_before_single_variation' );
			do_action( 'woocommerce_single_variation' );
			do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
