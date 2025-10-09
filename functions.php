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


function ajax_load_more_testimonials() {
    $paged     = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page  = isset($_POST['per_page']) ? intval($_POST['per_page']) : 6;
    $post_type = sanitize_text_field($_POST['post_type']);
    $terms     = sanitize_text_field($_POST['terms']);
    $term_ids  = $terms ? array_map('intval', explode(',', $terms)) : [];

    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => $per_page,
        'paged'          => $paged,
    ];

    if ( ! empty($term_ids) ) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'testimonial_category',
                'field'    => 'term_id',
                'terms'    => $term_ids,
                'operator' => 'IN',
            ],
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/testimonial', 'card');
        endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_testimonials', 'ajax_load_more_testimonials');
add_action('wp_ajax_nopriv_load_more_testimonials', 'ajax_load_more_testimonials');


function testimonials_load_scripts() {
    wp_enqueue_script(
        'load-more-testimonials',
        get_template_directory_uri() . '/src/js/load-more-testimonials.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('load-more-testimonials', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'testimonials_load_scripts');


function theme_register_sidebars() {
    register_sidebar(array(
        'name'          => __('Blog Sidebar', 'valtas-theme'),
        'id'            => 'blog-sidebar',
        'before_widget' => '<div class="mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="fw-bold mb-3">',
        'after_title'   => '</h5>',
    ));
}
add_action('widgets_init', 'theme_register_sidebars');
