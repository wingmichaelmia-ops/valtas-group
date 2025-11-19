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
blockquote.wp-block-quote {
    padding: 2rem;
    background: rgba(0, 159, 237, .1);
    line-height: normal;
}
/* keep both columns aligned */
.blog-page .row.g-5 {
    align-items: start;
}
.blog-page a {
    text-decoration: none;
}
.blog-page a:hover {
    color: #f3b700;
}
</style>

<section class="echo-block echo-block-page_title">
<?php
get_template_part(
    'template-parts/partials/acf/blocks/block',
    'page_title',
    [
        'title'      => 'The Latest <span class="highlight">From Valtas</span>',
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
            <div id="blog-posts-wrapper"><!-- wrapper for AJAX -->

    <?php
    $paged = max(1, get_query_var('paged'), get_query_var('page'));

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'paged'          => $paged,
    ];

    $query = new WP_Query($args);
    ?>

    <div class="row g-4" id="blog-posts-container">
        <?php
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();

                $post_url   = urlencode(get_permalink());
                $post_title = urlencode(get_the_title());
                $share_facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
                $share_x        = 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url;
                ?>
                <div class="col-md-12 blog-item-post">
                    <div class="card h-100 border-0">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large', ['class' => 'card-img-top']); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-body py-4 px-0">
                            <div class="card-meta d-flex gap-3 small mb-2 align-items-center">
                                <div class="date-capsule"><?php echo get_the_date('m/d/y'); ?></div>
                                <div class="share-links d-flex gap-2">
                                    <a href="<?php echo esc_url($share_facebook); ?>" target="_blank" rel="noopener" class="text-primary">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/fb.png'); ?>" alt="Facebook" loading="lazy">
                                    </a>
                                    <a href="<?php echo esc_url($share_x); ?>" target="_blank" rel="noopener" class="text-dark">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/x.png'); ?>" alt="X" loading="lazy">
                                    </a>
                                </div>
                            </div>

                            <h3 class="card-title mb-3">
                                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a>
                            </h3>

                            <?php
                            $post_id = get_the_ID();
                            $content = get_the_content();
                            $excerpt = wp_trim_words( wp_strip_all_tags( $content ), 50, '..' ); // strip HTML and limit words

                            // Clean allowed tags (optional if you stripped all tags)
                            $excerpt = wp_kses($excerpt, [
                                'strong'=>[], 
                                'em'=>[], 
                            ]);

                            echo '<p>' . $excerpt . '</p>';
                            echo '<a href="' . esc_url(get_permalink($post_id)) . '" class="read-more">Read more</a>';
                            ?>
                        </div>
                        <hr class="my-3">
                    </div>
                </div>
                <?php
            endwhile;
        else :
            echo '<p>No blog posts found.</p>';
        endif;
        wp_reset_postdata();
        ?>
    </div> <!-- #blog-posts-container -->

    <!-- Pagination -->
    <div class="post-pagination text-center mt-4">
        <?php
        if ($query->max_num_pages > 1) {
            $paginate_links = paginate_links([
                'total' => $query->max_num_pages,
                'current' => $paged,
                'mid_size' => 2,
                'prev_text' => '&lt;',
                'next_text' => '&gt;',
                'type' => 'array'
            ]);

            foreach ($paginate_links as $link) {

                // Handle current page
                if (strpos($link, 'current') !== false) {
                    echo '<span class="current">' . strip_tags($link) . '</span>';
                    continue;
                }

                // Extract page number from link (supports both /page/2/ and ?paged=2)
                preg_match('/page\/(\d+)|paged=(\d+)/', $link, $matches);

                if (!empty($matches[1])) $page_num = $matches[1];
                elseif (!empty($matches[2])) $page_num = $matches[2];
                else $page_num = 1;

                // Replace <a> with AJAX link
                $link = preg_replace('/<a.*?>(.*?)<\/a>/', '<a href="#" class="ajax-page-link" data-page="'.$page_num.'">$1</a>', $link);

                echo $link;
            }
        }
        ?>
    </div>

</div> <!-- #blog-posts-wrapper -->
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <aside class="blog-sidebar">
                <?php 
                if (is_active_sidebar('blog-sidebar')) {
                    dynamic_sidebar('blog-sidebar');
                } else {
                    $sidebar_title   = function_exists('get_field') ? get_field('sidebar_title', 'option') : '';
                    $sidebar_content = function_exists('get_field') ? get_field('sidebar_content', 'option') : '';
                    if ($sidebar_title) echo '<h4>' . esc_html($sidebar_title) . '</h4>';
                    if ($sidebar_content) echo '<div>' . wp_kses_post($sidebar_content) . '</div>';
                    if (!$sidebar_title && !$sidebar_content)
                        echo '<p>Add widgets to the Blog Sidebar in Appearance → Widgets.</p>';
                }
                ?>
            </aside>
        </div>
    </div>
</div>


<?php get_footer(); 

add_action('wp_footer', function() {
?>
<script>
jQuery(document).ready(function($){

    function loadPosts(selectedYears, paged = 1) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_posts_by_year',
                years: selectedYears,
                paged: paged
            },
            beforeSend: function() {
                $('#blog-posts-container').addClass('loading');
            },
            success: function(response) {
                $('#blog-posts-container').html(response);
                $('#blog-posts-container').removeClass('loading');

                $('html, body').animate({
                    scrollTop: $('#blog-posts-container').offset().top - 80
                }, 300);
            }
        });
    }

    // Year checkbox change
    $(document).on('change', '.year-checkbox', function () {

        if ($(this).val() === 'all') {
            $('.year-checkbox').not('#year-all').prop('checked', false);
            $('#year-all').prop('checked', true);
        } else {
            $('#year-all').prop('checked', false);
        }

        let selectedYears = $('.year-checkbox:checked').map(function(){
            return $(this).val();
        }).get();

        if (selectedYears.length === 0) {
            $('#year-all').prop('checked', true);
            selectedYears = ['all'];
        }

        loadPosts(selectedYears, 1);
    });

    // AJAX pagination click
    $(document).on('click', '.ajax-page-link', function(e){
        e.preventDefault();

        let selectedYears = $('.year-checkbox:checked').map(function(){
            return $(this).val();
        }).get();

        if (selectedYears.length === 0) selectedYears = ['all'];

        let paged = $(this).data('page') || 1;

        loadPosts(selectedYears, paged);
    });

});
</script>
<?php
});
