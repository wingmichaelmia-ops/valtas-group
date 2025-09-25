<?php

$default = array(
    "title"          => get_sub_field( 'title' ) ?: "Please enter title",
    "content"        => get_sub_field( 'content' ) ?: false,
    "form_shortcode" => get_sub_field( 'form_shortcode' ),
    "contact_info"   => get_sub_field( 'contact_info' ),
    "address"        => get_sub_field( 'address' ),
    "social_links"   => get_sub_field( 'social_links' ),
    "map_embed"      => get_sub_field( 'map_embed' ),
);

$args = wp_parse_args( $args, $default );

?>

<div class="contact-block padding-normal to-fade" data-delay="0.1">
    <div class="container">
        <div class="row">
            <div class="col col-12 col-lg-6 pe-lg-5 mb-5 mb-lg-0 to-fade" data-delay="0.2">
                <?php if ($args['title']) { ?>
                    <h2 class="h2"><?php echo $args['title']; ?></h2>
                <?php } ?>
                <?php if ($args['content']) { ?>
                    <p class="h4"><?php echo $args['content']; ?></p>
                <?php } ?>

                <?php if ($args['form_shortcode']) { ?>
                <div class="mt-5">
                    <?php echo do_shortcode($args['form_shortcode']); ?>
                </div>
                <?php } ?>
            </div>
            <div class="contact-info col col-12 col-lg-6 ps-lg-5 to-fade" data-delay="0.3">
                <div class="bg-gray p-4 p-md-5">
                    <div class="row">
                        <?php if ($args['contact_info']) { ?>
                        <div class="col col-md-6">
                            <?php if ($args['contact_info']['label']) { ?>
                            <h3 class="h2 h3"><?php echo $args['contact_info']['label']; ?></h3>
                            <?php } ?>

                            <?php if ($args['contact_info']['contact_number']) { ?>
                            <a class="d-flex mb-3" href="tel:<?php echo $args['contact_info']['contact_number']; ?>">
                                <span class="icon icon-Phone me-3 align-middle"></span>
                                <span class="fw-bold"><?php echo $args['contact_info']['contact_number']; ?></span>
                            </a>
                            <?php } ?>

                            <?php if ($args['contact_info']['email_address']) { ?>
                            <a class="d-flex" href="tel:<?php echo $args['contact_info']['email_address']; ?>">
                                <span class="icon icon-Email me-3 align-middle"></span>
                                <span class="fw-bold"><?php echo $args['contact_info']['email_address']; ?></span>
                            </a>
                            <?php } ?>

                            <?php if ($args['social_links']) { ?>
                            <div class="social-links mt-3 mt-md-5">
                                <?php if ($args['social_links']['label']) { ?>
                                <h3 class="h2 h3"><?php echo $args['social_links']['label']; ?></h3>
                                <?php } ?>
                                <div class="d-flex">
                                    <?php foreach ($args['social_links']['links'] as $link) { ?>
                                    <a href="<?php echo $link['url']; ?>">
                                        <span class="icon icon-<?php echo $link['icon']; ?> me-2"></span>
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>

                        <?php if ($args['address']) { ?>
                        <div class="col col-md-6 mt-3 mt-md-0">
                            <?php if ($args['address']['label']) { ?>
                            <h3 class="h2 h3"><?php echo $args['address']['label']; ?></h3>
                            <?php } ?>
                            <div class="d-flex">
                                <span class="icon icon-Location text-color-green me-3"></span>
                                <div class="fw-bold text-color-green"><?php echo $args['address']['text']; ?></div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div id="map-embed" class="ratio-70 position-relative">
                    
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                    crossorigin=""/>
                    
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                    crossorigin=""></script>

                    <div id="map-<?php echo $args['block_index'] ?>" class="w-100 h-100 position-absolute top-0 start-0"></div>

                    <script>
                        var map = L.map('map-<?php echo $args['block_index'] ?>').setView([52.556120, -0.260130], 13);

                        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                            maxZoom: 20,
                            subdomains:['mt0','mt1','mt2','mt3']
                        }).addTo(map);

                        L.marker([52.556120, -0.260130]).addTo(map)
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>