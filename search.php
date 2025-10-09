<?php
/**
 * Template: Search Results
 */

get_header();

// Get the search query
$search_query = get_search_query();
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
            'title'      => 'Results <span class="highlight">From Valtas</span>', // use the post title dynamically
            'title_tag'  => 'h1',
            'content'    => 'News, updates, and stories to keep you in the know.',
        ]
    );
    ?>
</section>
<div class="container py-5 search-results-page">
    <?php if ( have_posts() ) : ?>
        <div class="row g-4">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium_large', [ 'class' => 'card-img-top', 'loading' => 'lazy' ] ); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-body">
                            <h3 class="card-title h5">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="card-text">
                                <?php
                                $content = get_the_content();
                                echo wpautop( wp_trim_words( $content, 50, '...' ) );
                                ?>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0">
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="mt-5 text-center">
            <?php the_posts_pagination( [
                'mid_size'  => 2,
                'prev_text' => __( '&laquo; Prev', 'textdomain' ),
                'next_text' => __( 'Next &raquo;', 'textdomain' ),
            ] ); ?>
        </div>

    <?php else : ?>
        <div class="text-center py-5">
            <h2>No results found</h2>
            <p>Try searching again or explore our latest posts.</p>
            <?php get_search_form(); ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
