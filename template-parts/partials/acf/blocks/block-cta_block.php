<?php

$default = array(
    "title_tag"      => get_sub_field( 'title_tag' ),
    "title"         => get_sub_field( 'title' ),
    "content"       => get_sub_field( 'blurb' ),
    "background_image" => get_sub_field('background_image'),
    "button_group" => get_sub_field( 'button_group' ),
    'background_postion_desktop' => get_sub_field( 'background_postion_desktop' ) ?: '75',
    'background_postion_mobile' => get_sub_field( 'background_postion_mobile' ) ?: '80'
);

$args = wp_parse_args( $args, $default );

?>
<style>
    .valtas-cta-block .bg-image {
        object-position: <?php echo $args['background_postion_desktop']; ?>%;
    }
    @media (max-width: 767.98px) {
        .valtas-cta-block .bg-image {
            object-position: <?php echo $args['background_postion_mobile']; ?>%;
        }
    }
</style>
<div class="valtas-cta-block">
    
    <?php 
        $image_id = get_sub_field('background_image');
        $cta_image_id = get_field('cta_background_image');
        if ( is_single() ) {
            echo '<img src="' . esc_url( get_template_directory_uri() . '/img/cta-single-post.jpg' ) . '" alt="Default banner" class="bg-image" loading="lazy">';
           
        }
        if ( $image_id ) {
            echo wp_get_attachment_image( $image_id, 'full', false, array(
                'class'   => 'bg-image',
                'loading' => 'lazy',
            ) );
        } elseif ( $cta_image_id ) {
            echo wp_get_attachment_image( $cta_image_id, 'full', false, array(
                'class'   => 'bg-image',
                'loading' => 'lazy',
            ) );
        } else {
            // fallback image (as <img> tag)
            echo '<img src="' . esc_url( get_template_directory_uri() . '/img/default-cta.jpg' ) . '" alt="" class="bg-image default-cta" loading="lazy">';
        }
    ?>
    <div class="container">
        <div class="valtas-cta-block__content px-0 text-white">
            
            <?php if ( $args['title'] ) : ?>
                <<?php echo esc_html( $args['title_tag'] ); ?> class="valtas-cta-block__title"><?php echo $args['title']; ?></<?php echo esc_html( $args['title_tag'] ); ?>>
            <?php endif; ?>

            <?php if ( $args['content'] ) : ?>
                <div class="valtas-cta-block__text">
                    <?php echo wp_kses_post( wpautop( $args['content'] ) ); ?>
                </div>
            <?php endif; ?>
            <?php if ( !empty($args['button_group']) ) : ?>
                <div class="valtas-cta-block__buttons d-flex flex-wrap gap-2">
                    <?php foreach ( $args['button_group'] as $row ) : 
                        $button = $row['button'] ?? null;
                        if ( $button ) :
                            $url    = $button['url'] ?? '';
                            $title  = $button['title'] ?? '';
                            $target = !empty($button['target']) ? $button['target'] : '_self';
                            
                            if ( $url && $title ) : ?>
                                <div class="btn-valtas">
                                    <a href="<?php echo esc_url($url); ?>" 
                                    target="<?php echo esc_attr($target); ?>" 
                                    class="btn btn-primary">
                                        <?php echo esc_html($title); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>