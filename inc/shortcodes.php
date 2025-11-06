<?php
/**
 * Wordpress Shortcodes
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Current year shortcode
 *
 * Print out the current year
 */
add_shortcode('current-year', 'current_year_shortcode');
function current_year_shortcode() {
	return date('Y');
}



function my_contact_info_shortcode() {
    // Get values from ACF options (adjust field names to match yours)
    $phone = get_field('phone_number', 'option');
    $email = get_field('email', 'option');

    ob_start();
    ?>
    <div class="contact-info">
		<div class="row">
			<div class="col-7 col-md-6 border border-white p-2 p-md-3">
				<?php if ( $email ) : ?>
					Email Us <a href="mailto:<?php echo antispambot( esc_attr( $email ) ); ?>" class="text-white">
						<?php echo antispambot( esc_html( $email ) ); ?>
					</a>
				<?php endif; ?>
			</div>
			<div class="col-5 col-md-6 border border-white p-2 p-md-3">
				<?php if ( $phone ) : ?>
					Call Us <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $phone) ); ?>" class="text-white">
						<?php echo esc_html( $phone ); ?>
					</a>
        		<?php endif; ?>
			</div>
		</div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'contact_info', 'my_contact_info_shortcode' );