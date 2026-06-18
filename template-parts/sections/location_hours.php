<?php
/**
 * Location and Hours section.
 *
 * @package bubble-stop
 */

$map_embed       = get_sub_field( 'map_embed' );
$heading         = get_sub_field( 'heading' );
$store_name      = get_sub_field( 'store_name' );
$address         = get_sub_field( 'address' );
$email           = get_sub_field( 'email' );
$directions_link = get_sub_field( 'directions_link' );
$hours           = get_sub_field( 'hours' );

if ( ! $map_embed && ! $heading && ! $address && ! $hours ) {
	return;
}
?>

<section class="location-hours layout-padding pt-50 pt-md-70 pb-50 pb-md-70">
	<?php if ( $map_embed ) : ?>
		<div class="location-hours__map">
			<?php echo $map_embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php endif; ?>

	<div class="location-hours__content">
		<div class="location-hours__col-heading">
			<?php if ( $heading ) : ?>
				<h2 class="location-hours__title"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
		</div>
		
		<div class="location-hours__col-details">
			<?php if ( $store_name ) : ?>
				<p class="location-hours__store"><?php echo esc_html( $store_name ); ?></p>
			<?php endif; ?>
			
			<?php if ( $address ) : ?>
				<p class="location-hours__address"><?php echo wp_kses_post( $address ); ?></p>
			<?php endif; ?>
			
			<?php if ( $email ) : ?>
				<p class="location-hours__email">
					<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				</p>
			<?php endif; ?>
			
			<?php if ( $directions_link ) : ?>
				<p class="location-hours__directions">
					<a href="<?php echo esc_url( $directions_link ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Get directions', 'bubble-stop' ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>
		
		<div class="location-hours__col-hours">
			<?php if ( $hours ) : ?>
				<ul class="location-hours__schedule">
					<?php foreach ( $hours as $row ) : ?>
						<li>
							<span class="day"><?php echo esc_html( $row['day'] ); ?></span>
							<span class="time"><?php echo esc_html( $row['time'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
