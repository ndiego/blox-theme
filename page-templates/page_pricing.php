<?php
/**
 * This file adds the Pricing template to the Blox Theme.
 *
 * @author Nick Diego
 * @package Blox Theme
 * @subpackage Customizations
 */

/*
Template Name: Pricing
*/

// Add custom body class to the head
add_filter( 'body_class', 'blox_add_body_class' );
function blox_add_body_class( $classes ) {
   $classes[] = 'blox-pricing';
   return $classes;
}

// Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Run the Genesis loop
genesis();
