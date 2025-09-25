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
			$args = array(
				"title"          => apply_filters( 'archive_title', get_the_archive_title()),
				"alignment"      => "start",
				"image_url"      => apply_filters( 'archive_image', get_the_post_thumbnail_url() ?: get_template_directory_uri() . '/assets/header-placeholder.jpg' )
			);

			get_template_part( 'template-parts/partials/acf/blocks/block', 'page_title', $args );

			get_template_part( 'template-parts/archive/filter', get_post_type());
			get_template_part( 'template-parts/archive/loop', get_post_type());
		?>
	</div><!-- #content -->
</main><!-- #main -->

<?php
get_footer();
