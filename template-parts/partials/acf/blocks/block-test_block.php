<?php

$default = array(
    "title"               => get_sub_field( 'title' ) ?: "Please enter title",
    "image"               => get_sub_field( 'image' ),
);

$args = wp_parse_args( $args, $default );
?>

<div class="block-video padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12 to-fade" data-delay="0.2">
                <div class="mb-5">
                    <?php if ($args['title']) { ?>
                        <h2 class="h2 text"><?php echo $args['title']; ?></h2>
                    <?php } ?>
                    
                </div>
test
                <?php if ($args['image']) { ?>
                    <div class="video-wrap mb-5 to-fade" data-delay="0.3">
                        <?php echo $args['image']; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>