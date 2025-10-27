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

// Add filter dropdown for categories and types on admin post list
if (!function_exists('nakatani_add_admin_filters')) {
	function nakatani_add_admin_filters() {
		global $typenow;
		
		// Only add filters for 'wine' post type
		if ($typenow == 'wine') {
			// Filter by Category
			$selected = isset($_GET['category-wine']) ? $_GET['category-wine'] : '';
			$category_args = array(
				'show_option_all' => 'All Categories',
				'taxonomy' => 'category-wine',
				'name' => 'category-wine',
				'selected' => $selected,
			);
			wp_dropdown_categories($category_args);
			
			// Filter by Type
			$selected_type = isset($_GET['type-wine']) ? $_GET['type-wine'] : '';
			$type_args = array(
				'show_option_all' => 'All Types',
				'taxonomy' => 'type-wine',
				'name' => 'type-wine',
				'selected' => $selected_type,
			);
			wp_dropdown_categories($type_args);
		}
	}
	add_action('restrict_manage_posts', 'nakatani_add_admin_filters');
}

// Apply filter query
if (!function_exists('nakatani_filter_admin_posts')) {
	function nakatani_filter_admin_posts($query) {
		global $pagenow, $typenow;
		
		// Only run on admin post list page
		if (!is_admin() || $pagenow != 'edit.php' || $typenow != 'wine') {
			return;
		}
		
		// Check if filter buttons were clicked
		if (!isset($_GET['filter_action'])) {
			return;
		}
		
		// Get filter values
		$category_filter = isset($_GET['category-wine']) ? intval($_GET['category-wine']) : 0;
		$type_filter = isset($_GET['type-wine']) ? intval($_GET['type-wine']) : 0;
		
		// Don't do anything if both are 0 or unset
		if ($category_filter <= 0 && $type_filter <= 0) {
			return;
		}
		
		// Build tax_query
		$tax_query = array();
		
		if ($category_filter > 0) {
			$tax_query[] = array(
				'taxonomy' => 'category-wine',
				'field' => 'term_id',
				'terms' => $category_filter,
			);
		}
		
		if ($type_filter > 0) {
			$tax_query[] = array(
				'taxonomy' => 'type-wine',
				'field' => 'term_id',
				'terms' => $type_filter,
			);
		}
		
		// Set relation if multiple filters
		if (count($tax_query) > 1) {
			$tax_query['relation'] = 'AND';
		}
		
		// Apply the tax_query
		$query->set('tax_query', $tax_query);
	}
	add_action('pre_get_posts', 'nakatani_filter_admin_posts');
}
