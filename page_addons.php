<?php
/**
 * This file adds the Account template to the Blox Theme.
 *
 * @author Nick Diego
 * @package Blox Theme
 * @subpackage Customizations
 */

/*
Template Name: Addons
*/

// Add custom body class to the head
add_filter( 'body_class', 'blox_add_body_class' );
function blox_add_body_class( $classes ) {
   $classes[] = 'blox-addons';
   return $classes;
}

// Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );

// Remove the main content of the page, we will add our own
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_entry_content', 'blox_do_addons' );

function blox_do_addons() {
	// Set up the objects needed
	$my_wp_query = new WP_Query();
	$all_pages = $my_wp_query->query( array( 
		'post_type' => 'page', 
		'orderby' => 'menu_order', 
		'order' => 'ASC', 
		'posts_per_page' => -1 
	) );

	// Get the page as an Object
	$addons_page =  get_page_by_title( 'Addons' );

	// Filter through all pages and find Portfolio's children
	$addons = get_page_children( $addons_page->ID, $all_pages );
	
	//echo print_r( $addons );

	
	if ( ! empty( $addons ) ) {
	?>
	<section class="addon-list columns columns-3 grid">
		<div class="wrapper">
		<?php foreach ( $addons as $addon ) { ?>
			<div class="item">
				<div class="item-wrapper">
					<a class="entry-image" href="<?php echo get_the_permalink( $addon->ID ); ?>" title="<?php echo get_the_title( $addon->ID ); ?>"><?php echo get_the_post_thumbnail( $addon->ID, 'full' ); ?></a>
					<h3 class="entry-title"><a href="<?php echo get_the_permalink( $addon->ID ); ?>" title="<?php echo get_the_title( $addon->ID ); ?>"><?php echo get_the_title( $addon->ID ); ?></a></h3>
					<p><?php echo get_excerpt( '150', $addon->post_excerpt ); ?></p>
				</div>
				<a class="readmore" href="<?php the_permalink( $addon->ID ); ?>" title="<?php the_title(); ?>"><?php _e( 'Learn More', 'blox-theme' ); ?></a>
		 	</div>
		<?php } wp_reset_query(); ?>
		</div>
	</section>
	<?php
	} else {
		_e( 'You have\'t added any Addons yet!', 'blox-theme' );
	}
}

//* Run the Genesis loop
genesis();