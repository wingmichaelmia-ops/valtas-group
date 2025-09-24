<?php
/**
 * Plugin functions and settings overrides
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Disable Auto <p> on Contact Form 7
 *
 * Disable the default behaviour where every break entered in Contact Form 7 is turned into a paragraph
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );


/**
 * Change Contact Form 7 submit btn 
 *
 * Change Contact Form 7 submit btn from input type to button type
 */
//https://wpklik.com/wordpress-tutorials/html5-submit-button-element-wordpress/
remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
add_action('wpcf7_init', 'twentysixteen_child_cf7_button');

function twentysixteen_child_cf7_button() {
	wpcf7_add_form_tag('submit', 'twentysixteen_child_cf7_button_handler');
}

function twentysixteen_child_cf7_button_handler($tag) {
	$tag = new WPCF7_FormTag($tag);
	$class = wpcf7_form_controls_class($tag->type);
	$options = $tag->options;
	
	foreach ($options as $option) {
		if (strpos($option, "class:") === 0) {
			$class .= ' '.substr($option, 6);
		}
	}
	
	$class .= ' btn';
	$atts  = array();
	$atts['class']  = $tag->get_class_option($class);
	$atts['id'] = $tag->get_id_option();
	$atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
	$value = isset($tag->values[0]) ? $tag->values[0] : '';

	if (empty($value)) {
		$value = esc_html__('Contact Us', 'understrap-child');
	}

	$atts['type'] = 'submit';
	$atts = wpcf7_format_atts($atts);
	$html = sprintf('<button class="%1$s">%2$s</button>', $class, $value);
    
	return $html;
}