<?php
/**
 * Product card component.
 *
 * @package bubble-stop
 */

if ( ! function_exists( 'bubble_stop_render_product_card' ) ) {
	function bubble_stop_render_product_card( $post_id = null, $args = [] ) {
		$post_id = $post_id ? absint( $post_id ) : get_the_ID();

		if ( ! $post_id ) {
			return;
		}

		$defaults = [
			'image_sizes'    => '(max-width: 767px) 100vw, (max-width: 1199px) 50vw, 33vw',
			'class'          => '',
			'fetchpriority'  => 'auto',
			'echo'           => true,
		];

		$args       = wp_parse_args( $args, $defaults );
		$permalink  = get_permalink( $post_id );
		$title      = get_the_title( $post_id );
		$title      = $title ? $title : __( 'Untitled Product', 'bubble-stop' );

		$card_classes = [ 'product-card' ];
		if ( $args['class'] ) {
			$card_classes[] = $args['class'];
		}

		// Build ACF-compatible image array from the WP post thumbnail.
		$thumbnail_id   = get_post_thumbnail_id( $post_id );
		$thumbnail_data = null;
		if ( $thumbnail_id ) {
			$thumbnail_data = [
				'ID'  => $thumbnail_id,
				'url' => wp_get_attachment_url( $thumbnail_id ),
				'alt' => get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) ?: $title,
			];
		}

		ob_start();
		?>

		<article id="product-<?php echo esc_attr( $post_id ); ?>" <?php post_class( implode( ' ', array_map( 'sanitize_html_class', $card_classes ) ), $post_id ); ?>>
			<div class="product-card__media">
				<?php if ( $thumbnail_data && function_exists( 'bubble_stop_render_responsive_picture' ) ) : ?>
					<?php
					bubble_stop_render_responsive_picture(
						$thumbnail_data,
						[
							'class'         => 'product-card__image',
							'lazy'          => true,
							'fetchpriority' => $args['fetchpriority'],
							'sizes'         => $args['image_sizes'],
						]
					);
					?>
				<?php endif; ?>
			</div>

			<div class="product-card__content">
				<h3 class="product-card__title">
					<?php echo esc_html( $title ); ?>
				</h3>
			</div>
		</article>

		<?php
		$output = ob_get_clean();

		if ( $args['echo'] ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $output;
		}
	}
}
