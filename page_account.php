<?php
/**
 * This file adds the Account template to the Blox Theme.
 *
 * @author Nick Diego
 * @package Blox Theme
 * @subpackage Customizations
 */

/*
Template Name: Account
*/

// Add custom body class to the head
add_filter( 'body_class', 'blox_add_body_class' );
function blox_add_body_class( $classes ) {
   $classes[] = 'blox-account';
   return $classes;
}

// Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );

// Add account navigation back
add_action( 'genesis_before_content', 'blox_account_menu' );
function blox_account_menu() {
	wp_nav_menu( array( 
		'menu' => 'acccount_menu', 
		'container' => 'div', 
		'container_class' => '', 
		'container_id' => '', 
		'menu_class' => 'menu account-menu', 
		'menu_id' => '',
    	'echo' => true, 
    	'fallback_cb' => 'wp_page_menu', 
    	'before' => '', 
    	'after' => '', 
    	'link_before' => '', 
    	'link_after' => '', 
    	'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    	'depth' => 0, 
    	'walker' => '', 
    	'theme_location' => 'account_menu' 
    ) );
}

// Add login and logout links to account menu
add_filter( 'wp_nav_menu_items', 'blox_loginout_link', 10, 2 );
function blox_loginout_link( $items, $args ) {
    if ( is_user_logged_in() && $args->theme_location == 'account_menu' ) {
        $items .= '<li id="menu-item-logout" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. wp_logout_url( home_url() ) .'">Log Out</a></li>';
    } else if ( ! is_user_logged_in() && $args->theme_location == 'account_menu' ) {
        $items .= '<li id="menu-item-logout" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. site_url('login') .'">Log In</a></li>';
    }
    return $items;
}

// Remove the main content of the page so we can show it conditionally
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Add the page content back if the user is logged in, otherwise print the error message
add_action( 'genesis_before', 'blox_conditional_content' );
function blox_conditional_content() {
	if ( is_user_logged_in() ) {
		add_action( 'genesis_entry_content', 'genesis_do_post_content' );
    } else {
		add_action( 'genesis_entry_content', 'blox_login_error' );
    }
}

// Print logged out error message
function blox_login_error() {
	?>
	<div style="text-align=center">
		<h3><?php _e( 'Oops, it looks like you are not logged in...', 'blox-theme' );?></h3> 
		<p>You need to be a Blox customer to access this content. Already a Blox user? <a href="<?php echo site_url('login');?>">Login here</a>.</p> 
	</div>
	<?php
}

// Run the Genesis loop
genesis();
