<?php
/**
 * Menu Page Helper Functions
 *
 * @package bubble-stop
 */

/**
 * Get product categories for the menu.
 */
if ( ! function_exists( 'bubble_stop_get_menu_categories' ) ) {
	function bubble_stop_get_menu_categories() {
		$categories = get_terms(
			[
				'taxonomy'   => 'product_category',
				'hide_empty' => true,
				'parent'     => 0,
				'orderby'    => 'name',
				'order'      => 'ASC',
			]
		);

		return is_wp_error( $categories ) ? [] : $categories;
	}
}

/**
 * Get products within a category.
 */
if ( ! function_exists( 'bubble_stop_get_category_products' ) ) {
	function bubble_stop_get_category_products( $category_id, $limit = 12 ) {
		$args = [
			'post_type'      => 'bubble_product',
			'posts_per_page' => max( 1, min( 50, absint( $limit ) ) ),
			'tax_query'      => [
				[
					'taxonomy' => 'product_category',
					'field'    => 'term_id',
					'terms'    => $category_id,
				],
			],
			'orderby'        => 'title',
			'order'          => 'ASC',
		];

		$query = new WP_Query( $args );
		return $query->posts;
	}
}

/**
 * Render a product card for the menu carousel.
 */
if ( ! function_exists( 'bubble_stop_render_menu_product_card' ) ) {
	function bubble_stop_render_menu_product_card( $post_id ) {
		$permalink = get_permalink( $post_id );
		$title     = get_the_title( $post_id );
		$image_id  = get_post_thumbnail_id( $post_id );
		?>
		<article class="menu-product-card">
			<a href="<?php echo esc_url( $permalink ); ?>" class="menu-product-card__image" tabindex="-1" aria-hidden="true">
				<?php
				if ( $image_id && function_exists( 'bubble_stop_render_responsive_picture' ) ) {
					bubble_stop_render_responsive_picture(
						[
							'ID'  => $image_id,
							'url' => wp_get_attachment_url( $image_id ),
							'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: $title,
						],
						[
							'class' => 'menu-product-card__image-file',
							'sizes' => '(max-width: 575px) 80vw, (max-width: 991px) 42vw, 20vw',
						]
					);
				} else {
					echo '<div class="menu-product-card__placeholder"></div>';
				}
				?>
			</a>

			<div class="menu-product-card__body">
				<h3 class="menu-product-card__title">
					<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
				</h3>
				<a href="<?php echo esc_url( $permalink ); ?>" class="menu-product-card__link" aria-label="<?php echo esc_attr( sprintf( __( 'View %s', 'bubble-stop' ), $title ) ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true" width="20" height="20"><path d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6L20 7H6M9.5 20a.8.8 0 1 0 0-1.6.8.8 0 0 0 0 1.6Zm7 0a.8.8 0 1 0 0-1.6.8.8 0 0 0 0 1.6Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</a>
			</div>
		</article>
		<?php
	}
}

/**
 * Render a single category block with its products in a carousel.
 */
if ( ! function_exists( 'bubble_stop_render_menu_category_block' ) ) {
	function bubble_stop_render_menu_category_block( $category, $limit = 12 ) {
		$products = bubble_stop_get_category_products( $category->term_id, $limit );
		if ( ! $products ) {
			return;
		}

		$subtitle = get_field( 'menu_subtitle', $category );
		$block_id = wp_unique_id( 'menu-category-' );
		?>
		<section id="<?php echo esc_attr( $block_id ); ?>" class="shop-category-block">
			<header class="shop-category-block__header">
				<div class="shop-category-block__details">
					<div class="shop-category-block__name-wrap">
						<h2 class="shop-category-block__title"><?php echo esc_html( $category->name ); ?></h2>
						<?php if ( $subtitle ) : ?>
							<span class="shop-category-block__subtitle"><?php echo esc_html( $subtitle ); ?></span>
						<?php endif; ?>
					</div>
					<div class="shop-category-block__price">
						<span><?php esc_html_e( 'Regular', 'bubble-stop' ); ?></span>
						<strong class="price"><?php echo esc_html( '£5.50' ); ?></strong>
					</div>
					<div class="shop-category-block__price">
						<span><?php esc_html_e( 'Large', 'bubble-stop' ); ?></span>
						<strong class="price"><?php echo esc_html( '£6.50' ); ?></strong>
					</div>
				</div>

				<div class="shop-category-block__controls">
					<button type="button" class="bubble-carousel-arrow shop-category-block__arrow shop-category-block__arrow--prev" aria-label="<?php esc_attr_e( 'Previous products', 'bubble-stop' ); ?>">&larr;</button>
					<button type="button" class="bubble-carousel-arrow shop-category-block__arrow shop-category-block__arrow--next" aria-label="<?php esc_attr_e( 'Next products', 'bubble-stop' ); ?>">&rarr;</button>
				</div>
			</header>

			<div class="shop-category-block__carousel">
				<?php foreach ( $products as $product ) : ?>
					<?php bubble_stop_render_menu_product_card( $product->ID ); ?>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
