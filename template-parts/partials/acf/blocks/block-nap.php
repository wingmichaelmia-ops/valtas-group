<?php
/**
 * Block: Image + Text Repeater (with Icon List)
 */

$defaults = [
    'title_tag'       => get_sub_field('title_tag'),
    'header_title'    => get_sub_field('header_title'),
    'intro_text'      => get_sub_field('intro_text'),
];

$args = wp_parse_args($args ?? [], $defaults);
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
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
            <?php
                $address = get_field('address', 'option');
            ?>
            <ul class="nap-list">
                <?php if($address) { ?>
                    <li>
                        <label>Our Location</label>
                        <img src="<?php echo get_template_directory_uri() . ?>'/img/nap_map-pin.png">
                        <?php echo $address; ?>
                    </li>
                <?php } ?>    
            </ul>
        </div>
    </div>
</div>