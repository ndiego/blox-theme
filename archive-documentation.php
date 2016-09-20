<?php
// Force full width
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove default archive title and add our custom documentation one
remove_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description' );
add_action( 'genesis_after_header', 'blox_do_documentation_archive_title', 2 );
function blox_do_documentation_archive_title() {
	?>
	<h1 class="entry-title" itemprop="headline">
		<?php _e( 'Documentation', 'blox-theme' ); ?>
	</h1>
	<?php get_search_form(); 
}

// Remove the archive loop...
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Print the documentation categories and all their associated docs
add_action( 'genesis_before_loop', 'blox_print_categories', 1 );
function blox_print_categories() {

	$args = array(
		'orderby'           => 'term_group', 
		'order'             => 'ASC',
		'hide_empty'        => true, 
		'fields'            => 'all', 
		'hierarchical'      => true, 
	); 

	$categories = get_terms( 'documentation-type', $args );
	
	if ( ! empty( $categories ) ) {
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
				'orderby'        => 'menu_order', 
				'order'          => 'ASC',
				'posts_per_page' => -1
			);
		
			$docs = new WP_Query( $args );
		
			if ( ! empty ( $docs ) ) {
				?>
				<div id="category_<?php echo $category->slug; ?>" class="documentation-wrapper">
					<div class="documentation-heading">
						<h3><?php echo $category->name; ?></h3>
					</div>
					<div class="documentation-body">
						<ul>
							<?php while ( $docs->have_posts() ) : $docs->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
				<?php
			}
		}
	} else {
		_e( 'Nothing to show here, add some docs with categories.', 'blox-theme' );
	}
}

genesis();