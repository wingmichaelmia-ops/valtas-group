<?php

$default = array(
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'content' ),
    "image"         => get_sub_field( 'image' ), // image URLs
    "position"      => get_sub_field( 'position' ) ?: 'left'
);

$args = wp_parse_args( $args, $default );

?>

<div class="block-featured_content padding-normal featured_content-collage position-relative to-fade" data-delay="0.1">

    <img src="<?php echo get_template_directory_uri() ?>/assets/logo-circle-gray.svg" width="100" height="100" class="content-fade-graphic position-absolute" alt="Badge">

    <div class="container">
        <div class="row">
            <div class="col col-12 to-fade" data-delay="0.2">
                <div class="featured-content featured-content-fade position-relative <?php echo $args['position'] == 'left' ? 'bg-x-left' : 'bg-x-right' ?>">


                    <div class="row justify-content-between position-relative to-fade" data-delay="0.3">
                        <div class="col col-12 col-md-6  position-relative fade-content <?php echo $args['position'] == 'left' ? 'order-md-2' : 'col-lg-5' ?>">
        
                            <img
                                data-src="<?php echo get_template_directory_uri() ?>/assets/leaf-branch-white.svg"
                                width="176.492" height="174.415" alt="leaf branch"
                                class="echo-lazy featured-content-fade-branch position-absolute bottom-0"
                            />

                            <div class="wysiwyg">
                                <?php if ( $title = $args['title'] ) : ?>
                                    <h3 class="h2"><?php echo $title ?></h3>
                                <?php endif; ?>
                                <?php echo $args['content'] ?>
                            </div>
                        </div>
                        <div class="col col-12 col-md-6 echo-lazy bg"  data-bg="true" data-src="<?php echo $args['image']['url'] ?>">
                            <!--  -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>