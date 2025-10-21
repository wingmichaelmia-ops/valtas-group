<?php
/**
 * Template Name: Members Area
 * Description: Private page for logged-in users only, using ACF renderer partial.
 */

global $post;

/**
 * Redirect logged-out users if page is restricted via Members plugin
 */
if (
	function_exists( 'members_is_post_content_restricted' ) &&
	isset( $post->ID ) &&
	members_is_post_content_restricted( $post->ID )
) {
	if ( ! is_user_logged_in() ) {
		// Custom login URL for your local site
		$login_url = '/login/';
		$redirect  = add_query_arg( 'redirect_to', urlencode( get_permalink( $post->ID ) ), $login_url );

		wp_redirect( $redirect );
		exit;
	}
}

get_header();
?>

<style>
    .page-title__content {
        max-width: 477px;
    }
    .echo-block-page_title img.bg-image:nth-child(2) {
        display: none;
    }
</style>
<section class="echo-block echo-block-page_title">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'page_title',
        [
            'title'      => 'BoardX <span class="highlight">Archive</span>', // use the post title dynamically
            'title_tag'  => 'h1',
            'content'    => ' BoardX is a free, invitation-only resource hub powered by Valtas that equips nonprofit boards with tools, insights, and connections to grow their eXperience, eXpertise, and eXcellence, with a monthly donation from Valtas to every nonprofit whose board engages with the platform that month.',
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
        'post_type'      => 'boardx-article',
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
                                    <?php echo wp_kses_post( wp_trim_words( get_the_content(), 30, '...' ) ); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="stretched-link opacity-0"></a>
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
                            } else {
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo get_the_content(); ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download>Download File</a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row flex-grow-1 g-4">
                <?php elseif ($count === 3 || $count === 4) : ?>
                            <!-- Bottom right small articles -->
                            <div class="col-6">
                                <div class="boardx-card small position-relative h-100">
                                    <?php if ($image) {
                                        ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                    } elseif ($download) {
                                        ?>
                                        <div class="newspaper-holder">
                                        <?php
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100" alt="Download Available">';
                                        ?>
                                        </div>
                                        <?php
                                    } else {
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                                    } ?>
                                    <div class="article-content">
                                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                        <?php echo get_the_content(); ?>
                                        <div class="mb-2">
                                        <?php if ($download): ?>
                                            <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download>Download File</a>
                                        <?php else: ?>
                                            <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
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
                <p>Rotating spotlight on a topic of near-term importance for boards, with handpicked resources to help your board focus where it matters most</p>
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
        'post_type'      => 'boardx-article',
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
                                    <?php echo wp_kses_post( wp_trim_words( get_the_content(), 30, '...' ) ); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="stretched-link opacity-0"></a>
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
                            } else {
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo get_the_content(); ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download>Download File</a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row flex-grow-1 g-4">
                <?php elseif ($count === 3 || $count === 4) : ?>
                            <!-- Bottom right small articles -->
                            <div class="col-6">
                                <div class="boardx-card small position-relative h-100">
                                    <?php if ($image) {
                                        ?>
                                        <div class="featured-img">
                                        <?php
                                        echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                                        ?>
                                        </div>
                                        <?php
                                    } elseif ($download) {
                                        ?>
                                        <div class="newspaper-holder">
                                        <?php
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100" alt="Download Available">';
                                        ?>
                                        </div>
                                        <?php
                                    } else {
                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                                    } ?>
                                    <div class="article-content">
                                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                        <?php echo get_the_content(); ?>
                                        <div class="mb-2">
                                        <?php if ($download): ?>
                                            <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download>Download File</a>
                                        <?php else: ?>
                                            <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
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
            'post_type'      => 'boardx-article',
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
                                <?php echo wp_kses_post( wp_trim_words( get_the_content(), 30, '...' ) ); ?>
                            </div>
                                
                            <a href="<?php the_permalink(); ?>" class="stretched-link opacity-0"></a>
                    </div>
                </div>
            </div>       
        <?php else : ?>
            <div class="col-4">
                <div class="boardx-card small position-relative h-100 bg-light-secondary">
                    <?php if ($image) { ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                        <?php } elseif ($download) { ?>
                            <div class="newspaper-holder">
                                <?php echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100" alt="Download Available">'; ?>
                            </div>
                        <?php } else {
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } ?>
                        <div class="article-content">
                            <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                            <?php echo get_the_content(); ?>
                            <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download>Download File</a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
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
        'post_type'      => 'boardx-article',
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
                                <?php echo wp_kses_post( wp_trim_words( get_the_content(), 30, '...' ) ); ?>
                            </div>
                                
                            <a href="<?php the_permalink(); ?>" class="stretched-link opacity-0"></a>
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
                            } else {
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo get_the_content(); ?>
                                <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download>Download File</a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
            </div>
        <?php else : ?>
            <div class="col-lg-4">
                <div class="boardx-card small position-relative h-100">
                    <?php if ($image) { ?>
                        <div class="featured-img">
                            <?php
                                echo '<img src="' . esc_url($image) . '" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                        <?php } elseif ($download) { ?>
                            <div class="newspaper-holder">
                                <?php echo '<img src="' . esc_url(get_template_directory_uri() . '/img/newspaper.jpg') . '" class="img-fluid w-100" alt="Download Available">'; ?>
                            </div>
                        <?php } else {
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/note.png') . '" class="img-fluid mb-3" alt="Read More">';
                            } ?>
                        <div class="article-content">
                            <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                            <?php echo get_the_content(); ?>
                            <div class="mb-2">
                                <?php if ($download): ?>
                                    <a href="<?php echo esc_url($download); ?>" class="text-decoration-underline" download>Download File</a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
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
<?php get_footer(); ?>
