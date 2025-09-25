<?php

$popups = get_field( 'site_popups', 'options' ) ?: array();

if ( ! empty( $popups ) ) {


    foreach( $popups as $key => $popup ) {

        $block_index = "site_popup_global_" . $key;

        $args = array(
            'block_index'   => $block_index, 
            'block_id'      => $block_index,
            "header"        => $popup['header'],
            "body"          => $popup['body'],
            "trigger"       => $popup['trigger']
        );

        get_template_part( 'template-parts/partials/acf/blocks/block', 'popup', $args);
        
    }
}