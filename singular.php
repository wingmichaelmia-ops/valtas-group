<?php
/**
 * The template for displaying all single posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="site-main" id="main">
	<div class="content" id="content" tabindex="-1">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				get_template_part( 'template-parts/partials/header/header_single', get_post_type() );

				the_post();

				get_template_part( 'template-parts/single/single', get_post_type() );
			}
		} else {
			get_template_part( 'template-parts/single/single', 'none' );
		}
		?>
	</div><!-- #content -->
</main><!-- #main -->

<?php
get_footer();
