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
            <?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = [
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'paged'          => $paged,
];

$query = new WP_Query($args);
?>

<div id="blog-posts-container">

    <?php if ($query->have_posts()) : ?>
        <div class="row g-4">
            <?php while ($query->have_posts()) : $query->the_post(); ?>

                <div class="col-md-4">
                    <article class="blog-card">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                            </a>
                        <?php endif; ?>

                        <h3 class="blog-title mt-3">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <p class="blog-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </p>

                        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                    </article>
                </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>

    <?php
    // Pagination as ARRAY for AJAX
    $pagination = paginate_links([
        'total'     => $query->max_num_pages,
        'current'   => $paged,
        'type'      => 'array',
        'mid_size'  => 2,
        'prev_text' => '&lt;',
        'next_text' => '&gt;',
    ]);
    ?>

    <div id="ajax-pagination" class="post-pagination text-center mt-4">
        <?php if (!empty($pagination)): ?>
            <ul class="pagination justify-content-center">
                <?php foreach ($pagination as $page): ?>
                    <li class="page-item">
                        <?php echo str_replace('page-numbers', 'page-link', $page); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <?php wp_reset_postdata(); ?>

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

<script>
jQuery(document).ready(function($) {
    function loadFilteredPosts(data) {
        $.ajax({
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            type: 'POST',
            data: data,
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
    }

    // Category Filter
    $('#category-filter-form input[type="checkbox"]').on('change', function() {
        let selected = [];
        $('#category-filter-form input[type="checkbox"]:checked').each(function() {
            selected.push($(this).val());
        });
        loadFilteredPosts({
            action: 'filter_blog_posts',
            categories: selected
        });
    });

    // Year Filter
    $('#year-filter-form .year-checkbox').on('change', function() {
        let selectedYears = [];
        if ($(this).val() === 'all' && $(this).is(':checked')) {
            $('#year-filter-form .year-checkbox').not(this).prop('checked', false);
        } else {
            $('#year-filter-form .year-checkbox[value="all"]').prop('checked', false);
        }
        $('#year-filter-form .year-checkbox:checked').each(function() {
            selectedYears.push($(this).val());
        });
        loadFilteredPosts({
            action: 'filter_blog_posts',
            years: selectedYears
        });
    });
});
</script>

<?php get_footer(); ?>
