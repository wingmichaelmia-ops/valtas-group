<?php
    $default = array(
        "alignment"      => get_sub_field( 'alignment' ),
        "title"          => get_sub_field( 'title' ) ? : "Please enter title",
        "text"           => get_sub_field( 'text' ), // array of image URLs
        "logos"          => get_sub_field( 'logos' ),
        "link"           => get_sub_field( 'link' ) ?: array()
    );
    
    $args = wp_parse_args( $args, $default );

    $text_alignment = 'text-' . $args['alignment'];
?>

<div class="logo-carousel padding-normal to-fade" data-delay="0.1">
    <div class="container to-fade" data-delay="0.2">
        <div class="<?php echo $text_alignment; ?>">
            <?php if ($args['title']) { ?>
            <h2 class="h2 <?php echo $text_alignment; ?>"><?php echo $args['title']; ?></h2>
            <?php } ?>
            <?php if ($args['text']) { ?>
            <p class="h4"><?php echo $args['text']; ?></p>
            <?php } ?>
            <?php if ($args['logos']) { ?>
            <div class="mt-5">
                <?php
                    $swiper_options = array(
                        "slidesPerView" => 1,
                        "spaceBetween"  => 30,
                        "loop"          => true,
                        "centeredSlides" => true,
                        "breakpoints"   => array(
                            769 => array(
                                "slidesPerView" => 3,
                            ),
                            1280 => array(
                                "slidesPerView" => 4,
                            ),
                            1340 => array(
                                "slidesPerView" => count( $args['logos'] ),
                            )
                        ),  
                        'navigation'    => array(
                            'nextEl'    => '.swiper-button-next.logo-carousel-nav-' . $args['block_index'],
                            'prevEl'    => '.swiper-button-prev.logo-carousel-nav-' . $args['block_index'],
                        ),
                        "autoplay"      => array(
                            "delay"     => 2500
                        ),
                    );
                ?>
                <div class="position-relative to-fade" data-delay="0.3">
                    <div class="logo-carousel-swiper swiper auto-init" data-options='<?php echo json_encode( $swiper_options ) ?>'>
                        <div class="swiper-wrapper">
                            <?php foreach ($args['logos'] as $logo) : if ( $logo['image'] ) : ?>
                                <div class="swiper-slide">
                                    <img data-src="<?php echo $logo['image']['url']; ?>" class="echo-lazy logo-carousel-image" width="100" height="60" alt="image-key">
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="swiper-button-prev swiper-nav-outside logo-carousel-nav-<?php echo $args['block_index'] ?>"></div>
                    <div class="swiper-button-next swiper-nav-outside logo-carousel-nav-<?php echo $args['block_index'] ?>"></div>
                </div>
            </div>
            <?php } ?>

            <?php if ( $link = $args['link'] ) : ?>
                <div class="logo-carousel-cta mt-5 <?php echo $text_alignment ?> to-fade" data-delay="0.4">
                    <a href="<?php echo $link['url'] ?>" target="<?php echo $link['target'] ?>" class="btn btn-primary"><?php echo $link['title'] ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>