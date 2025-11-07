<?php
/**
 * Block: Icon + Text Block
 */

$defaults = [
    'title_tag'       => get_sub_field('title_tag') ?: 'h2',
    'header_title'    => get_sub_field('header_title'),
    'intro_text'      => get_sub_field('intro_text'),
    'icon_text'       => get_sub_field('icon_list') ?: [], // renamed repeater
    'header_position' => get_sub_field('header_position') ?: 'header-title-center',
    'button'      => get_sub_field('button'),
    'icon_shadow'   => get_sub_field('icon_shadow'),
    'mobile_layout'   => get_sub_field('mobile_layout')
];

$args = wp_parse_args($args ?? [], $defaults);
$button = $args['button'];

$mobile_layout = $args['mobile_layout'];

if($mobile_layout == 'one_column') {
    $mobile_layout = 'col-lg';
} else {
    $mobile_layout = 'col-6 col-lg';
}
?>

<?php if ( $args['header_title'] || $args['intro_text'] ) : ?>
    <div class="container pt-5 <?php echo esc_attr($args['header_position']); ?>">
        <?php if ( $args['header_title'] ) : ?>
            <<?php echo esc_html( $args['title_tag'] ); ?> class="text-block__title">
                <?php echo $args['header_title']; ?>
            </<?php echo esc_html( $args['title_tag'] ); ?>>
        <?php endif; ?>

        <?php if ( $args['intro_text'] ) : ?>
            <div class="text-block__intro-text">
                <?php echo wp_kses_post( wpautop( $args['intro_text'] ) ); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ( !empty($args['icon_text']) ) : ?>
    <div class="icon-text-block container py-0 py-md-5 pb-5 <?php echo $args['icon_shadow'] ?>">
        <div class="row g-0 g-lg-4 mb-0 mb-md-5">
            <?php foreach ( $args['icon_text'] as $item ) :
                $icon_img = $item['image'] ?? '';
                $title    = $item['title'] ?? '';
                $blurb    = $item['blurb'] ?? '';
                $title_tag = $item['title_tag'] ?? 'h3';
            ?>
                <div class="<?php echo $mobile_layout; ?> icon-text-item">
                    <?php if ( $icon_img ) : ?>
                        <div class="icon mb-3">
                            <?php echo wp_get_attachment_image( $icon_img, 'thumbnail', false, ['class' => ''] ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $title ) : ?>
                        <<?php echo esc_html($title_tag); ?> class="text-title">
                            <?php echo esc_html($title); ?>
                        </<?php echo esc_html($title_tag); ?>>
                    <?php endif; ?>

                    <?php if ( $blurb ) : ?>
                        <div class="icon-text-blurb">
                            <?php echo wp_kses_post($blurb); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ( $button ) : ?>
            <div class="btn-valtas center-button my-4">
                <a href="<?php echo esc_url($button['url']); ?>" class="btn btn-primary" target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                    <?php echo esc_html($button['title']); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

