<?php

$default = array(
    "posts"         => get_sub_field( 'posts' ) ?: array(),
    "position"      => get_sub_field( 'position' ) ?: 'right'
);

$args = wp_parse_args( $args, $default );

$placeholder_image = get_template_directory_uri() . '/assets/header-placeholder.jpg';

$swiper_options = array(
    'slidesPerView' => 1,
    'spaceBetween'  => 30,
    'autoHeight'    => false,
    'effect'        => 'fade',
    'loop'          => true,
    'navigation'    => array(
        'nextEl'    => '.swiper-button-next.featured-post-case_study-nav-' . $args['block_index'],
        'prevEl'    => '.swiper-button-prev.featured-post-case_study-nav-' . $args['block_index'],
    ),
    // "breakpoints"   => array(
    //     769 => array(
    //         'autoHeight'    => true,
    //     ),
    // )
);

?>

<div class="block-featured_posts padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12 position-relative to-fade" data-delay="0.2">

                <div class="swiper auto-init" data-options='<?php echo json_encode( $swiper_options ) ?>'>
                    <div class="swiper-wrapper">
                        <?php
                            $_posts = new WP_Query( array(
                                'post_type'         => 'echo_case_studies',
                                // 'posts__in'         => $args['posts'],
                                // 'posts_per_page'    => ( count( $args['posts'] ) ) ?: 5
                            ));

                            if ( $_posts->have_posts() ) {


                                while( $_posts->have_posts() ) {
                                        
                                        
                                    $_posts->the_post();

                                    $image_url = get_the_post_thumbnail_url() ?: $placeholder_image;

                                    ?>
                                    <div class="swiper-slide h-auto">
                                        <div class="featured-content h-100 featured-content-fade <?php echo $args['position'] == 'left' ? 'bg-x-left' : 'bg-x-right' ?> position-relative">
                                            <div class="row h-100 justify-content-between position-relative">
                                                <div class="col col-12 col-md-6 position-relative fade-content <?php echo $args['position'] == 'left' ? 'order-md-2' : 'col-lg-5' ?>">
                                                    <img
                                                        data-src="<?php echo get_template_directory_uri() ?>/assets/leaf-branch-white.svg"
                                                        width="176.492" height="174.415" alt="leaf branch"
                                                        class="echo-lazy featured-content-fade-branch position-absolute bottom-0"
                                                    />
                                                    <div class="wysiwyg featured-post-data position-relative">
                                                        <span class="fw-bold text-uppercase">Case Study</span>
                                                        <h3 class="h2 mt-3"><?php the_title() ?></h3>

                                                        <div class="excerpt mb-4">
                                                            <?php echo wp_trim_words( get_the_content() ) ?>
                                                        </div>

                                                        <a href="<?php echo get_the_permalink() ?>" class="btn btn-primary">Read more</a>
                                                        <a href="<?php echo get_post_type_archive_link( 'echo_case_studies' ) ?>" class="btn btn-secondary">See more case studies</a>
                                                    </div>
                                                </div>
                                                <div class="col col-12 col-md-6 echo-lazy bg" data-bg="true" data-src="<?php echo $image_url ?>">
                                                    <!--  -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                            wp_reset_postdata();
                        ?>
                    </div>
                    <div class="position-absolute swiper-nav-custom_post-wrapper d-flex align-items-center pos-<?php echo $args['position'] ?> to-fade" data-delay="0.3">
                        <div class="swiper-button-prev swiper-nav-custom_post featured-post-case_study-nav-<?php echo $args['block_index'] ?>"></div>
                        <div class="swiper-button-next swiper-nav-custom_post featured-post-case_study-nav-<?php echo $args['block_index'] ?>"></div>
                    </div>
                </div>

                
                
            </div>
        </div>
    </div>
</div>