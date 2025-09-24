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

