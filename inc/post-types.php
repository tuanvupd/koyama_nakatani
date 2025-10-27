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
			'supports' => array('title', 'thumbnail', 'revisions', 'page-attributes'),
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
add_action('restrict_manage_posts', function() {
	global $typenow;
	
	// Only add filters for 'wine' post type
	if ($typenow == 'wine') {
		// Filter by Category
		wp_dropdown_categories(array(
			'show_option_all' => 'All Categories',
			'taxonomy' => 'category-wine',
			'name' => 'category-wine',
			'selected' => isset($_GET['category-wine']) ? $_GET['category-wine'] : 0,
			'hierarchical' => true,
			'depth' => 3,
			'show_count' => false,
		));
		
		// Filter by Type
		wp_dropdown_categories(array(
			'show_option_all' => 'All Types',
			'taxonomy' => 'type-wine',
			'name' => 'type-wine',
			'selected' => isset($_GET['type-wine']) ? $_GET['type-wine'] : 0,
			'hierarchical' => true,
			'depth' => 3,
			'show_count' => false,
		));
	}
});

// Apply filter query
add_action('pre_get_posts', function($query) {
	global $pagenow;
	
	// Only run on admin post list page for wine post type
	if (!is_admin() || $pagenow != 'edit.php' || !isset($_GET['post_type']) || $_GET['post_type'] != 'wine') {
		return;
	}
	
	// Get filter values - support both ID and slug
	$category_filter = isset($_GET['category-wine']) ? $_GET['category-wine'] : '';
	$type_filter = isset($_GET['type-wine']) ? $_GET['type-wine'] : '';
	
	// Build tax_query
	$tax_query = array();
	
	if (!empty($category_filter)) {
		// Check if it's a number (ID) or slug
		if (is_numeric($category_filter) && $category_filter > 0) {
			$tax_query[] = array(
				'taxonomy' => 'category-wine',
				'field' => 'term_id',
				'terms' => absint($category_filter),
			);
		} else {
			// It's a slug
			$tax_query[] = array(
				'taxonomy' => 'category-wine',
				'field' => 'slug',
				'terms' => $category_filter,
			);
		}
	}
	
	if (!empty($type_filter)) {
		// Check if it's a number (ID) or slug
		if (is_numeric($type_filter) && $type_filter > 0) {
			$tax_query[] = array(
				'taxonomy' => 'type-wine',
				'field' => 'term_id',
				'terms' => absint($type_filter),
			);
		} else {
			// It's a slug
			$tax_query[] = array(
				'taxonomy' => 'type-wine',
				'field' => 'slug',
				'terms' => $type_filter,
			);
		}
	}
	
	// Apply tax_query if we have filters
	if (!empty($tax_query)) {
		if (count($tax_query) > 1) {
			$tax_query['relation'] = 'AND';
		}
		$query->set('tax_query', $tax_query);
	}
	
	// Add menu_order support for drag-drop sorting (only when no custom order is set)
	if (!$query->get('orderby')) {
		$query->set('orderby', 'menu_order');
		$query->set('order', 'ASC');
	}
});

// Enable simple page ordering for wine posts
add_filter('simple_page_ordering_is_sortable', function($sortable, $post) {
	if ($post->post_type === 'wine') {
		return true;
	}
	return $sortable;
}, 10, 2);
