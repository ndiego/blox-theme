<?php
/**
 * This file adds the Home Page.
 *
 * @author Nick Diego
 * @package Blox Theme
 * @subpackage Customizations
 */

//add_action( 'wp_enqueue_scripts', 'blox_enqueue_home_scripts' );
/**
 * Enqueue Scripts
 */
function blox_enqueue_home_scripts() {

	wp_enqueue_script( 'blox-home', get_bloginfo( 'stylesheet_directory' ) . '/js/home.js', array( 'jquery' ), '1.0.0', true );

}

add_action( 'genesis_meta', 'blox_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function blox_home_genesis_meta() {

	if ( is_active_sidebar( 'home-widgets-1' ) || is_active_sidebar( 'home-widgets-2' ) || is_active_sidebar( 'home-widgets-3' ) || is_active_sidebar( 'home-widgets-4' ) || is_active_sidebar( 'home-widgets-5' ) || is_active_sidebar( 'home-widgets-6' ) ) {

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Add blox-home body class
		add_filter( 'body_class', 'blox_body_class' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );


		//* Add home widgets
		add_action( 'genesis_before_footer', 'blox_home_widgets', 1 );

	}
}

function blox_body_class( $classes ) {

	$classes[] = 'blox-home';
	return $classes;

}


function blox_home_widgets() {

	echo '<div id="home-widgets" class="home-widgets">';

	genesis_widget_area( 'home-widgets-1', array(
		'before' => '<div class="home-widgets-1 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-widgets-2', array(
		'before' => '<div class="home-widgets-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-widgets-3', array(
		'before' => '<div class="home-widgets-3 test widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-widgets-4', array(
		'before' => '<div class="home-widgets-4 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-widgets-5', array(
		'before' => '<div class="home-widgets-5 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-widgets-6', array(
		'before' => '<div class="home-widgets-6 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	echo '</div>';

}

genesis();
