<?php
/**
 * AJAX product-category tabs and carousel.
 *
 * @package bubble-stop
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$eyebrow      = get_sub_field( 'eyebrow' );
$heading      = get_sub_field( 'heading' );
$categories   = get_sub_field( 'categories' );
$product_limit = get_sub_field( 'product_limit' ) ?: 8;
$button_link  = get_sub_field( 'button_link' );

if ( ! $categories || ! is_array( $categories ) ) {
	return;
}

$category_terms = [];
foreach ( $categories as $category ) {
	$term = is_object( $category ) ? $category : get_term( absint( $category ), 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		$category_terms[] = $term;
	}
}

if ( ! $category_terms ) {
	return;
}

$first_category = $category_terms[0];
$section_id     = wp_unique_id( 'product-category-showcase-' );
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="product-category-showcase layout-padding" data-product-limit="<?php echo absint( $product_limit ); ?>">
	<div class="product-category-showcase__header">
		<div class="product-category-showcase__heading">
			<?php if ( $eyebrow ) : ?>
				<p class="product-category-showcase__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<?php if ( $heading ) : ?>
				<h2 class="product-category-showcase__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
		</div>

	</div>

	<div class="product-category-showcase__navigation">
		<div class="product-category-showcase__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Product categories', 'bubble-stop' ); ?>">
			<?php foreach ( $category_terms as $index => $category ) : ?>
				<button
					type="button"
					class="product-category-showcase__tab<?php echo 0 === $index ? ' is-active' : ''; ?>"
					role="tab"
					aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
					aria-controls="<?php echo esc_attr( $section_id ); ?>-products"
					data-category-id="<?php echo absint( $category->term_id ); ?>"
				>
					<?php echo esc_html( $category->name ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="product-category-showcase__controls" aria-label="<?php esc_attr_e( 'Carousel controls', 'bubble-stop' ); ?>">
			<button type="button" class="bubble-carousel-arrow product-category-showcase__arrow product-category-showcase__arrow--prev" aria-label="<?php esc_attr_e( 'Previous products', 'bubble-stop' ); ?>">&larr;</button>
			<button type="button" class="bubble-carousel-arrow product-category-showcase__arrow product-category-showcase__arrow--next" aria-label="<?php esc_attr_e( 'Next products', 'bubble-stop' ); ?>">&rarr;</button>
		</div>
	</div>

	<div id="<?php echo esc_attr( $section_id ); ?>-products" class="product-category-showcase__panel" role="tabpanel" aria-live="polite">
		<div class="product-category-showcase__carousel">
			<?php bubble_stop_render_category_showcase_products( $first_category->term_id, $product_limit ); ?>
		</div>
	</div>

	<?php if ( $button_link && function_exists( 'bubble_stop_render_button' ) ) : ?>
		<div class="product-category-showcase__actions">
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
</section>
