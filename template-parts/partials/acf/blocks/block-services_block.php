<?php

$default = array(
    "title_tag"      => get_sub_field( 'title_tag' ),
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'blurb' ),
    "service"       => get_sub_field( 'services' ),
);

$args = wp_parse_args( $args, $default );

?>

<div class="valtas-services-block pt-5">
    <div class="container" style="max-width: 826px;">
       <div class="row">
            <div class="col-lg-12 text-center">
                <?php if ( $args['title'] ) : ?>
                    <<?php echo esc_html( $args['title_tag'] ); ?>><?php echo $args['title']; ?></<?php echo esc_html( $args['title_tag'] ); ?>>
                <?php endif; ?>  
                <?php if ( $args['content'] ) : ?>
                    <?php echo $args['content']; ?>
                <?php endif; ?>  
            </div>
        </div>
    </div>
    <div class="container">
       <?php if ( !empty($args['service']) ) : ?>
    <div class="service-list mt-5 ps-5 ps-md-0 pb-0 pb-md-5">
        <?php $i = 1; // start counter ?>
            <?php foreach ( $args['service'] as $service ) : 
                $image  = $service['service_featured_image']; 
                $tag    = $service['service_title_tag'];
                $title  = $service['service_title'];
                $blurb  = $service['service_blurb'];
                $button = $service['service_button'];
            ?>
            <div class="service-item row align-items-center">
                <div class="tracker"></div>
                <div class="col-md-5">
                    <?php if ( $image ) : ?>
                        <div class="service-image mb-3">
                            <?php echo wp_get_attachment_image( $image, 'large', false, ['class' => 'card-img-top'] ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-5">
                    <div class="service-number mb-4">
                        <?php echo sprintf('%02d', $i); ?>
                    </div>

                    <?php if ( $title ) : ?>
                        <<?php echo esc_attr($tag ?: 'h3'); ?> class="service-title mb-4">
                            <?php echo esc_html($title); ?>
                        </<?php echo esc_attr($tag ?: 'h3'); ?>>
                    <?php endif; ?>
                    
                    <?php if ( $blurb ) : ?>
                        <div class="service-blurb">
                            <?php echo $blurb; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $button ) : ?>
                        <div class="btn-valtas my-4">
                            <a href="<?php echo esc_url($button['url']); ?>" 
                            class="btn btn-primary"
                            target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        </div>
                    <?php endif; ?>  
                </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>
    <?php endif; ?>




    </div>
</div>