<?php
/**
 * @package bubble-stop
 */

if (!defined('BUBBLE_STOP_VERSION')) {
    define('BUBBLE_STOP_VERSION', '1.0.0');
}

// ─────────────────────────────────────────────────────────────────
// ACF DEPENDENCY CHECK
// This theme requires Advanced Custom Fields (free or pro).
// Without it the dispatcher, section builder, and all settings
// helpers are non-functional. Fail loudly rather than silently.
// ─────────────────────────────────────────────────────────────────

add_action('admin_notices', function () {
    if (class_exists('ACF')) {
        return;
    }

    if (!current_user_can('activate_plugins')) {
        return;
    }

    $install_url = admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term');
    ?>
	<div class="notice notice-error">
		<p>
			<?php
printf(
        wp_kses(
            /* translators: %s: URL to plugin installer */
            __('<strong>Bubble Stop requires Advanced Custom Fields.</strong> The page builder, section templates, and all site settings depend on it. <a href="%s">Install ACF Free &rarr;</a>', 'bubble-stop'),
            [
                'strong' => [],
                'a'      => ['href' => []],
            ]
        ),
        esc_url($install_url)
    );
    ?>
		</p>
	</div>
	<?php
});

// ─────────────────────────────────────────────────────────────────
// THEME SETUP
// ─────────────────────────────────────────────────────────────────

function bubble_stop_setup() {
    load_theme_textdomain('bubble-stop', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

    register_nav_menus(array(
        'mainMenu'   => esc_html__('Main Menu', 'bubble-stop'),
        'footerMenu' => esc_html__('Footer Menu', 'bubble-stop'),
    ));

    // Controls max width for oEmbed — should match --bubb-container-max.
    $GLOBALS['content_width'] = 1380;
}
add_action('after_setup_theme', 'bubble_stop_setup');

// ─────────────────────────────────────────────────────────────────
// WIDGET AREAS
// ─────────────────────────────────────────────────────────────────

function bubble_stop_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'bubble-stop'),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'bubble_stop_widgets_init');

// ─────────────────────────────────────────────────────────────────
// SCRIPTS & STYLES
// ─────────────────────────────────────────────────────────────────

function bubble_stop_scripts() {
    // ── Fonts ────────────────────────────────────────────────────
    wp_enqueue_style(
        'bubble-stop-custom-fonts',
        get_template_directory_uri() . '/assets/css/custom-fonts.css',
        array(),
        BUBBLE_STOP_VERSION
    );

    wp_enqueue_style(
        'bubble-stop-fonts',
        'https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&display=swap',
        array('bubble-stop-custom-fonts'),
        null,
        'all'
    );

    // ── Core CSS ─────────────────────────────────────────────────
    wp_enqueue_style('bubble-stop-spacer', get_template_directory_uri() . '/assets/css/spacer.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-utilities', get_template_directory_uri() . '/assets/css/utilities.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-video', get_template_directory_uri() . '/assets/css/video-behaviors.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-video-popup', get_template_directory_uri() . '/assets/css/video-popup.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('slick-carousel', get_template_directory_uri() . '/assets/css/slick.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-slick-custom', get_template_directory_uri() . '/assets/css/bubble-stop-slick-custom.css', array('slick-carousel'), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-design-style', get_template_directory_uri() . '/assets/css/bubble-stop-design-style.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-form-style', get_template_directory_uri() . '/assets/css/bubble-stop-form.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-starter-style', get_template_directory_uri() . '/assets/css/bubble-stop-starter-style.css', array(), BUBBLE_STOP_VERSION);
    wp_enqueue_style('bubble-stop-style', get_stylesheet_uri(), array(), BUBBLE_STOP_VERSION);

    // ── Core JS ──────────────────────────────────────────────────
    wp_enqueue_script('jquery-vimeo-player', get_template_directory_uri() . '/assets/js/jquery.mb.vimeo_player.min.js', array('jquery'), BUBBLE_STOP_VERSION, true);
    wp_enqueue_script('slick-carousel', get_template_directory_uri() . '/assets/js/slick.js', array('jquery'), BUBBLE_STOP_VERSION, true);
    wp_enqueue_script('bubble-stop-video-behaviors', get_template_directory_uri() . '/assets/js/video-behaviors.js', array('jquery'), BUBBLE_STOP_VERSION, true);
    wp_enqueue_script('bubble-stop-video-popup', get_template_directory_uri() . '/assets/js/video-popup.js', array('jquery'), BUBBLE_STOP_VERSION, true);
	wp_enqueue_script('bubble-stop-testimonials', get_template_directory_uri() . '/assets/js/bubble-stop-testimonials.js', array('jquery', 'slick-carousel'), BUBBLE_STOP_VERSION, true);
    wp_enqueue_script('bubble-stop-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery', 'slick-carousel'), BUBBLE_STOP_VERSION, true);
}
add_action('wp_enqueue_scripts', 'bubble_stop_scripts');

// ─────────────────────────────────────────────────────────────────
// EDITOR — Gutenberg disabled; theme uses ACF Flexible Content
// ─────────────────────────────────────────────────────────────────

add_filter('use_block_editor_for_post_type', '__return_false');
add_filter('use_block_editor_for_post', '__return_false');

add_action('after_setup_theme', function () {
    remove_theme_support('widgets-block-editor');
});

add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
}, 100);

add_action('admin_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}, 100);

// ─────────────────────────────────────────────────────────────────
// ACF JSON SYNC
// ─────────────────────────────────────────────────────────────────

add_filter('acf/settings/save_json', function ($path) {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

// ─────────────────────────────────────────────────────────────────
// CORE INCLUDES
// ─────────────────────────────────────────────────────────────────

require get_template_directory() . '/inc/image-sizes.php';

foreach (glob(get_template_directory() . '/inc/components/*/*.php') as $file) {
    require $file;
}

foreach (glob(get_template_directory() . '/inc/helper-functions/*.php') as $file) {
    require $file;
}

// ─────────────────────────────────────────────────────────────────
// WOOCOMMERCE
// Self-contained, optional module — see inc/woocommerce/woocommerce-setup.php.
// Guarded with file_exists() so projects that don't need WooCommerce can
// delete the whole module (that file, woocommerce/, assets/{css,js}/woocommerce/,
// .ai/WOOCOMMERCE.md) without touching this require.
// ─────────────────────────────────────────────────────────────────

$bubble_stop_woocommerce_setup = get_template_directory() . '/inc/woocommerce/woocommerce-setup.php';
if (file_exists($bubble_stop_woocommerce_setup)) {
    require $bubble_stop_woocommerce_setup;
}

// ─────────────────────────────────────────────────────────────────
// POST CONTENT CLEANUP
// ─────────────────────────────────────────────────────────────────

add_filter('the_content', function ($content) {
    if (is_admin() || 'post' !== get_post_type()) {
        return $content;
    }
    return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);
}, 20);
