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
	$addons_page =  get_page_by_title( 'Add-ons' );

	// Filter through all pages and find Portfolio's children
	$addons = get_page_children( $addons_page->ID, $all_pages );

	//echo print_r( $addons );


	if ( ! empty( $addons ) ) {
        $count = count($addons);
	?>
	<section class="addon-list columns columns-2 grid">
		<div class="wrapper">
		<?php foreach ( $addons as $addon ) { ?>
			<div class="item">
				<a class="entry-image" href="<?php echo get_the_permalink( $addon->ID ); ?>" title="<?php echo get_the_title( $addon->ID ); ?>"><?php echo get_the_post_thumbnail( $addon->ID, 'full' ); ?></a>
				<header class="entry-header">
                    <h3 class="entry-title"><a href="<?php echo get_the_permalink( $addon->ID ); ?>" title="<?php echo get_the_title( $addon->ID ); ?>"><?php echo get_the_title( $addon->ID ); ?></a></h3>
                </header>
                <div class="entry-content">
                    <p><?php echo get_the_excerpt( $addon->ID ); ?></p>
                    <a class="readmore button button-secondary" href="<?php the_permalink( $addon->ID ); ?>" title="<?php the_title(); ?>"><?php _e( 'Learn More', 'blox-theme' ); ?></a>
                </div>
		 	</div>
		<?php }

        // If there is an odd number of addons, show the filler block
        if ( $count % 2 != 0 ) {
            ?>
            <div class="item addon-idea">
                <div class="addon-idea-wrap">
				    <h2>Have a great new Add-on idea?</h2>
                    <p>Let us know! We are always looking for ways to improve and extend Blox.</p>
                    <a class="button button-secondary" href="/contact">Submit a Suggestion</a>
                </div>
		 	</div>
            <?php
        }

         ?>
		</div>
	</section>
	<?php
    wp_reset_query();

	} else {
		_e( 'You have\'t added any Addons yet!', 'blox-theme' );
	}
}

//* Run the Genesis loop
genesis();
