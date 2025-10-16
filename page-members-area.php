<?php
/**
 * Template Name: Members Area
 * Description: Private page for logged-in users only, using ACF renderer partial.
 */

global $post;

/**
 * Redirect logged-out users if page is restricted via Members plugin
 */
if (
	function_exists( 'members_is_post_content_restricted' ) &&
	isset( $post->ID ) &&
	members_is_post_content_restricted( $post->ID )
) {
	if ( ! is_user_logged_in() ) {
		// Custom login URL for your local site
		$login_url = '/login/';
		$redirect  = add_query_arg( 'redirect_to', urlencode( get_permalink( $post->ID ) ), $login_url );

		wp_redirect( $redirect );
		exit;
	}
}

get_header();
?>

<main id="primary" class="site-main members-area">
		<?php

		get_template_part( 'template-parts/partials/acf/renderer' );

		?>
</main>

<?php get_footer(); ?>
