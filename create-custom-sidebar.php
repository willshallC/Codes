<?php

//*********Create Custom Sidebar**************

function rmc_sidebar_init() {

    register_sidebar( array(
        'name' => __( 'Custom Sidebar', 'wpb' ),
        'id' => 'custom-sidebar-id',
        'description' => __( 'This is your sidebar description.', 'rmc' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

}

add_action( 'widgets_init', 'rmc_sidebar_init' );

?>