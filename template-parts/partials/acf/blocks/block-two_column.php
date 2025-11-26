<?php
/**
 * Block: Two Column (based on Image + Text)
 */

$defaults = [
    // First column
    'title_tag_first'      => get_sub_field('title_tag_first_column') ?: 'h2',
    'title_first'          => get_sub_field('first_column_title'),
    'blurb_first'          => get_sub_field('first_column_blurb'),
    'image_first'          => get_sub_field('first_column_image'),
    'image_position_first' => get_sub_field('first_column_image_position') ?: 'top_first_column_image_position',
    'button_first'         => get_sub_field('first_column_button'),
    'css_first'         => get_sub_field('first_column_css'),

    // Second column
    'title_tag_second'      => get_sub_field('title_tag_second_column') ?: 'h2',
    'title_second'          => get_sub_field('second_column_title'),
    'blurb_second'          => get_sub_field('second_column_blurb'),
    'image_second'          => get_sub_field('second_column_image'),
    'image_position_second' => get_sub_field('second_column_image_position') ?: 'top_first_column_image_position',
    'button_second'         => get_sub_field('second_column_button'),
    'css_second'         => get_sub_field('second_column_css'),
];

$args = wp_parse_args($args ?? [], $defaults);

$css_first = $args['css_first'] ?? [];

if ( is_array( $css_first ) ) {
    $css_first = implode( ' ', $css_first ); // Convert to space-separated list
}

$css_second = $args['css_second'] ?? [];

if ( is_array( $css_second ) ) {
    $css_second = implode( ' ', $css_second ); // Convert to space-separated list
}
?>

<div class="two-column-block container py-5">
    <div class="row g-5">
        
        <!-- First Column -->
        <?php if ( $args['title_first'] || $args['blurb_first'] || $args['image_first'] ) : ?>
            <div class="col-lg-6 ">
                <div class="row align-items-center g-4 <?php echo $args['image_position_first'] === 'bottom_first_column_image_position' ? 'flex-column-reverse' : ''; ?> <?php echo esc_attr( implode( ' ', (array) $args['css_first'] ) ); ?>">
                    
                    <div class="col-12 image-col">
                        <?php if ( $args['image_first'] ) : ?>
                            <?php echo wp_get_attachment_image( $args['image_first'], 'large', false, ['class' => 'img-fluid'] ); ?>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 text-col">
                        <?php if ( $args['title_first'] ) : ?>
                            <<?php echo esc_html( $args['title_tag_first'] ); ?> class="page-title__title mb-3">
                                <?php echo  $args['title_first']; ?>
                            </<?php echo esc_html( $args['title_tag_first'] ); ?>>
                        <?php endif; ?>

                        <?php if ( $args['blurb_first'] ) : ?>
                            <div class="blurb">
                                <?php echo $args['blurb_first']; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $args['button_first'] ) : ?>
                            <div class="btn-valtas my-4">
                                <a href="<?php echo esc_url($args['button_first']['url']); ?>" 
                                   class="btn btn-primary"
                                   target="<?php echo esc_attr($args['button_first']['target'] ?: '_self'); ?>">
                                    <?php echo esc_html($args['button_first']['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endif; ?>

        <!-- Second Column -->
        <?php if ( $args['title_second'] || $args['blurb_second'] || $args['image_second'] ) : ?>
            <div class="col-lg-6">
                <div class="row align-items-center g-4 <?php echo $args['image_position_second'] === 'bottom_first_column_image_position' ? 'flex-column-reverse' : ''; ?>  <?php echo esc_attr( implode( ' ', (array) $args['css_second'] ) ); ?>">
                    
                    <div class="col-12 image-col">
                        <?php if ( $args['image_second'] ) : ?>
                            <?php echo wp_get_attachment_image( $args['image_second'], 'large', false, ['class' => 'img-fluid'] ); ?>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 text-col">
                        <?php if ( $args['title_second'] ) : ?>
                            <<?php echo esc_html( $args['title_tag_second'] ); ?> class="page-title__title mb-3">
                                <?php echo esc_html( $args['title_second'] ); ?>
                            </<?php echo esc_html( $args['title_tag_second'] ); ?>>
                        <?php endif; ?>

                        <?php if ( $args['blurb_second'] ) : ?>
                            <div class="blurb">
                                <?php echo  $args['blurb_second']; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $args['button_second'] ) : ?>
                            <div class="btn-valtas my-4">
                                <a href="<?php echo esc_url($args['button_second']['url']); ?>" 
                                   class="btn btn-primary"
                                   target="<?php echo esc_attr($args['button_second']['target'] ?: '_self'); ?>">
                                    <?php echo esc_html($args['button_second']['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
