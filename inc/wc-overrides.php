<?php
/**
 * WooCommerce functions and settings overrides
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Allow Shop Manager roles to paste iframes
 *
 * @source https://wordpress.org/support/topic/code-editor-field-and-user-capabilities-woocommerce/
 *
 * @return obj $role The capabilities
 */
add_action('admin_init', function () {
	if ( !get_role('shop_manager')) return;

	// gets the author role
	$role = get_role('shop_manager');

	// would allow the shop_manager to edit others' posts for current theme only
	$role->add_cap('unfiltered_html');
});
