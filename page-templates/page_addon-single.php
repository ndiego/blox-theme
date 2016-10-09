<?php
/**
 * This file adds the Account template to the Blox Theme.
 *
 * @author Nick Diego
 * @package Blox Theme
 * @subpackage Customizations
 */

/*
Template Name: Addon - Single
*/

// Add custom body class to the head
add_filter( 'body_class', 'blox_add_body_class' );
function blox_add_body_class( $classes ) {
   $classes[] = 'blox-addon-single';
   return $classes;
}


add_action( 'genesis_sidebar', 'blox_print_addon_info', 2 );
function blox_print_addon_info() {
	$id = get_the_ID();

	$version       = get_post_meta( $id, 'blox_addon_version', true );
	$requires      = get_post_meta( $id, 'blox_addon_requires', true );
	$released      = get_post_meta( $id, 'blox_addon_released', true );
	$updated       = get_post_meta( $id, 'blox_addon_updated', true );
	$documentation = get_post_meta( $id, 'blox_addon_documentation', true );

	?>
	<section class="widget addon-meta">
		<div class="widget-wrap">
            <div class="addon-disclaimer">
                <p><?php echo sprintf( __( 'Blox add-ons are only available to %1$sDeveloper%2$s or %1$sMultisite%2$s license holders. Add-ons are not compatible with %3$sBlox Lite%2$s and cannot be purchased separately.', 'blox-theme' ), '<a href="/pricing">', '</a>', '<a href="https://wordpress.org/plugins/blox-lite/">' );?></p>
            </div>
			<div class="meta-value">
				<h4 class="widget-title widgettitle"><?php _e( 'Add-on Version', 'blox-theme' ); ?></h4>
				<p><?php echo $version; ?><br><a href="#changelog"><?php _e( 'View Changelog', 'blox-theme' ); ?></a></p>
			</div>
			<div class="meta-value">
				<h4 class="widget-title widgettitle"><?php _e( 'Requires Blox', 'blox-theme' ); ?></h4>
				<p><?php echo $requires; ?></p>
			</div>
			<div class="meta-value">
				<h4 class="widget-title widgettitle"><?php _e( 'Release Date', 'blox-theme' ); ?></h4>
				<p><?php echo $released; ?></p>
			</div>
			<div class="meta-value">
				<h4 class="widget-title widgettitle"><?php _e( 'Last Updated', 'blox-theme' ); ?></h4>
				<p><?php echo $updated; ?></p>
			</div>
			<div class="meta-value">
				<h4 class="widget-title widgettitle"><?php _e( 'Documentation', 'blox-theme' ); ?></h4>
				<p><a href="<?php echo $documentation; ?>" title="<?php _e( 'View Documentation', 'blox-theme' ); ?>"><?php _e( 'View Documentation', 'blox-theme' ); ?></a></p>
			</div>
			<div class="addons-home">
				<a href="/addons" class="button button-secondary"><?php _e( 'All Add-ons', 'blox-theme' ); ?></a>
			</div>
		</div>


	</section>
	<?php
}

//* Run the Genesis loop
genesis();
