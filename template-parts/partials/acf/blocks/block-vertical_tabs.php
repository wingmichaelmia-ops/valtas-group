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

<div class="padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row justify-content-center to-fade" data-delay="0.2">
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

    <div class="d-none d-md-block container pt-5 vertical-tab vertical-tab-block_<?php echo $args['block_id'] ?> to-fade" data-delay="0.3">
        <div class="row mx-0">
            <div class="col col-12 px-0">
                <?php if ( $tabs = $args['tabs'] ) : ?>
                    <div class="row align-items-center mx-0">
                        <div class="col col-11 col-md-8 col-lg-4">
                            <?php foreach( $tabs as $key => $tab ) : ?>
                                <div id="vertical-tab-content-block_<?php echo $args['block_id'] ?>-iteration_<?php echo $key ?>" data-key="<?php echo $key ?>" class="vertical-tab-content <?php echo ( ! $key ) ? "on" : "" ?>">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col col-12 mb-5">
                                            <div class="position-relative w-100">
                                                <div class="d-flex align-items-center flex-wrap justify-content-center">
                                                    <?php if ( $icon = $tab['icon'] ) : ?>
                                                        <div class="d-flex align-items-center flex-wrap justify-content-center">
                                                            <img src="<?php echo $icon['url'] ?>" class="mx-auto" alt="<?php echo esc_attr( $tab['title'] ) ?>" width="<?php echo $icon['width'] ?>" height="<?php echo $icon['height'] ?>" />
                                                            <p class="h5 fw-bold text-center text-primary d-block w-100"><?php echo $tab['title'] ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-12">
                                            <div class="position-relative tab-content-wrapper w-100">    
                                                <div class="d-flex align-items-center flex-wrap justify-content-center">
                                                    <div class="tab-content border-top border-bottom py-3">
                                                        <?php echo strip_tags( $tab['content'] ) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    
                        <div class="col col-1 col-md-4 col-lg-7 offset-lg-1">
                            <div class="row">
                                <?php foreach( $tabs as $key => $tab ) : ?>
                                    <div class="col col-12 col-md-6">
                                        <div 
                                            data-key="<?php echo $key ?>"
                                            data-target="#vertical-tab-content-block_<?php echo $args['block_id'] ?>-iteration_<?php echo $key ?>"
                                            class="vertical-tab-toggler <?php echo ( ! $key ) ? "on" : "" ?> d-flex align-items-center w-100">
                                            <?php if ( $icon = $tab['icon'] ) : ?>
                                                <img src="<?php echo $icon['url'] ?>" class="vertical-tab-icon my-0" alt="<?php echo esc_attr( $tab['title'] ) ?>" width="<?php echo $icon['width'] ?>" height="<?php echo $icon['height'] ?>" />
                                                <p class="my-0 text-green fw-bold d-none d-lg-block "><?php echo $tab['title'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="d-block d-md-none container pt-5 vertical-tab vertical-tab-block_<?php echo $args['block_id'] ?> to-fade" data-delay="0.3">
        <div class="row mx-0">
            <div class="col col-12 px-0">
                <?php if ( $tabs = $args['tabs'] ) : ?>
                    <div class="row align-items-center mx-0">
                        <?php foreach( $tabs as $key => $tab ) : ?>
                            <div id="" class="vertical-tab-content">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col col-12 mb-5">
                                        <div class="position-relative w-100">
                                            <div class="d-flex align-items-center flex-wrap justify-content-center">
                                                <?php if ( $icon = $tab['icon'] ) : ?>
                                                    <div class="d-flex align-items-center flex-wrap justify-content-center">
                                                        <img src="<?php echo $icon['url'] ?>" class="mx-auto" alt="<?php echo esc_attr( $tab['title'] ) ?>" width="<?php echo $icon['width'] ?>" height="<?php echo $icon['height'] ?>" />
                                                        <p class="h5 fw-bold text-center text-primary d-block w-100"><?php echo $tab['title'] ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-12">
                                        <div class="position-relative tab-content-wrapper w-100">    
                                            <div class="d-flex align-items-center flex-wrap justify-content-center">
                                                <div class="tab-content border-top border-bottom py-3">
                                                    <?php echo strip_tags( $tab['content'] ) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col col-12 col-md-6">
                            <div class="row">
                                <?php foreach( $tabs as $key => $tab ) : ?>
                                    <div class="col col-12">
                                        <div 
                                            data-key=""
                                            data-target=""
                                            class="vertical-tab-toggler for-mobile d-flex align-items-center w-100">
                                            <?php if ( $icon = $tab['icon'] ) : ?>
                                                <img src="<?php echo $icon['url'] ?>" class="vertical-tab-icon my-0" alt="<?php echo esc_attr( $tab['title'] ) ?>" width="<?php echo $icon['width'] ?>" height="<?php echo $icon['height'] ?>" />
                                                <p class="my-0 text-green fw-bold"><?php echo $tab['title'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<style>
    /* JP to consolidate and add to correct sass file */
    .vertical-tab .vertical-tab-toggler {
        border-radius: 40px;
    }
    .vertical-tab .vertical-tab-content {
        box-shadow: none;
    }

    .tab-content.border-top.border-bottom.py-3 {
       border-bottom: 3px solid #568045 !important;
        border-top: 3px solid #568045 !important;
        padding: 30px !important;
        text-align: center;
    }

    @media screen and ( max-width: 767px ) {
        .vertical-tab .vertical-tab-toggler:not(.for-mobile) {
            border-radius: 0;
            width: 50px !important;
            height: 35px !important;
            border-top-left-radius: 40px;
            border-bottom-left-radius: 40px;
            padding: 0;
        }
    }
</style>