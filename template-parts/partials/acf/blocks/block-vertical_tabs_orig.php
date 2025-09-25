<?php

$default = array(
    "title"     => get_sub_field( 'title' ),
    "content"   => get_sub_field( 'content' ),
    "tabs"      => get_sub_field( 'tabs' ) ?: array()
);

$args = wp_parse_args( $args, $default );

$gallery_options = array(
    'slidesPerView' => 2
);

?>

<div class="padding-normal">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-12 col-xxl-9">
                <?php if ( $args['title'] ) : ?>
                    <h3 class="h2 text-center"><?php echo $args['title'] ?></h3>
                <?php endif; ?>
                <?php if ( $args['content'] ) : ?>
                    <div class="text-center fw-bold"><?php echo $args['content'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container-left pe-0 pt-5 vertical-tab vertical-tab-block_<?php echo $args['block_id'] ?>">
        <div class="row mx-0">
            <div class="col col-12 px-0">
                <?php if ( $tabs = $args['tabs'] ) : ?>
                    <div class="row mx-0">
                        <div class="col col-12 col-lg-5 col-xxl-4 px-0">
                            <?php foreach( $tabs as $key => $tab ) : ?>
                                <div 
                                    data-key="<?php echo $key ?>"
                                    data-target="#vertical-tab-content-block_<?php echo $args['block_id'] ?>-iteration_<?php echo $key ?>"
                                    class="vertical-tab-toggler <?php echo ( ! $key ) ? "on" : "" ?> d-flex align-items-center w-100">
                                    <?php if ( $icon = $tab['icon'] ) : ?>
                                        <img src="<?php echo $icon['url'] ?>" class="vertical-tab-icon my-0" alt="<?php echo esc_attr( $tab['title'] ) ?>" width="<?php echo $icon['width'] ?>" height="<?php echo $icon['height'] ?>" />
                                        <p class="my-0 text-green fw-bold"><?php echo $tab['title'] ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="col col-12 col-lg-7 col-xxl-8 px-0">
                            <?php foreach( $tabs as $key => $tab ) : ?>
                                <div id="vertical-tab-content-block_<?php echo $args['block_id'] ?>-iteration_<?php echo $key ?>" data-key="<?php echo $key ?>" class="vertical-tab-content bg-light <?php echo ( ! $key ) ? "on" : "" ?>">
                                    <div class="row align-items-center justify-content-center pe-lg-5">
                                        <div class="col col-12 col-md-6 col-xxl-5">
                                            <div class="position-relative ratio-100 w-100">
                                                <div class="top-50 start-50 translate-middle p-5 text-center position-absolute w-100 h-100 d-flex align-items-center flex-wrap justify-content-center">
                                                    <?php if ( $icon = $tab['icon'] ) : ?>
                                                        <div>
                                                            <img src="<?php echo $icon['url'] ?>" class="mx-auto" alt="<?php echo esc_attr( $tab['title'] ) ?>" width="<?php echo $icon['width'] ?>" height="<?php echo $icon['height'] ?>" />
                                                            <p class="h5 fw-bold text-center text-primary d-block w-100"><?php echo $tab['title'] ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-12 col-md-6 col-xxl-5">
                                            <div class="position-relative tab-content-wrapper ratio-100 w-100">    
                                                <div class="top-50 start-50 translate-middle p-5 position-absolute w-100 h-100 d-flex align-items-center flex-wrap justify-content-center">
                                                    <div class="tab-content border-top border-bottom py-3">
                                                        <?php echo strip_tags( $tab['content'] ) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-12">
                                            <div class="swiper auto-init" data-options='<?php echo json_encode( $gallery_options ) ?>'>
                                                <div class="swiper-wrapper">
                                                    <?php foreach( $tab['images'] as $image_url ) : ?>
                                                        <div class="swiper-slide">
                                                            <div class="ratio-100 bg" style="background-image: url(<?php echo $image_url ?>);"></div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>