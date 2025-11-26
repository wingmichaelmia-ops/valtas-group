<?php

$default = array(
    'title_tag'        => get_sub_field('title_tag') ?: 'h2',
    'title'            => get_sub_field('title') ?: get_the_title(),
    'content'          => get_sub_field('blurb'),
    'background_image' => get_sub_field('background_image'),
    'button_group' => get_sub_field( 'button_group' ),
    'background_postion_desktop' => get_sub_field( 'background_postion_desktop' ) ?: '75',
    'background_postion_mobile' => get_sub_field( 'background_postion_mobile' ) ?: '80',
    'g_start' => get_sub_field('gradient_start') ?: '60',
    'g_end' => get_sub_field('gradient_end') ?: '100',
    'content_fullwidth' => get_sub_field('content_fullwidth') ?: false,
);

$args = wp_parse_args( $args, $default );


$g_start = $args['g_start'];
$g_end = $args['g_end'];
?>
<style>
    .echo-block-page_title .bg-image {
        object-position: <?php echo $args['background_postion_desktop']; ?>%;
    }
    @media (max-width: 767.98px) {
        .echo-block-page_title .bg-image {
            object-position: <?php echo $args['background_postion_mobile']; ?>%;
        }
    }
    <?php if($args['content_fullwidth']) : ?>
    .echo-block-page_title .page-title__content {
        max-width: 100%;
    }
    <?php endif; ?>
    <?php if ($g_start && $g_end) : ?>
    .echo-block-page_title:before {
        background: linear-gradient(90deg, #000 0, rgba(0, 0, 0, .59) <?php echo esc_attr($g_start); ?>%, rgba(0, 0, 0, 0) <?php echo esc_attr($g_end); ?>%);
    }
    <?php endif; ?>
</style>
    
    <?php 
        $image = get_sub_field('background_image');
        $header_image_id = get_field('header_background_image');
        if (empty($image)) {
            $image = get_post_thumbnail_id(get_the_ID());
        }
        // 🧩 If single post → always use fallback
        if ( is_single() ) {
            echo '<img src="' . esc_url( get_template_directory_uri() . '/img/default-banner.jpg' ) . '" alt="Default banner" class="bg-image" loading="lazy">';
           
        }
        $member_banner_image = get_field('boardx_background_image'); // ACF field

        if ( is_page_template('page-members-area.php') ) {

            $image_id = '';

            // If ACF returns an array (common when return format = array)
            if ( is_array($member_banner_image) && !empty($member_banner_image['ID']) ) {
                $image_id = $member_banner_image['ID'];

            // If ACF returns an ID
            } elseif ( is_numeric($member_banner_image) ) {
                $image_id = $member_banner_image;
            }

            // Display selected image
            if ( !empty($image_id) ) {
                echo wp_get_attachment_image(
                    $image_id,
                    'full',
                    false,
                    [
                        'class'   => 'bg-image feature-image',
                        'loading' => 'lazy'
                    ]
                );
                ?>
                <style>
                    .echo-block-page_title img.bg-image:nth-child(3) {
                        display: none;
                    }
                </style>
                <?php
            // Fallback image
            } else {
                echo '<img src="' . esc_url( get_template_directory_uri() . '/img/boardx-archive-banner.jpg' ) . '" alt="Default banner" class="bg-image" loading="lazy">';
            }
        }

        if ($image) {
            if (is_array($image) && isset($image['ID'])) {
                $image_id = $image['ID'];
            } elseif (is_numeric($image)) {
                $image_id = $image;
            }

            if (!empty($image_id)) {
                echo wp_get_attachment_image($image_id, 'full', false, [
                    'class'   => 'bg-image feature-image',
                    'loading' => 'lazy',
                ]);
            }
        } elseif ($header_image_id) {
            if (is_array($header_image_id) && isset($header_image_id['ID'])) {
                $image_id = $header_image_id['ID'];
            } elseif (is_numeric($header_image_id)) {
                $image_id = $header_image_id;
            }

            if (!empty($image_id)) {
                echo wp_get_attachment_image($image_id, 'full', false, [
                    'class'   => 'bg-image feature-image',
                    'loading' => 'lazy',
                ]);
            }
        } else {
            // fallback image (as <img> tag)
            echo '<img src="' . esc_url( get_template_directory_uri() . '/img/default-banner.jpg' ) . '" alt="" class="bg-image" loading="lazy">';
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
            <?php if ( !empty($args['button_group']) ) : ?>
                <div class="valtas-title-block__buttons d-flex flex-wrap gap-2">
                    
                    <?php
                        if ( is_user_logged_in() && is_page('boardspark') ) {
                            echo '<div class="btn-valtas"><a href="/boardspark-archive/">BoardSpark Archives</a></div>';
                            echo do_shortcode('[logout_button redirect="/login/" label="Sign Out"]');
                        } elseif ( is_user_logged_in() && is_page('boardspark-archive') ) {
                            echo '<div class="btn-valtas"><a href="/contact-us/">Contact Us</a></div>';
                            echo do_shortcode('[logout_button redirect="/login/" label="Sign Out"]');
                        } else {
                            foreach ( $args['button_group'] as $row ) : 
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
                            <?php endforeach; 
                        }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>


