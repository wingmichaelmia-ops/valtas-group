<?php
/**
 * Block: Proeject Feed
 */

// Get ACF taxonomy field (could be array if multiple selected)

$title     = get_sub_field('title');
$title_tag = get_sub_field('title_tag') ?: 'h2';
$categories = get_sub_field('select_category'); 
$case_studies_layout = get_sub_field('case_studies_layout'); 

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
    'posts_per_page' => 4,
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
if($case_studies_layout == 'case_studies_layout_2') {
    $text_col = 'col-md-6 ps-0 ps-lg-4';
    $image_col = 'col-md-6';
} else {
    $image_col = 'col-md-5';
    $text_col = 'col-md-7 pt-5';
}
?>

<div class="project-block py-5">
    <div class="container text-center">
        <?php if ( $title ) : ?>
            <<?php echo esc_attr($title_tag); ?> class="block-title mb-4">
                <?php echo $title; ?>
            </<?php echo esc_attr($title_tag); ?>>
        <?php endif; ?>
    </div>
    <div class="container <?php echo $case_studies_layout ?>">
        <div class="row g-5 align-items-center">
            <?php if ( $query->have_posts() ) : ?>
                <?php $i = 1; // counter ?>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="project-item col-md-6">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <div class="project-item_img ratio ratio-16x9">
                                <?php the_post_thumbnail('full', ['class' => 'object-fit-cover']); ?>
                            </div>
                        </a>
                    <?php endif; ?>
                    <div class="project-item_meta mt-3 mb-2">
                       Project | <?php echo get_the_date(); ?>
                    </div>  
                    <h5 class="project-title mb-3">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h5>
                        
                    <?php the_field('custom_blurb'); ?>
                </div>
                <?php $i++; ?>   
                <?php endwhile; ?>
            <?php else : ?>
                <p>No case studies found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php wp_reset_postdata(); ?>
