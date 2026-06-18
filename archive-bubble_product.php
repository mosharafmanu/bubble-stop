<?php
/**
 * The template for displaying bubble_product archives.
 *
 * @package bubble-stop
 */

get_header();
?>

	<main id="primary" class="site-main product-archive-page">

		<?php if ( function_exists( 'bubble_stop_breadcrumb' ) ) : ?>
			<?php bubble_stop_breadcrumb( true ); ?>
		<?php endif; ?>

		<header class="archive-header layout-padding pt-50 pt-md-70 pt-lg-100">
			<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
			<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
		</header>

		<section class="product-grid-section layout-padding pt-40 pt-md-50 pb-50 pb-md-70 pb-lg-100">
			<?php if ( have_posts() ) : ?>

				<div class="product-grid card-grid columns-4">
					<?php
					while ( have_posts() ) :
						the_post();

						if ( function_exists( 'bubble_stop_render_product_card' ) ) {
							bubble_stop_render_product_card();
						} else {
							get_template_part( 'template-parts/content', 'product' );
						}
					endwhile;
					?>
				</div>

				<?php
				if ( function_exists( 'bubble_stop_render_pagination' ) ) {
					bubble_stop_render_pagination();
				}
				?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</section>

	</main>

<?php
get_footer();
