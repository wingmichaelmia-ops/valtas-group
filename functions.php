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

add_action('wp_head', function() {
    ?>
    <script>
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php
});


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



add_action( 'widgets_init', function() {
    register_widget( 'Valtas_Category_Filter_Widget' );
});

class Valtas_Category_Filter_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'valtas_category_filter_widget',
            __( 'Category Filter Checklist', 'valtas' ),
            [ 'description' => __( 'Displays category checkboxes for filtering posts.', 'valtas' ) ]
        );
    }

    function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<div class="valtas-category-list">';
        echo $args['before_title'] . __( 'Category :', 'valtas' ) . $args['after_title'];

        $categories = get_categories([
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true,
        ]);

        // 🔹 Start form
        echo '<form id="category-filter-form">';

        // 🔹 Add "All" checkbox (checked by default)
        echo '<div class="form-check mb-2">';
        echo '<input 
                class="form-check-input category-checkbox" 
                type="checkbox" 
                id="cat-all" 
                value="all" 
                checked
            >';
        echo '<label class="form-check-label" for="cat-all">All</label>';
        echo '</div>';

        // 🔹 Individual category checkboxes
        foreach ( $categories as $cat ) {
            echo '<div class="form-check mb-2">';
            echo '<input 
                    class="form-check-input category-checkbox" 
                    type="checkbox" 
                    value="' . esc_attr( $cat->term_id ) . '" 
                    id="cat-' . esc_attr( $cat->term_id ) . '"
                >';
            echo '<label class="form-check-label" for="cat-' . esc_attr( $cat->term_id ) . '">' . esc_html( $cat->name ) . '</label>';
            echo '</div>';
        }

        echo '</form>';

        echo $args['after_widget'];
        echo '</div>';
    }
}
//YEAR FILTER WIDGET//

add_action( 'widgets_init', function() {
    register_widget( 'Valtas_Year_Filter_Widget' );
});

class Valtas_Year_Filter_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'valtas_year_filter_widget',
            __( 'Year Filter Checklist', 'valtas' ),
            [ 'description' => __( 'Displays a checklist to filter blog posts by year.', 'valtas' ) ]
        );
    }

    function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<div class="valtas-category-list">';
        echo $args['before_title'] . __( 'Select by year :', 'valtas' ) . $args['after_title'];

        global $wpdb;
        $years = $wpdb->get_col("
            SELECT DISTINCT YEAR(post_date)
            FROM $wpdb->posts
            WHERE post_status = 'publish'
            AND post_type = 'post'
            ORDER BY post_date DESC
        ");

        if ( $years ) {
            echo '<form id="year-filter-form">';
            echo '<div class="form-check mb-2">
                    <input class="form-check-input year-checkbox" type="checkbox" value="all" id="year-all" checked>
                    <label class="form-check-label" for="year-all">All</label>
                  </div>';

            foreach ( $years as $year ) {
                echo '<div class="form-check mb-2">
                        <input class="form-check-input year-checkbox" type="checkbox" value="' . esc_attr( $year ) . '" id="year-' . esc_attr( $year ) . '">
                        <label class="form-check-label" for="year-' . esc_attr( $year ) . '">' . esc_html( $year ) . '</label>
                      </div>';
            }

            echo '</form>';
        } else {
            echo '<p>No posts available yet.</p>';
        }

        echo '</div>';
        echo $args['after_widget'];
    }
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

function filter_posts() {
    $years = isset($_POST['years']) ? $_POST['years'] : ['all'];
    $cats  = isset($_POST['categories']) ? $_POST['categories'] : ['all'];
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = [
        'post_type' => 'post',
        'posts_per_page' => 6,
        'paged' => $paged,
    ];

    // Year filter
    if (!in_array('all', $years)) {
        $args['date_query'] = ['relation' => 'OR'];
        foreach ($years as $year) {
            $args['date_query'][] = ['year' => intval($year)];
        }
    }

    // Category filter
    if (!in_array('all', $cats)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => array_map('intval', $cats),
            ]
        ];
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :
        echo '<div class="row g-4" id="blog-posts-container">';
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-md-12 blog-item-post">
                <div class="card h-100 border-0">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium_large', ['class'=>'card-img-top']); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-body py-4 px-0">
                        <div class="card-meta d-flex gap-3 small mb-2 align-items-center">
                            <div class="date-capsule"><?php echo get_the_date('m/d/y'); ?></div>
                                <div class="share-links d-flex gap-2">
                                    <a href="<?php echo esc_url($share_facebook); ?>" target="_blank" rel="noopener" class="text-primary">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/fb.png'); ?>" alt="Facebook" loading="lazy">
                                    </a>
                                    <a href="<?php echo esc_url($share_x); ?>" target="_blank" rel="noopener" class="text-dark">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/x.png'); ?>" alt="X" loading="lazy">
                                    </a>
                                </div>
                            </div>
                        <h3 class="card-title mb-3">
                            <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a>
                        </h3>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 50); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more">Read more</a>
                    </div>
                </div>
            </div>
        <?php
        endwhile;
        echo '</div>';

        // Pagination (same as before, using data-page)
        if ($query->max_num_pages > 1) :
            echo '<div class="post-pagination text-center mt-4">';
            $paginate_links = paginate_links([
                'total' => $query->max_num_pages,
                'current' => $paged,
                'mid_size' => 2,
                'prev_text' => '&lt;',
                'next_text' => '&gt;',
                'type' => 'array'
            ]);

            foreach ($paginate_links as $link) {

                if (strpos($link, 'current') !== false) {
                    echo '<span class="current">' . strip_tags($link) . '</span>';
                    continue;
                }

                preg_match('/href=[\'"]?([^\'" >]+)/', $link, $href_match);
                $href = isset($href_match[1]) ? $href_match[1] : '';

                $page_num = 1;
                if ($href) {
                    $url_parts = wp_parse_url($href);
                    if (!empty($url_parts['query'])) {
                        parse_str($url_parts['query'], $query_vars);
                        if (!empty($query_vars['paged'])) $page_num = intval($query_vars['paged']);
                    } elseif (!empty($url_parts['path'])) {
                        if (preg_match('#/page/(\d+)/?#', $url_parts['path'], $matches)) {
                            $page_num = intval($matches[1]);
                        }
                    }
                }

                $link = preg_replace('/<a.*?>(.*?)<\/a>/', '<a href="#" class="ajax-page-link" data-page="'.$page_num.'">$1</a>', $link);
                echo $link;
            }

            echo '</div>';
        endif;

    else :
        echo '<p>No posts found.</p>';
    endif;

    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}


// =====================================================
// CUSTOM LOGIN PAGE SETUP (for Members plugin integration)
// =====================================================

// Redirect logged-in users away from the login page BEFORE output starts
function redirect_logged_in_user_from_login_page() {
    if ( is_page( 'login' ) && is_user_logged_in() ) {
        wp_redirect( home_url( '/boardspark-archive/' ) );
        exit;
    }
}
add_action( 'template_redirect', 'redirect_logged_in_user_from_login_page' );

// Custom Login Form Shortcode
function custom_login_form_shortcode() {

    if ( is_user_logged_in() ) {
        return '<div class="alert alert-info text-center my-5">You are already logged in.</div>';
    }

    // Capture any login errors
    $login_errors = '';
    if ( isset( $_GET['login'] ) && $_GET['login'] === 'failed' ) {
        $login_errors = '<div class="alert alert-danger text-center mb-3">Invalid username or password.</div>';
    }

    // Custom form markup (no labels, using placeholders)
    ob_start();
    ?>
    <div class="custom-login-wrapper">
        <div class="custom-login-wrapper-inner">
                <h2 class="h4 mb-2 fw-bold text-primary">Welcome to BoardSpark</h2>
                <p class="mb-2">Please sign in to continue...</p>
                <?php echo $login_errors; ?>
                <form name="loginform" id="custom-login-form" action="<?php echo esc_url( wp_login_url() ); ?>" method="post">
                    <div class="mb-4">
                        <input type="text" name="log" id="user_login" class="form-control" placeholder="Username or Email Address" required>
                    </div>
                    <div class="mb-4">
                        <input type="password" name="pwd" id="user_pass" class="form-control" placeholder="Password" required>
                    </div>
                    <!--<div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" name="rememberme" type="checkbox" id="rememberme" value="forever">
                            <label class="form-check-label" for="rememberme">Remember Me</label>
                        </div>
                    </div>-->
                    <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary w-100" value="Submit">
                    <div class="text-center mt-5 form-links">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Lost your password?</a> | <a href="<?php echo esc_url( home_url( '/request-access/' ) ); ?>">Request Access</a>
                    </div>
                    <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/boardspark-archive/' ) ); ?>">
                    <input type="hidden" name="testcookie" value="1">
                </form>
        </div>
    </div>
    <style>
        .custom-login-wrapper {
            background-image: url('<?php echo esc_url( get_template_directory_uri() . '/img/login-bg.jpg' ); ?>');
            min-height: 80dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            padding-top: 200px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }
        .custom-login-wrapper-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-flow: column;
            background: white;
            padding: 3rem 2rem;
            border-radius: 30px;
            width: 100%;
            max-width: 577px;
            box-shadow: 0 10px 125px rgba(0, 52, 78, .08);
        }
        #custom-login-form {
            width: 100%;
            margin-top: 1rem;
        }
        #custom-login-form input[type="text"],
        #custom-login-form input[type="password"] {
            width: 100%;
            margin-bottom: 15px;
            border-radius: 10px;
            padding: 1rem;
            background-color: #F5F5F5;
            border-color: #F5F5F5;
        }
        #custom-login-form input[type="submit"] {
            width: 100%;
            background: linear-gradient(90deg,rgba(0, 159, 237, 1) 0%, rgba(1, 47, 108, 1) 100%);
            color: #fff;
            border: none;
            padding: 1rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-radius: 30px;
            text-transform: uppercase;
        }
        #custom-login-form input[type="submit"]:hover {
            background-color: #009fed;
        }
        .form-links a {
            color: #009fed;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode( 'custom_login_form', 'custom_login_form_shortcode' );

function custom_register_form_shortcode() {

    if ( is_user_logged_in() ) {
        return '<div class="alert alert-info text-center my-5">You are already logged in.</div>';
    }

    $errors = array();
    $success = '';

    // Handle form submission
    if ( isset( $_POST['custom_user_register'] ) ) {
        $username = sanitize_user( $_POST['username'] );
        $email    = sanitize_email( $_POST['email'] );
        $password = $_POST['password'];
        $confirm  = $_POST['confirm_password'];

        if ( empty( $username ) || empty( $email ) || empty( $password ) || empty( $confirm ) ) {
            $errors[] = 'All fields are required.';
        }
        if ( ! is_email( $email ) ) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ( username_exists( $username ) || email_exists( $email ) ) {
            $errors[] = 'Username or email already exists.';
        }
        if ( $password !== $confirm ) {
            $errors[] = 'Passwords do not match.';
        }

        // If no errors, register the user
        if ( empty( $errors ) ) {
            $user_id = wp_create_user( $username, $password, $email );
            if ( ! is_wp_error( $user_id ) ) {
                wp_new_user_notification( $user_id, null, 'both' ); // Sends email to admin & user
                $success = 'Registration successful! You can now log in.';
                $_POST = array(); // Clear form
            } else {
                $errors[] = 'Registration failed. Please try again.';
            }
        }
    }

    // Build output
    ob_start();
    ?>
    <div class="custom-login-wrapper">
        <div class="custom-login-wrapper-inner">
                        <h2 class="h4 text-center mb-4 fw-bold text-primary">Request Access</h2>

                        <?php if ( ! empty( $errors ) ) : ?>
                            <div class="alert alert-danger"><?php echo implode( '<br>', $errors ); ?></div>
                        <?php elseif ( ! empty( $success ) ) : ?>
                            <div class="alert alert-success text-center"><?php echo esc_html( $success ); ?></div>
                        <?php endif; ?>

                        <form id="custom-register-form" method="post" action="">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                            </div>
                            <input type="submit" name="custom_user_register" class="btn btn-primary w-100" value="Register">
                            <div class="text-center mt-5 form-links">
                                <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>">Already have an account? Log in</a>
                            </div>
                        </form>
        </div>
    </div>

    <style>
        .custom-login-wrapper {
            background-image: url('<?php echo esc_url( get_template_directory_uri() . '/img/login-bg.jpg' ); ?>');
            min-height: 80dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            padding-top: 200px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }
        .custom-login-wrapper-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-flow: column;
            background: white;
            padding: 3rem 2rem;
            border-radius: 30px;
            width: 100%;
            max-width: 577px;
            box-shadow: 0 10px 125px rgba(0, 52, 78, .08);
        }
        #custom-register-form {
            width: 100%;
            margin-top: 1rem;
        }
        #custom-register-form input[type="text"],
        #custom-register-form input[type="password"],
        #custom-register-form input[type="email"] {
            width: 100%;
            margin-bottom: 15px;
            border-radius: 10px;
            padding: 1rem;
            background-color: #F5F5F5;
            border-color: #F5F5F5;
        }
        #custom-register-form input[type="submit"] {
            width: 100%;
            background: linear-gradient(90deg,rgba(0, 159, 237, 1) 0%, rgba(1, 47, 108, 1) 100%);
            color: #fff;
            border: none;
            padding: 1rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-radius: 30px;
            text-transform: uppercase;
        }
        #custom-register-form input[type="submit"]:hover {
            background-color: #009fed;
        }
        .form-links a {
            color: #009fed;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode( 'custom_register_form', 'custom_register_form_shortcode' );



// Redirect logged-out users from Members Area template or content tagged "BoardSpark"
function valtas_redirect_members_area_pages() {

	// Redirect if using the Members Area template
	if ( is_page_template( 'page-members-area.php' ) && ! is_user_logged_in() ) {
		wp_redirect( home_url( '/login/' ) );
		exit;
	}

	// Redirect if post or page has the tag "BoardSpark"
	if ( ( is_single() || is_page() ) && has_tag( 'BoardSpark' ) && ! is_user_logged_in() ) {
		wp_redirect( home_url( '/login/' ) );
		exit;
	}
}
add_action( 'template_redirect', 'valtas_redirect_members_area_pages' );

add_action( 'init', function() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
} );



/*FILTER BY YEAR*/

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script(
        'valtas-blog-filter',
        get_template_directory_uri() . '/js/blog-filter.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('valtas-blog-filter', 'valtas_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
});
add_action('wp_ajax_filter_posts_by_year', 'valtas_filter_posts_by_year');
add_action('wp_ajax_nopriv_filter_posts_by_year', 'valtas_filter_posts_by_year');

function valtas_filter_posts_by_year() {
    $years = isset($_POST['years']) ? (array) $_POST['years'] : [];

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'paged'          => 1,
    ];

    if (!in_array('all', $years)) {
        $args['date_query'] = [
            [
                'year' => intval($years[0]), // Only handle one year for simplicity; extendable for multiple
            ]
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        echo '<div class="row g-4">';
        while ($query->have_posts()) :
            $query->the_post();
            ?>
            <div class="col-md-12 blog-item-post">
                <div class="card h-100 border-0">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium_large', ['class' => 'card-img-top']); ?>
                        </a>
                    <?php endif; ?>

                    <div class="card-body py-4 px-0">
                        <div class="card-meta d-flex gap-3 small mb-2 align-items-center">
                            <div class="date-capsule"><?php echo get_the_date('m/d/y'); ?></div>
                        </div>
                        <h3 class="card-title mb-3">
                            <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <?php echo wpautop(wp_trim_words(get_the_content(), 50, '...')); ?>
                    </div>
                </div>
                <hr class="my-3">
            </div>
            <?php
        endwhile;
        echo '</div>';
    else :
        echo '<p>No posts found for this year.</p>';
    endif;

    wp_reset_postdata();
    wp_die();
}





add_action('wp_ajax_load_more_case_studies', 'load_more_case_studies');
add_action('wp_ajax_nopriv_load_more_case_studies', 'load_more_case_studies');

function load_more_case_studies() {

    $offset     = intval($_POST['offset']);
    $categories = sanitize_text_field($_POST['categories']);
    $layout     = sanitize_text_field($_POST['layout']);

    // Convert categories to array
    $term_ids = array_filter(array_map('intval', explode(',', $categories)));

    $args = [
        'post_type'      => 'case-study',
        'posts_per_page' => 4,
        'offset'         => $offset,
    ];

    if (!empty($term_ids)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'cs-category',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ]
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :

        ob_start();

        while ($query->have_posts()) : $query->the_post(); ?>

            <div class="project-item col-md-6">
                <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <div class="project-item_img ratio ratio-16x9">
                            <?php the_post_thumbnail('full', ['class' => 'object-fit-cover']); ?>
                        </div>
                    </a>
                <?php endif; ?>

                <div class="project-item_meta mt-3 mb-2">
                    IMPACT | <?php echo get_the_date('m/d/y'); ?>
                </div>

                <h5 class="project-title mb-3">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h5>

                <?php
                $custom_excerpt = get_field('org_blurb');
                if ($custom_excerpt) {
                    $excerpt = mb_substr($custom_excerpt, 0, 300);
                    if (mb_strlen($custom_excerpt) > 300) {
                        $excerpt = preg_replace('/\s+?(\S+)?$/', '', $excerpt) . '...';
                    }
                    echo wp_kses_post($excerpt);
                }
                ?>
            </div>

        <?php endwhile;

        wp_reset_postdata();
        echo ob_get_clean();

    endif;

    die();
}



/**
 * Safe Custom Login Redirection
 * Redirect wp-login.php to /login/ without breaking login functionality
 */

add_action('init', function () {

    // Current request URI and method
    $request_uri  = $_SERVER['REQUEST_URI'];
    $request_method = $_SERVER['REQUEST_METHOD'];

    // ------------------------------------------------------------------
    // 1. Allow required core endpoints
    // ------------------------------------------------------------------
    $allowed = [
        'wp-cron.php',
        'admin-ajax.php',
        'wp-json',
    ];
    foreach ($allowed as $ok) {
        if (strpos($request_uri, $ok) !== false) {
            return; // do nothing
        }
    }

    // ------------------------------------------------------------------
    // 2. Allow wp-login.php POST requests (login submission)
    // ------------------------------------------------------------------
    if ($request_method === 'POST' && strpos($request_uri, 'wp-login.php') !== false) {
        return; // allow login POST
    }

    // ------------------------------------------------------------------
    // 3. Redirect wp-login.php GET requests to custom /login/
    // ------------------------------------------------------------------
    if (
        strpos($request_uri, 'wp-login.php') !== false ||
        isset($_GET['loggedout'])
    ) {
        wp_safe_redirect(home_url('/login/'));
        exit;
    }
});



/**
 * Block wp-admin for non-logged users
 */
add_action('admin_init', function () {

    // Allow AJAX
    if (wp_doing_ajax()) return;

    // If not logged in → redirect to custom login
    if (!is_user_logged_in()) {
        wp_safe_redirect(home_url('/login/'));
        exit;
    }
});


// Redirect boardX users away from wp-admin
add_action( 'admin_init', function() {
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();

        if ( in_array( 'boardx', (array) $user->roles, true ) ) {

            if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
                wp_redirect( home_url() );
                exit;
            }
        }
    }
});
