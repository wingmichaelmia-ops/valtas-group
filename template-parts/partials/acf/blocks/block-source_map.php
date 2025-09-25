
<style>
    .source-map {
        /* height: 500px; */
        width: 100%;
        padding-top: 80%;
        display: block;
    }

    .source-content {
        height: 500px;
        overflow: auto;
        min-height: 100%;
    }
    
    .grower-regions {
        display: none;
    }
    
    .map-bounds {
        cursor: pointer;   
    }

    .map-bounds[data-region="europe"] {
        /* border: 1px solid; */
        top: 0;
        left: 41%;
        width: 22%;
        height: 34%;
    }

    .map-bounds[data-region="africa"] {
        top: 35%;
        width: 23%;
        height: 50%;
        /* border: 1px solid; */
        left: 40%;
    }

    .map-bounds[data-region="asia"] {
        width: 36%;
        height: 58%;
        /* border: 1px solid red; */
        top: 0;
        right: 0;
    }

    .map-bounds[data-region="north america"] {
        width: 40%;
        height: 50%;
        /* border: 1px solid; */
        top: 0;
        left: 0;
    }

    .map-bounds[data-region="south america"] {
        width: 40%;
        height: 50%;
        /* border: 1px solid; */
        bottom: 0;
        left: 0;
    }

    .map-bounds[data-region="oceania"] {
        width: 36%;
        height: 40%;
        right: 0;
        bottom: 0;
        /* border: 1px solid red; */
    }
</style>

<div class="padding-normal border-top">
    <div class="container">
        
        <div class="row">
            <div class="col col-12">
                
              <div class="row">
                    <div class="col col-6 col-lg-3 order-2 order-lg-1">
                        <div class="source-content position-relative bg-light p-3">
                            <?php
                                $regions = get_terms( ['taxonomy' => 'region', 'hide_empty' => false ] );

                                $region_local = array();
                                $region_slugs = array();

                                if ( $regions ) {
                                    foreach( $regions as $region ) {
                                        // $region_slugs[$region->slug] = $region->name; 
                                        $region_slugs[$region->slug] = $region->name; 
                                        $region_local[$region->slug] = array(
                                            'name'      => strtolower( $region->name ),
                                            'export_to' => get_field( 'export_to', 'region_' . $region->term_id  ) ?: array(
                                                array( 'country' => 'Japan' ),
                                                array( 'country' => 'India' ),
                                                array( 'country' => 'Canada' ),
                                                array( 'country' => 'China' ),
                                                array( 'country' => 'Greece' ),
                                            ),
                                            "source_from"   => get_field( 'source_from', 'region_' . $region->term_id ) ?: array()
                                        );

                                        $source = get_field( 'source_from', 'region_' . $region->term_id );

                                        echo sprintf( '<div id="%s" data-region="%s" class="grower-regions p-lg-4">', $region->slug, strtolower( $region->name ) );

                                        echo '<div class="region-title h3 text-capitalise mb-2">Regions we<br>source products</div>';
                                        echo sprintf( '<div class="region-description mb-4">%s</div>', $region->description ?: '' );

                                        if ( $source ) {

                                            foreach( $source as $country ) {
                                                ?>
                                                <div class="d-block pb-3 mb-3 border-bottom text-decoration-none">
                                                    <?php echo $country['country'] ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                            
                                        echo '</div>';

                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col col-12 col-lg-6 d-flex order-1 order-md-1 align-items-center">
                        <div class="position-relative overflow-hidden to-fade w-100 mb-5 mb-lg-0" data-delay="0.5">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/map/all.svg" width="368" height="182" alt="World Map" class="position-relative w-100 h-auto d-block m-0" />
                            <img src="<?php echo get_template_directory_uri() ?>/assets/map/as.svg?v=2" width="368" height="182" alt="World Map" class="position-absolute w-100 top-50 start-50 translate-middle grower-regions" style="margin-top: 1%" data-region="asia" />
                            <img src="<?php echo get_template_directory_uri() ?>/assets/map/eu.svg?v=2" width="368" height="182" alt="World Map" class="position-absolute w-100 top-50 start-50 translate-middle grower-regions" data-region="europe" />
                            <img src="<?php echo get_template_directory_uri() ?>/assets/map/na.svg?v=2" width="368" height="182" alt="World Map" class="position-absolute w-100 top-50 start-50 translate-middle grower-regions" data-region="north america" />
                            <img src="<?php echo get_template_directory_uri() ?>/assets/map/sa.svg?v=2" width="368" height="182" alt="World Map" class="position-absolute w-100 top-50 start-50 translate-middle grower-regions" data-region="south america" />
                            <img src="<?php echo get_template_directory_uri() ?>/assets/map/oc.svg?v=2" width="368" height="182" alt="World Map" class="position-absolute w-100 top-50 start-50 translate-middle grower-regions" style="margin-top: 1%" data-region="oceania" />
                            <img src="<?php echo get_template_directory_uri() ?>/assets/map/af.svg?v=2" width="368" height="182" alt="World Map" class="position-absolute w-100 top-50 start-50 translate-middle grower-regions" data-region="africa" />
                        
                            <div class="map-bounds position-absolute" data-region="europe"></div>                                
                            <div class="map-bounds position-absolute" data-region="africa"></div>                                
                            <div class="map-bounds position-absolute" data-region="asia"></div>                                
                            <div class="map-bounds position-absolute" data-region="north america"></div>                                
                            <div class="map-bounds position-absolute" data-region="south america"></div>
                            <div class="map-bounds position-absolute" data-region="oceania"></div>                                

                        </div>
                    </div>
                    <div class="col col-6 col-lg-3 order-2 order-lg-1 source-content-col">
                        <div class="source-content position-relative bg-light p-3">
                            <?php
                                foreach( $region_local as $slug => $data ) {
                                    ?>
                                    <div id="<?php echo $slug ?>_export" class="grower-regions p-lg-4" data-region="<?php echo $data['name'] ?>">
                                        <p class="h3 mb-4">Regions we<br>export to</p>
                                        <?php foreach( $data['export_to'] as $countries ) : ?>
                                            <div class="d-block pb-3 mb-3 border-bottom text-decoration-none">
                                                <?php echo $countries['country'] ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
crossorigin=""/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
crossorigin=""></script>

<script>

    function restyleLayer( region ) {

        jQuery('.grower-regions').hide();
        jQuery('.grower-regions[data-region="'+ region.toLowerCase() +'"]').show();
    }

    restyleLayer( 'Europe' );

    jQuery( 'body' ).on( 'click, mouseenter', '.map-bounds', function() {

        restyleLayer( jQuery(this).attr( 'data-region' ) )
    })

</script>