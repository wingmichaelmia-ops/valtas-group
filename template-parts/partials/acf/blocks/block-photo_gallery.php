<?php

$default = array(
    "title"        => get_sub_field( 'title' ) ?: "Please enter title",
    "content"      => get_sub_field( 'content' ) ?: false,
    "gallery"      => get_sub_field( 'gallery' ) ?: false,
    "alignment"    => get_sub_field( 'text_alignment' ) ?: "start",
);

$args = wp_parse_args( $args, $default );

?>

<div class="photo-gallery padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12 to-fade" data-delay="0.2">
                <div class="text-md-<?php echo $args['alignment'] ?>">
                    <?php if ($args['title']) { ?>
                        <h2 class="h2 text-<?php echo $args['alignment'] ?>"><?php echo $args['title']; ?></h2>
                    <?php } ?>
                    <?php if ($args['content']) { ?>
                        <p class="h4"><?php echo $args['content']; ?></p>
                    <?php } ?>
                </div>

                <?php if ($args['gallery']) { ?>
                <div class="mt-5">
                    <?php
                        $swiper_options = array(
                            "slidesPerView" => 1,
                            "spaceBetween"  => 30,
                            "loop"          => true,
                            "breakpoints"   => array(
                                769 => array(
                                    "slidesPerView" => 1,
                                    "spaceBetween"  => 30,
                                ),
                                1340 => array(
                                    "slidesPerView" => 3,
                                    "spaceBetween"  => 90,
                                )
                            ),
                            'navigation'    => array(
                                'nextEl'    => '.swiper-button-next.logo-carousel-nav-' . $args['block_index'],
                                'prevEl'    => '.swiper-button-prev.logo-carousel-nav-' . $args['block_index'],
                            )
                        );
                    ?>
                    <div class="position-relative to-fade" data-delay="0.3">
                        <div class="photo-gallery-swiper swiper auto-init" data-options='<?php echo json_encode( $swiper_options ) ?>'>
                            <div class="swiper-wrapper">
                                <?php foreach ($args['gallery'] as $gallery_item) : ?>
                                    <div class="swiper-slide">
                                        <?php if ($gallery_item['image']) { ?>
                                        <img src="<?php echo $gallery_item['image']['url']; ?>" alt="<?php echo $gallery_item['image']['alt']; ?>">
                                        <?php } ?>
                                        <?php if ($gallery_item['title']) { ?>
                                        <h3 class="h3 mt-4"><?php echo $gallery_item['title']; ?></h3>
                                        <?php } ?>
                                        <?php if ($gallery_item['description']) { ?>
                                        <div class="mt-4">
                                            <?php echo $gallery_item['description']; ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="swiper-button-prev swiper-nav-outside logo-carousel-nav-<?php echo $args['block_index'] ?>"></div>
                        <div class="swiper-button-next swiper-nav-outside logo-carousel-nav-<?php echo $args['block_index'] ?>"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>