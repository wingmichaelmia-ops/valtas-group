<?php

$default = array(
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'content' ),
    "steps"         => get_sub_field( 'steps' ) ?: array(),
    "cta"           => get_sub_field( 'cta_title' ),
    "link"          => get_sub_field( 'link' ) ?: array()
);

$args = wp_parse_args( $args, $default );

?>

<div class="block-how_we_work padding-normal position-relative overflow-hidden to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12 col-lg-10 mx-auto">
                <h3 class="h2 text-center to-fade" data-delay="0.2"><?php echo $args['title'] ?></h3>
                <?php if ( $args['content'] ) : ?>
                    <p class="h4 text-center to-fade" data-delay="0.3"><?php echo $args['content'] ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php if ( $steps = $args['steps'] ) : ?>
            <!-- <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 how_we_work-row mt-5 position-relative">
                <div class="how_we_work-line position-absolute bg-warning"></div>
                <?php foreach( $steps as $key => $step ) : ?>
                    <div class="col mb-4 mb-lg-0 position-relative">
                        <div class="px-xl-3 h-100">
                            <div class="how_we_work-step text-center text-md-start position-relative p-4 h-100">
                                <span class="count d-flex justify-content-center align-items-center rounded-circle position-absolute fw-bold h3"><?php echo $key + 1 ?></span>
                                <span class="product-card-title text-primary mb-3 d-block h5"><?php echo $step['title'] ?></span>
                                <p><?php echo $step['content'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> -->

            <?php
                $swiper_options = array(
                    "slidesPerView" => 1,
                    "spaceBetween"  => 30,
                    "loop"          => false,
                    "autoplay"      => array(
                        "delay"     => 2500
                    ),
                    "breakpoints"   => array(
                        992 => array(
                            "slidesPerView" => 4,
                        )
                    ),  
                    'navigation'    => array(
                        'nextEl'    => '.swiper-button-next.how-we-work-nav-' . $args['block_index'],
                        'prevEl'    => '.swiper-button-prev.how-we-work-nav-' . $args['block_index'],
                    )
                );
            ?>

            <div class="row how_we_work-row mt-5 position-relative to-fade" data-delay="0.4">
                <div class="how_we_work-line position-absolute bg-warning"></div>
                <div class="col col-12">
                    <div class="swipwer auto-init" data-options='<?php echo json_encode( $swiper_options ) ?>'>
                        <div class="swiper-wrapper">
                            <?php foreach( $steps as $key => $step ) : ?>
                                <div class="swiper-slide mb-4 mb-lg-0 position-relative h-auto">
                                    <div class="px-xl-3 h-100">
                                        <div class="how_we_work-step text-center text-md-start position-relative p-4 h-100">
                                            <span class="count d-flex justify-content-center align-items-center rounded-circle position-absolute fw-bold h3"><?php echo $key + 1 ?></span>
                                            <span class="product-card-title text-primary mb-3 d-block h5"><?php echo $step['title'] ?></span>
                                            <p><?php echo $step['content'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="swiper-button-prev swiper-nav-outside how-we-work-nav-<?php echo $args['block_index'] ?>"></div>
                        <div class="swiper-button-next swiper-nav-outside how-we-work-nav-<?php echo $args['block_index'] ?>"></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $link = $args['link'] ) : ?>
            <div class="row to-fade" data-delay="0.5">
                <div class="col col-12">
                    <div class="justify-content-center d-flex flex-wrap align-items-center">
                        <p class="h4 d-inline text-center text-md-end mt-4 mt-md-5"><?php echo $args['cta'] ?></p>
                        <a href="<?php echo $link['url'] ?>" <?php echo $link['target'] ?> class="btn btn-secondary mt-1 mt-md-5 ms-0 ms-md-3"><?php echo $link['title'] ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>