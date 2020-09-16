<?php

function register_sedoo_maps_block_types() {

    // register a testimonial block.
    acf_register_block_type(array(
        'name'              => 'sedoo_blocks_maps',
        'title'             => __('Sedoo Maps'),
        'description'       => __('Ajoute un block maps'),
        'render_callback'   => 'sedoo_blocks_maps_render_callback',
        'enqueue_style'     => plugin_dir_url( __FILE__ ) . 'css/maps.css',
        'category'          => 'sedoo-block-category',
        'icon'              => 'location-alt',
        'keywords'          => array( 'maps','carte', 'sedoo' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_sedoo_maps_block_types');
}