<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'echo_container_type' );
$linkedin = get_field('linkedin', 'option');
$facebook = get_field('facebook', 'option');
$privacy_policy = get_field('privacy_policy', 'option');
$terms_conditions = get_field('terms_conditions', 'option');
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">
					<div class="footer-widgets">
						<div class="row border-top border-bottom">
							<div class="col-md-4 text-center p-4">
								<a href="<?php echo get_site_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/img/footer-logo.png'; ?>" alt="Valtas Group Logo"></a>
							</div>
							<div class="col-md-8 border-start">
								<div class="row">
									<div class="col-md-4 p-4">
										<h4 class="footer-title">Quick Links</h4>
										<?php
											wp_nav_menu(array(
												'theme_location' => 'quick-links', 
												'container' => 'nav',
												'container_class' => 'main-nav',
												'menu_class' => 'menu',
											));
										?>
									</div>
									<div class="col-md-4 p-4">
										<h4 class="footer-title">More Links</h4>
										<?php
											wp_nav_menu(array(
												'theme_location' => 'more-links', 
												'container' => 'nav',
												'container_class' => 'main-nav',
												'menu_class' => 'menu',
											));
										?>
									</div>
									<div class="col-md-4 p-4">
										<h4 class="footer-title">About</h4>
										<?php
											wp_nav_menu(array(
												'theme_location' => 'about-menu', 
												'container' => 'nav',
												'container_class' => 'main-nav',
												'menu_class' => 'menu',
											));
										?>
									</div>
									<div class="col-md-12 border-top p-4">
										<h4 class="footer-title">Contact Us</h4>
										<div class="row">
											<div class="col-md-4">
												<a href="mailto:<?php the_field('email', 'option'); ?>"><img src="<?php echo get_template_directory_uri() . '/img/email.svg'?>"> <?php the_field('email', 'option'); ?></a>
											</div>
											<div class="col-md-4">
												<a href="tel:<?php the_field('phone_number', 'option'); ?>"><img src="<?php echo get_template_directory_uri() . '/img/phone.svg'?>"> <?php the_field('phone_number', 'option'); ?></a>
											</div>
											<div class="col-md-4">
												<?php if($linkedin) { ?>
													<a href="<?php the_field('linkedin', 'option'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/img/linkedin.svg'?>"></a>
												<?php } ?>
												<?php if($facebook) { ?>
													<a href="<?php the_field('facebook', 'option'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri() . '/img/fb.svg'?>"></a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="site-info row py-3">
						<div class="col-md-6">
							© COPYRIGHT VALTAS GROUP - ALL RIGHTS RESERVED.
						</div>
						<div class="col-md-6 text-md-end">
							<?php if($privacy_policy) { ?><a href="<?php echo $privacy_policy; ?>">Privacy Policy</a><?php } ?>  |  <?php if($terms_conditions) { ?><a href="<?php the_field('terms_conditions', 'option') ?>">Terms & Conditions</a><?php } ?>
						</div>
						

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!-- col -->

		</div><!-- .row -->

	</div><!-- .container(-fluid) -->

</div><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>

