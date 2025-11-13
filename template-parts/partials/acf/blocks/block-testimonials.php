<?php

$default = array(
    "title_tag"      => get_sub_field( 'title_tag' ),
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'blurb' ),
    "testimonials"       => get_sub_field( 'testimonials' ),
    "featured_review" => get_sub_field( 'featured_review' ),
);

$args = wp_parse_args( $args, $default );

?>
<div class="valtas-testimonials-block py-5 px-3 px-lg-0">
    <div class="container">
       <div class="row">
            <div class="col-lg-12">
                <?php if ( $args['title'] ) : ?>
                    <<?php echo esc_html( $args['title_tag'] ); ?>><?php echo $args['title']; ?></<?php echo esc_html( $args['title_tag'] ); ?>>
                <?php endif; ?>  
                <?php if ( $args['content'] ) : ?>
                    <?php echo $args['content']; ?>
                <?php endif; ?>  
                <?php if ( !empty($args['testimonials']) ) : ?>
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- Indicators -->
                            <div class="carousel-indicators">
                                <?php foreach ( $args['testimonials'] as $index => $testimonial ) : ?>
                                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"></button>
                                <?php endforeach; ?>
                            </div>
                            <?php foreach ( $args['testimonials'] as $index => $testimonial ) : 
                                $title       = $testimonial['testimonial_title'];
                                $blurb       = $testimonial['testimonial_blurb'];
                                $name        = $testimonial['testimonial_name'];
                                $designation = $testimonial['testimonial_designation'];
                            ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="testimonial">
                                        <?php if ( $title ) : ?>
                                            <h3 class="testimonial-title mb-3"><?php echo esc_html($title); ?></h3>
                                        <?php endif; ?>
                                        
                                        <?php if ( $blurb ) : ?>
                                            <div class="testimonial-blurb mb-3">
                                                <?php echo wp_kses_post($blurb); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="testimonial-meta">
                                            <div class="testimonial-meta_name">
                                                <?php if ( $name ) : ?>
                                                    <strong class="testimonial-name"><?php echo esc_html($name); ?></strong>
                                                <?php endif; ?>
                                                <?php if ( $designation ) : ?>
                                                    <span class="testimonial-designation d-block"><?php echo esc_html($designation); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <img src="<?php echo get_template_directory_uri(); ?>/img/quote.svg" alt="Quote Icon" class="quote-icon">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>


                    </div>
                <?php endif; ?>
            </div>
            <!--
            <div class="col-lg-1">
                <div class="vr h-100 mx-auto d-none d-lg-flex"></div>
                <hr class="d-block d-lg-none my-4">
            </div>
            <div class="col-lg-4">
                <img src="<?php echo get_template_directory_uri(); ?>/img/rating.png" alt="Testimonial Image" class="img-fluid">
                <hr>
                <?php if ( !empty($args['featured_review']) ) : 
                    $featured = $args['featured_review'];
                    $title    = $featured['featured_review_title'] ?? '';
                    $blurb    = $featured['featured_review_blurb'] ?? '';
                ?>
                    <div class="featured-review">
                        <?php if ( $title ) : ?>
                            <h3 class="featured-review-title mb-3">
                                <?php echo esc_html($title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ( $blurb ) : ?>
                            <div class="featured-review-blurb">
                                <?php echo wp_kses_post($blurb); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
            -->
        </div>
    </div>
</div>


