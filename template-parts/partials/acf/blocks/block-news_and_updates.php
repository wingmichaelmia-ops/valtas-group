<?php

$default = array(
    "title_tag"      => get_sub_field( 'title_tag' ),
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'blurb' ),
    "link"       => get_sub_field( 'link' ),
);

$args = wp_parse_args( $args, $default );
$button = $args['link'];
?>

<div class="valtas-insight-block py-5">
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
<?php
$blog_posts = get_posts([
    'post_type'      => 'post',
    'posts_per_page' => 4,
]);
?>

<?php
$blog_posts = get_posts([
    'post_type'      => 'post',
    'posts_per_page' => 4,
]);
?>

    <?php if ( $blog_posts ) : ?>
        <div class="blog-section container py-5">
            <div class="row g-4">
                <?php foreach ( $blog_posts as $index => $post ) : 
                    setup_postdata( $post );
                    $title   = get_the_title( $post );
                    $link    = get_permalink( $post );
                    $excerpt = get_the_excerpt( $post );
                    $thumb   = get_the_post_thumbnail( $post->ID, 'large', ['class' => 'card-img'] );
                    $date    = get_the_date('m-d-y', $post ); // Format 08-07-25
                ?>

                    <?php if ( $index === 0 ) : ?>
                        <!-- First post full-width with overlay -->
                        <div class="col-12">
                            <div class="card text-white featured-post">
                                <?php if ( $thumb ) : ?>
                                    <a href="<?php echo esc_url($link); ?>">
                                        <?php echo $thumb; ?>
                                    </a>
                                <?php endif; ?>
                                <div class="card-img-overlay p-5 d-flex flex-column justify-content-end bg-dark bg-opacity-50">
                                    <div  style="max-width:700px;">
                                    <div class="post-date mb-2">
                                        <?php echo esc_html($date); ?>
                                    </div>
                                    <h2 class="card-title">
                                        <a href="<?php echo esc_url($link); ?>" class="text-white text-decoration-none">
                                            <?php echo esc_html($title); ?>
                                        </a>
                                    </h2>
                                    <div class="card-text"><?php echo $excerpt; ?></div>
                                    <a href="<?php echo esc_url($link); ?>" class="btn btn-text text-white">Learn More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- Next three posts -->
                        <div class="col-md-4">
                            <div class="card border-radius-0 h-100">
                                <?php if ( $thumb ) : ?>
                                    <div class="card-img-top">
                                        <a href="<?php echo esc_url($link); ?>">
                                            <?php echo $thumb; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="post-date mb-2">
                                        <?php echo esc_html($date); ?>
                                    </div>
                                    <h5 class="card-title">
                                        <a href="<?php echo esc_url($link); ?>">
                                            <?php echo esc_html($title); ?>
                                        </a>
                                    </h5>
                                    <div class="card-text"><?php echo $excerpt; ?></div>
                                    <a href="<?php echo esc_url($link); ?>" class="btn btn-text">Learn More</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ( $button ) : ?>
                        <div class="btn-valtas my-4 btn-center">
                            <a href="<?php echo esc_url($button['url']); ?>" 
                            class="btn btn-primary"
                            target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        </div>
                    <?php endif; ?>  
</div>