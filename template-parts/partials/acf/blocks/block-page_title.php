<?php

$default = array(
    'title_tag'        => get_sub_field('title_tag') ?: 'h2',
    'title'            => get_sub_field('title') ?: get_the_title(),
    'content'          => get_sub_field('blurb'),
    'background_image' => get_sub_field('background_image') ?: get_post_thumbnail_id(get_the_ID()),
);

$args = wp_parse_args( $args, $default );

?>
    
    <?php 
        $image = get_sub_field('background_image');

        if (empty($image)) {
            $image = get_post_thumbnail_id(get_the_ID());
        }

        if ($image) {
            if (is_array($image) && isset($image['ID'])) {
                $image_id = $image['ID'];
            } elseif (is_numeric($image)) {
                $image_id = $image;
            }

            if (!empty($image_id)) {
                echo wp_get_attachment_image($image_id, 'full', false, [
                    'class'   => 'bg-image',
                    'loading' => 'lazy',
                ]);
            }
        }
    ?>


    <div class="container">
        <div class="page-title__content text-white">
            
            <?php if ( $args['title'] ) : ?>
                <<?php echo esc_html( $args['title_tag'] ); ?> class="page-title__title"><?php echo $args['title']; ?></<?php echo esc_html( $args['title_tag'] ); ?>>
            <?php endif; ?>

            <?php if ( $args['content'] ) : ?>
                    <?php echo wp_kses_post( wpautop( $args['content'] ) ); ?>
            <?php endif; ?>
            <?php 
                $link = get_sub_field('button');
                if( $link ): 
                    $url = $link['url'];
                    $title = $link['title'];
                    $target = $link['target'] ? $link['target'] : '_self';
                    ?>
                    <div class="btn-valtas">
                        <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="btn btn-primary">
                            <?php echo esc_html($title); ?>
                        </a>
                </div>
            <?php endif; ?>
        </div>
    </div>


