<?php
function blox_related_posts() {

	if ( is_singular( 'post' ) ) {

		$current_id = get_the_ID();

		$categories = get_the_terms( $current_id, 'category' );
		foreach ( $categories as $category ) {
			$category_array[] = $category->term_id;
		}

		$related_query = new WP_Query( array(
			'showposts'    => 2,
			'orderby' 	   => 'rand',
			'cat' 		   => implode( $category_array, ',' ),
			'post__not_in' => array( $current_id )
		) );

		if ( $related_query->have_posts() ) {
			?>
			<section class="latest-posts columns columns-2 grid">
				<div class="wrapper">
				<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
					<div class="item">
						<div class="item-wrapper">
							<a class="entry-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
							<header class="entry-header">
								<p class="entry-meta"><?php echo do_shortcode( '[post_date]' );?></p>
								<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
							</header>
							<div class="entry-content">
								<p><?php echo get_the_excerpt(); ?></p>
							</div>
						</div>
					</div>
				<?php endwhile; wp_reset_query(); ?>
				</div>
			</section>
			<?php
		}
	}
}
