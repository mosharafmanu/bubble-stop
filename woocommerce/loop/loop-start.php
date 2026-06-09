<?php
/**
 * Product loop start — replaces WC's <ul class="products"> with our card-grid div.
 *
 * @package bubble-stop
 */

defined( 'ABSPATH' ) || exit;

$columns = wc_get_loop_prop( 'columns' );
?>
<div class="products card-grid columns-<?php echo esc_attr( $columns ); ?>">
