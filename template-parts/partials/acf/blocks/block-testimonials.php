<?php

$default = array(
    "title"     => get_sub_field( 'title' ),
    "reviews"   => get_sub_field( 'reviews' ),
    "link"      => get_sub_field( 'link' ) ?: array(),
    "link_2"    => get_sub_field( 'link_2' ) ?: array(),
);

$args = wp_parse_args( $args, $default );

?>

<div class="block-testimonials padding-normal position-relative to-fade" data-delay="0.1">

    <img src="<?php echo get_template_directory_uri() ?>/assets/logo-circle-white.svg" width="100" height="100" class="testimonials-content-badge position-absolute start-0 w-auto translate-middle-x" alt="Badge">

    <div class="container position-relative">
        <div class="row">
            <div class="col col-12 to-fade" data-delay="0.2">
                <?php if ($args['title']) { ?>
                <h2 class="h2 text-center"><?php echo $args['title']; ?></h2>
                <?php } ?>
            </div>
            <div class="col col-12 position-relative overflow-visible to-fade" data-delay="0.3">
                <?php
                    $testimonial_options = array(
                        'slidesPerView' => 1,
                        'spaceBetween'  => 30,
                        'loop'          => true,
                        'breakpoints'   => array(
                            769 => array(
                                'slidesPerView' => 2
                            ),
                            1200 => array(
                                'slidesPerView' => 3
                            ),
                            1300 => array(
                                'slidesPerView' => 4
                            )
                            ),
                            
                        'navigation'    => array(
                            'nextEl'    => '.swiper-button-next.testimonial-carousel-nav-' . $args['block_index'],
                            'prevEl'    => '.swiper-button-prev.testimonial-carousel-nav-' . $args['block_index'],
                        )
                    )
                ?>
                <div class="swiper auto-init" data-options='<?php echo json_encode( $testimonial_options ) ?>'>
                    <div class="swiper-wrapper">
                        <?php
                            $reviews = new WP_Query( array(
                                "post_type"     => "echo_reviews",
                                "post__in"      => $args['reviews']
                            ));
                            if ( $reviews->have_posts() ) {
                                while( $reviews->have_posts() ) {
                                    $reviews->the_post();
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="shadow-offset">
                                            <?php get_template_part( 'templates/loops/content', 'echo_reviews' ) ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                            wp_reset_postdata();
                        ?>
                    </div>
                </div>
                
                <div class="swiper-button-prev swiper-nav-outside testimonial-carousel-nav-<?php echo $args['block_index'] ?>"></div>
                <div class="swiper-button-next swiper-nav-outside testimonial-carousel-nav-<?php echo $args['block_index'] ?>"></div>

            </div>

            <div class="col col-12 text-center">
                <?php if ( $link = $args['link'] ) : ?>
                    <a href="<?php echo $link['url'] ?>" class="btn btn-primary mt-4" target="<?php echo $link['target'] ?>"><?php echo $link['title'] ?></a>
                <?php endif; ?>
                <?php if ( $link = $args['link_2'] ) : ?>
                    <a href="<?php echo $link['url'] ?>" class="btn btn-secondary mt-4" target="<?php echo $link['target'] ?>"><?php echo $link['title'] ?></a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>