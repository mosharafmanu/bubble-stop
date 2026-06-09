<?php
/**
 * Bubble Stop drink customization controls and cart persistence.
 *
 * @package bubble-stop
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'bubble_stop_get_drink_customization_options' ) ) {
	function bubble_stop_get_drink_customization_options() {
		return [
			'sweetness' => [
				'less'   => __( 'Less', 'bubble-stop' ),
				'normal' => __( 'Normal', 'bubble-stop' ),
				'more'   => __( 'More', 'bubble-stop' ),
			],
			'ice_level' => [
				'less'   => __( 'Less', 'bubble-stop' ),
				'normal' => __( 'Normal', 'bubble-stop' ),
				'more'   => __( 'More', 'bubble-stop' ),
			],
			'free_toppings' => [
				'original-tapioca-jelly-bubbles' => __( 'Original Tapioca, Jelly And Bubbles', 'bubble-stop' ),
				'passionfruit-bubbles'            => __( 'Passionfruit Bubbles', 'bubble-stop' ),
				'mango-bubbles'                   => __( 'Mango Bubbles', 'bubble-stop' ),
				'lychee-bubbles'                  => __( 'Lychee Bubbles', 'bubble-stop' ),
				'strawberry-bubbles'              => __( 'Strawberry Bubbles', 'bubble-stop' ),
			],
			'extra_toppings' => [
				'original-tapioca-jelly-bubbles' => __( 'Original Tapioca, Jelly And Bubbles', 'bubble-stop' ),
				'passionfruit-bubbles'            => __( 'Passionfruit Bubbles', 'bubble-stop' ),
				'mango-bubbles'                   => __( 'Mango Bubbles', 'bubble-stop' ),
				'lychee-bubbles'                  => __( 'Lychee Bubbles', 'bubble-stop' ),
				'strawberry-bubbles'              => __( 'Strawberry Bubbles', 'bubble-stop' ),
			],
			'extras' => [
				'whipped-cream-cheese-cloud' => __( 'Whipped Cream, Cheese Cloud', 'bubble-stop' ),
			],
		];
	}
}

if ( ! function_exists( 'bubble_stop_get_paid_addon_price' ) ) {
	function bubble_stop_get_paid_addon_price() {
		return 0.50;
	}
}

if ( ! function_exists( 'bubble_stop_render_preference_options' ) ) {
	function bubble_stop_render_preference_options( $name, $label, $options ) {
		?>
		<fieldset class="drink-option-group drink-option-group--preference">
			<legend><?php echo esc_html( $label ); ?></legend>
			<div class="drink-choice-row">
				<?php foreach ( $options as $value => $option_label ) : ?>
					<label class="drink-choice">
						<input type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" required>
						<span><?php echo esc_html( $option_label ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</fieldset>
		<?php
	}
}

if ( ! function_exists( 'bubble_stop_render_drink_customizations' ) ) {
	function bubble_stop_render_drink_customizations() {
		$options     = bubble_stop_get_drink_customization_options();
		$addon_price = bubble_stop_get_paid_addon_price();
		?>
		<div class="drink-customizations">
			<?php bubble_stop_render_preference_options( 'bubble_sweetness', __( 'Sweetness', 'bubble-stop' ), $options['sweetness'] ); ?>
			<?php bubble_stop_render_preference_options( 'bubble_ice_level', __( 'Ice Level', 'bubble-stop' ), $options['ice_level'] ); ?>

			<fieldset class="drink-option-group drink-option-group--toppings">
				<legend><?php esc_html_e( 'Free Topping', 'bubble-stop' ); ?></legend>
				<div class="drink-topping-picker is-open">
					<button type="button" class="drink-topping-picker__toggle" aria-expanded="true">
						<?php esc_html_e( 'Original Tapioca, Jelly And Bubbles', 'bubble-stop' ); ?>
					</button>
					<input type="hidden" name="bubble_free_toppings[]" value="original-tapioca-jelly-bubbles">
					<div class="drink-topping-picker__options">
						<?php foreach ( $options['free_toppings'] as $value => $option_label ) : ?>
							<?php if ( 'original-tapioca-jelly-bubbles' === $value ) { continue; } ?>
							<label class="drink-checkbox">
								<input type="checkbox" name="bubble_free_toppings[]" value="<?php echo esc_attr( $value ); ?>">
								<span><?php echo esc_html( $option_label ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>
			</fieldset>

			<?php
			$selects = [
				'bubble_extra_topping' => [ __( 'Extra Topping', 'bubble-stop' ), $options['extra_toppings'] ],
				'bubble_extra'         => [ __( 'Extra', 'bubble-stop' ), $options['extras'] ],
			];
			?>
			<?php foreach ( $selects as $name => $select_data ) : ?>
				<label class="drink-option-group drink-option-group--select">
					<span class="drink-option-group__label"><?php echo esc_html( $select_data[0] ); ?></span>
					<div class="drink-paid-select">
					<select name="<?php echo esc_attr( $name ); ?>">
						<?php foreach ( $select_data[1] as $value => $option_label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $option_label ); ?></option>
						<?php endforeach; ?>
					</select>
					<span class="drink-paid-select__price" aria-hidden="true">+<?php echo esc_html( number_format_i18n( $addon_price * 100, 0 ) ); ?>p</span>
					</div>
				</label>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'bubble_stop_sanitize_drink_choice' ) ) {
	function bubble_stop_sanitize_drink_choice( $value, $options ) {
		$value = sanitize_key( wp_unslash( $value ) );
		return isset( $options[ $value ] ) ? $value : '';
	}
}

add_filter( 'woocommerce_add_to_cart_validation', function( $passed ) {
	if ( empty( $_POST['bubble_drink_configurator'] ) ) {
		return $passed;
	}

	$options   = bubble_stop_get_drink_customization_options();
	$sweetness = isset( $_POST['bubble_sweetness'] ) ? bubble_stop_sanitize_drink_choice( $_POST['bubble_sweetness'], $options['sweetness'] ) : '';
	$ice_level = isset( $_POST['bubble_ice_level'] ) ? bubble_stop_sanitize_drink_choice( $_POST['bubble_ice_level'], $options['ice_level'] ) : '';

	if ( ! $sweetness ) {
		wc_add_notice( __( 'Please select a sweetness level.', 'bubble-stop' ), 'error' );
		$passed = false;
	}

	if ( ! $ice_level ) {
		wc_add_notice( __( 'Please select an ice level.', 'bubble-stop' ), 'error' );
		$passed = false;
	}

	return $passed;
}, 10, 1 );

add_filter( 'woocommerce_add_cart_item_data', function( $cart_item_data, $product_id, $variation_id ) {
	if ( empty( $_POST['bubble_drink_configurator'] ) ) {
		return $cart_item_data;
	}

	$options = bubble_stop_get_drink_customization_options();
	$data    = [];

	$data['sweetness'] = isset( $_POST['bubble_sweetness'] ) ? bubble_stop_sanitize_drink_choice( $_POST['bubble_sweetness'], $options['sweetness'] ) : '';
	$data['ice_level'] = isset( $_POST['bubble_ice_level'] ) ? bubble_stop_sanitize_drink_choice( $_POST['bubble_ice_level'], $options['ice_level'] ) : '';

	$free_toppings = isset( $_POST['bubble_free_toppings'] ) ? (array) wp_unslash( $_POST['bubble_free_toppings'] ) : [];
	$data['free_toppings'] = array_values(
		array_filter(
			array_map(
				function( $value ) use ( $options ) {
					return bubble_stop_sanitize_drink_choice( $value, $options['free_toppings'] );
				},
				$free_toppings
			)
		)
	);

	$paid_fields = [
		'extra_topping' => [ 'post_key' => 'bubble_extra_topping', 'options' => 'extra_toppings' ],
		'extra'         => [ 'post_key' => 'bubble_extra', 'options' => 'extras' ],
	];

	$paid_count = 0;
	foreach ( $paid_fields as $data_key => $field ) {
		$data[ $data_key ] = isset( $_POST[ $field['post_key'] ] )
			? bubble_stop_sanitize_drink_choice( $_POST[ $field['post_key'] ], $options[ $field['options'] ] )
			: '';
		if ( $data[ $data_key ] ) {
			$paid_count++;
		}
	}

	$product = wc_get_product( $variation_id ?: $product_id );
	if ( $product ) {
		$data['base_price'] = (float) $product->get_price();
	}
	$data['addon_total'] = $paid_count * bubble_stop_get_paid_addon_price();

	$cart_item_data['bubble_customizations'] = $data;

	return $cart_item_data;
}, 10, 3 );

add_action( 'woocommerce_before_calculate_totals', function( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}

	foreach ( $cart->get_cart() as $cart_item ) {
		$data = $cart_item['bubble_customizations'] ?? [];
		if ( empty( $data ) || ! isset( $data['base_price'], $data['addon_total'] ) ) {
			continue;
		}

		$cart_item['data']->set_price( (float) $data['base_price'] + (float) $data['addon_total'] );
	}
}, 20 );

if ( ! function_exists( 'bubble_stop_get_cart_customization_display' ) ) {
	function bubble_stop_get_cart_customization_display( $data ) {
		$options = bubble_stop_get_drink_customization_options();
		$display = [];

		$fields = [
			'sweetness'     => [ __( 'Sweetness', 'bubble-stop' ), 'sweetness' ],
			'ice_level'     => [ __( 'Ice Level', 'bubble-stop' ), 'ice_level' ],
		];

		foreach ( $fields as $key => $field ) {
			if ( ! empty( $data[ $key ] ) && isset( $options[ $field[1] ][ $data[ $key ] ] ) ) {
				$display[] = [ 'key' => $field[0], 'value' => $options[ $field[1] ][ $data[ $key ] ] ];
			}
		}

		if ( ! empty( $data['free_toppings'] ) ) {
			$labels = array_intersect_key( $options['free_toppings'], array_flip( $data['free_toppings'] ) );
			if ( $labels ) {
				$display[] = [ 'key' => __( 'Free Topping', 'bubble-stop' ), 'value' => implode( ', ', $labels ) ];
			}
		}

		$paid_fields = [
			'extra_topping' => [ __( 'Extra Topping', 'bubble-stop' ), 'extra_toppings' ],
			'extra'         => [ __( 'Extra', 'bubble-stop' ), 'extras' ],
		];

		foreach ( $paid_fields as $key => $field ) {
			if ( ! empty( $data[ $key ] ) && isset( $options[ $field[1] ][ $data[ $key ] ] ) ) {
				$display[] = [ 'key' => $field[0], 'value' => $options[ $field[1] ][ $data[ $key ] ] ];
			}
		}

		return $display;
	}
}

add_filter( 'woocommerce_get_item_data', function( $item_data, $cart_item ) {
	if ( empty( $cart_item['bubble_customizations'] ) ) {
		return $item_data;
	}

	return array_merge( $item_data, bubble_stop_get_cart_customization_display( $cart_item['bubble_customizations'] ) );
}, 10, 2 );

add_action( 'woocommerce_checkout_create_order_line_item', function( $item, $cart_item_key, $values ) {
	if ( empty( $values['bubble_customizations'] ) ) {
		return;
	}

	foreach ( bubble_stop_get_cart_customization_display( $values['bubble_customizations'] ) as $detail ) {
		$item->add_meta_data( $detail['key'], $detail['value'], true );
	}
}, 10, 3 );
