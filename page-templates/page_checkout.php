<?php
/**
 * This file adds the Account template to the Blox Theme.
 *
 * @author Nick Diego
 * @package Blox Theme
 * @subpackage Customizations
 */

/*
Template Name: Checkout
*/


// Add custom body class to the head
add_filter( 'body_class', 'blox_add_body_class' );
function blox_add_body_class( $classes ) {
   $classes[] = 'blox-checkout';
   return $classes;
}


// Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove navigation
remove_action( 'genesis_header_right', 'genesis_do_nav' );

remove_action( 'genesis_before', 'blox_page_modifications' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );


// Remove footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Run the Genesis loop
genesis();
