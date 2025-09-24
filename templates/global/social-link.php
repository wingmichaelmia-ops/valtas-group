<?php
/**********************************************************
 *
 * File:         Social Link
 * Description:  Output a social media link
 * Version:      v0.1
 * Modified:     20/05/2022
 *
 **********************************************************/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$defaults = array(
	'site'      => get_field('social-link__social') ?: 'facebook',
	'show-text' => get_field('social-link--show-text') ?: 'no',
	'colour'    => get_field('social-link--colour') ?: 'base',
	'icon-size' => get_field('social-link--icon-size') ?: '',
	'classes'   => isset( $block['className'] ) ? $block['className'] : '',
);

$args      = isset( $args ) ? wp_parse_args( $args, $defaults ) : $defaults;

$classes   = array();
$classes[] = 'social-link';
$classes[] = 'iconic-link';
$classes[] = 'iconic-link--' . esc_html( $args['colour'] );
$classes[] = $args['show-text'] == 'yes' ? 'iconic-link--has-text' : '';
$classes[] = esc_html( $args['classes'] );

$icon_size = $args['icon-size'] ? 'iconic-link__icon--'.$args['icon-size'] : '';

$site      = esc_html( strtolower( str_replace( ' ', '', $args['site'] ) ) );
$link      = get_option( 'options_g_'.$site );
$text      = $args['show-text'] == 'no' ? '<span class="social-link__label visually-hidden">' : '<span class="social-link__label iconic-link__label">';
$text     .= ucfirst( $args['site'] ) . '</span>';

echo sprintf('<a class="%1$s" href="%2$s" target="_blank"><i class="social-link__icon iconic-link__icon icon-%3$s %4$s"></i>%5$s</a>', implode(' ', $classes), $link, $site, $icon_size, $text);