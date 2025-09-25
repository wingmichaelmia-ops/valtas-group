<?php

$default = array(
    "title"             => get_sub_field( 'title' ) ?: '',
    "content"           => get_sub_field( 'content' ) ?: "Please enter cntent",
    "images"            => get_sub_field( 'images' ) ?: array(), // array of image URLs
    "image_position"    => get_sub_field( 'image_position' ) ?: "right", // left OR right
    "design"            => get_sub_field( 'design' ) ?: "white"
);

$args = wp_parse_args( $args, $default );

$swiper_options = array(
    "autoplay"  => array(
        "speed"     => 3000
    )
);

?>

<div class="block-image_and_content position-relative overflow-hidden padding-normal block-style-<?php echo $args['design'] ?> <?php echo ( $args['image_position'] == 'right' ) ? 'image-on-end' : 'image-on-start'; ?>">

    <img src="<?php echo get_template_directory_uri() ?>/assets/logo-circle-gray.svg" alt="Badge" width="100" height="100" class="block-image_and_content-badge position-absolute w-auto opacity-50 block-image_and_content-start" />
    <img src="<?php echo get_template_directory_uri() ?>/assets/logo-circle-white.svg" alt="Badge" width="100" height="100" class="block-image_and_content-badge position-absolute w-auto opacity-50 block-image_and_content-end" />

    <div class="container position-relative to-fade" data-delay="0.1">
        <div class="row justify-content-between align-items-center">
            <div class="col col-12 col-md-4 <?php echo ( $args['image_position'] == 'right' ) ? "order-md-2" : "order-md-1" ?> to-fade" data-delay="0.2">
                <div class="image-conent-swiper swiper auto-init my-3" data-options='<?php echo json_encode( $swiper_options ) ?>'>
                    <div class="swiper-wrapper">
                        <?php foreach( $args['images'] as $image ) : ?>
                            <div class="swiper-slide">
                                <div class="ratio-100 bg echo-lazy" data-bg="true" data-src="<?php echo $image ?>"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col col-12 col-md-7 order-md-1 to-fade" data-delay="0.3">
                <div class="px-5">
                    <?php if ( $args['title'] ) : ?>
                        <h3 class="h2 text-primary"><?php echo $args['title'] ?></h3>
                    <?php endif; ?>
                    <div class="wysiwyg">
                        <?php echo $args['content'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>