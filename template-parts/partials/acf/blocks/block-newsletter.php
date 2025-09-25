<?php

$defaults = array(
    "title" => get_sub_field( 'title' ),
    "form"  => get_sub_field( 'form_shortcode' )
);

$args = wp_parse_args( $args, $defaults );

?>

<div class="padding-normal to-fade" data-delay="0.1">

    <div class="container">
        <div class="row">
            <div class="col col-12 col-xxl-10 mx-auto">
                <div class="row align-items-center">
                    <div class="col col-12 col-md-6 to-fade" data-delay="0.2">
                        <div class="row align-items-center">
                            <div class="col col-12 col-md-4">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/logo-green-newsletter.svg" alt="Badge" width="226.097" class="d-block col-6 mx-auto col-md-12" height="222.786" />
                            </div>
                            <div class="col col-12 col-md-8">
                                <h4 class="h2 mt-3 pe-md-5"><small><?php echo $args['title'] ?></small></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6 to-fade" data-delay="0.3">
                        <?php echo do_shortcode( $args['form'] ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>