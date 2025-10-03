<?php
/**
 * Block: Case Studies by Category
 */

// Get ACF taxonomy field (could be array if multiple selected)

$title     = get_sub_field('title');
$title_tag = get_sub_field('title_tag') ?: 'h2';
$categories = get_sub_field('select_category'); 

// Normalize return values
if ( $categories ) {
    // If single value, make it an array
    $term_ids = is_array($categories) ? $categories : [ ( is_object($categories) ? $categories->term_id : $categories ) ];
} else {
    $term_ids = [];
}

// WP_Query args
$args = [
    'post_type'      => 'case-study', // or 'case-study', confirm slug
    'posts_per_page' => 6,
];

if ( ! empty($term_ids) ) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'cs-category', // replace with actual taxonomy slug
            'field'    => 'term_id',
            'terms'    => $term_ids,
            'operator' => 'IN', // will include posts that belong to any of the selected categories
        ],
    ];
}

$query = new WP_Query($args);
?>

<div class="case-studies-block py-5">
    <div class="container text-center">
        <?php if ( $title ) : ?>
            <<?php echo esc_attr($title_tag); ?> class="block-title mb-4">
                <?php echo $title; ?>
            </<?php echo esc_attr($title_tag); ?>>
        <?php endif; ?>
    </div>
    <div class="container">
        
        <?php if ( $query->have_posts() ) : ?>
            <?php $i = 1; // counter ?>
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="row align-items-center case-study-item">
                    <div class="col-md-7 pt-5">
                        <div class="cs-item-label">Case Study <?php echo $i; ?></div>
                        <h5 class="case-study-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h5>
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="col-md-5">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('full'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No case studies found.</p>
        <?php endif; ?>
    </div>
</div>

<?php wp_reset_postdata(); ?>
