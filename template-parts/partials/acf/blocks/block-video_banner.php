<?php

$default = array(
    "title"     => get_sub_field( 'title' ),
    "video"     => get_sub_field( 'video_mp4' ),
    "link"      => get_sub_field( 'link' ) ?: array(),
    "link_2"    => get_sub_field( 'link_2' ) ?: array()
);

$args = wp_parse_args( $args, $default );

?>

<div class="block-video_banner position-relative overflow-hidden d-flex flex-wrap align-items-center bg-primary">

    <video class="video-banner position-absolute top-50 start-50 translate-middle h-100 w-100 no-translate to-fade" style="transition: 12s ease !important;" data-delay="0.4" autoplay="autoplay" loop="loop" muted="" width="1280" height="720">
        <source src="<?php echo $args['video'] ?>" type="video/mp4">
    </video>

    <div class="container position-relative">
        <div class="row">
            <div class="d-flex video-banner-content flex-wrap col align-items-center col-12 col-md-6 col-lg-5 col-xl-4">

                <div class="wysiwyg">
                    <h1 class="text-white text-serif to-fade" data-delay="0.2"><?php echo $args['title'] ?></h1>
                    <hr />
                    <div class="vide-banner-buttons to-fade" data-delay="0.25">
                        <?php if ( $link = $args['link'] ) : ?>
                            <a href="<?php echo $link['url'] ?>" class="btn btn-primary to-fade" data-delay="0.3" target="<?php echo $link['target'] ?>"><?php echo $link['title'] ?></a>
                        <?php endif; ?>
                        <?php if ( $link = $args['link_2'] ) : ?>
                            <a href="<?php echo $link['url'] ?>" class="btn btn-secondary to-fade" data-delay="0.35" target="<?php echo $link['target'] ?>"><?php echo $link['title'] ?></a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>