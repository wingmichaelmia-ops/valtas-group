<?php

$default = array(
    "title"     => get_sub_field( 'title' ),
    "content"   => get_sub_field( 'content' ),
    "steps"     => get_sub_field( 'steps' ) ?: array()
);

$args = wp_parse_args( $args, $default );

$gallery_options = array(
    'slidesPerView' => 2
);

?>

<div class="padding-normal pb-5 bg-light to-fade" data-delay="0.1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-12 col-xxl-9 to-fade" data-delay="0.2">
                <?php if ( $args['title'] ) : ?>
                    <h3 class="h2 text-center"><?php echo $args['title'] ?></h3>
                <?php endif; ?>
                <?php if ( $args['content'] ) : ?>
                    <div class="text-center fw-bold"><?php echo $args['content'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="order-process position-relative to-fade" data-delay="0.1">
    <?php if ( $steps = $args['steps'] ) : ?>
        <?php foreach( $steps as $key => $step ) : $key++; $is_even = ($key % 2 == 0); ?>
            <div class="position-relative to-fade" data-delay="0.2">
                <div class="position-absolute top-0 <?php echo ( $is_even ) ? "end-0" : "start-0" ?> h-100 col-lg-6 col-12 bg echo-lazy" data-bg="true" data-src="<?php echo $step['Image'] ?>"></div>
                <div class="container position-relative content">
                    <div class="row">
                        <div class="col col-12 col-lg-6 col-xxl-5 order-process__content d-flex align-items-center <?php echo ( $is_even ) ? "pe-md-8" : "offset-lg-6 offset-xxl-7 ps-md-5" ?>">
                            <div class="padding-normal w-100">
                                <h5 class="h2"><?php echo $step['title'] ?></h5>
                                <?php echo $step['content'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow count text-primary position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center fw-bold"><?php echo $key ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>