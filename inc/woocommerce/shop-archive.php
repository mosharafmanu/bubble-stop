<?php
/**
 * Bubble Stop shop and product-category archive renderer.
 *
 * @package bubble-stop
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'bubble_stop_get_shop_field' ) ) {
	function bubble_stop_get_shop_field( $field_name, $default = false ) {
		$shop_page_id = wc_get_page_id( 'shop' );

		if ( $shop_page_id > 0 && function_exists( 'get_field' ) ) {
			$value = get_field( $field_name, $shop_page_id );
			if ( false !== $value && null !== $value && '' !== $value ) {
				return $value;
			}
		}

		return $default;
	}
}

if ( ! function_exists( 'bubble_stop_get_shop_categories' ) ) {
	function bubble_stop_get_shop_categories() {
		if ( is_product_category() ) {
			$term = get_queried_object();
			return $term instanceof WP_Term ? [ $term ] : [];
		}

		$categories = get_terms(
			[
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'parent'     => 0,
				'orderby'    => 'menu_order',
				'order'      => 'ASC',
			]
		);

		return is_wp_error( $categories ) ? [] : $categories;
	}
}

if ( ! function_exists( 'bubble_stop_get_shop_category_products' ) ) {
	function bubble_stop_get_shop_category_products( $category, $limit = 12 ) {
		if ( ! $category instanceof WP_Term ) {
			return [];
		}

		return wc_get_products(
			[
				'status'   => 'publish',
				'limit'    => max( 1, min( 30, absint( $limit ) ) ),
				'category' => [ $category->slug ],
				'orderby'  => 'menu_order',
				'order'    => 'ASC',
			]
		);
	}
}

if ( ! function_exists( 'bubble_stop_get_shop_category_prices' ) ) {
	function bubble_stop_get_shop_category_prices( $category, $products ) {
		$prices = [
			'regular' => '',
			'large'   => '',
		];

		if ( function_exists( 'get_field' ) ) {
			$prices['regular'] = get_field( 'regular_price', $category ) ?: '';
			$prices['large']   = get_field( 'large_price', $category ) ?: '';
		}

		$regular_prices    = [];
		$large_prices      = [];
		$unassigned_prices = [];

		foreach ( $products as $product ) {
			$price_products = $product->is_type( 'variable' )
				? array_filter( array_map( 'wc_get_product', $product->get_children() ) )
				: [ $product ];

			foreach ( $price_products as $price_product ) {
				$price = $price_product->get_price();
				if ( '' === $price ) {
					continue;
				}

				$size = '';
				foreach ( $price_product->get_attributes() as $attribute_name => $attribute_value ) {
					if ( false !== strpos( strtolower( $attribute_name ), 'size' ) ) {
						$size = strtolower( (string) $attribute_value );
						break;
					}
				}

				if ( false !== strpos( $size, 'large' ) ) {
					$large_prices[] = (float) $price;
				} elseif ( false !== strpos( $size, 'regular' ) || false !== strpos( $size, 'small' ) ) {
					$regular_prices[] = (float) $price;
				} else {
					$unassigned_prices[] = (float) $price;
				}
			}
		}

		$regular_prices    = array_values( array_unique( $regular_prices ) );
		$large_prices      = array_values( array_unique( $large_prices ) );
		$unassigned_prices = array_values( array_unique( $unassigned_prices ) );
		sort( $regular_prices, SORT_NUMERIC );
		sort( $large_prices, SORT_NUMERIC );
		sort( $unassigned_prices, SORT_NUMERIC );

		if ( ! $prices['regular'] ) {
			$prices['regular'] = $regular_prices[0] ?? ( $unassigned_prices[0] ?? '' );
		}
		if ( ! $prices['large'] ) {
			$prices['large'] = $large_prices[0] ?? '';
			if ( ! $prices['large'] ) {
				foreach ( $unassigned_prices as $unassigned_price ) {
					if ( (float) $unassigned_price !== (float) $prices['regular'] ) {
						$prices['large'] = $unassigned_price;
						break;
					}
				}
			}
		}

		return $prices;
	}
}

if ( ! function_exists( 'bubble_stop_render_shop_product_card' ) ) {
	function bubble_stop_render_shop_product_card( $product ) {
		if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
			return;
		}

		$product_id = $product->get_id();
		$permalink  = get_permalink( $product_id );
		$image_id   = $product->get_image_id();
		$show_price = ! $product->is_type( 'variable' ) && '' !== $product->get_price();
		?>
		<article class="shop-menu-card">
			<a href="<?php echo esc_url( $permalink ); ?>" class="shop-menu-card__image" tabindex="-1" aria-hidden="true">
				<?php
				if ( $image_id && function_exists( 'bubble_stop_render_responsive_picture' ) ) {
					bubble_stop_render_responsive_picture(
						[
							'ID'  => $image_id,
							'url' => wp_get_attachment_url( $image_id ),
							'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: $product->get_name(),
						],
						[
							'class' => 'shop-menu-card__image-file',
							'sizes' => '(max-width: 575px) 80vw, (max-width: 991px) 42vw, 20vw',
						]
					);
				} else {
					echo wp_kses_post( wc_placeholder_img( 'woocommerce_thumbnail' ) );
				}
				?>
			</a>

			<div class="shop-menu-card__body">
				<h3 class="shop-menu-card__title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
				<?php if ( $show_price ) : ?>
					<div class="shop-menu-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				<?php endif; ?>
				<a
					href="<?php echo esc_url( $permalink ); ?>"
					class="shop-menu-card__cart"
					aria-label="<?php echo esc_attr( sprintf( __( 'View %s', 'bubble-stop' ), $product->get_name() ) ); ?>"
				>
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6L20 7H6M9.5 20a.8.8 0 1 0 0-1.6.8.8 0 0 0 0 1.6Zm7 0a.8.8 0 1 0 0-1.6.8.8 0 0 0 0 1.6Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</a>
			</div>
		</article>
		<?php
	}
}

if ( ! function_exists( 'bubble_stop_render_shop_category_block' ) ) {
	function bubble_stop_render_shop_category_block( $category, $limit ) {
		$products = bubble_stop_get_shop_category_products( $category, $limit );
		if ( ! $products ) {
			return;
		}

		$prices   = bubble_stop_get_shop_category_prices( $category, $products );
		$subtitle = function_exists( 'get_field' ) ? get_field( 'menu_subtitle', $category ) : '';
		$block_id = wp_unique_id( 'shop-category-' );
		?>
		<section id="<?php echo esc_attr( $block_id ); ?>" class="shop-category-block">
			<header class="shop-category-block__header">
				<div class="shop-category-block__details">
					<div class="shop-category-block__name-wrap">
						<h2 class="shop-category-block__title"><?php echo esc_html( $category->name ); ?></h2>
						<?php if ( $subtitle ) : ?><span class="shop-category-block__subtitle"><?php echo esc_html( $subtitle ); ?></span><?php endif; ?>
					</div>
					<?php if ( $prices['regular'] ) : ?>
						<div class="shop-category-block__price"><span><?php esc_html_e( 'Regular', 'bubble-stop' ); ?></span><strong><?php echo wp_kses_post( wc_price( $prices['regular'] ) ); ?></strong></div>
					<?php endif; ?>
					<?php if ( $prices['large'] ) : ?>
						<div class="shop-category-block__price"><span><?php esc_html_e( 'Large', 'bubble-stop' ); ?></span><strong><?php echo wp_kses_post( wc_price( $prices['large'] ) ); ?></strong></div>
					<?php endif; ?>
				</div>

				<div class="shop-category-block__controls" aria-label="<?php echo esc_attr( sprintf( __( '%s carousel controls', 'bubble-stop' ), $category->name ) ); ?>">
					<button type="button" class="bubble-carousel-arrow shop-category-block__arrow shop-category-block__arrow--prev" aria-label="<?php esc_attr_e( 'Previous products', 'bubble-stop' ); ?>">&larr;</button>
					<button type="button" class="bubble-carousel-arrow shop-category-block__arrow shop-category-block__arrow--next" aria-label="<?php esc_attr_e( 'Next products', 'bubble-stop' ); ?>">&rarr;</button>
				</div>
			</header>

			<div class="shop-category-block__carousel">
				<?php foreach ( $products as $product ) : ?>
					<?php bubble_stop_render_shop_product_card( $product ); ?>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}

if ( ! function_exists( 'bubble_stop_render_shop_page' ) ) {
	function bubble_stop_render_shop_page() {
		$categories = bubble_stop_get_shop_categories();
		$limit      = absint( bubble_stop_get_shop_field( 'products_per_category', 12 ) );
		$eyebrow    = bubble_stop_get_shop_field( 'menu_eyebrow', __( 'Our Menu', 'bubble-stop' ) );
		$heading    = bubble_stop_get_shop_field( 'menu_heading', __( 'Create Your Drink', 'bubble-stop' ) );
		?>
		<main class="shop-menu-page">
			<?php get_template_part( 'inc/woocommerce/templates/shop-hero' ); ?>

			<section class="shop-menu layout-padding">
				<header class="shop-menu__header">
					<?php if ( $eyebrow ) : ?><p class="shop-menu__eyebrow"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
					<?php if ( $heading ) : ?><h2 class="shop-menu__title"><?php echo esc_html( $heading ); ?></h2><?php endif; ?>
				</header>

				<div class="shop-menu__categories">
					<?php foreach ( $categories as $category ) : ?>
						<?php bubble_stop_render_shop_category_block( $category, $limit ?: 12 ); ?>
					<?php endforeach; ?>
				</div>
			</section>
		</main>
		<?php
	}
}
