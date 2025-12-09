<?php
/**
 * Template Name: Members Area
 * Description: Private page for logged-in users only, using ACF renderer partial.
 */

global $post;

/**
 * Redirect logged-out users if page is restricted via Members plugin
 */

	if ( ! is_user_logged_in() ) {
		wp_safe_redirect(home_url('/login/'));
        exit;
	}


get_header();
$title = get_field('hero_title');
$blurb = get_field('hero_blurb');
$bg = get_field('boardx_background_image');
?>

<style>
    
    <?php if($bg): ?>
    .echo-block-page_title .bg-image:not(.feature-image) {
        display: none;
    }
    <?php else: ?>
    .echo-block-page_title img.bg-image:nth-child(2) {
        display: none;
    }
    <?php endif; ?>
</style>
<?php
// STARTS - wrapp your content with this conditional statement
if ( post_password_required() && ! is_user_logged_in() ) :

    // if your post is password protected with our Pro version, show our password form instead
    echo get_the_password_form();

/* display the password protected content if the correct password is entered */ 
else :

?>
<section class="echo-block echo-block-page_title">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'page_title',
        [
            'title'      => $title ?: 'BoardSpark <span class="highlight">Archive</span>', // use the post title dynamically
            'title_tag'  => 'h1',
            'content'    => $blurb ?: ' BoardSpark is a free, invitation-only resource hub powered by Valtas that equips nonprofit boards with tools, insights, and connections to grow their eXperience, eXpertise, and eXcellence, with a monthly donation from Valtas to every nonprofit whose board engages with the platform that month.',
            'button_group' => get_field( 'button_group' ),
        ]
    );
    ?>
</section>

<section class="echo-block echo-block-articles_block bg-light-secondary">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Welcome &amp; <span class="highlight">Orientation</span>        </h2>

            </div>
<?php
$defaults = [
    'articles'        => 'Orientation',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles'])) {
        foreach ($args['articles'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles']) && isset($args['articles']->slug)) {
            $taxonomy_slugs[] = $args['articles']->slug;
        } elseif (is_numeric($args['articles'])) {
            $term_obj = get_term($args['articles'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>


<?php if (!empty($query) && $query->have_posts()) : ?>
    <div class="container pb-5">
        <div class="row g-4 align-items-stretch">
            <?php
            $count = 0;
            while ($query->have_posts()) :
                $query->the_post();
                $count++;
                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $download = get_field('file_download');
                $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
            ?>

                <?php if ($count === 1) : ?>
                    <!-- Left large article -->
                    <div class="col-lg-4">
                        <div class="boardx-card large h-100 position-relative">
                            <?php if ($image): ?>
                                <div class="featured-img">
                                    <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="article-content bottom-0 start-0 py-2">
                                <h3 class="boardx-title"><?php the_title(); ?></h3>
                                <div class="boardx-excerpt">
                                    <?php echo $description; ?>
                                </div>
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="col-lg-8 d-flex flex-column gap-4">
                <?php elseif ($count === 2) : ?>
                        <!-- Top right article -->
                        <div class="boardx-card flex-grow-1 position-relative">
                            <?php if ($image) {
                               ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100 featured-img" alt="Download Available">';
                            }  elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else {
                                
                            } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo $description; ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row flex-grow-1 g-4">
                <?php elseif ($count === 3 || $count === 4) : ?>
                            <!-- Bottom right small articles -->
                            <div class="col-6">
                                <div class="boardx-card position-relative h-100">
                                    <?php if ($image) {
                                        ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                    }  elseif($download){
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                                    } else {
                                        
                                    } ?>
                                    <div class="article-content">
                                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                        <?php echo $description; ?>
                                        <div class="mb-2">
                                        <?php if ($download): ?>
                                            <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php endif; ?>

            <?php endwhile; ?>
                        </div><!-- /.row -->
                    </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <?php wp_reset_postdata(); ?>
<?php endif; ?>

</section>
<section class="echo-block echo-block-articles_block">
    <div class="container pt-5 mb-5 ">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="valtas-cta-block__title">
                    This Month’s Feature: <span class="highlight">Succession Planning</span>
                </h2>                              
            </div>
            <div class="col-lg-6 py-2">
                <p>Want the latest board resources? Each month we’ll feature a new topic here and provide the resources your board needs to operate well across that area. This month we’re focused on succession planning. Get this month’s featured resources below!</p>
            </div>
        </div>
    </div>
<?php
$defaults = [
    'articles_2'        => 'feature',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles_2'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles_2'])) {
        foreach ($args['articles_2'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles_2']) && isset($args['articles_2']->slug)) {
            $taxonomy_slugs[] = $args['articles_2']->slug;
        } elseif (is_numeric($args['articles_2'])) {
            $term_obj = get_term($args['articles_2'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles_2']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>


<?php if (!empty($query) && $query->have_posts()) : ?>
    <div class="container pb-5">
        <div class="row g-4 align-items-stretch flex-row-reverse">
            <?php
            $count = 0;
            while ($query->have_posts()) :
                $query->the_post();
                $count++;
                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $download = get_field('file_download');
                $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
            ?>

                <?php if ($count === 1) : ?>
                    <!-- Left large article -->
                    <div class="col-lg-4">
                        <div class="boardx-card large h-100 position-relative">
                            <?php if ($image): ?>
                                <div class="featured-img ratio ratio-1x1">
                                    <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="article-content bottom-0 start-0 py-2">
                                <h3 class="boardx-title"><?php the_title(); ?></h3>
                                <div class="boardx-excerpt">
                                    <?php echo $description; ?>
                                </div>
                                
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                <div class="col-lg-8 d-flex flex-column gap-4">
                <?php elseif ($count === 2) : ?>
                        <!-- Top right article -->
                        <div class="boardx-card flex-grow-1 position-relative">
                            <?php if ($image) {
                               ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100 featured-img" alt="Download Available">';
                            } elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else {
                                
                            } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo $description; ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row flex-grow-1 g-4">
                <?php elseif ($count === 3 || $count === 4) : ?>
                            <!-- Bottom right small articles -->
                            <div class="col-6">
                                <div class="boardx-card position-relative h-100">
                                    <?php if ($image) {
                                        ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                    }   elseif($download){
                                            echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                                        } else {
                                            
                                        } ?>
                                    <div class="article-content">
                                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                        <?php echo $description; ?>
                                        <div class="mb-2">
                                        <?php if ($download): ?>
                                            <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php endif; ?>

            <?php endwhile; ?>
                        </div><!-- /.row -->
                    </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <?php wp_reset_postdata(); ?>
<?php endif; ?>

</section>
<section class="ask-section">
   <div class="container py-5">
      <div class="ask-boardx">
          <div class="ask-boardx_form">                                  
            <?php echo do_shortcode('[contact-form-7 title="Ask Us Anything"]'); ?>
          </div>                            
      </div>
   </div>
</section>
<section id="responsibilities">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Board Roles &amp; <br><span class="highlight">Responsibilities</span>
        </h2>
    </div>
    <div class="container pb-5">
        <div class="row">
    <?php
    $defaults = [
        'articles_3'        => 'responsibilities',
    ];

    $args = wp_parse_args($args ?? [], $defaults);
    // Query articles by selected taxonomy terms (archieve)
    if (!empty($args['articles_3'])) :

        // Normalize to slugs no matter the return type
        $taxonomy_slugs = [];

        if (is_array($args['articles_3'])) {
            foreach ($args['articles_3'] as $term) {
                if (is_object($term) && isset($term->slug)) {
                    $taxonomy_slugs[] = $term->slug; // Term object
                } elseif (is_numeric($term)) {
                    $term_obj = get_term($term, 'archieve');
                    if ($term_obj && !is_wp_error($term_obj)) {
                        $taxonomy_slugs[] = $term_obj->slug;
                    }
                } else {
                    $taxonomy_slugs[] = sanitize_title($term); // Already a slug
                }
            }
        } else {
            // Single selection fallback
            if (is_object($args['articles_3']) && isset($args['articles_3']->slug)) {
                $taxonomy_slugs[] = $args['articles_3']->slug;
            } elseif (is_numeric($args['articles_3'])) {
                $term_obj = get_term($args['articles_3'], 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($args['articles_3']);
            }
        }

        // Query posts by taxonomy slug(s)
        $query = new WP_Query([
            'post_type'      => 'boardspark-article',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'ASC', // oldest first
            'tax_query'      => [
                [
                    'taxonomy' => 'xarchieve',
                    'field'    => 'slug',
                    'terms'    => $taxonomy_slugs,
                ],
            ],
        ]);

    endif;
    ?>    

    <?php
        $count = 0;
        while ($query->have_posts()) :
            $query->the_post();
            $count++;
            $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $download = get_field('file_download');
            $description = get_field('description');
            $button_text = get_field('button_text') ?: 'Download File';
    ?>
        <?php if ($count === 1) : ?>
            <!-- Left large article -->
            <div class="col-lg-12 mb-2">
                <div class="boardx-card boardx-card-overlay large h-100 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="article-content bottom-0 start-0 py-2">
                        <h3 class="boardx-title"><?php the_title(); ?></h3>
                            <div class="boardx-excerpt">
                                <?php echo $description; ?>
                            </div>
                                
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                    </div>
                </div>
            </div>       
        <?php else : ?>
            <div class="col-4">
                <div class="boardx-card position-relative h-100 bg-light-secondary">
                    <?php if ($image) { ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                        <?php }   elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else {
                                
                            } ?>
                        <div class="article-content">
                            <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                            <?php echo $description; ?>
                            <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
        
        <?php endif; ?>
    <?php endwhile; ?>
    </div>
    </div>
</section>
<section class="echo-block bg-light-blue">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Board Structure & <span class="highlight">Governance</span>
        </h2>
    </div>
<?php
$defaults = [
    'articles_4'        => 'governance',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles_4'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles_4'])) {
        foreach ($args['articles_4'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles_4']) && isset($args['articles_4']->slug)) {
            $taxonomy_slugs[] = $args['articles_4']->slug;
        } elseif (is_numeric($args['articles_4'])) {
            $term_obj = get_term($args['articles_4'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles_4']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>
<div class="container pb-5">
    <div class="row g-4">
    <?php
            $count = 0;
            while ($query->have_posts()) :
                $query->the_post();
                $count++;
                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $download = get_field('file_download');
                $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
    ?>
        <?php if ($count === 1) : ?>
            <!-- Left large article -->
            <div class="col-lg-8">
                <div class="boardx-card boardx-card-overlay large h-100 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="article-content bottom-0 start-0 py-2">
                        <h3 class="boardx-title"><?php the_title(); ?></h3>
                            <div class="boardx-excerpt">
                               <?php echo $description; ?>
                            </div>
                                
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php elseif ($count === 2) : ?>
            <div class="col-lg-4">
                <div class="boardx-card flex-grow-1 position-relative">
                            <?php if ($image) {
                               ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100 featured-img" alt="Download Available">';
                            }  elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else {
                                
                            } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo $description; ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
            </div>
        <?php else : ?>
            <div class="col-lg-4">
                <div class="boardx-card position-relative h-100">
                    <?php if ($image) { ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                        <?php }   elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else {
                                
                            } ?>
                        <div class="article-content">
                            <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                            <?php echo $description; ?>
                            <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
        
        <?php endif; ?>
    <?php endwhile; ?>
    </div>
</div>
</section>

<section class="text-white gradient-bg">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Financial  <span class="highlight">Oversight</span>
        </h2>
    </div>
    <div class="container pb-5">
        <div class="row g-4">
<?php
$defaults = [
    'articles_5'        => 'financial',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles_5'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles_5'])) {
        foreach ($args['articles_5'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles_5']) && isset($args['articles_5']->slug)) {
            $taxonomy_slugs[] = $args['articles_5']->slug;
        } elseif (is_numeric($args['articles_5'])) {
            $term_obj = get_term($args['articles_5'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles_5']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>
<?php 
$count = 0;
while ($query->have_posts()) :
    $query->the_post();
    $count++;
    $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    $download = get_field('file_download');
    $description = get_field('description');
    $button_text = get_field('button_text') ?: 'Download File';
?>

    <?php if (in_array($count, [1, 2, 3])) : ?>
        <!-- SMALL CARDS -->
            <div class="col-lg-4">
                <div class="boardx-card transparent-bg position-relative h-100">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    
                    <?php elseif($download): ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/note.png'); ?>" class="img-fluid mb-3 white-icon" alt="Read More">
                    <?php else: ?>
                    <?php endif; ?>

                    <div class="article-content">
                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                        <?php echo $description; ?>
                        <div class="mb-2">
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($count === 4): ?>
            <!-- MIDDLE CARD -->
            <div class="col-lg-4">
                <div class="boardx-card transparent-bg flex-grow-1 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php elseif($download): ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/note.png'); ?>" class="img-fluid mb-3 white-icon" alt="Read More">
                    <?php else: ?>
                    <?php endif; ?>

                    <div class="article-content">
                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                        <?php echo $description; ?>
                        <div class="mb-2">
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($count === 5): ?>
            <!-- LARGE FEATURE CARD -->
            <div class="col-lg-8">
                <div class="boardx-card boardx-card-overlay large h-100 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="article-content bottom-0 start-0 py-2">
                        <h3 class="boardx-title"><?php the_title(); ?></h3>
                        <div class="boardx-excerpt">
                            <?php echo $description; ?>
                        </div>
                        <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php endwhile; ?>
    </div>
</div>

<!--fundraising-->
<div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Fundraising & Donor <span class="highlight">Engagement</span>
        </h2>
    </div>
    <div class="container pb-5">
        <div class="row g-4">
<?php
$defaults = [
    'articles_6'        => 'fundraising',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles_6'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles_6'])) {
        foreach ($args['articles_6'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles_6']) && isset($args['articles_6']->slug)) {
            $taxonomy_slugs[] = $args['articles_6']->slug;
        } elseif (is_numeric($args['articles_6'])) {
            $term_obj = get_term($args['articles_6'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles_6']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>
<?php 
$count = 0;
while ($query->have_posts()) :
    $query->the_post();
    $count++;
    $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    $download = get_field('file_download');
    $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
?>

    <?php if ( $count === 1) : ?>
        <!-- SMALL CARDS -->
            <div class="col-lg-6">
                <div class="boardx-card boardx-card-overlay large h-100 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="article-content bottom-0 start-0 py-2">
                        <h3 class="boardx-title"><?php the_title(); ?></h3>
                        <div class="boardx-excerpt">
                            <?php echo $description; ?>
                        </div>
                        <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php elseif ($count === 2): ?>
            <!-- LARGE FEATURE CARD -->
            <div class="col-lg-6">
                <div class="boardx-card transparent-bg flex-grow-1 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php elseif($download): ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/note.png'); ?>" class="img-fluid mb-3 white-icon" alt="Read More">
                    <?php else: ?>
                    <?php endif; ?>

                    <div class="article-content">
                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                        <?php echo $description; ?>
                        <div class="mb-2">
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (in_array($count, [3, 4, 5])): ?>
            <!-- MIDDLE CARD -->
            <div class="col-lg-4">
                <div class="boardx-card transparent-bg flex-grow-1 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                   
                    <?php elseif($download): ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/note.png'); ?>" class="img-fluid mb-3 white-icon" alt="Read More">
                    <?php else: ?>
                    <?php endif; ?>

                    <div class="article-content">
                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                        <?php echo $description; ?>
                        <div class="mb-2">
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        
        <?php endif; ?>

    <?php endwhile; ?>
    </div>
</div>


</section>
<section id="strategic-plan">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Strategic Planning <br><span class="highlight">And Impact</span>
        </h2>
    </div>
    <div class="container pb-5">
        <div class="row g-4">
    <?php
    $defaults = [
        'articles_7'        => 'strategic-planning',
    ];

    $args = wp_parse_args($args ?? [], $defaults);
    // Query articles by selected taxonomy terms (archieve)
    if (!empty($args['articles_7'])) :

        // Normalize to slugs no matter the return type
        $taxonomy_slugs = [];

        if (is_array($args['articles_7'])) {
            foreach ($args['articles_7'] as $term) {
                if (is_object($term) && isset($term->slug)) {
                    $taxonomy_slugs[] = $term->slug; // Term object
                } elseif (is_numeric($term)) {
                    $term_obj = get_term($term, 'archieve');
                    if ($term_obj && !is_wp_error($term_obj)) {
                        $taxonomy_slugs[] = $term_obj->slug;
                    }
                } else {
                    $taxonomy_slugs[] = sanitize_title($term); // Already a slug
                }
            }
        } else {
            // Single selection fallback
            if (is_object($args['articles_7']) && isset($args['articles_7']->slug)) {
                $taxonomy_slugs[] = $args['articles_7']->slug;
            } elseif (is_numeric($args['articles_7'])) {
                $term_obj = get_term($args['articles_7'], 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($args['articles_7']);
            }
        }

        // Query posts by taxonomy slug(s)
        $query = new WP_Query([
            'post_type'      => 'boardspark-article',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'ASC', // oldest first
            'tax_query'      => [
                [
                    'taxonomy' => 'xarchieve',
                    'field'    => 'slug',
                    'terms'    => $taxonomy_slugs,
                ],
            ],
        ]);

    endif;
    ?>    

    <?php
        $count = 0;
        while ($query->have_posts()) :
            $query->the_post();
            $count++;
            $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $download = get_field('file_download');
            $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
    ?>
        <?php if ($count === 1) : ?>
            <!-- Left large article -->
            <div class="col-lg-12 mb-2">
                <div class="boardx-card boardx-card-overlay overlay-white large h-100 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="article-content bottom-0 start-0 py-2">
                        <h3 class="boardx-title"><?php the_title(); ?></h3>
                            <div class="boardx-excerpt">
                                <?php echo $description; ?>
                            </div>
                                
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                    </div>
                </div>
            </div>       
        <?php else : ?>
            <div class="col-4">
                <div class="boardx-card position-relative h-100 bg-grey">
                    <?php if ($image) { ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                       
                        <?php } elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else { } ?>
                        <div class="article-content">
                            <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                            <?php echo $description; ?>
                            <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
        
        <?php endif; ?>
    <?php endwhile; ?>
    </div>
    </div>
</section>
<section class="echo-block echo-block-articles_block bg-light-secondary">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Board Dynamics  <span class="highlight">And Culture</span>        </h2>

            </div>
<?php
$defaults = [
    'articles_8'        => 'board-dynamics',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles_8'])) {
        foreach ($args['articles_8'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles_8']) && isset($args['articles_8']->slug)) {
            $taxonomy_slugs[] = $args['articles_8']->slug;
        } elseif (is_numeric($args['articles'])) {
            $term_obj = get_term($args['articles_8'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles_8']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>


<?php if (!empty($query) && $query->have_posts()) : ?>
    <div class="container pb-5">
        <div class="row g-4 align-items-stretch">
            <?php
            $count = 0;
            while ($query->have_posts()) :
                $query->the_post();
                $count++;
                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $download = get_field('file_download');
                $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
            ?>

                <?php if ($count === 1) : ?>
                    <!-- Left large article -->
                    <div class="col-lg-4">
                        <div class="boardx-card large h-100 position-relative">
                            <?php if ($image): ?>
                                <div class="featured-img ratio ratio-1x1">
                                    <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="article-content bottom-0 start-0 py-2">
                                <h3 class="boardx-title"><?php the_title(); ?></h3>
                                <div class="boardx-excerpt">
                                    <?php echo $description; ?>
                                </div>
                                
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="col-lg-8 d-flex flex-column gap-4">
                <?php elseif ($count === 2) : ?>
                        <!-- Top right article -->
                        <div class="boardx-card flex-grow-1 position-relative">
                            <?php if ($image) {
                               ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100 featured-img" alt="Download Available">';
                            } elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else { } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo $description; ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row flex-grow-1 g-4">
                <?php elseif ($count === 3 || $count === 4) : ?>
                            <!-- Bottom right small articles -->
                            <div class="col-6">
                                <div class="boardx-card position-relative h-100">
                                    <?php if ($image) {
                                        ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                    } elseif($download){
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                                    } else { } ?>
                                    <div class="article-content">
                                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                        <?php echo $description; ?>
                                        <div class="mb-2">
                                        <?php if ($download): ?>
                                            <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php endif; ?>

            <?php endwhile; ?>
                        </div><!-- /.row -->
                    </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <?php wp_reset_postdata(); ?>
<?php endif; ?>

</section>
<section class="echo-block">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            CEO/ED Support &amp;<span class="highlight">Evaluation</span>
        </h2>
    </div>
<?php
$defaults = [
    'articles_9'        => 'ceo-ed',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles_9'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles_9'])) {
        foreach ($args['articles_9'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles_9']) && isset($args['articles_9']->slug)) {
            $taxonomy_slugs[] = $args['articles_9']->slug;
        } elseif (is_numeric($args['articles_9'])) {
            $term_obj = get_term($args['articles_9'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles_9']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>


<?php if (!empty($query) && $query->have_posts()) : ?>
    <div class="container pb-5">
        <div class="row g-4 align-items-stretch flex-row-reverse">
            <?php
            $count = 0;
            while ($query->have_posts()) :
                $query->the_post();
                $count++;
                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $download = get_field('file_download');
                $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
            ?>

                <?php if ($count === 1) : ?>
                    <!-- Left large article -->
                    <div class="col-lg-4">
                        <div class="boardx-card large h-100 position-relative">
                            <?php if ($image): ?>
                                <div class="featured-img ratio ratio-1x1">
                                    <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="article-content bottom-0 start-0 py-2">
                                <h3 class="boardx-title"><?php the_title(); ?></h3>
                                <div class="boardx-excerpt">
                                    <?php echo $description; ?>
                                </div>
                                
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                <div class="col-lg-8 d-flex flex-column gap-4">
                <?php elseif ($count === 2) : ?>
                        <!-- Top right article -->
                        <div class="boardx-card flex-grow-1 position-relative">
                            <?php if ($image) {
                               ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100 featured-img" alt="Download Available">';
                            } elseif($download){
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } else { } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo $description; ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row flex-grow-1 g-4">
                <?php elseif ($count === 3 || $count === 4) : ?>
                            <!-- Bottom right small articles -->
                            <div class="col-6">
                                <div class="boardx-card position-relative h-100">
                                    <?php if ($image) {
                                        ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                    } elseif($download){
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                                    } else { } ?>
                                    <div class="article-content">
                                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                        <?php echo $description; ?>
                                        <div class="mb-2">
                                        <?php if ($download): ?>
                                            <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php endif; ?>

            <?php endwhile; ?>
                        </div><!-- /.row -->
                    </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
<div class="container">
    <hr class="my-4">
</div>
<div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Board Recruitment &<br><span class="highlight">Onboarding</span>
        </h2>
    </div>
    <div class="container pb-5">
        <div class="row g-4">
<?php
$defaults = [
    'articles_10'        => 'board-recruitment',
];

$args = wp_parse_args($args ?? [], $defaults);
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles_10'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles_10'])) {
        foreach ($args['articles_10'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles_10']) && isset($args['articles_6']->slug)) {
            $taxonomy_slugs[] = $args['articles_10']->slug;
        } elseif (is_numeric($args['articles_10'])) {
            $term_obj = get_term($args['articles_10'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles_10']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardspark-article',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>
<?php 
$count = 0;
while ($query->have_posts()) :
    $query->the_post();
    $count++;
    $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    $download = get_field('file_download');
    $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
?>

    <?php if ( $count === 1) : ?>
        <!-- SMALL CARDS -->
            <div class="col-lg-6">
                <div class="boardx-card boardx-card-overlay large h-100 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="article-content bottom-0 start-0 py-2">
                        <h3 class="boardx-title"><?php the_title(); ?></h3>
                        <div class="boardx-excerpt">
                            <?php echo $description; ?>
                        </div>
                        <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php elseif ($count === 2): ?>
            <!-- LARGE FEATURE CARD -->
            <div class="col-lg-6">
                <div class="boardx-card bg-light-secondary flex-grow-1 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php elseif($download): ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/note.png'); ?>" class="img-fluid mb-3 white-icon" alt="Read More">
                    <?php else: ?>
                    <?php endif; ?>

                    <div class="article-content">
                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                        <?php echo $description; ?>
                        <div class="mb-2">
                            <?php if ($download): ?>
                                <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (in_array($count, [3, 4, 5])): ?>
            <!-- MIDDLE CARD -->
            <div class="col-lg-4">
                <div class="boardx-card bg-light-secondary flex-grow-1 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php elseif($download): ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/note.png'); ?>" class="img-fluid mb-3 white-icon" alt="Read More">
                    <?php else: ?>
                    <?php endif; ?>

                    <div class="article-content">
                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                        <?php echo $description; ?>
                        <div class="mb-2">
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        
        <?php endif; ?>

    <?php endwhile; ?>
    </div>
</div>

</section>
<section class="echo-block bg-light-blue">
    <div class="container pt-5 mb-5 header-title-center">
        <h2 class="valtas-cta-block__title">
            Equity & Inclusion  <br><span class="highlight">in Governance</span>
        </h2>
    </div>
    <div class="container pb-5">
        <div class="row g-4">
    <?php
    $defaults = [
        'articles_11'        => 'equity-inclusion',
    ];

    $args = wp_parse_args($args ?? [], $defaults);
    // Query articles by selected taxonomy terms (archieve)
    if (!empty($args['articles_11'])) :

        // Normalize to slugs no matter the return type
        $taxonomy_slugs = [];

        if (is_array($args['articles_11'])) {
            foreach ($args['articles_11'] as $term) {
                if (is_object($term) && isset($term->slug)) {
                    $taxonomy_slugs[] = $term->slug; // Term object
                } elseif (is_numeric($term)) {
                    $term_obj = get_term($term, 'archieve');
                    if ($term_obj && !is_wp_error($term_obj)) {
                        $taxonomy_slugs[] = $term_obj->slug;
                    }
                } else {
                    $taxonomy_slugs[] = sanitize_title($term); // Already a slug
                }
            }
        } else {
            // Single selection fallback
            if (is_object($args['articles_11']) && isset($args['articles_11']->slug)) {
                $taxonomy_slugs[] = $args['articles_11']->slug;
            } elseif (is_numeric($args['articles_11'])) {
                $term_obj = get_term($args['articles_11'], 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($args['articles_11']);
            }
        }

        // Query posts by taxonomy slug(s)
        $query = new WP_Query([
            'post_type'      => 'boardspark-article',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'ASC', // oldest first
            'tax_query'      => [
                [
                    'taxonomy' => 'xarchieve',
                    'field'    => 'slug',
                    'terms'    => $taxonomy_slugs,
                ],
            ],
        ]);

    endif;
    ?>    

    <?php
        $count = 0;
        while ($query->have_posts()) :
            $query->the_post();
            $count++;
            $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $download = get_field('file_download');
            $description = get_field('description');
                $button_text = get_field('button_text') ?: 'Download File';
    ?>
        <?php if ($count === 1) : ?>
            <!-- Left large article -->
            <div class="col-lg-12 mb-2">
                <div class="boardx-card boardx-card-overlay overlay-white large h-100 position-relative">
                    <?php if ($image): ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="article-content bottom-0 start-0 py-2">
                        <h3 class="boardx-title"><?php the_title(); ?></h3>
                            <div class="boardx-excerpt">
                                <?php echo $description; ?>
                            </div>
                                
                            <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                    </div>
                </div>
            </div>       
        <?php else : ?>
            <div class="col-4">
                <div class="boardx-card position-relative h-100 bg-white">
                    <?php if ($image) { ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                        <?php } elseif($download){
                            echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                        } else { } ?>
                        <div class="article-content">
                            <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                            <?php echo $description; ?>
                            <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download><?php echo $button_text; ?></a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
        
        <?php endif; ?>
    <?php endwhile; ?>
    </div>
    </div>
</section>

<?php

endif;
// ENDS - hide custom fields with PPWP password protection

get_footer(); ?>
