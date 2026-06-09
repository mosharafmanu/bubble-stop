<?php
/**
 * Product category showcase AJAX and card rendering.
 *
 * @package bubble-stop
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'bubble_stop_render_menu_product_card' ) ) {
	function bubble_stop_render_menu_product_card( $product ) {
		if ( is_numeric( $product ) ) {
			$product = wc_get_product( $product );
		}

		if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
			return;
		}

		$product_id = $product->get_id();
		$permalink  = get_permalink( $product_id );
		$image_id   = $product->get_image_id();
		$summary    = $product->get_short_description();

		if ( ! $summary ) {
			$summary = wp_trim_words( wp_strip_all_tags( $product->get_description() ), 18 );
		}
		?>
		<article class="menu-product-card">
			<a href="<?php echo esc_url( $permalink ); ?>" class="menu-product-card__image" tabindex="-1" aria-hidden="true">
				<?php
				if ( $image_id && function_exists( 'bubble_stop_render_responsive_picture' ) ) {
					bubble_stop_render_responsive_picture(
						[
							'ID'  => $image_id,
							'url' => wp_get_attachment_url( $image_id ),
							'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: $product->get_name(),
						],
						[
							'class' => 'menu-product-card__image-file',
							'sizes' => '(max-width: 767px) 75vw, 25vw',
						]
					);
				} else {
					echo wp_kses_post( wc_placeholder_img( 'woocommerce_thumbnail' ) );
				}
				?>
			</a>

			<div class="menu-product-card__body">
				<h3 class="menu-product-card__title">
					<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
				</h3>

				<?php if ( $summary ) : ?>
					<div class="menu-product-card__description"><?php echo wp_kses_post( wpautop( $summary ) ); ?></div>
				<?php endif; ?>
			</div>
		</article>
		<?php
	}
}

if ( ! function_exists( 'bubble_stop_get_category_showcase_products' ) ) {
	function bubble_stop_get_category_showcase_products( $category_id, $limit = 8 ) {
		$category_slug = get_term_field( 'slug', absint( $category_id ), 'product_cat' );

		if ( ! $category_slug || is_wp_error( $category_slug ) ) {
			return [];
		}

		return wc_get_products(
			[
				'status'   => 'publish',
				'limit'    => max( 1, min( 20, absint( $limit ) ) ),
				'category' => [ $category_slug ],
				'orderby'  => 'menu_order',
				'order'    => 'ASC',
			]
		);
	}
}

if ( ! function_exists( 'bubble_stop_render_category_showcase_products' ) ) {
	function bubble_stop_render_category_showcase_products( $category_id, $limit = 8 ) {
		$products = bubble_stop_get_category_showcase_products( $category_id, $limit );

		if ( ! $products ) {
			echo '<p class="product-category-showcase__empty">' . esc_html__( 'No products found in this category.', 'bubble-stop' ) . '</p>';
			return;
		}

		foreach ( $products as $product ) {
			bubble_stop_render_menu_product_card( $product );
		}
	}
}

function bubble_stop_ajax_load_category_showcase_products() {
	check_ajax_referer( 'bubble_stop_category_showcase', 'nonce' );

	$category_id = isset( $_POST['category_id'] ) ? absint( $_POST['category_id'] ) : 0;
	$limit       = isset( $_POST['limit'] ) ? absint( $_POST['limit'] ) : 8;
	$term        = $category_id ? get_term( $category_id, 'product_cat' ) : false;

	if ( ! $term || is_wp_error( $term ) ) {
		wp_send_json_error( [ 'message' => esc_html__( 'Invalid product category.', 'bubble-stop' ) ], 400 );
	}

	ob_start();
	bubble_stop_render_category_showcase_products( $category_id, $limit );
	wp_send_json_success( [ 'html' => ob_get_clean() ] );
}
add_action( 'wp_ajax_bubble_stop_load_category_products', 'bubble_stop_ajax_load_category_showcase_products' );
add_action( 'wp_ajax_nopriv_bubble_stop_load_category_products', 'bubble_stop_ajax_load_category_showcase_products' );

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_script(
		'bubble-stop-product-category-showcase',
		get_template_directory_uri() . '/assets/js/woocommerce/bubble-stop-product-category-showcase.js',
		[ 'jquery', 'slick-carousel' ],
		BUBBLE_STOP_VERSION,
		true
	);

	wp_localize_script(
		'bubble-stop-product-category-showcase',
		'bubbleStopCategoryShowcase',
		[
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'bubble_stop_category_showcase' ),
			'error'   => esc_html__( 'Products could not be loaded. Please try again.', 'bubble-stop' ),
		]
	);
}, 25 );
