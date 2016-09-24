<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme
//include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );
include_once( get_stylesheet_directory() . '/lib/login.php' );
include_once( get_stylesheet_directory() . '/lib/documentation.php' );
//include_once( get_stylesheet_directory() . '/lib/shortcodes.php' );

// Set Localization (do not remove)
load_child_theme_textdomain( 'blox-theme', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'blox' ) );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Blox Theme', 'blox' ) );
define( 'CHILD_THEME_URL', 'http://www.outermsostdesign.com' );
define( 'CHILD_THEME_VERSION', '1.0.0' );



// Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'blox_load_scripts' );
function blox_load_scripts() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,700', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'global-js', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0', true );
}


// Add new image sizes
add_image_size( 'featured-page', 960, 700, TRUE );
add_image_size( 'featured-post', 400, 300, TRUE );

// Add theme support for page excerpts
add_post_type_support( 'page', 'excerpt' );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

// Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content' );

// Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'blox' ) ) );

// Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );

// Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

// Do page modifications (mostly title changes)
add_action( 'genesis_before', 'blox_page_modifications' );
function blox_page_modifications() {
	if ( is_page() && ! is_home() && ! is_front_page() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_after_header', 'blox_open_post_title', 1 );
		add_action( 'genesis_after_header', 'blox_do_page_title', 2 );
		add_action( 'genesis_after_header', 'blox_close_post_title', 3 );
	} elseif ( is_author() ) {
    	add_action( 'genesis_after_header', 'blox_open_post_title', 1 ) ;
        add_action( 'genesis_after_header', 'blox_do_author_title', 2 );
        add_action( 'genesis_after_header', 'blox_close_post_title', 3 );
        add_action( 'genesis_before_entry', 'blox_do_archive_thumbnails' );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	} elseif ( is_category() || is_archive() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
		add_action( 'genesis_after_header', 'blox_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 2 );
		add_action( 'genesis_after_header', 'blox_close_post_title', 3 );
        add_action( 'genesis_before_entry', 'blox_do_archive_thumbnails' );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	} elseif ( is_search() ) {
        remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
        add_action( 'genesis_after_header', 'blox_open_post_title', 1 ) ;
        add_action( 'genesis_after_header', 'genesis_do_search_title', 2 );
        add_action( 'genesis_after_header', 'blox_close_post_title', 3 );
        add_action( 'genesis_before_entry', 'blox_do_archive_thumbnails' );
    	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
    } elseif ( is_home() && ! is_front_page() ) {
        add_action( 'genesis_after_header', 'blox_open_post_title', 1 ) ;
        add_action( 'genesis_after_header', 'blox_do_blog_title', 2 );
        add_action( 'genesis_after_header', 'blox_close_post_title', 3 );
        add_action( 'genesis_before_entry', 'blox_do_archive_thumbnails' );
        remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
    } elseif ( is_singular( 'post' ) ) {
    	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
        add_action( 'genesis_after_header', 'blox_open_post_title', 1 ) ;
        add_action( 'genesis_after_header', 'blox_do_post_title', 2 );
        add_action( 'genesis_after_header', 'blox_close_post_title', 3 );
        add_action( 'genesis_entry_header', 'blox_do_post_thumbnail' );
        remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
    } elseif ( is_singular( 'download' ) ) {
    	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'genesis_after_header', 'blox_open_post_title', 1 );
		add_action( 'genesis_after_header', 'blox_do_page_title', 2 );
		add_action( 'genesis_after_header', 'blox_close_post_title', 3 );
    }
}

// Custom title opener
function blox_open_post_title() {
	echo '<div class="page-title"><div class="wrap">';
}

// Custom title closer
function blox_close_post_title() {
	echo '</div></div>';
}

// Custom page title
function blox_do_page_title() {
	$id       = get_the_ID();
	$title    = get_the_title();
	$subtitle = get_post_meta( $id, 'blox_subtitle', true );

	// If not title, return
	if ( 0 === mb_strlen( $title ) ) {
		return;
	}

	echo '<h1 class="entry-title" itemprop="headline">' . $title . '</h1>';

	if ( ! empty( $subtitle ) ) {
		echo '<p class="entry-subtitle">' . $subtitle . '</h1>';
	}
}

// Custom blog page title
function blox_do_blog_title() {
	?>
	<h1 class="entry-title" itemprop="headline"><?php _e( 'The Blox Blog', 'blox-theme' ); ?></h1>
	<p class="entry-subtitle"><?php _e( 'Release Notes & Tutorials', 'blox-theme' ); ?></p>
	<?php
}

// Custom single posts title
function blox_do_post_title() {

	$categories = get_the_terms( get_the_ID(), 'category' );

	foreach ( $categories as $category ) {
		$category_array[] = '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
	}

	$author_id = get_queried_object()->post_author;
	$author_archive_link = '<a href="' . get_author_posts_url ( $author_id ) . '">' . get_the_author_meta( 'display_name', $author_id ) . '</a>';

	?>
	<p class="title-categories"><?php echo implode( $category_array, ', ' );?></p>
	<h1 class="entry-title" itemprop="headline"><?php echo get_the_title(); ?></h1>
	<p class="title-meta entry-meta"><?php echo do_shortcode( '[post_date] by ' . $author_archive_link . ' [post_comments] [post_edit]' );?></p>
	<?php
}

// Custom author title
function blox_do_author_title() {
	$user_data = get_user_by( 'slug', get_query_var('author_name') );
	?>
	<h1 class="entry-title" itemprop="headline"><?php echo $user_data->nickname . "'s " . __( 'Posts', 'blox-theme' ); ?></h1>
	<?php
}

// Custom function for adding last modified text to docs
function blox_do_modified_text() {
	?>
	<div class="entry-last-modified">
		<?php echo __( 'Last updated', 'blox-theme' ) . ': ' . get_the_modified_date(); ?>
	</div>
	<?php
}

// Function for adding thumnails to single posts
function blox_do_post_thumbnail() {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'full' );
	}
}

// Function for adding thumbnails to archive pages
function blox_do_archive_thumbnails() {
	if ( has_post_thumbnail() ) {
		?>
		<a class="archive-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
		<?php
	}
}





// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');






// Add related posts on blog posts
add_action( 'genesis_after_entry', 'blox_single_related_posts', 1 );
function blox_single_related_posts() {

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
							<p class="entry-meta"><?php echo do_shortcode( '[post_date]' );?></p>
							<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo get_excerpt( '150' ); ?></p>
						</div>
						<a class="readmore" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php _e( 'Read More', 'blox-theme' ); ?></a>
					</div>
				<?php endwhile; wp_reset_query(); ?>
				</div>
			</section>
			<?php
		}
	}
}

// Custom function that generates a shorter excerpt
function get_excerpt( $characters, $excerpt = '' ){
	if ( $excerpt == '' ) {
		$excerpt = get_the_excerpt();
	}
	$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr( $excerpt, 0, $characters );
	$excerpt = substr( $excerpt, 0, strripos( $excerpt, " ") );
	$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
	$excerpt = $excerpt . ' [...]';
	return $excerpt;
}

// Prevent Page Scroll When Clicking the More Link
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );
function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}

// Modify the WordPress read more link
add_filter( 'get_the_content_more_link', 'blox_read_more_link' );
function blox_read_more_link() {
	return '... <div><a class="button" href="' . get_permalink() . '">Continue Reading</a></div>';
}

// Modify the size of the Gravatar in author box
add_filter( 'genesis_author_box_gravatar_size', 'blox_author_box_gravatar_size' );
function blox_author_box_gravatar_size( $size ) {
	return 96;
}

// Modify the size of the Gravatar in comments
add_filter( 'genesis_comment_list_args', 'blox_comment_list_args' );
function blox_comment_list_args( $args ) {
    $args['avatar_size'] = 60;
	return $args;
}

// Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'blox_remove_comment_form_allowed_tags' );
function blox_remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}

// Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

// Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-widgets-1',
	'name'        => __( 'Home 1', 'blox' ),
	'description' => __( 'This is the first section of the home page.', 'blox-theme' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-2',
	'name'        => __( 'Home 2', 'blox' ),
	'description' => __( 'This is the second section of the home page.', 'blox-theme' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-3',
	'name'        => __( 'Home 3', 'blox' ),
	'description' => __( 'This is the third section of the home page.', 'blox-theme' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-4',
	'name'        => __( 'Home 4', 'blox' ),
	'description' => __( 'This is the fourth section of the home page.', 'blox-theme' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-5',
	'name'        => __( 'Home 5', 'blox' ),
	'description' => __( 'This is the fifth section of the home page.', 'blox-theme' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-6',
	'name'        => __( 'Home 6', 'blox' ),
	'description' => __( 'This is the sixth section of the home page.', 'blox-theme' ),
) );




// Add new custom footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'blox_custom_footer' );
function blox_custom_footer() {
	?>
	<p>Copyright &copy; <?php echo date("Y") ?> <a href="http://www.outermostdesign.com/" target="_blank">Outermost Design, LLC</a>. All Rights Reserved. Blox is a product of Outermost Design, LLC.</p>
	<p>Proudly powered by <a href="http://www.wordpress.org/" target="_blank">Wordpress</a>, the <a href="http://www.studiopress.com/" target="_blank">Genesis Framework</a> and <a href="http://www.bloxwp.com/">Blox</a>.</p>
	<?php
}





// Redirect logged-in users to members page if they try and visit the login page
add_action( 'template_redirect', 'blox_redirect_login_to_members' );
function blox_redirect_login_to_members() {

	if ( is_page('login') && is_user_logged_in() && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {

		wp_redirect( '/your-account/', 301 );
  		exit;
    }
}

// Redirect un-logged-in users to login page is they try and visit the members page
add_action( 'template_redirect', 'blox_redirect_members_to_login' );
function blox_redirect_members_to_login() {

	if ( is_page('your-account') && ! is_user_logged_in() && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {

		wp_redirect( '/login/', 301 );
  		exit;
    }
}


// Register custom Account menu for account pages
register_nav_menus( array(
	'account_menu' => 'Account Navigation Menu'
) );


// EDD Functions

add_action( 'edd_register_account_fields_before', 'blox_register_account_fields_before', 10 );
function blox_register_account_fields_before() {
	echo '<p class="blox-cart-description">Your account will give you instant access to all past purchases and all purchased files. License renewals and priority support are also handled through your personalized account.</p>';
}
add_action( 'edd_purchase_form_before_email', 'blox_purchase_form_before_email', 10 );
function blox_purchase_form_before_email() {
	echo '<p class="blox-cart-description">We need your first name, last name and email address so that we can send you a purchase receipt and downloadable files. Your information will never be shared with a third party.</p>';
}
add_action( 'edd_checkout_login_fields_before', 'blox_checkout_login_fields_before', 10 );
function blox_checkout_login_fields_before() {
	echo '<span><legend>Account Login</legend></span>';
}

add_action( 'edd_payment_mode_before_gateways', 'blox_payment_mode_before_gateways', 10 );
function blox_payment_mode_before_gateways() {
	echo '<p class="blox-cart-description">We currently support PayPal and Amazon Payments. All transactions are handled securely through them. We will never see your credit card information.</p>';
}

remove_action( 'edd_purchase_form_before_submit', 'edd_terms_agreement' );
add_action( 'edd_purchase_form_before_submit', 'blox_terms_agreement' );
function blox_terms_agreement() {
	if ( edd_get_option( 'show_agree_to_terms', false ) ) {
		$agree_text  = edd_get_option( 'agree_text', '' );
		$agree_label = edd_get_option( 'agree_label', __( 'Agree to Terms?', 'easy-digital-downloads' ) );
		?>
		<fieldset id="edd_terms_agreement">
			<span><legend>Terms of Use</legend></span>
			<p class="blox-cart-description">You must check the box below to purchase Blox.</p>
			<label for="edd_agree_to_terms">
				<input name="edd_agree_to_terms" class="required" type="checkbox" id="edd_agree_to_terms" value="1"/>
				By purchasing Blox, you agree to the <a href="https://www.bloxwp.com/terms-conditions/" title="Terms and Conditions" target="_blank">Terms &amp; Conditions</a> of use.
			</label>
		</fieldset>
		<?php
	}
}

remove_action( 'edd_cart_empty', 'edd_empty_checkout_cart' );
add_action( 'edd_cart_empty', 'blox_empty_checkout_cart' );
function blox_empty_checkout_cart() {
	?>
	<div style="text-align: center; max-width: 700px;margin: 0 auto;">
		<h2>Oops... There's nothing in your cart!</h2>
		<p>Head over to the pricing page to learn about the different licensing options for Blox.</p>
		<a class="button" href="/pricing">View Pricing</a>

		<p class="example-block warning" style="margin-top:50px;">Did you actually add a Blox license to your cart and it isn't showing up here? Try clearing your browser cache and then add a license to your cart again.</p>
	</div>
	<?php
}
