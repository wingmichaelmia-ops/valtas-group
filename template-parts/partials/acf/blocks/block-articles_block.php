<?php
/**
 * Block: Articles Block
 */

$defaults = [
    'title_tag'       => get_sub_field('title_tag') ?: 'h2',
    'header_title'    => get_sub_field('header_title'),
    'intro_text'      => get_sub_field('intro_text'),
    'image_text'      => get_sub_field('image_text') ?: [],
    'header_position' => get_sub_field('header_position') ?: 'header-title-center',
    'articles'        => get_sub_field('category') ?: [],
];

$args = wp_parse_args($args ?? [], $defaults);
?>

<?php if (!empty($args['header_title'])) : ?>
    <div class="container pt-5 mb-5 <?php echo esc_attr($args['header_position']); ?>">
        <<?php echo esc_html($args['title_tag']); ?> class="valtas-cta-block__title">
            <?php echo $args['header_title']; ?>
        </<?php echo esc_html($args['title_tag']); ?>>

        <?php if ($args['intro_text']) : ?>
            <div class="valtas-cta-block__intro-text mb-5">
                <?php echo wp_kses_post(wpautop($args['intro_text'])); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
// Query articles by selected taxonomy terms (archieve)
if (!empty($args['articles'])) :

    // Normalize to slugs no matter the return type
    $taxonomy_slugs = [];

    if (is_array($args['articles'])) {
        foreach ($args['articles'] as $term) {
            if (is_object($term) && isset($term->slug)) {
                $taxonomy_slugs[] = $term->slug; // Term object
            } elseif (is_numeric($term)) {
                $term_obj = get_term($term, 'archieve');
                if ($term_obj && !is_wp_error($term_obj)) {
                    $taxonomy_slugs[] = $term_obj->slug;
                }
            } else {
                $taxonomy_slugs[] = sanitize_title($term); // Already a slug
            }
        }
    } else {
        // Single selection fallback
        if (is_object($args['articles']) && isset($args['articles']->slug)) {
            $taxonomy_slugs[] = $args['articles']->slug;
        } elseif (is_numeric($args['articles'])) {
            $term_obj = get_term($args['articles'], 'archieve');
            if ($term_obj && !is_wp_error($term_obj)) {
                $taxonomy_slugs[] = $term_obj->slug;
            }
        } else {
            $taxonomy_slugs[] = sanitize_title($args['articles']);
        }
    }

    // Query posts by taxonomy slug(s)
    $query = new WP_Query([
        'post_type'      => 'boardx-article',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'ASC', // oldest first
        'tax_query'      => [
            [
                'taxonomy' => 'xarchieve',
                'field'    => 'slug',
                'terms'    => $taxonomy_slugs,
            ],
        ],
    ]);

endif;
?>


<?php if (!empty($query) && $query->have_posts()) : ?>
    <div class="container pb-5">
        <div class="row g-4 align-items-stretch">
            <?php
            $count = 0;
            while ($query->have_posts()) :
                $query->the_post();
                $count++;
                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>

                <?php if ($count === 1) : ?>
                    <!-- Left large article -->
                    <div class="col-lg-4">
                        <div class="boardx-card large h-100 position-relative">
                            <?php if ($image): ?>
                                <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 featured-img" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            <div class="article-content bottom-0 start-0 py-2">
                                <h3 class="boardx-title"><?php the_title(); ?></h3>
                                <div class="boardx-excerpt">
                                    <?php echo wp_kses_post( wp_trim_words( get_the_content(), 30, '...' ) ); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="stretched-link opacity-0"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="col-lg-8 d-flex flex-column gap-4">
                <?php elseif ($count === 2) : ?>
                        <!-- Top right article -->
                        <div class="boardx-card flex-grow-1 position-relative">
                            <?php if ($image): ?>
                                <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                            <?php else: ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/img/note.png' ); ?>" class="mb-3">
                            <?php endif; ?>
                            <div class="article-content">
                                <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                <?php echo get_the_content(); ?>
                                <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
                            </div>
                        </div>

                        <div class="row flex-grow-1 g-4">
                <?php elseif ($count === 3 || $count === 4) : ?>
                            <!-- Bottom right small articles -->
                            <div class="col-6">
                                <div class="boardx-card small position-relative h-100">
                                    <?php if ($image): ?>
                                        <img src="<?php echo esc_url($image); ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>
                                    <div class="article-content">
                                        <h3 class="boardx-title mb-1"><?php the_title(); ?></h3>
                                        <?php echo get_the_content(); ?>
                                        <a href="<?php the_permalink(); ?>" class="text-decoration-underline">Read More</a>
                                    </div>
                                </div>
                            </div>
                <?php endif; ?>

            <?php endwhile; ?>
                        </div><!-- /.row -->
                    </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
