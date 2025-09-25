<?php

$default = array(
    "title"               => get_sub_field( 'title' ) ?: "Please enter title",
    "subtext"             => get_sub_field( 'subtext' ) ?: "Please enter subtext",
    "heading_alignment"   => get_sub_field( 'heading_alignment' ),
    "video"               => get_sub_field( 'video' ),
    "content"             => get_sub_field( 'content' ),
);

$args = wp_parse_args( $args, $default );
?>

<div class="block-video padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12 to-fade" data-delay="0.2">
                <div class="<?php echo 'text-' . $args['heading_alignment'] ?> mb-5">
                    <?php if ($args['title']) { ?>
                        <h2 class="h2 text-<?php echo $args['heading_alignment'] ?>"><?php echo $args['title']; ?></h2>
                    <?php } ?>
                    
                    <?php if ($args['subtext']) { ?>
                        <p class="h4"><?php echo $args['subtext']; ?></p>
                    <?php } ?>
                </div>

                <?php if ($args['video']) { ?>
                    <div class="video-wrap mb-5 to-fade" data-delay="0.3">
                        <?php echo $args['video']; ?>
                    </div>
                <?php } ?>

                <?php if ($args['content']) { ?>
                    <div class="to-fade" data-delay="0.4">
                        <?php echo $args['content']; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>