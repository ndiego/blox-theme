<?php

//* Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_loop', 'genesis_404' );
add_action( 'genesis_loop', 'blox_do_404' );

function blox_do_404() {
	?>
	<div class="page-title">
		<h1 class="entry-title" itemprop="headline"><?php _e( 'Hmm, this doesn\'t look right...', 'blox-theme' ); ?></h1>
		<p class="entry-subtitle"><?php _e( 'We can\'t seem to find the page you are looking for! Use the navigation at the top of the page to continue looking.', 'blox-theme' ); ?></p>
	</div>
	<?php
}


//* Run the Genesis loop
genesis();
