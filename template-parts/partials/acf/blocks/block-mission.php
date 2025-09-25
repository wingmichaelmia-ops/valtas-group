<?php

    $default = array(
        "title"     => get_sub_field( 'title' ),
        "content"   => get_sub_field( 'content' ),
        "missions"  => get_sub_field( 'missions' ) ?: array()
    );

    $args = wp_parse_args( $args, $default );

    $gallery_options = array(
        'slidesPerView' => 2
    );

?>

<div class="order-process mission-box position-relative to-fade" data-delay="0.1">
    <div class="data-container">
        <?php if ( $missions = $args['missions'] ) : ?>
            <?php foreach( $missions as $key => $mission ) : $key++; $is_even = ($key % 2 == 0); ?>
                <div class="position-relative mission-row overflow-hidden data-my-4 data-my-lg-5 to-fade" data-delay="0.2">
                    <div class="position-absolute top-0 <?php echo ( $is_even ) ? "end-0" : "start-0" ?> h-100 col-lg-6 col-12 bg echo-lazy" data-bg="true" data-src="<?php echo $mission['Image'] ?>">
                        <?php if ( $key === 1 ) : ?>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <?php if ( $args['title'] ) : ?>
                                    <h2 class="h2 text-start text-white"><?php echo $args['title'] ?></h2>
                                    <style>.hero-text-mission{ font-size: 3rem; }</style>
                                <?php endif; ?>
                                <?php if ( $args['content'] ) : ?>
                                    <h2 class="h1 text-start fw-bold hero-text-mission text-white"><?php echo $args['content'] ?></h2>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="position-relative content to-fade" data-delay="0.3">
                        <div class="row">
                            <div class="col col-12 col-lg-6 <?php echo ( $is_even ) ? "" : "offset-lg-6" ?>">
                                <div class="mission-content text-center text-white h3">
                                    <?php echo $mission['content'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    /* JP to consolidate and add to correct sass file */
    .mission-row {
        /* border-radius: 24px; */
        /* border-top-left-radius: 0; */
        box-shadow: 0 0 20px rgba(0, 0, 0, .1607843137);
    }

    @media screen and ( max-width: 1440px ) {
        .mission-content {
            font-size: 23px;
            min-height: 325px;
            padding: 50px;
        }
        .hero-text-mission {
            font-size: 3rem;
        }
    }

    .mission-content {
        font-size: 16px;
    }

    @media screen and ( min-width: 768px ) {
        .mission-content {
            font-size: 24px;
        }
    }

    @media screen and ( max-width: 768px ) {
        .hero-text-title {
            font-size: 2.5rem;
        }
    }
</style>