<?php

$default = array(
    "image"           => get_sub_field( 'image' ) ?: false,
    "content"         => get_sub_field( 'content' ) ?: false,
    "image_position"  => get_sub_field( 'image_position' ) ?: false,
);

$args = wp_parse_args( $args, $default );

?>

<div class="text-image-block padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row justify-content-between align-items-center to-fade" data-delay="0.2">
            <div class="image-wrap mb-5 mb-lg-0 col d-flex justify-content-center justify-content-lg-start <?php if ($args['image_position'] == 'right') { echo 'order-2 d-flex justify-content-lg-end'; } ?>">
                <img src="<?php echo $args['image']['url']; ?>" alt="<?php echo $args['image']['alt']; ?>">
            </div>
            <div class="content-wrap col-12 col-lg-8 <?php  echo ($args['image_position'] == 'right') ? "pe-lg-5" : "ps-lg-5" ?> to-fade" data-delay="0.3">
                <?php echo $args['content']; ?>
            </div>
        </div>
    </div>
</div>