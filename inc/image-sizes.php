<?php
/**
 * @package bubble-stop
 */

add_action( 'after_setup_theme', 'bubble_stop_register_image_sizes' );
function bubble_stop_register_image_sizes() {
	add_image_size( 'bubb-300',  300,  9999, false );
	add_image_size( 'bubb-600',  600,  9999, false );
	add_image_size( 'bubb-900',  900,  9999, false );
	add_image_size( 'bubb-1200', 1200, 9999, false );
	add_image_size( 'bubb-1600', 1600, 9999, false );
}

// ─────────────────────────────────────────────────────────────────
// DISABLE WORDPRESS DEFAULT SIZES
// ─────────────────────────────────────────────────────────────────

add_filter( 'intermediate_image_sizes_advanced', function( $sizes ) {
	unset( $sizes['medium'] );
	unset( $sizes['medium_large'] );
	unset( $sizes['large'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );
	return $sizes;
} );

// ─────────────────────────────────────────────────────────────────
// SRCSET + WEBP
// ─────────────────────────────────────────────────────────────────

add_filter( 'max_srcset_image_width', function() {
	return 3840;
} );

add_filter( 'mime_types', function( $mimes ) {
	$mimes['webp'] = 'image/webp';
	return $mimes;
} );
