<?php

/**
 * Use this file to register any custom post types you wish to create.
 */
if (!function_exists('nakatani_create_custom_post_type')) {
	// Register Custom Post Type
	function nakatani_create_custom_post_type()
	{
		register_post_type('wine', array(
			'labels' => array(
				'name' => __('Wine'),
				'singular_name' => __('wine'),
				'add_new' => __('Add New'),
				'add_new_item' => __('Add New wine'),
				'edit_item' => __('Edit Wine'),
				'new_item' => __('New Wine'),
				'view_item' => __('View Wine'),
				'search_items' => __('Search Wine'),
				'not_found' => __('Not found'),
				'not_found_in_trash' => __('Not found in Trash'),
				'all_items' => __('All wine'),
				'menu_name' => __('Wine'),
			),
			'label' => __('Wine', 'nakatani'),
			'supports' => array('title', 'thumbnail','revisions'),
			'menu_icon' => 'dashicons-admin-generic',
			'hierarchical' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'can_export' => true,
			'has_archive' => false,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'post',
			'publicly_queryable' => false, 
			'show_in_rest' => true,
		));
	}

	add_action('init', 'nakatani_create_custom_post_type', 0);
}

if (!function_exists('nakatani_create_custom_taxonomy')) {
	function nakatani_create_custom_taxonomy()
	{
		register_taxonomy('category-wine', array('wine'), array(
			'labels' => array(
				'name' => 'Categories',
				'singular_name' => 'Category',
				'search_items' => 'Search Category',
				'all_items' => 'All Category',
				'edit_item' => 'Edit Category',
				'update_item' => 'Update Category',
				'add_new_item' => 'Add New Category',
				'new_item_name' => 'New Category Name',
				'menu_name' => 'Categories',
			),
			'rewrite' => false,
			'hierarchical' => true,
			'public' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
			'show_in_rest' => true,
		));


		register_taxonomy('type-wine', array('wine'), array(
			'labels' => array(
				'name' => 'Types',
				'singular_name' => 'Type',
				'search_items' => 'Search Type',
				'all_items' => 'All Type',
				'edit_item' => 'Edit Type',
				'update_item' => 'Update Type',
				'add_new_item' => 'Add New Type',
				'new_item_name' => 'New Type Name',
				'menu_name' => 'Types',
			),
			'rewrite' => false,
			'hierarchical' => true,
			'public' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
			'show_in_rest' => true,
		));
	}
	add_action('init', 'nakatani_create_custom_taxonomy', 0);
}
