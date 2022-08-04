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


// This function tells WP to add a new "meta box"
function acl_add_ee_meta_box() {
    acl_ee_meta_box(
        'acl-ee', // id of the <div> we'll add
        'Zoom URL', //title
        'acl_ee_zoom_url', // callback function that will echo the box content
        'espresso_events' // where to add the box: on "post", "page", or "link" page
    );
}

// This function echoes the content of our meta box
function acl_ee_zoom_url() {
    echo "I'm living in a box";
}

// // Hook things in, late enough so that add_meta_box() is defined
// if (is_admin())
//     add_action('admin_menu', 'acl_add_ee_meta_box');

?>
