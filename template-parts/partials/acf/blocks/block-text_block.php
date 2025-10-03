<?php
/**
 * Block: Image + Text Repeater (with Icon List)
 */

$defaults = [
    'title_tag'       => get_sub_field('title_tag'),
    'header_title'    => get_sub_field('header_title'),
    'intro_text'      => get_sub_field('intro_text'),
    'image_text'      => get_sub_field('image_text') ?: [],
    'header_position' => get_sub_field('header_position') ?: 'header-title-center',
];

$args = wp_parse_args($args ?? [], $defaults);
?>

<?php if ( !empty($args['header_title']) ) : ?>
    <div class="container pt-5 <?php echo esc_attr($args['header_position']); ?>">
        <?php if ( $args['header_title'] ) : ?>
            <<?php echo esc_html( $args['title_tag'] ); ?> class="valtas-cta-block__title">
                <?php echo  $args['header_title']; ?>
            </<?php echo esc_html( $args['title_tag'] ); ?>>
        <?php endif; ?>

        <?php if ( $args['intro_text'] ) : ?>
            <div class="valtas-cta-block__intro-text">
                <?php echo wp_kses_post( wpautop( $args['intro_text'] ) ); ?>
            </div>
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
            $css            = $row['css'] ?? '';
            $image_position = $row['image_position'] ?? 'left';
            $icon_list      = $row['icon_list'] ?? []; // 👈 nested repeater
            $button = $row['image-text_button'];

            $css_classes = is_array($css) ? implode(' ', array_map('esc_attr', $css)) : esc_attr($css);
        ?>
            <div class="row align-items-center image-text-row <?php echo $css_classes; ?> <?php echo $image_position === 'right' ? 'flex-row-reverse' : ''; ?>">
                <div class="col-lg-6 image-col">
                    <?php if ( $image ) : ?>
                        <?php echo wp_get_attachment_image( $image, 'large', false, ['class' => ''] ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 text-col">
                    <?php if ( $title ) : ?>
                        <<?php echo esc_html( $title_tag ); ?> class="page-title__title mb-3">
                            <?php echo $title; ?>
                        </<?php echo esc_html( $title_tag ); ?>>
                    <?php endif; ?>

                    <?php if ( $blurb ) : ?>
                        <div class="blurb">
                            <?php echo wp_kses_post($blurb); ?>
                        </div>
                        <?php if ( $button ) : ?>
                            <div class="btn-valtas my-4">
                                <a href="<?php echo esc_url($button['url']); ?>" 
                                class="btn btn-primary"
                                target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                                    <?php echo esc_html($button['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>  
                    <?php endif; ?>

                    <?php if ( !empty($icon_list) ) : ?>
                        <div class="icon-list mt-3">
                            <?php foreach ( $icon_list as $icon ) :
                                $icon_img   = $icon['icon_list_icon'] ?? '';
                                $icon_blurb = $icon['icon_list_blurb'] ?? '';
                            ?>
                                <div class="icon-list-item d-flex align-items-start mb-3">
                                    <?php if ( $icon_img ) : ?>
                                        <div class="icon me-3">
                                            <?php echo wp_get_attachment_image( $icon_img, 'thumbnail', false, ['class' => ''] ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( $icon_blurb ) : ?>
                                        <div class="icon-text">
                                            <?php echo wp_kses_post($icon_blurb); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
