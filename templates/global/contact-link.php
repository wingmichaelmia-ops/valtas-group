<?php
/**********************************************************
 *
 * File:         Contact Link
 * Description:  Output a contact link
 * Version:      v0.1
 * Modified:     20/05/2022
 *
 **********************************************************/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$defaults = array(
	'show-icon' => get_field('contact-link--show-icon') ?: 'yes',
	'show-text' => get_field('contact-link--show-text') ?: 'yes' ,
	'link-type' => get_field('contact-link--link-type') ?: 'phone',
	'colour'    => get_field('contact-link--colour') ?: 'base',
	'icon-size' => get_field('contact-link--icon-size') ?: '',
	'classes'   => isset( $block['className'] ) ? $block['className'] : '',
	'content'   => get_field('contact-link__content') ?: '',
);

$args       = isset( $args ) ? wp_parse_args( $args, $defaults ) : $defaults;

$classes    = array();
$classes[]  = 'contact-link';
$classes[]  = 'iconic-link';
$classes[]  = 'iconic-link--' . esc_html( $args['colour'] );
$classes[]  = $args['show-text'] == 'yes' ? 'iconic-link--has-text' : '';
$classes[]  = esc_html( $args['classes'] );
$classes[]  = isset( $block['align_text']) ? ' text--'.$block['align_text'] : '';
$classes[]  = 'contact-link__'.$args['link-type'];

$icon_size  = $args['icon-size'] ? 'iconic-link__icon--'.$args['icon-size'] : '';

$link_type  = esc_html( strtolower( str_replace( ' ', '', $args['link-type'] ) ) );
$link_value = get_option( 'options_g_'.$link_type );

if ( $link_type == 'email' ) {
	$link_href = 'mailto:'.$link_value;
} elseif ( $link_type == 'phone' || $link_type == 'phone_service' ) {
	$link_href = 'tel:' . str_replace( ' ', '', $link_value);
} else {
	$link_href = $link_value;
}

$icon      = $args['show-icon'] == 'yes' ? '<i class="contact-link__icon iconic-link__icon icon-'.$link_type.' '.$icon_size.'"></i>' : '';

$show_text = $args['show-text'] == 'yes' ? '' : 'visually-hidden';
$text      = sprintf('<span class="contact-link__label iconic-link__label %1$s">%2$s</span>', $show_text, do_shortcode($args['content']) );

echo sprintf('<a class="%1$s" href="%2$s" target="_blank">%3$s %4$s</a>', implode(' ', $classes), $link_href, $icon, $text);