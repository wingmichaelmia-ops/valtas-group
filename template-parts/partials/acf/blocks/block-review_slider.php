<?php
/**
 * Block: Valtas Review Block (from CPT)
 */

$default = array(
    'title_tag'  => get_sub_field('title_tag') ?: 'h2',
    'title'      => get_sub_field('title'),
    'content'    => get_sub_field('content'),
    'count'      => get_sub_field('testimonial_count') ?: -1, // optional limit
    'background' => get_sub_field('background')
);

$args = wp_parse_args($args ?? [], $default);

// Query Testimonials
$testimonial_query = new WP_Query(array(
    'post_type'      => 'testimonial',
    'posts_per_page' => $args['count'],
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));
$bg_style = '';
if (!empty($args['background'])) {
    $bg_style = 'style="background: url(' . esc_url($args['background']['url']) . ') center center / cover no-repeat;"';
}

?>

<div class="valtas-review-block py-5 px-3 px-lg-0" <?php echo $bg_style; ?>>
    <div class="container py-0 py-lg-5">
        <div class="row align-items-center">

            <div class="col-lg-12">
                <?php if ($testimonial_query->have_posts()) : ?>
                    <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                        <!-- Carousel Items -->
                        <div class="carousel-inner">
                            <?php
                            $index = 0;
                            while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                                $title       = get_field('testimonial_title') ?: get_the_title();
                                $blurb       = get_field('testimonials_review');
                                $name        = get_field('testimonials_name');
                                $designation = get_field('testimonials_designation');
                            ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="testimonial p-4">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/white-quote.png'); ?>" alt="Quote Icon" class="quote-icon" style="width:40px;">
                                        <?php if ($title) : ?>
                                            <h3 class="testimonial-title my-3 text-white"><?php echo esc_html($title); ?></h3>
                                        <?php endif; ?>

                                        <?php if ($blurb) : ?>
                                            <div class="testimonial-blurb mb-2 text-white">
                                                <?php echo wp_kses_post($blurb); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="testimonial-meta d-flex justify-content-between align-items-center mt-4">
                                            <div class="testimonial-meta_name">
                                                <?php if ($name) : ?>
                                                    <h3 class="testimonial-name d-block text-white mb-2 fw-bold"><?php echo esc_html($name); ?></h3>
                                                <?php endif; ?>
                                                <?php if ($designation) : ?>
                                                    <span class="testimonial-designation small  text-white"><?php echo esc_html($designation); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $index++; endwhile; wp_reset_postdata(); ?>
                        </div>

                        <!-- Controls -->
                        <div class="carousel-controls">
                            <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
