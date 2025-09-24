<?php
/**********************************************************
 *
 * File:         Blocks
 * Description:  ACF blocks function call
 * Version:      v0.1
 * Modified:     23/01/24
 *
 **********************************************************/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// register blocks
add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {

	$blocks = array(
		'faqs-block',
		'text-image-block',
	);

	foreach ( $blocks as $block ) {
		register_block_type( get_stylesheet_directory() . '/templates/blocks/'.$block.'/block.json' );
	}
}
