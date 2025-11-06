<?php
/**
 * Block: Why Valtas
 */

$default = array(
    'title_tag'      => get_sub_field('title_tag'),
    'title'          => get_sub_field('title'),
    'content'        => get_sub_field('blurb'),
    'featured_image' => get_sub_field('featured_image'),
    'button'         => get_sub_field('button'),
    'cards'          => get_sub_field('cards'), // repeater
);

$args = wp_parse_args($args, $default);
?>

<div class="why-valtas-block py-5">
    <div class="container">

        <?php if (!empty($args['title'])) : ?>
            <<?php echo esc_attr($args['title_tag'] ?: 'h2'); ?> class="section-title text-center mb-4">
                <?php echo $args['title']; ?>
            </<?php echo esc_attr($args['title_tag'] ?: 'h2'); ?>>
        <?php endif; ?>

        <?php if (!empty($args['content'])) : ?>
            <div class="section-intro text-center mb-5">
                <?php echo wp_kses_post($args['content']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($args['cards'])) : ?>
            <?php
            $has_image = !empty($args['featured_image']);
            $image_html = $has_image
                ? sprintf(
                    '<div class="col-lg-4 order-3 order-lg-2 d-flex justify-content-center align-items-center text-center">
                        <img src="%s" alt="%s" class="img-fluid">
                    </div>',
                    esc_url($args['featured_image']['url']),
                    esc_attr($args['featured_image']['alt'])
                )
                : '';
            ?>

            <div class="row g-4 justify-content-center align-items-stretch">

                <?php
                // Split cards into 2 groups (left + right)
                $left_cards  = array_slice($args['cards'], 0, ceil(count($args['cards']) / 2));
                $right_cards = array_slice($args['cards'], ceil(count($args['cards']) / 2));

                $counter = 1;

                // Left column
                if (!empty($left_cards)) :
                    echo '<div class="col-lg-4 order-1 d-flex flex-column gap-4">';
                    foreach ($left_cards as $card) :
                        $cards_title_tag = $card['cards_title_tag'] ?? 'h3';
                        $cards_title     = $card['cards_title'] ?? '';
                        $cards_blurb     = $card['cards_blurb'] ?? '';
                        $cards_button    = $card['cards_button'] ?? '';
                ?>
                        <div class="why-card h-100 text-md-start">
                            <?php if ($cards_title) : ?>
                                <div class="why-card-number fw-bold mb-2">
                                    0<?php echo $counter; ?>
                                </div>
                                <<?php echo esc_attr($cards_title_tag); ?> class="mb-3 fw-bold why-card-title pb-3">
                                    <?php echo esc_html($cards_title); ?>
                                </<?php echo esc_attr($cards_title_tag); ?>>
                            <?php endif; ?>

                            <?php if ($cards_blurb) : ?>
                                <div class="card-blurb mb-3">
                                    <?php echo wp_kses_post($cards_blurb); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($cards_button['url'])) : ?>
                                <a href="<?php echo esc_url($cards_button['url']); ?>" target="<?php echo esc_attr($cards_button['target'] ?? '_self'); ?>" class="btn btn-outline-primary btn-sm">
                                    <?php echo esc_html($cards_button['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                <?php
                        $counter++;
                    endforeach;
                    echo '</div>';
                endif;

                // Middle image (if exists) — now responsive order
                if ($has_image) echo $image_html;

                // Right column
                if (!empty($right_cards)) :
                    echo '<div class="col-lg-4 order-2 order-lg-3 d-flex flex-column gap-4">';
                    foreach ($right_cards as $card) :
                        $cards_title_tag = $card['cards_title_tag'] ?? 'h3';
                        $cards_title     = $card['cards_title'] ?? '';
                        $cards_blurb     = $card['cards_blurb'] ?? '';
                        $cards_button    = $card['cards_button'] ?? '';
                ?>
                        <div class="why-card h-100 text-start text-lg-end">
                            <?php if ($cards_title) : ?>
                                <div class="why-card-number fw-bold mb-2">
                                    0<?php echo $counter; ?>
                                </div>
                                <<?php echo esc_attr($cards_title_tag); ?> class="mb-3 fw-bold why-card-title pb-3">
                                    <?php echo esc_html($cards_title); ?>
                                </<?php echo esc_attr($cards_title_tag); ?>>
                            <?php endif; ?>

                            <?php if ($cards_blurb) : ?>
                                <div class="card-blurb mb-3">
                                    <?php echo wp_kses_post($cards_blurb); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($cards_button['url'])) : ?>
                                <a href="<?php echo esc_url($cards_button['url']); ?>" target="<?php echo esc_attr($cards_button['target'] ?? '_self'); ?>" class="btn btn-outline-primary btn-sm">
                                    <?php echo esc_html($cards_button['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                <?php
                        $counter++;
                    endforeach;
                    echo '</div>';
                endif;
                ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($args['button'])) :
            $main_url    = $args['button']['url'] ?? '';
            $main_label  = $args['button']['title'] ?? '';
            $main_target = $args['button']['target'] ?? '_self';
        ?>
            <div class="text-center mt-5">
                <a href="<?php echo esc_url($main_url); ?>" target="<?php echo esc_attr($main_target); ?>" class="btn btn-primary">
                    <?php echo esc_html($main_label); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
