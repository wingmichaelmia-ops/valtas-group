<?php
/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
			?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<?php
			// Start the loop.
			while ( have_posts() ) {
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'templates/loops/content', get_post_format() );
			}
		} else {
			get_template_part( 'templates/loops/content', 'none' );
		}
		?>

		<?php
		// Display the pagination component.
		understrap_pagination();
		?>
	</div><!-- #content -->
</main><!-- #main -->

<?php
get_footer();
