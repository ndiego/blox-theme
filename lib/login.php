<?php
//------------------------------------------------------------------------//
//---Functions for Login Settings-----------------------------------------//
//------------------------------------------------------------------------//

add_filter( 'login_headertitle', 'blox_login_logo_title' );
/**
 * Add custom title to the login logo (custom or not), replaces "Powered by Wordpress"
 */
function blox_login_logo_title() {
	return 'Go to homepage';
}


add_filter( 'login_headerurl', 'blox_login_logo_url' );
/**
 * Add custom link to the login logo (custom or not), replaces link to wordpress.org
 */
function blox_login_logo_url( $url ) {
	return 'https://www.bloxwp.com/';
}


add_action( 'login_enqueue_scripts', 'blox_login_styles' );

function blox_login_styles() {
	wp_register_style( 'blox-login-styles', get_stylesheet_directory_uri() . '/login.css' );
	wp_enqueue_style( 'blox-login-styles' );
}

//add_filter( 'login_redirect', 'blox_login_redirect', 10, 3 );
/**
 * Redirect non-admins to the homepage after logging into the site.
 */
function blox_login_redirect( $redirect_to, $request) {
	$user = wp_get_current_user();
	
	return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : home_url();
}