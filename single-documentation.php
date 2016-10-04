<?php

// Force right sidebar
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

// Reposition Page Title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_after_header', 'blox_open_post_title', 1 );
add_action( 'genesis_after_header', 'blox_do_documentation_title', 2 );
add_action( 'genesis_after_header', 'blox_close_post_title', 3 );

function blox_do_documentation_title() {

	$categories = get_the_terms( get_the_ID(), 'documentation-type' );

	foreach ( $categories as $category ) {
		$category_array[] = '<a href="/documentation/#category_' . $category->slug . '">' . $category->name . '</a>';
	}
	?>
	<div class="post-description">
		<!--<span class="title-categories"><?php echo implode( $category_array, ', ' );?></span>-->
		<h1 class="entry-title" itemprop="headline"><?php echo get_the_title(); ?></h1>
	</div>
	<?php
}


// Remove Genesis empty widget notice, since we might not actually have any real widgets in the sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );


add_action( 'genesis_sidebar', 'blox_print_documentation_toc', 2 );
function blox_print_documentation_toc() {
	?>
	<section class="widget documentation-toc">
		<div class="widget-wrap">
			<h4 class="widget-title widgettitle"><?php _e( 'Table of Contents', 'blox-theme' ); ?></h4>
			<ol class="menu"></ol>
		</div>
	</section>

	<?php
}



add_action( 'genesis_sidebar', 'blox_print_selected_sidebar', 2 );
/**
 * Print the documentation categories and all their associated docs in the sidebar
 */
function blox_print_selected_sidebar() {

	$current_doc = get_the_title();

	$categories = get_the_terms( get_the_ID(), 'documentation-type' );

	foreach( $categories as $category ) {

		$args = array(
			'post_type' => 'documentation',
			'tax_query' => array(
				array(
					'taxonomy' => 'documentation-type',
					'field'    => 'slug',
					'terms'    => $category->slug,
				),
			),
			'orderby'   => 'menu_order',
			'order'     => 'ASC',
			'posts_per_page' => -1
		);

		$docs = new WP_Query( $args );

		if ( ! empty ( $docs ) ) {
			?>
			<section id="documentation_type_<?php echo $category->slug; ?>" class="widget documentation-type">
				<div class="widget-wrap">
					<h4 class="widget-title widgettitle"><?php echo $category->name; ?></h4>
					<ul class="menu">
						<?php while ( $docs->have_posts() ) : $docs->the_post(); ?>
						<li class="menu-item <?php echo $current_doc == get_the_title() ? 'current_menu_item' : ''; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
					</ul>
				</div>
			</section>
			<?php
		}
	}
	?>
	<section class="widget documentation-type">
		<div class="widget-wrap">
			<div class="documentation-home">
				<a class="button button-secondary" href="/documentation"><?php _e( 'All Documentation', 'easy-docs' ); ?></a>
			</div>
		</div>
	</section>
	<?php
}


add_action( 'genesis_entry_footer', 'blox_do_modified_text', 8 );


// Remove the entry header content
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove the entry footer markup and content
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

// Add edit button on admin side
add_action( 'genesis_after_entry', 'eds_edit_button' );
function eds_edit_button() {
	edit_post_link( '(Edit)' );
}

genesis();
