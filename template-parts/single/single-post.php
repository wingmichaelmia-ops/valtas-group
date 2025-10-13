<?php
    // Share URLs
    $post_url   = urlencode( get_permalink() );
    $post_title = urlencode( get_the_title() );
    $share_facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
    $share_x        = 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url;

?>
<style>
    .page-title__content {
        max-width: 700px;
    }
    .echo-block-page_title .bg-image:nth-child(2) {
        display: none;
    }
    .echo-block-page_title h2.page-title__title {
        font-size: clamp(3.75rem, .1563rem + 11.5vw, 6.625rem);
    }
    img.bg-image.default-cta {
        display: none;
    }
    .post-thumbnail img {
        width: 100%;
        height: auto;;
    }
    .blog-content h2, .blog-content h3{
        font-size: clamp(1.25rem, 0.8594rem + 1.25vw, 1.5625rem);
        color: #012f6c;
        margin: 2rem 0;
    }
    .colored-box {
        background-color: #f4f7f8;
        padding: 2rem;
        margin: 1rem 0;
    }
</style>
<section class="echo-block echo-block-page_title">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'page_title',
        [
            'title'      => 'The Latest <span class="highlight">From Valtas</span>', // use the post title dynamically
            'title_tag'  => 'h2',
            'content'    => 'News, updates, and stories to keep you in the know.',
        ]
    );
    ?>
</section>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('full'); ?>
                </div>
                <div class="card-meta d-flex gap-3 small mb-2 align-items-center py-3">
                    <div class="date-capsule"><?php the_date(); ?></div>
                    <div class="share-links d-flex gap-2">
                        <a href="<?php echo esc_url( $share_facebook ); ?>" target="_blank" rel="noopener" class="text-primary" title="Share on Facebook">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/fb.png' ); ?>" alt="Facebook Icon" loading="lazy">
                        </a>
                        <a href="<?php echo esc_url( $share_x ); ?>" target="_blank" rel="noopener" class="text-dark" title="Share on X">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/x.png' ); ?>" alt="X Icon" loading="lazy"> 
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-12 col-lg-12">
            <h1 class="blog-title mb-3"><?php the_title(); ?></h1>
            <div class="blog-content pt-2 pb-5">
                <?php the_content() ?>
            </div>
        </div>
    </div>
</div>



<section class="echo-block echo-block-cta_block">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'cta_block',
        [
            'title'      => 'Ready to Get <span class="highlight">Started?</span>', // use the post title dynamically
            'title_tag'  => 'h2',
            'content'    => 'Strong boards build strong organizations. Let’s start a conversation about how we can help yours lead with vision, purpose, and confidence.',
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