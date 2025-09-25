<?php

$defaults = array(
    "title"     => get_sub_field( 'title' ),
    "content"   => get_sub_field( 'content' ),
    "products"  => get_sub_field( 'products' ) ?: array()   
);

$args = wp_parse_args( $args, $defaults );

?>

<div class="block-featured_products padding-normal d-block w-100 position-relative to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12">
                <h3 class="h2 text-center to-fade" data-delay="0.2"><?php echo $args['title'] ?></h3>
                <?php if ( $args['content'] ) : ?>
                    <p class="h4 text-center to-fade" data-delay="0.3"><?php echo $args['content'] ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col col-12 position-relative to-fade" data-delay="0.4">
                <?php 

                    $featured_products = new WP_Query( array(
                        "post_type" => 'product',
                        "post__in" => $args['products']
                    ));

                    $featured_product_swiper_options = array(
                        'slidesPerView'  => 2,
                        'spaceBetween'   => 30,
                        'breakpoints'    => array(
                            600 => array(
                                'slidesPerView' => 3,
                            ),
                            // 769 => array(
                            //     'slidesPerView' => 3,
                            // ),
                            1200 => array(
                                'slidesPerView' => 4,
                                'spaceBetween'  => 20,
                            ),
                            1300 => array(
                                'slidesPerView' => 5,
                            )
                            ),
                            'navigation'    => array(
                                'nextEl'    => '.swiper-button-next.featured_product_swiper-nav-' . $args['block_index'],
                                'prevEl'    => '.swiper-button-prev.featured_product_swiper-nav-' . $args['block_index'],
                            )
                    );

                    if ( $featured_products->have_posts() ) {
                        ?><div class="featured_product_swiper swiper auto-init mt-3 mt-md-4" data-options='<?php echo json_encode( $featured_product_swiper_options ) ?>'><div class="swiper-wrapper"><?php
                            while( $featured_products->have_posts() ) {
                                $featured_products->the_post();
                                echo '<div class="swiper-slide h-auto">';
                                get_template_part( 'templates/loops/content', 'product' );
                                echo '</div>';
                            }
                        ?></div></div><?php
                        wp_reset_postdata();
                    }

                ?>
                <div class="swiper-button-prev swiper-nav-outside featured_product_swiper-nav-<?php echo $args['block_index'] ?>"></div>
                <div class="swiper-button-next swiper-nav-outside featured_product_swiper-nav-<?php echo $args['block_index'] ?>"></div>

            </div>
        </div>
    </div>
</div>