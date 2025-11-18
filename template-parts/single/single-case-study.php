<?php
    $title = get_field('header_title') ?: get_the_title();
    $header_blurb = get_field('header_blurb');
    $words = explode(' ', trim($title));
    $cta_title = get_field('cta_title');
    $cta_blurb = get_field('cta_blurb');
    $image_id = get_field('cta_background_image');

    if (count($words) >= 1) {
        $last_word = array_pop($words);
        $title_formatted = implode(' ', $words) . ' <span class="highlight">' . $last_word . '</span>';
    } else {
        $title_formatted = '<span>' . $title . '</span>';
    }
?>
<style>
    .page-title__content {
        max-width: 800px;
    }
    .page-title__title {
        line-height: 1em;    
    }
    #content a {
        text-decoration: none;
    }
    #content a:hover {
        color: #f3b700;
    }
    .approach-title {
        letter-spacing: normal;
    }

    section:not(.echo-block-cta_block) .highlight{
        background-color: transparent;
        display: inline-block;
        padding: 0;
        color: #009fed;
    }
    .highlight.d-block {
        width: max-content;
    }
    .company-logo-image {
        max-height: 100px;
        width: auto;
    }
</style>
<section class="echo-block echo-block-page_title">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'page_title',
        [
            'title'      => 'Impact: ' . $title_formatted, // use the post title dynamically
            'title_tag'  => 'h1',
            'content'     => $header_blurb,
            'button_group' => get_field( 'button_group' )
        ]
    );
    ?>
</section>
<?php if(get_field('dates_of_client_service_start') || get_field('dates_of_client_service_end')): ?>
    <section class="bg-primary text-white text-center">
        <div class="container py-3">
            <strong style="color:#f3b700">Dates of Client Service:</strong> <?php echo get_field('dates_of_client_service_start') ?: 'Month Year'; ?> - <?php echo get_field('dates_of_client_service_end') ?: 'Month Year'; ?>
        </div>
    </section>
<?php endif; ?>
<section class="overview py-5 px-3 px-md-0">
    <div class="container">
        <div class="row align-items-center flex-column-reverse flex-lg-row">
            <div class="col-lg-6">
                <?php 
                    echo wp_get_attachment_image( 
                        get_field('org_featured_image') ?: get_post_thumbnail_id(), 
                        'full', 
                        false, 
                        ['class' => 'org-featured-image', 'loading' => 'lazy'] 
                    );
                ?>

            </div>
            <div class="col-lg-6">
                <?php 
                    echo wp_get_attachment_image( 
                        get_field('company_logo') ?: get_post_thumbnail_id(), 
                        'full', 
                        false, 
                        ['class' => 'company-logo-image mb-2', 'loading' => 'lazy'] 
                    );
                ?>
                <h2><?php echo get_field('org_title') ?: 'Organization <span class="highlight">Overview</span>'; ?></h2>
                
                <?php
                    the_field('org_blurb');
                ?>  
                
            </div>
        </div>
    </div>
</section>
<section class="challenge-block py-5 bg-light-secondary px-3 px-md-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2><?php echo get_field('challenge_title') ?: 'The <span class="highlight">Challenge</span>'; ?></h2>
                <?php
                    the_field('challenge_blurb');
                ?>  
                
            </div>
            <div class="col-lg-6">
                <?php 
                    echo wp_get_attachment_image( 
                        get_field('challenge_featured_image') ?: get_post_thumbnail_id(), 
                        'full', 
                        false, 
                        ['class' => 'challenge_featured_image', 'loading' => 'lazy'] 
                    );
                ?>

            </div>
            
        </div>
    </div>
</section>
<section class="our-approach-block py-5 gradient-bg text-white px-3 px-md-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2><?php echo get_field('approach_title') ?: 'Our <span class="highlight">Approach</span>'; ?></h2>
                <?php
                   echo get_field('approach_blurb') ?: 'Valtas partnered with Harbor Hope to provide a dual solution: interim leadership to steady the ship, and a comprehensive search process to secure the right long-term leader.';
                ?>  
                
            </div>
        </div>
            <?php
            $our_approach = get_field('our_approach');

            if ( $our_approach ) : ?>
                <div class="our-approach container pt-5">
                        <?php foreach ( $our_approach as $item ) : 
                            $image = $item['our_approach_image'];
                            $title = $item['our_approach_title'];
                            $blurb = $item['our_approach_blurb'];
                        ?>
                        <div class="row approach-item align-items-center my-4">
                            <div class="col-lg-6">
                                <?php if ( $image ) : ?>
                                    <div class="approach-image">
                                        <?php echo wp_get_attachment_image( $image, 'full', false, [ 'class' => 'img-fluid mb-3 mb-lg-0' ] ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-6">
                                <?php if ( $title ) : ?>
                                    <h3 class="approach-title h5 fw-bold mb-3"><?php echo esc_html( $title ); ?></h3>
                                <?php endif; ?>

                                <?php if ( $blurb ) : ?>
                                    <div class="approach-blurb"><?php echo $blurb; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                </div>
            <?php endif; ?>
    </div>
</section>
<section class="outcome-block py-5 px-3 px-md-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2><?php echo get_field('outcome_title') ?: 'The <span class="highlight">Outcome</span>'; ?></h2>
                <?php
                   echo get_field('outcome_blurb') ?: '';
                ?>  
                
            </div>
        </div>
        <div class="row pt-5 flex-row-reverse align-items-center">
           <?php
                $outcome_featured_image = get_field('outcome_featured_image');       
                if ( $outcome_featured_image ) : ?>
                    <div class="col-lg-6">
                        <?php echo wp_get_attachment_image( 
                            $outcome_featured_image, 
                            'full', 
                            false, 
                            [ 
                                'class'   => 'img-fluid mb-4 mb-lg-0', 
                                'loading' => 'lazy' 
                            ] 
                        ); ?>
                    </div>
                    <div class="col-lg-6">
                <?php else : ?>
                    <div class="col-lg-12">
            <?php endif; ?>
            <?php
                $checklist = get_field('checklist');

                if ( $checklist ) : ?>
                    <div class="outcome-checklist">
                            <?php foreach ( $checklist as $item ) :
                                $title = $item['outcome_title'];
                                $text = $item['outcome_blurb'];
                                if ( $title ) : ?>
                                    <div class="outcome-checklist-item">
                                        <i class="checklist-icon"></i>
                                        <p class="section-title"><?php echo  $title; ?></p>
                                        <?php echo $text ?>
                                    </div>
                                <?php endif;
                            endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        <?php if(get_field('featured_text')): ?>
        <div class="row pt-5">
            <div class="col-12">
                <div class="ribbon">
                    <?php echo get_field('featured_text'); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<section class="client-perspective-block py-5 bg-light-secondary px-3 px-md-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Client <span class="highlight">Perspective</span></h2>
            </div>
        </div>
    </div>
    <?php
        $cp_featured_image = get_field('cp_featured_image');

        // Set default image path (relative to your theme directory)
        $default_image_url = get_template_directory_uri() . '/img/client-perspective-default.jpg';
    ?>
    <div class="container mt-3 mt-md-5" style="max-width:1156px;">
        <div class="row justify-content-center cp_container rounded">
            <div class="col-lg-4">
                <?php if ( $cp_featured_image ) : ?>
                    <?php echo wp_get_attachment_image(
                        $cp_featured_image,
                        'full',
                        false,
                        [
                            'class'   => 'img-fluid rounded',
                            'loading' => 'lazy',
                            'alt'     => get_post_meta($cp_featured_image, '_wp_attachment_image_alt', true)
                        ]
                    ); ?>
                <?php else : ?>
                    <img 
                        src="<?php echo esc_url( $default_image_url ); ?>" 
                        alt="Client Perspective" 
                        class="img-fluid rounded" 
                        loading="lazy"
                    >
                <?php endif; ?>
            </div>
            <div class="col-lg-8 p-3">
                <div class="cp_content">
                    <?php the_field('cp_testimonial'); ?>
                </div>
                <div class="cp_author mt-4">
                    <h5 class="cp_name">
                        <?php the_field('cp_name'); ?>   
                    </h5>
                    <span class="cp_designation">
                        <?php the_field('cp_designation'); ?>
                    </span>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/img/cp-quote.png' ); ?>" alt="Quote Icon" class="quote-icon" loading="lazy">
                </div>
            </div>
                
        </div>
    </div>
</section>
<section class="echo-block echo-block-cta_block text-end">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'cta_block',
        [
            'title'      => $cta_title ?: 'Ready to Strengthen <span class="highlight d-block">Your Board?</span>', // use the post title dynamically
            'title_tag'  => 'h2',
            'content'    => $cta_blurb ?: 'Every leadership transition represents both a risk and an opportunity. With the right support, it can be a catalyst for renewal and growth.',
            'button_group' => get_field( 'cta_button_group' ),
            
        ]
    );
    ?>
</section>