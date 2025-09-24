<?php
/**
 * WordPress functions and settings overrides
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Enable shortcodes on the text widget
 *
 * Allow shortcodes that are entered into the text widget to be rendered
 * on the frontend of the website
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Remove Site Health dashboard widget
 *
 * Prevent the Site Health widget from displaying on the WordPress
 * dashboard.
 */
add_action( 'wp_dashboard_setup', 'remove_site_health_widget' );
function remove_site_health_submenu() {
	$page = remove_submenu_page( 'tools.php', 'site-health.php' );
}

/**
 * Remove Site Health from admin menu
 */
add_action( 'admin_menu', 'remove_site_health_submenu', 999 );
function remove_site_health_widget() {
	global $wp_meta_boxes;
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] );
}

/**
 * Remove WordPress version from <head>
 *
 * Prevent WordPress declaring in the <head> which version is running
 * as this can help bots determine any venerabilities the site is
 * susceptible to
 *
 * @source https://digwp.com/2009/07/remove-wordpress-version-number/
 *
 * @param string $src The source URL of the enqueued style/script
 * @return string $src Amended source URL of the enqueued style/script
 */

// remove version from scripts and styles
add_filter('style_loader_src', 'remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'remove_version_scripts_styles', 9999);
function remove_version_scripts_styles($src) {

	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}

remove_action('wp_head', 'wp_generator'); // remove version from head
add_filter('the_generator', '__return_empty_string'); // remove version from rss

/**
 * Remove Users from REST endpoint
 *
 * By default the WordPress REST API publishes a public JSON feed listing all usernames
 * This can be a venerability by giving bots a way to scrape a list of usernames to try
 * brute forcing passwords again. This filter disables the username feed.
 *
 * @source https://juhastenroos.com/post/disable-wordpress-rest-api-endpoints-example-user-endpoint/
 *
 * @param array $endpoints Available endpoints
 * @return array $endpoints Revised list of available endpoints
 */
add_filter('rest_endpoints', 'disable_user_rest_endpoints');
function disable_user_rest_endpoints( $endpoints ) {

	if ( isset( $endpoints['/wp/v2/users'] ) ) {
		unset( $endpoints['/wp/v2/users'] );
	}

	if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
		unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
}

/**
 * User roles that can edit Privacy Policy page
 *
 * Allow more user roles to be able to edit the WordPress Privacy
 * policy page, beyond the default admin role
 *
 * @source https://wordpress.stackexchange.com/questions/318666/how-to-allow-editor-to-edit-privacy-page-settings-only
 *
 * @param string[] $caps Primitive capabilities required of the user
 * @param string $cap Capability being checked.
 * @param int $user_id The user ID
 * @param array $args Adds context to the capability check, typically starting with an object ID
 * @return string The capabilities
 */
add_action('map_meta_cap', 'custom_manage_privacy_options', 1, 4);
function custom_manage_privacy_options($caps, $cap, $user_id, $args) {

	if ( !is_user_logged_in() ) return $caps;

	$target_roles = array('seo-editor', 'editor', 'shop_manager', 'administrator');
	$user_meta    = get_userdata($user_id);
	$user_roles   = ( array ) $user_meta->roles;

	if (array_intersect($target_roles, $user_roles)) {
		if ('manage_privacy_options' === $cap) {
			$manage_name = is_multisite() ? 'manage_network' : 'manage_options';
			$caps = array_diff($caps, [ $manage_name ]);
		}
	}
	return $caps;
}

/**
 * Sets lazy to default on wp_get_attachment()
 *
 * @source https://developer.wordpress.org/reference/functions/wp_lazy_loading_enabled/
 *
 * @return obj $role The capabilities
 */
add_filter( 'wp_lazy_loading_enabled', '__return_true' );
