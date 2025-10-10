<?php
/**
 * Template Name: Blog Page
 */

get_header();
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
            'title'      => 'The Latest <span class="highlight">From Valtas</span>', // use the post title dynamically
            'title_tag'  => 'h1',
            'content'    => 'News, updates, and stories to keep you in the know.',
        ]
    );
    ?>
</section>
<div class="blog-page container py-5 px-3 px-md-0">
    <div class="row g-5">
        <!-- Main Blog Posts -->
        <div class="col-lg-8 blog-items">
            <?php
            // Get current page number
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            // Query for blog posts
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'paged'          => $paged,
            );

            $query = new WP_Query($args);

            if ( $query->have_posts() ) :
                echo '<div class="row g-4">';

                while ( $query->have_posts() ) :
                    $query->the_post();
                    // Share URLs
                    $post_url   = urlencode( get_permalink() );
                    $post_title = urlencode( get_the_title() );

                    $share_facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
                    $share_x        = 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url;
                    ?>
                    <div class="col-md-12 blog-item-post">
                        <div class="card h-100 border-0">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large', array('class' => 'card-img-top')); ?>
                                </a>
                            <?php endif; ?>

                            <div class="card-body py-4 px-0">
                                <div class="card-meta d-flex gap-3 small mb-2 align-items-center">
                                    <div class="date-capsule"><?php echo get_the_date(); ?></div>
                                    <div class="share-links d-flex gap-2">
                                        <a href="<?php echo esc_url( $share_facebook ); ?>" target="_blank" rel="noopener" class="text-primary" title="Share on Facebook">
                                            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/fb.png' ); ?>" alt="Facebook Icon" loading="lazy">
                                        </a>
                                        <a href="<?php echo esc_url( $share_x ); ?>" target="_blank" rel="noopener" class="text-dark" title="Share on X">
                                            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/x.png' ); ?>" alt="X Icon" loading="lazy">    
                                        </a>
                                    </div>
                                </div>
                                <h3 class="card-title mb-3">
                                    <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <?php
                                    if ( ! function_exists( 'trim_preserve_html' ) ) {
                                        /**
                                         * Trim text to a number of words while preserving HTML formatting.
                                         */
                                        function trim_preserve_html( $text, $limit = 100 ) {
                                            // Split by spaces but keep HTML tags
                                            $words = preg_split( '/(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE );
                                            $word_count = 0;
                                            $output = '';

                                            foreach ( $words as $word ) {
                                                // Count only actual words, not HTML tags or whitespace
                                                if ( trim( $word ) !== '' && strip_tags( $word ) === $word ) {
                                                    $word_count++;
                                                }

                                                $output .= $word;

                                                if ( $word_count >= $limit ) {
                                                    break;
                                                }
                                            }

                                            // Fix any unclosed HTML tags
                                            $output = force_balance_tags( $output );

                                            return $output . '';
                                        }
                                    }

                                    // 1️⃣ Get post content or manual excerpt
                                    $post_id = get_the_ID();
                                    $excerpt = trim( get_post_field( 'post_excerpt', $post_id ) );

                                    if ( empty( $excerpt ) ) {
                                        $excerpt = get_post_field( 'post_content', $post_id );
                                    }

                                    // 2️⃣ Remove unwanted fragments like "[...]" or "Read More... from ..."
                                    $excerpt = preg_replace( '/\s*\[.*?\]\s*/', ' ', $excerpt );
                                    $excerpt = preg_replace( '/\s*Read\s*More.*$/i', ' ', $excerpt );

                                    // 3️⃣ Trim while keeping HTML formatting
                                    $excerpt = trim_preserve_html( $excerpt, 100 );

                                    // 4️⃣ Add read more link
                                    $read_more_link = '<a href="' . esc_url( get_permalink( $post_id ) ) . '" class="read-more">Read more</a>';

                                    // 5️⃣ Output with allowed post HTML (keeps formatting)
                                    echo wp_kses_post( $excerpt . $read_more_link );
                                ?>
                            </div>
                        <hr class="my-3">
                        </div>
                    </div>
                    <?php
                endwhile;

                echo '</div>';

                // Pagination
                echo '<div class="mt-5">';
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '« Prev',
                    'next_text' => 'Next »',
                ));
                echo '</div>';

                wp_reset_postdata();
            else :
                echo '<p>No blog posts found.</p>';
            endif;
            ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <aside class="blog-sidebar">
                <?php 
                // Option 1: Use default WP sidebar (curly-brace syntax)
                if ( is_active_sidebar('blog-sidebar') ) {
                    dynamic_sidebar('blog-sidebar');
                } else {
                    // Option 2: Fallback to ACF fields or static content
                    $sidebar_title   = function_exists('get_field') ? get_field('sidebar_title', 'option') : '';
                    $sidebar_content = function_exists('get_field') ? get_field('sidebar_content', 'option') : '';

                    if ( $sidebar_title ) {
                        echo '<h4>' . esc_html($sidebar_title) . '</h4>';
                    }

                    if ( $sidebar_content ) {
                        echo '<div>' . wp_kses_post($sidebar_content) . '</div>';
                    }

                    if ( ! $sidebar_title && ! $sidebar_content ) {
                        echo '<p>Add widgets to the Blog Sidebar in Appearance → Widgets.</p>';
                    }
                }
                ?>
            </aside>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $('#category-filter-form input[type="checkbox"]').on('change', function() {
        let selected = [];

        $('#category-filter-form input[type="checkbox"]:checked').each(function() {
            selected.push($(this).val());
        });

        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            type: 'POST',
            data: {
                action: 'filter_blog_posts',
                categories: selected
            },
            beforeSend: function() {
                $('.blog-item-post').css('opacity', '0.5');
            },
            success: function(response) {
                $('.blog-item-post').css('opacity', '1');
                $('.col-lg-8 .row.g-4').html(response);
            }
        });
    });
});
</script>
<script>
jQuery(document).ready(function($) {
    $('#year-filter-form .year-checkbox').on('change', function() {
        let selectedYears = [];

        // If "All Years" is checked, uncheck others
        if ($(this).val() === 'all' && $(this).is(':checked')) {
            $('#year-filter-form .year-checkbox').not(this).prop('checked', false);
        } else {
            $('#year-filter-form .year-checkbox[value="all"]').prop('checked', false);
        }

        $('#year-filter-form .year-checkbox:checked').each(function() {
            selectedYears.push($(this).val());
        });

        // AJAX request
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: {
                action: 'filter_blog_posts',
                years: selectedYears
            },
            beforeSend: function() {
                $('#blog-posts-container').css('opacity', '0.5');
            },
            success: function(response) {
                $('#blog-posts-container').css('opacity', '1').html(response);
            },
            error: function() {
                $('#blog-posts-container').css('opacity', '1').html('<p>Error loading posts.</p>');
            }
        });
    });
});
</script>


<?php get_footer(); ?>
