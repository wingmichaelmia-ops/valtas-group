<?php

$default = array(
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'content' ),
    "images"        => get_sub_field( 'images' ) ?: array() // array of image URLs
);

$args = wp_parse_args( $args, $default );

?>

<div class="block-featured_content featured_content-collage padding-normal position-relative to-fade" data-delay="0.1">

    <div class="container">
        <div class="row">
            <div class="col col-12">
                <div class="featured-content position-relative to-fade" data-delay="0.2">
                    
                    <div class="position-absolute overflow-hidden w-100 h-100 top-0 start-0">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/logo-circle-white.svg" width="100" height="100" class="featured-content-badge position-absolute start-50 translate-middle-x opacity-50" alt="Badge">
                    </div>

                    <div class="row justify-content-between position-relative to-fade" data-delay="0.3">
                        <div class="col col-12 col-md-6 col-lg-5">
                            <div class="wysiwyg">
                                <?php if ( $title = $args['title'] ) : ?>
                                    <h3 class="h2"><?php echo $title ?></h3>
                                <?php endif; ?>
                                <?php echo $args['content'] ?>
                            </div>
                        </div>

                        <div class="col col-12 col-md-6 to-fade" data-delay="0.3">
                            <div class="d-none d-md-block featured-collage position-relative">
                                <?php
                                    foreach( $args['images'] as $key => $image_url ) {
                                        echo sprintf(
                                            '<div class="collage-image echo-lazy bg collage-image-%s" data-bg="true" data-src="%s"></div>',
                                            $key,
                                            $image_url
                                        );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="d-block d-md-none" style="margin-top: -30px;">
                    <div class="swiper auto-init" data-options='<?php echo json_encode( array( "autoplay" => array( "delay" => 1500 ) ) ) ?>'>
                        <div class="swiper-wrapper">
                            <?php
                                foreach( $args['images'] as $key => $image_url ) {
                                    echo sprintf(
                                        '<div class="swiper-slide"><div class="echo-lazy bg ratio-70" data-bg="true" data-src="%s"></div></div>',
                                        $image_url
                                    );
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>