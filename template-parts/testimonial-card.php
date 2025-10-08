<?php
$hide_title   = get_field('hide_title');
$video_review = get_field('video_review');
$classes      = [];

if ( $hide_title ) $classes[] = 'no-title';
if ( $video_review ) $classes[] = 'has-video';
?>

<div class="masonry-item p-3 mb-4 border shadow <?php echo esc_attr( implode(' ', $classes) ); ?>">
    <?php if ( $video_review ) : ?>
        <div class="video-review ratio ratio-4x3 mb-3">
            <?php echo $video_review; ?>
        </div>
    <?php endif; ?>

    <?php if ( ! $hide_title ) : ?>
        <h5 class="project-title mb-2"><?php the_title(); ?></h5>
        <hr class="title-separator">
    <?php endif; ?>

    <div class="testimonial-review mb-3"><?php the_field('testimonials_review'); ?></div>
    <hr>
    <div class="testimonials-meta row align-items-center mt-3">
        <div class="col-8">
            <div class="testimonial-author mb-0"><?php the_field('testimonials_name'); ?></div>
            <div class="testimonial-company mb-0"><?php the_field('testimonials_designation'); ?></div>
        </div>
        <div class="col-4 text-end">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/quote-blue.svg' ); ?>" alt="Quote Icon" class="quote-icon">
        </div>
    </div>
</div>
