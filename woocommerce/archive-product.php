<?php
/**
 * Shop and product-category archive.
 *
 * @package bubble-stop
 */

defined( 'ABSPATH' ) || exit;

get_header();

woocommerce_output_all_notices();

if ( function_exists( 'bubble_stop_render_shop_page' ) ) {
	bubble_stop_render_shop_page();
}

get_footer();
