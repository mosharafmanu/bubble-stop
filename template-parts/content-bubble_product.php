<?php
/**
 * Template part for displaying single bubble_product.
 *
 * @package bubble-stop
 */

$regular_price = get_field( 'regular_price' ) ?: '£5.50';
$large_price   = get_field( 'large_price' ) ?: '£6.50';
$order_link    = get_field( 'order_link' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'product-single-v2' ); ?>>
	
	<div class="product-single-v2__intro layout-padding pt-40">
		<h1 class="product-single-v2__intro-title text-center"><?php esc_html_e( 'Create Your Drink', 'bubble-stop' ); ?></h1>
	</div>

	<div class="product-single-v2__container layout-padding pb-30 ">
		<div class="product-single-v2__card">
			<div class="product-single-v2__grid">
				
				<div class="product-single-v2__media">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="product-single-v2__image-wrap">
							<?php the_post_thumbnail( 'full', [ 'class' => 'product-single-v2__image' ] ); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="product-single-v2__content">
					<h2 class="product-single-v2__title"><?php the_title(); ?></h2>
					
					<?php if ( $regular_price || $large_price ) : ?>
						<div class="product-single-v2__prices">
							<?php if ( $regular_price ) : ?>
								<div class="product-single-v2__price-row">
									<span class="product-single-v2__price-label"><?php esc_html_e( 'Regular', 'bubble-stop' ); ?></span>
									<span class="product-single-v2__price-value"><?php echo esc_html( $regular_price ); ?></span>
								</div>
							<?php endif; ?>
							
							<?php if ( $large_price ) : ?>
								<div class="product-single-v2__price-row">
									<span class="product-single-v2__price-label"><?php esc_html_e( 'Large', 'bubble-stop' ); ?></span>
									<span class="product-single-v2__price-value"><?php echo esc_html( $large_price ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<div class="product-single-v2__description">
						<h3 class="product-single-v2__description-label"><?php esc_html_e( 'Description', 'bubble-stop' ); ?></h3>
						<div class="product-single-v2__description-text">
							<?php the_content(); ?>
						</div>
					</div>

					<div class="product-single-v2__actions">
						<a href="#tebi-takeaway" class="site-btn product-single-v2__button js-tebi-trigger">
							<?php echo esc_html__( 'Order Now', 'bubble-stop' ); ?>
						</a>
					</div>
				</div>

			</div>
		</div>
	</div>

</article>
