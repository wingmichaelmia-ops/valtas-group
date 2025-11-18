<?php
/**
 * Block: Testimonials Masonry Grid (with Load More)
 */

$settings = [
    'title_tag'       => get_sub_field('title_tag') ?: 'h2',
    'header_title'    => get_sub_field('header_title'),
    'intro_text'      => get_sub_field('intro_text'),
    'header_position' => get_sub_field('header_position') ?: 'header-title-center',
    'hide_title'      => get_sub_field('hide_title'),
    'taxonomy_filter' => get_sub_field('select_category'),
];

// Normalize taxonomy
$term_ids = [];
if ( ! empty( $settings['taxonomy_filter'] ) ) {
    $term_ids = is_array( $settings['taxonomy_filter'] ) 
        ? array_map( fn($t) => is_object($t) ? $t->term_id : $t, $settings['taxonomy_filter'] )
        : [ $settings['taxonomy_filter'] ];
}

// WP_Query (first batch)
$per_page = 4; // Number of posts to load initially
$query_args = [
    'post_type'      => 'testimonial',
    'posts_per_page' => $per_page,
    'paged'          => 1,
    'orderby'        => 'date',
    'order'          => 'ASC', // 👈 oldest first
];
if ( ! empty($term_ids) ) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'testimonial_category',
            'field'    => 'term_id',
            'terms'    => $term_ids,
            'operator' => 'IN',
        ],
    ];
}
$query = new WP_Query($query_args);
?>

<?php if ( $settings['header_title'] || $settings['intro_text'] ) : ?>
    <div class="container pt-5 <?php echo esc_attr($settings['header_position']); ?>">
        <?php if ( $settings['header_title'] ) : ?>
            <<?php echo esc_html( $settings['title_tag'] ); ?> class="valtas-cta-block__title">
                <?php echo $settings['header_title']; ?>
            </<?php echo esc_html( $settings['title_tag'] ); ?>>
        <?php endif; ?>

        <?php if ( $settings['intro_text'] ) : ?>
            <div class="valtas-cta-block__intro-text">
                <?php echo wp_kses_post( wpautop( $settings['intro_text'] ) ); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="container py-5 testimonials-masonry-wrapper" 
     data-post-type="testimonial" 
     data-per-page="<?php echo esc_attr($per_page); ?>" 
     data-tax-terms="<?php echo esc_attr( implode(',', $term_ids) ); ?>">

    <?php if ( $query->have_posts() ) : ?>
        <div class="masonry-grid">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php get_template_part('template-parts/testimonial', 'card'); ?>
            <?php endwhile; ?>
        </div>

        <?php if ( $query->found_posts > $per_page ) : ?>
            <div id="load-more-container">
                <div class="btn-valtas">
                    <a href="#load-more-container" target="_self" class="btn btn-primary load-more-testimonials" data-page="1">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/img/load.png' ); ?>"> &nbsp;Load More
                    </a>
                </div>
            </div>
            
        <?php endif; ?>
    <?php else : ?>
        <p>No testimonials found.</p>
    <?php endif; ?>
</div>

<?php wp_reset_postdata(); ?>
