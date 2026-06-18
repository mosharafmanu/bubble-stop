<?php
/**
 * Template Name: Menu Page
 *
 * @package bubble-stop
 */

get_header();

// Hero Fields
$hero_heading     = get_field( 'shop_hero_heading' );
$hero_highlights  = get_field( 'shop_hero_highlights' );
$hero_description = get_field( 'shop_hero_description' );
$hero_button      = get_field( 'shop_hero_button' );
$hero_image       = get_field( 'shop_hero_image' );

// Menu Section Fields
$menu_eyebrow = get_field( 'menu_eyebrow' ) ?: __( 'Our Menu', 'bubble-stop' );
$menu_heading = get_field( 'menu_heading' ) ?: __( 'Create Your Drink', 'bubble-stop' );

$categories = bubble_stop_get_menu_categories();
?>

<main id="primary" class="site-main shop-menu-page">
	
	<?php if ( $hero_heading || $hero_image ) : ?>
	<section class="menu-hero-banner layout-padding pt-50 pt-md-70">
		<div class="menu-hero-banner__container">
			<div class="menu-hero-banner__grid">
				<div class="menu-hero-banner__content-card">
					<?php if ( $hero_heading ) : ?>
						<h1 class="menu-hero-banner__title"><?php echo esc_html( $hero_heading ); ?></h1>
					<?php endif; ?>

					<?php if ( $hero_highlights ) : ?>
						<ul class="menu-hero-banner__list">
							<?php foreach ( $hero_highlights as $highlight ) : ?>
								<li><?php echo esc_html( $highlight['text'] ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( $hero_description ) : ?>
						<div class="menu-hero-banner__description">
							<?php echo wp_kses_post( $hero_description ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $hero_button ) : ?>
						<a href="<?php echo esc_url( $hero_button['url'] ); ?>" 
						   class="site-btn btn-secondary menu-hero-banner__button"
						   <?php echo ! empty( $hero_button['target'] ) ? 'target="' . esc_attr( $hero_button['target'] ) . '"' : ''; ?>>
							<?php echo esc_html( $hero_button['title'] ); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="menu-hero-banner__media">
					<?php if ( $hero_image ) : ?>
						<?php echo wp_get_attachment_image( $hero_image['ID'], 'full', false, [ 'class' => 'menu-hero-banner__image' ] ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<header class="menu-section-header layout-padding pt-50 pt-md-70 pt-lg-100">
		<div class="menu-section-header__content text-center">
			<p class="menu-section-header__eyebrow"><?php echo esc_html( $menu_eyebrow ); ?></p>
			<h2 class="menu-section-header__title"><?php echo esc_html( $menu_heading ); ?></h2>
		</div>
	</header>

	<div class="shop-menu layout-padding pb-50 pb-md-70 pb-lg-100">
		<div class="shop-menu__categories">
			<?php if ( $categories ) : ?>
				<?php foreach ( $categories as $category ) : ?>
					<?php bubble_stop_render_menu_category_block( $category ); ?>
				<?php endforeach; ?>
			<?php else : ?>
				<p class="text-center"><?php esc_html_e( 'No categories found. Please add some product categories and assign products to them.', 'bubble-stop' ); ?></p>
			<?php endif; ?>
		</div>
	</div>

</main>

<?php
get_footer();
