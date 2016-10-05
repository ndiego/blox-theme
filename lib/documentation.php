<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


add_filter( 'single_template', 'blox_single_template' );
add_filter( 'archive_template', 'blox_archive_template' );

add_filter( 'manage_edit-documentation_columns', 'add_docs_column_header' );
add_filter( 'manage_documentation_posts_custom_column', 'add_docs_column_value', 10, 3);

// Setup taxonomy ordering
add_filter( 'manage_edit-blox_category_columns', 'add_column_header' );
add_filter( 'manage_blox_category_custom_column', 'add_column_value', 10, 3);
add_action( 'documentation-type_add_form_fields', 'term_group_add_form_field' );
add_action( 'documentation-type_edit_form_fields', 'term_group_edit_form_field' );

add_action( 'create_term', 'add_edit_term_group' );
add_action( 'edit_term', 'add_edit_term_group' );

add_action( 'quick_edit_custom_box', 'quick_edit_term_group', 10, 3 );


add_action( 'init', 'blox_register_documentation_post_type' );
function blox_register_documentation_post_type() {

	$labels = array(
		'name'               => __( 'Documentation', 'blox' ),
		'singular_name'      => __( 'Doc', 'blox' ),
		'add_new'            => __( 'Add New', 'blox' ),
		'add_new_item'       => __( 'Add New Doc', 'blox' ),
		'edit_item'          => __( 'Edit Doc', 'blox' ),
		'new_item'           => __( 'New Doc', 'blox' ),
		'view_item'          => __( 'View Doc', 'blox' ),
		'search_items'       => __( 'Search Documentation', 'blox' ),
		'not_found'          => __( 'No documentation found.', 'blox' ),
		'not_found_in_trash' => __( 'No documentation found in trash.', 'blox' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( 'Documentation', 'blox' )
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'show_ui'			  	    => true,
		'show_in_admin_bar'   => true,
		'rewrite'             => array( 'slug' => 'documentation' ),
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-book-alt',
		'has_archive'		 		  => true,
		'hierarchical'		    => true,
		'supports'     		    => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo' ),
		//'taxonomies'		  => array( 'blox_category' )
	);

	// Register the easy_docs post type
	register_post_type( 'documentation', $args );
}

add_action( 'init', 'blox_register_documentation_categories' );
function blox_register_documentation_categories() {

	$labels = array(
		'name'                       => __( 'Categories' ),
		'singular_name'              => __( 'Category' ),
		'search_items'               => __( 'Search Categories' ),
		'popular_items'              => __( 'Popular Categories' ),
		'all_items'                  => __( 'All Categories' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Category' ),
		'update_item'                => __( 'Update Category' ),
		'add_new_item'               => __( 'Add New Category' ),
		'new_item_name'              => __( 'New Category Name' ),
		'separate_items_with_commas' => __( 'Separate Categories with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Categories' ),
		'choose_from_most_used'      => __( 'Choose from the most used Categories' ),
		'not_found'                  => __( 'No Categories found.' ),
		'menu_name'                  => __( 'Categories' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'has_archive'           => false,
		'rewrite'               => array( 'slug' => 'documentation-type' ),
	);

	// Register category taxonomy
	register_taxonomy( 'documentation-type', 'documentation', $args );
}


function blox_archive_template( $archive_template ) {
	 global $post;

	 if ( is_post_type_archive ( 'documentation' ) ) {
		if ( file_exists( get_stylesheet_directory() .  'archive-documentation.php' ) ) {
			$archive_template = get_stylesheet_directory() . 'archive-documentation.php';
		}
	 }
	 return $archive_template;
}


function blox_single_template( $single_template ) {
	global $post;

	if ($post->post_type == 'documentation'){
		if ( file_exists( get_stylesheet_directory() .  'single-documentation.php' ) ) {
			$single_template = get_stylesheet_directory() . 'single-documentation.php';
		}
	}
	return $single_template;
}


function add_docs_column_header( $columns ) {

	$new_columns = array();

	// Specify where we want to put our column
	foreach( $columns as $key => $title ) {
		if ( $key=='date' ) {
			$new_columns['menu_order'] = __( 'Order', 'blox-theme' );
		}
		$new_columns[$key] = $title;
	}
	return $new_columns;
}

function add_docs_column_value( $column_name, $post_ID ) {
	if ( $column_name == 'menu_order' ) {

		$order = get_post_field( 'menu_order', $post_ID);

		if ( ! empty( $order ) ) {
			echo $order;
		} else {
			echo '<span aria-hidden="true">—</span>';
		}
	}
}


function add_column_header( $columns ) {

	$columns['term_group'] = __( 'Order', 'blox-theme' );
	return $columns;
}

function add_column_value( $empty = '', $column, $term_id ) {

	$term = get_term( $term_id, 'documentation-type' );

	// Here $column is equal to term_group
	return $term->$column;
}


function add_edit_term_group( $term_id ) {

	global $wpdb;

	if ( isset($_POST['term_group_order'] ) ) {

		$wpdb->update( $wpdb->terms, array( 'term_group' => $_POST['term_group_order'] ), array( 'term_id' => $term_id ) );
	}
}

function term_group_add_form_field() {

	$form_field = '<div class="form-field"><label for="term_group_order">' . __( 'Order', 'blox-theme' ) . '</label><input name="term_group_order" id="term_group_order" type="text" value="0" style="width:5em" /><p>' . __( 'Choose the category order. This is the order in which the categories will be displayed on the frontend.', 'blox-theme' ) . '</p></div>';

	echo $form_field;
}

function term_group_edit_form_field( $term ) {

	$form_field = '<tr class="form-field"><th scope="row" valign="top"><label for="term_group_order">' . __( 'Order', 'blox-theme' )  . '</label></th><td><input name="term_group_order" id="term_group_order" type="text" value="' . $term->term_group . '" style="width:5em" /><p class="description">' . __( 'Choose the category order. This is the order in which the categories will be displayed on the frontend.', 'blox-theme' ) .'</p></td></tr>';

	echo $form_field;
}

function quick_edit_term_group() {

	$term_group_field = '<fieldset><div class="inline-edit-col"><label><span class="title">' . __( 'Order', 'blox-theme' ) . '</span><span class="input-text-wrap"><input class="ptitle" name="term_group_order" type="text" value="" /></span></label></div></fieldset>';
	echo $term_group_field;
}







add_action( 'wp_enqueue_scripts', 'blox_documentation_scripts' );
/**
 * Loads scripts for documentation pages
 *
 */
function blox_documentation_scripts() {

	if ( is_tax( 'documentation-type' ) || get_post_type() == 'documentation' ){

		// Ajax stuff for the search form
		wp_enqueue_script( 'ajax-search', get_bloginfo( 'stylesheet_directory' ) . '/js/documentation/ajax-search.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'ajax-search', 'SearchDocumentation', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

	if ( is_singular() && get_post_type() == 'documentation' ){

		wp_enqueue_script( 'single-frontend-scripts', get_bloginfo( 'stylesheet_directory' ) . '/js/documentation/single.js', array( 'jquery' ), '1.0.0', true );
	}
}

add_action( 'wp_ajax_blox_load_search_results', 'blox_load_search_results' );
add_action( 'wp_ajax_nopriv_blox_load_search_results', 'blox_load_search_results' );
/**
 * Loads the documenation search results
 *
 */
function blox_load_search_results() {

	// Modify the excerpts for search
	add_filter( 'excerpt_length', 'blox_set_search_excerpt_length' );
	add_filter( 'excerpt_more', 'blox_set_search_excerpt_more' );
	
	$query = $_POST['query'];

	$args = array(
		'post_type' => 'documentation',
		'post_status' => 'publish',
		's' => $query
	);
	$search = new WP_Query( $args );

	ob_start();
	?>
	<div class="search-results-wrapper">
	<h3><?php printf( __( 'Search Results for "%s"', 'blox-theme' ), '<strong>' . $query . '</strong>' ); ?></h3>

		<?php
		if ( $search->have_posts() ) {
			while ( $search->have_posts() ) : $search->the_post();

				$categories = get_the_terms( get_the_ID(), 'documentation-type' );
				if ( $categories && ! is_wp_error( $categories ) ) {
					$category_array = array();
					foreach ($categories as $category) {
						$category_array[] = $category->name;
					}
					$category_string = join( ", ", $category_array);
				}

				?>
				<article class="search-result">
					<h4>
						<?php echo $category_string; ?> <span class="dashicons dashicons-arrow-right-alt2"></span>
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h4>
					<p><?php echo get_the_excerpt();?></p>
				</article>
				<?php
			endwhile;
		} else {
			?>
			<div class="no-search-results">
				<?php _e( 'Sorry, no results were found. You may need to send in a support ticket...', 'blox-theme' ); ?>
			</div>
			<?php
		}
	?>
	</div>
	<?php
	$content = ob_get_clean();

	echo $content;
	die();

}

add_filter( 'genesis_search_form', 'blox_modify_documentation_search_form', 10, 3 );
/**
 * Modify Search form for documentation pages
 *
 * @param string search form
 * @param string search text
 * @param string button text
 * @return string modified search form
 */
function blox_modify_documentation_search_form( $form, $search_text, $button_text ) {
	if ( ! ( is_post_type_archive( 'documentation' ) || is_singular( 'documentation' ) ) ) {
		return $form;
	}

	$search_text = __( 'Search Documentation...', 'blox-theme' );
	$docs_form = '
	<div id="search_container">
		<form>
		<input type="text" placeholder="'. $search_text .'" name="s" />
		<input type="hidden" name="post_type" value="easy_docs" />
		<button type="submit" class="dashicons-search submit-search" value="" />
		</form>
	</div>
	';

	return $docs_form;
}

add_action( 'genesis_after_header', 'blox_print_search_results_container' );
/**
 * Add search result div
 *
 * @since 1.0.0
 */
function blox_print_search_results_container() {
	if ( is_post_type_archive( 'documentation' ) || is_singular( 'documentation' ) ) {
		echo '<div id="search_results"></div>';
	}
}
