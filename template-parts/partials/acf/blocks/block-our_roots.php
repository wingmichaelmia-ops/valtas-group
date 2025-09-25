<?php

$default = array(
    "timeline_heading"   => get_sub_field( 'timeline_heading' ) ?: false,
    "timeline"           => get_sub_field( 'timeline' ) ?: false
);

$args = wp_parse_args( $args, $default );

$block_id = $args['block_id'];

?>

<div class="our-story padding-normal to-fade" data-delay="0.1">
    <?php if ($args['timeline_heading']) { ?>
    <div class="timeline-heading col col-12 overflow-hidden to-fade" data-delay="0.2">
        <img src="<?php echo get_template_directory_uri() ?>/assets/logo-circle-white.svg" class="bottom-0 timeline-logo position-absolute end-0 opacity-25" alt="Tree" width="400" height="400" >
        <div class="row position-relative">
            <div class="container">
                <div class="text-primary fw-bold mt-3 pe-xl-5"><?php echo $args['timeline_heading']; ?></div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="container padding-normal to-fade" data-delay="0.3">
        <div class="row">
            <?php if ($args['timeline']) { ?>
            <div class="timeline col col-12">
                <?php
                    $count = 0;
                    foreach ($args['timeline'] as $timeline) {
                ?>
                <div class="timeline-item row">
                    <div class="d-flex to-fade" data-delay="0.4">
                        <div class="d-md-flex align-items-center <?php echo (++$count % 2) ? 'ms-auto' : 'me-auto' ?>">
                            <?php if ($timeline['item']['year']) { ?>
                            <p class="h3"><?php echo $timeline['item']['year']; ?></p>
                            <?php } ?>
                            
                            <div class="content">
                                <?php if ($timeline['item']['image']) { ?>
                                <div data-bs-toggle="modal" data-bs-target="#timeline-lightbox">
                                    <img class="root-preview" src="<?php echo $timeline['item']['image']['url']; ?>" alt="<?php $timeline['item']['image']['alt']; ?>" width="400">
                                </div>
                                <?php } ?>
                                <div class="wysiwyg">
                                    <div class="fw-small fw-bold"><?php echo $timeline['item']['content']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <span>
                <span></span>
            </span>
            <?php } ?>
        </div>
    </div>
</div>


<!-- Popups -->
<div class="modal modal-lg fade" id="timeline-lightbox" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <img id="timeline-lightbox-image" src="#!">
            <div class="modal-header position-absolute top-0 end-0 border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

<script>
    // dirty inline script. Please forgive me
    jQuery( function( $ ) {
        $( document.body ).on( 'click', '.root-preview', function() {
            var $this = $(this);
            $( '#timeline-lightbox-image' ).attr( 'src', $this.attr( 'src' ) );
        })
    })
</script>