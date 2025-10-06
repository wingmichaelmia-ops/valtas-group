<?php
/**
 * Block: Valtas Cards
 */

$default = array(
    'title_tag'        => get_sub_field('title_tag'),
    'title'            => get_sub_field('title'),
    'content'          => get_sub_field('blurb'),
    'background_image' => get_sub_field('background_image'),
    'button'           => get_sub_field('button'),
    'cards'            => get_sub_field('cards'), // repeater
    'card_style'       => get_sub_field('card_style'), // new global card style option
);

$args = wp_parse_args($args, $default);

$bg_style = '';
if (!empty($args['background_image'])) {
    $bg_url = wp_get_attachment_image_url($args['background_image'], 'full');
    $bg_style = $bg_url ? 'style="background-image: url(' . esc_url($bg_url) . '); background-size: cover; background-position: center;"' : '';
}
?>

<div class="valtas-cards py-5" <?php echo $bg_style; ?>>
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
            <div class="row g-4 justify-content-center">
                <?php foreach ($args['cards'] as $card) :
                    $cards_title_tag = $card['cards_title_tag'] ?? 'h3';
                    $cards_title     = $card['cards_title'] ?? '';
                    $cards_blurb     = $card['cards_blurb'] ?? '';
                    $cards_image     = $card['cards_image'] ?? '';
                    $cards_button    = $card['cards_button'] ?? '';
                    $card_style      = $args['card_style'] ?? 'above_image'; // global control
                ?>

                    <div class="col-md-6">
                        <div class="card-item text-center h-100 p-0 overflow-hidden <?php echo esc_attr($card_style); ?>">
                            
                            <?php if ($card_style === 'image_overlay' && !empty($cards_image)) : 
                                $overlay_url = wp_get_attachment_image_url($cards_image, 'large');
                            ?>
                                <div class="card-img-overlay position-relative text-white d-flex align-items-center justify-content-center" style="background-image: url('<?php echo esc_url($overlay_url); ?>'); background-size: cover; background-position: center;">
                                    <div class="overlay-bg position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.5);"></div>
                                    <div class="overlay-content position-relative p-4">
                                        <div class="card-item_overlay-content">
                                            <?php if (!empty($cards_title)) : ?>
                                                <<?php echo esc_attr($cards_title_tag); ?> class="card-title mb-2">
                                                    <?php echo esc_html($cards_title); ?>
                                                </<?php echo esc_attr($cards_title_tag); ?>>
                                            <?php endif; ?>

                                            <?php if (!empty($cards_blurb)) : ?>
                                                <div class="card-text">
                                                    <?php echo wp_kses_post($cards_blurb); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($cards_button)) :
                                                $url    = $cards_button['url'] ?? '';
                                                $label  = $cards_button['title'] ?? '';
                                                $target = $cards_button['target'] ?? '_self';
                                            ?>
                                                <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="btn btn-outline-light">
                                                    <?php echo esc_html($label); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            <?php else : // Default: image above content ?>
                                <div class="card-content p-4">
                                    <?php if (!empty($cards_image)) : ?>
                                        <div class="card-img mb-3">
                                            <?php echo wp_get_attachment_image($cards_image, 'medium', false, array('class' => 'img-fluid')); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($cards_title)) : ?>
                                        <<?php echo esc_attr($cards_title_tag); ?> class="card-title mb-2">
                                            <?php echo esc_html($cards_title); ?>
                                        </<?php echo esc_attr($cards_title_tag); ?>>
                                    <?php endif; ?>

                                    <?php if (!empty($cards_blurb)) : ?>
                                        <div class="card-text mb-3">
                                            <?php echo wp_kses_post($cards_blurb); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($cards_button)) :
                                        $url    = $cards_button['url'] ?? '';
                                        $label  = $cards_button['title'] ?? '';
                                        $target = $cards_button['target'] ?? '_self';
                                    ?>
                                        <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="btn btn-primary">
                                            <?php echo esc_html($label); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
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
