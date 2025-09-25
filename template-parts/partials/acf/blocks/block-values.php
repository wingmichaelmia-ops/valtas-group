<?php

$default = array(
    "title"     => get_sub_field( 'title' ),
    "content"   => get_sub_field( 'content' ),
    "values"  => get_sub_field( 'values' ) ?: array()
);

$args = wp_parse_args( $args, $default );

$gallery_options = array(
    'slidesPerView' => 2
);

?>

<div class="values position-relative padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row justify-content-center to-fade" data-delay="0.2">
            <div class="col col-12 col-xxl-9">
                <?php if ( $args['title'] ) : ?>
                    <h3 class="h2 text-center"><small><?php echo $args['title'] ?></small></h3>
                <?php endif; ?>
                <?php if ( $args['content'] ) : ?>
                    <div class="text-center fw-bold"><?php echo $args['content'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row pt-5 to-fade" data-delay="0.3">
            <?php if ( $values = $args['values'] ) : ?>
                <?php foreach( $values as $value ) : ?>
                    <div class="value-wrapper col col-12 col-lg-4">
                        <div class="value-content h-100">
                            <h3 class="h2 text-center"><?php echo $value['title'] ?></h3>
                            <div class="mb-0 text-center text-primary fw-bold"><?php echo strip_tags( $value['content'] ) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>