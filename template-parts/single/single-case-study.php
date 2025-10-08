<?php
    $title = get_the_title(); // or get_sub_field('title');
    $words = explode(' ', trim($title));

    if (count($words) > 1) {
        $last_word = array_pop($words);
        $title_formatted = implode(' ', $words) . ' <span class="highlight">' . $last_word . '</span>';
    } else {
        $title_formatted = '<span>' . $title . '</span>';
    }
?>
<style>
    .page-title__content {
        max-width: 700px;
    }
</style>
<section class="echo-block echo-block-page_title">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'page_title',
        [
            'title'      => 'Case Studies: ' . $title_formatted, // use the post title dynamically
            'title_tag'  => 'h1',
        ]
    );
    ?>
</section>
<section class="overview py-5">
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
                <h2><?php echo get_field('org_title') ?: 'Organization <span class="highlight">Overview</span>'; ?></h2>
                <?php
                    the_field('org_blurb');
                ?>  
                
            </div>
        </div>
    </div>
</section>
<section class="challenge-block py-5 bg-light-secondary">
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
<section class="echo-block echo-block-cta_block">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'cta_block',
        [
            'title'      => 'Ready to Strengthen <span class="highlight">Your Board?</span>', // use the post title dynamically
            'title_tag'  => 'h2',
            'content'    => 'Every leadership transition represents both a risk and an opportunity. With the right support, it can be a catalyst for renewal and growth.',
            'button_group' => [
                [
                    'button' => [
                        'url'    => '/contact-us',
                        'title'  => 'Contact Us Today',
                        'target' => '_self',
                    ],
                ],
            ],
        ]
    );
    ?>
</section>