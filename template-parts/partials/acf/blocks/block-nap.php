<?php
/**
 * Block: NAP Section
 */

$defaults = [
    'title_tag'    => get_sub_field('title_tag') ?: 'h2',
    'header_title' => get_sub_field('header_title'),
    'intro_text'   => get_sub_field('intro_text'),
    'contact_form'   => get_sub_field('contact_form'),
];

$args = wp_parse_args($args ?? [], $defaults);
?>

<div class="container py-5 px-4 px-lg-0">
    <div class="row g-4">
        <div class="col-lg-6">
            <?php if ( $args['header_title'] ) : ?>
                <<?php echo esc_attr( $args['title_tag'] ); ?> class="valtas-cta-block__title">
                    <?php echo wp_kses_post( $args['header_title'] ); ?>
                </<?php echo esc_attr( $args['title_tag'] ); ?>>
            <?php endif; ?>

            <?php if ( $args['intro_text'] ) : ?>
                <div class="valtas-cta-block__intro-text mb-4">
                    <?php echo wp_kses_post( wpautop( $args['intro_text'] ) ); ?>
                </div>
            <?php endif; ?>

            <?php
            // Fetch from Options Page (ACF)
            $address = get_field('address', 'option');
            $phone   = get_field('phone_number', 'option');
            $email   = get_field('email', 'option');
            ?>

            <ul class="nap-list list-unstyled">
                <?php if ( $address ) : ?>
                    <li class="d-flex">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/img/nap_map-pin.png' ); ?>" alt="Map Pin" class="me-2" loading="lazy">
                        <div>
                            <p class="d-block label">Our Location</p>
                            <?php echo wp_kses_post( $address ); ?>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if ( $phone ) : ?>
                    <li class="d-flex">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/img/nap_phone.png' ); ?>" alt="Phone Icon" class="me-2" loading="lazy">
                        <div>
                            <p class="d-block label">Call Us</p>
                            <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $phone) ); ?>">
                                <?php echo esc_html( $phone ); ?>
                            </a>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if ( $email ) : ?>
                    <li class="d-flex">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/img/nap_envelop.png' ); ?>" alt="Email Icon" class="me-2" loading="lazy">
                        <div>
                            <p class="d-block label">Email</p>
                            <a href="mailto:<?php echo antispambot( esc_attr( $email ) ); ?>">
                                <?php echo antispambot( esc_html( $email ) ); ?>
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col-lg-6">
            <?php if($args["contact_form"]) { ?>
                <div class="valtas-form">
                    <?php echo do_shortcode('[contact-form-7 id="'. $args["contact_form"] .'"]'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
