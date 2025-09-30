<?php
/**
 * Block: Image + Text Repeater
 */

// Default values (in case no args passed)
$defaults = [
    'image_text' => get_sub_field('image_text') ?: [],
];

$args = wp_parse_args($args ?? [], $defaults);
?>

<?php if ( !empty($args['image_text']) ) : ?>
    <div class="image-text-block container py-5">
        <?php foreach ( $args['image_text'] as $row ) : 
            $image          = $row['image'] ?? '';
            $title          = $row['title'] ?? '';
            $blurb          = $row['blurb'] ?? '';
            $title_tag      = $row['title_tag'] ?? 'h2';
            $title          = $row['title'] ?? '';
            $image_position = $row['image_position'] ?? 'left';
        ?>
            <div class="row align-items-center g-5 image-text-row <?php echo $image_position === 'right' ? 'flex-row-reverse' : ''; ?>">
                <div class="col-md-6 image-col">
                    <?php if ( $image ) : ?>
                        <?php echo wp_get_attachment_image( $image, 'large', false, ['class' => ''] ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 text-col">
                    <?php if ( $title ) : ?>
                        <<?php echo esc_html( $title_tag ); ?> class="page-title__title mb-4"><?php echo $title; ?></<?php echo esc_html( $title_tag ); ?>>
                    <?php endif; ?>
                    <?php if ( $blurb ) : ?>
                        <div class="blurb">
                            <?php echo wp_kses_post($blurb); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
