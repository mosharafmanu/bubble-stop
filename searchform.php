<?php
/**
 * Custom Search Form
 *
 * @package bubble-stop
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-field" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'bubble-stop' ); ?></label>
	<input 
		type="search" 
		id="search-field" 
		class="search-field" 
		placeholder="<?php esc_attr_e( 'Search...', 'bubble-stop' ); ?>" 
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s" 
		required
	/>
	<button type="submit" class="search-submit">
		<?php esc_html_e( 'Search', 'bubble-stop' ); ?>
	</button>
</form>

