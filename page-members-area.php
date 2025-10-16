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

<style>
    .page-title__content {
        max-width: 477px;
    }
    .echo-block-page_title img.bg-image:nth-child(2) {
        display: none;
    }
</style>
<section class="echo-block echo-block-page_title">    
    
    <?php
    // ✅ Reusable ACF Page Title block
    get_template_part(
        'template-parts/partials/acf/blocks/block',
        'page_title',
        [
            'title'      => 'BoardX <span class="highlight">Archive</span>', // use the post title dynamically
            'title_tag'  => 'h1',
            'content'    => ' BoardX is a free, invitation-only resource hub powered by Valtas that equips nonprofit boards with tools, insights, and connections to grow their eXperience, eXpertise, and eXcellence, with a monthly donation from Valtas to every nonprofit whose board engages with the platform that month.',
        ]
    );
    ?>
</section>

<?php get_footer(); ?>
