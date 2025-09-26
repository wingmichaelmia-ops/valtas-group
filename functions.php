<?php
/**
 * Theme functions and definitions
 *
 * @package MMTheme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$echo_theme_inc_dir = 'inc';

// Array of files to include.
$echo_theme_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/cpt.php',                             // Register custom post types.
	'/wp-overrides.php',                    // Override default Wordpress functions & settings
	'/plugin-overrides.php',                // Override plugin functions & settings
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/shortcodes.php',                      // Library of shortcodes
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$echo_theme_includes[] = '/wc-overrides.php'; // Override default WooCommerce functions & settings
	$echo_theme_includes[] = '/woocommerce.php'; // WooCommerce functions
}

// Include files.
foreach ( $echo_theme_includes as $file ) {
	require_once get_theme_file_path( $echo_theme_inc_dir . $file );
}



function theme_register_menus() {
    register_nav_menus(
        array(
            'quick-links' => __('Quick Links Menu', 'quick-links'),
            'more-links' => __('More Links Menu', 'more-links'),
            'about-menu' => __('About Menu', 'about-menu')
        )
    );
}
add_action('after_setup_theme', 'theme_register_menus');


function mytheme_enqueue_swiper() {
    // Swiper CSS
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Init script
    wp_enqueue_script(
        'swiper-init',
        get_template_directory_uri() . '/src/js/swiper-init.js',
        array('swiper'),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_swiper', 20);