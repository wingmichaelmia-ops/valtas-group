<?php
/**
 * Block: Image + Text Repeater
 */

// Default values (in case no args passed)
$defaults = [
    
    'title_tag' => get_sub_field('title_tag'),
    'header_title' => get_sub_field('header_title'),
    'intro_text' => get_sub_field('intro_text'),
    'image_text' => get_sub_field('image_text') ?: [],
];

$args = wp_parse_args($args ?? [], $defaults);
?>
<?php if ( !empty($args['header_title']) ) : ?>
<div class="container pt-5 text-center" style="max-width:800px">
   <?php if ( $args['header_title'] ) : ?>
        <<?php echo esc_html( $args['title_tag'] ); ?> class="valtas-cta-block__title"><?php echo $args['header_title']; ?></<?php echo esc_html( $args['title_tag'] ); ?>>
     <?php endif; ?>

    <?php if ( $args['intro_text'] ) : ?>
        <?php echo wp_kses_post( wpautop( $args['intro_text'] ) ); ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ( !empty($args['image_text']) ) : ?>
    <div class="image-text-block container py-5">
        <?php foreach ( $args['image_text'] as $row ) : 
            $image          = $row['image'] ?? '';
            $title          = $row['title'] ?? '';
            $blurb          = $row['blurb'] ?? '';
            $title_tag      = $row['title_tag'] ?? 'h2';
            $title          = $row['title'] ?? '';
            $css          = $row['css'] ?? '';
            $image_position = $row['image_position'] ?? 'left';
        ?>
            <div class="row align-items-center g-5 image-text-row <?php foreach ($css as $style) : ?>
            <?php echo esc_attr($style); ?>
        <?php endforeach; ?> <?php echo $image_position === 'right' ? 'flex-row-reverse' : ''; ?>">
                <div class="col-md-6 image-col">
                    <?php if ( $image ) : ?>
                        <?php echo wp_get_attachment_image( $image, 'large', false, ['class' => ''] ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 text-col">
                    <?php if ( $title ) : ?>
                        <<?php echo esc_html( $title_tag ); ?> class="page-title__title"><?php echo $title; ?></<?php echo esc_html( $title_tag ); ?>>
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
