<?php
/**
 * Block: Project Feed
 */

// ACF fields
$title               = get_sub_field('title');
$title_tag           = get_sub_field('title_tag') ?: 'h2';
$categories          = get_sub_field('select_category');
$case_studies_layout = get_sub_field('case_studies_layout');

// Normalize categories
$term_ids = [];
if ($categories) {
    if (is_array($categories)) {
        foreach ($categories as $cat) {
            $term_ids[] = is_object($cat) ? $cat->term_id : intval($cat);
        }
    } else {
        $term_ids[] = is_object($categories) ? $categories->term_id : intval($categories);
    }
}

// Query for first batch
$args = [
    'post_type'      => 'case-study',
    'posts_per_page' => 4,
];

if (!empty($term_ids)) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'cs-category',
            'field'    => 'term_id',
            'terms'    => $term_ids,
        ]
    ];
}

$query = new WP_Query($args);

// Layout classes
if ($case_studies_layout === 'case_studies_layout_2') {
    $text_col  = 'col-md-6 ps-0 ps-lg-4';
    $image_col = 'col-md-6';
} else {
    $image_col = 'col-md-5';
    $text_col  = 'col-md-7 pt-5';
}
?>

<div class="project-block py-5">

    <div class="container text-center">
        <?php if ($title) : ?>
            <<?php echo esc_attr($title_tag); ?> class="block-title mb-4">
                <?php echo esc_html($title); ?>
            </<?php echo esc_attr($title_tag); ?>>
        <?php endif; ?>
    </div>

    <div class="container <?php echo esc_attr($case_studies_layout); ?>">

        <!-- Wrapper for AJAX -->
        <div id="project-feed-wrapper"
            data-categories="<?php echo esc_attr(implode(',', $term_ids)); ?>"
            data-layout="<?php echo esc_attr($case_studies_layout); ?>">

            <!-- Posts container -->
            <div id="project-feed-posts" class="row g-5">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>

                        <div class="project-item col-md-6">

                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <div class="project-item_img ratio ratio-16x9">
                                        <?php the_post_thumbnail('full', ['class' => 'object-fit-cover']); ?>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <div class="project-item_meta mt-3 mb-2">
                                IMPACT | <?php echo get_the_date('m/d/y'); ?>
                            </div>

                            <h5 class="project-title mb-3">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h5>

                            <?php
                            $custom_excerpt = get_field('org_blurb');
                            if ($custom_excerpt) :
                                $excerpt = mb_substr($custom_excerpt, 0, 300);
                                if (mb_strlen($custom_excerpt) > 300) {
                                    $excerpt = preg_replace('/\s+?(\S+)?$/', '', $excerpt) . '...';
                                }
                                echo wp_kses_post('<p>' . $excerpt . '</p>');
                            endif;
                            ?>

                        </div>

                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No case studies found.</p>
                <?php endif; ?>
            </div>

            <!-- Load More button -->
            <div class="load-more-wrap text-center mt-4">
                <div class="btn-valtas">
                    <a href="" id="project-load-more" class="btn btn-primary" data-offset="4"> 
                        <img src="https://valtasdev.wpenginepowered.com/wp-content/themes/valtas-theme/img/load.png"> &nbsp;Load More
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php wp_reset_postdata(); ?>
