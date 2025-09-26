<?php
$default = array(
    "title" => get_sub_field('title'),
    "text"  => get_sub_field('text'),
    "logos" => get_sub_field('logos'),
);

$args = wp_parse_args($args ?? [], $default);
?>

<div class="logo-carousel to-fade py-4" data-delay="0.1">
    <div class="container to-fade" data-delay="0.2">
            <?php if (!empty($args['logos']) && is_array($args['logos'])) : ?>
                <div>
                    <?php
                        $logo_count = count($args['logos']);
                    ?>
                    <div class="position-relative to-fade" data-delay="0.3">
                        <div class="logo-carousel-swiper swiper auto-init"
                             data-options='<?php echo json_encode($swiper_options); ?>'>
                            <div class="swiper-wrapper">
                                <?php foreach ($args['logos'] as $logo) : ?>
                                    <div class="swiper-slide">
                                        <img
                                        src="<?php echo esc_url($logo['url']); ?>"
                                        class="logo-carousel-image"
                                        alt="<?php echo esc_attr($logo['alt'] ?: 'Logo'); ?>">

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="swiper-button-prev swiper-nav-outside logo-carousel-nav-<?php echo esc_attr($args['block_index']); ?>"></div>
                        <div class="swiper-button-next swiper-nav-outside logo-carousel-nav-<?php echo esc_attr($args['block_index']); ?>"></div>
                    </div>
                </div>
            <?php endif; ?>

    </div>
</div>
