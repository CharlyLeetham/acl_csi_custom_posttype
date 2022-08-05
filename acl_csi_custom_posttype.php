<?php
/*
Plugin Name: ACL CSI Custom Post Types
Plugin URI: http://askcharlyleetham.com
Description: Custom Post Types for CSI
Version: 1.0
Author: Charly Dwyer
Author URI: http://askcharlyleetham.com
License: GPL

Changelog
Version 1.0 - Original Version
*/

// Testimonials
function acl_create_post_type() {

//PBX Hawaii Videos
	// set up labels
	$labels = array(
 		'name' => 'PBX Hawaii Videos',
    	'singular_name' => 'PBX Hawaii Video',
    	'add_new' => 'Add New PBX Hawaii Video',
    	'add_new_item' => 'Add New PBX Hawaii Video',
    	'edit_item' => 'Edit PBX Hawaii Video',
    	'new_item' => 'New PBX Hawaii Video',
    	'all_items' => 'All PBX Hawaii Videos',
    	'view_item' => 'View PBX Hawaii Video',
    	'search_items' => 'Search PBX Hawaii Videos',
    	'not_found' =>  'No PBX Hawaii Videos Found',
    	'not_found_in_trash' => 'No PBX Hawaii Videos found in Trash',
    	'parent_item_colon' => '',
    	'menu_name' => 'PBX Hawaii Videos',
    );
    //register post type
	register_post_type( 'acl-pbx-vid', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes', 'revisions', 'author' ),
		'taxonomies' => array( 'post_tag' ),
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'testimonial' ),
		)
	);
}
add_action( 'init', 'acl_create_post_type' );


// register taxonomies
function acl_register_taxonomy() {

//PBX Videos Taxonomy
	// set up labels
	$labels = array(
		'name'              => 'PBX Hawaii Videos Categories',
		'singular_name'     => 'PBX Hawaii Videos Category',
		'search_items'      => 'Search PBX Hawaii Videos Categories',
		'all_items'         => 'All PBX Hawaii Videos Categories',
		'edit_item'         => 'Edit PBX Hawaii Videos Category',
		'update_item'       => 'Update PBX Hawaii Videos Category',
		'add_new_item'      => 'Add New PBX Hawaii Videos Category',
		'new_item_name'     => 'New PBX Hawaii Videos Category',
		'menu_name'         => 'PBX Hawaii Videos Categories'
	);
	// register taxonomy
	register_taxonomy( 'acl-pbx-cat', 'acl-pbx-vid', array(
		'hierarchical' => true,
		'labels' => $labels,
		'query_var' => true,
		'show_admin_column' => true
	) );
}
add_action( 'init', 'acl_register_taxonomy' );


add_action( 'add_meta_boxes', 'acl_meta_box_add' );
function acl_meta_box_add()
{
    add_meta_box( 'acl-1', 'Zoom Details for Event', 'acl_meta_box_cb', 'espresso_events', 'normal', 'high' );
}

// function acl_meta_box_cb()
// {
//     echo 'What you put here, show\'s up in the meta box';
// }

function acl_meta_box_cb()
{

		// We'll use this nonce field later on when saving.
    wp_nonce_field( 'acl_zoom_meta_box_nonce', 'acl_zoom_box_nonce' );
?>
	<p>
  <label for="zoom_url">Zoom URL</label>
  <input type="text" name="zoom_url" id="zoom_url" />
	</p>

	<p>
	<label for="zoom_id">Zoom ID</label>
	<input type="text" name="zoom_id" id="zoom_id" />
	</p>

	<p>
	<label for="zoom_pwd">Zoom Password</label>
	<input type="text" name="zoom_pwd" id="zoom_pwd" />
	</p>

	<p>
	<label for="zoom_msg">Zoom Message</label>
	<?php
		wp_editor( $content, 'zoom_msg', array() );
	?>
	</p>
<?php
}

add_action( 'save_post', 'acl_meta_box_save' );

add_action( 'save_post', 'acl_meta_box_save' );
function acl_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// if our nonce isn't there, or we can't verify it, bail
		if ( !isset( $_POST['acl_zoom_box_nonce'] ) || !wp_verify_nonce( $_POST['acl_zoom_box_nonce'], 'acl_zoom_meta_box_nonce' ) ) return;

		// if our current user can't edit this post, bail
		if ( !current_user_can( 'edit_post' ) ) return;

		// now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );

    // Make sure your data is set before trying to save it
    if( isset( $_POST['zoom_url'] ) ) {
        update_post_meta( $post_id, 'zoom_url', wp_kses( $_POST['zoom_url'], $allowed ) );
		}

    if( isset( $_POST['zoom_id'] ) ) {
        update_post_meta( $post_id, 'zoom_id', esc_attr( $_POST['zoom_id'] ) );
		}

    if( isset( $_POST['zoom_pwd'] ) ) {
        update_post_meta( $post_id, 'zoom_pwd', esc_attr( $_POST['zoom_pwd'] ) );
		}

		if ( isset( $_POST['_zoom_msg'] ) ) {
		        update_post_meta($post->ID, '_zoom_msg', $_POST['_zoom_msg']);
		}


}
