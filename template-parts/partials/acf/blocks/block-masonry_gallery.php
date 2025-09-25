<?php

$defaults = array(
    "images"    => get_sub_field( 'images' ) ?: array() // array of image urls
);

$args = wp_parse_args( $args, $defaults );

$image_chunks = array_chunk( $args['images'], 3 ); // split images into chunks of 3.

$swiper_options = array(
    "slidesPerView" => 1,
    "spaceBetween"  => 20,
    "breakpoints"   => array(
        1000 => array(
            "slidesPerView" => 2,
        )
    )
);

?>

<div class="block-masonry_gallery position-relative overflow-hidden to-fade" data-delay="0.1">

    <div class="masonry_gallery-swiper swiper auto-init" data-options='<?php echo json_encode( $swiper_options ) ?>'>
        <div class="swiper-wrapper">
            <?php 
                foreach( $image_chunks as $image_chunk ) {
                    ?>
                    <div class="swiper-slide">
                        <div class="position-relative overflow-hidden ratio-50">
                        <?php
                            foreach( $image_chunk as $chunk_key => $image_url ) {
                                ?>
                                    <div class="masonry-image position-absolute masonry-image-<?php echo $chunk_key ?> echo-lazy bg" data-bg="true" data-src="<?php echo $image_url ?>"></div>
                                <?php
                            }
                        ?>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>

</div>