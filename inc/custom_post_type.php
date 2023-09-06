<?php

// Регистрация нового типа записей "company" с поддержкой меток
function custom_register_company_post_type() {
	$labels = array(
		'name' => 'Companies',
		'singular_name' => 'Company',
		'menu_name' => 'Companies',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Company',
		'edit_item' => 'Edit Company',
		'new_item' => 'New Company',
		'view_item' => 'View Company',
		'search_items' => 'Search Companies',
		'not_found' => 'No companies found',
		'not_found_in_trash' => 'No companies found in trash',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'company'),
		'capability_type' => 'post',
		'supports' => array('title', 'thumbnail'),
		'taxonomies' => array('company_tag'), // Добавление поддержки меток (tags)
	);

	register_post_type('company', $args);
}
add_action('init', 'custom_register_company_post_type');


function custom_register_taxonomy() {
	$labels_equipment = array(
		'name' => 'Equipment',
		'singular_name' => 'Equipment Tag',
		'menu_name' => 'Equipment',
		'search_items' => 'Search Equipment Tags',
		'popular_items' => 'Popular Equipment Tags',
		'all_items' => 'All Equipment Tags',
		'edit_item' => 'Edit Equipment Tag',
		'update_item' => 'Update Equipment Tag',
		'add_new_item' => 'Add New Equipment Tag',
		'new_item_name' => 'New Equipment Tag Name',
		'separate_items_with_commas' => 'Separate Equipment Tags with commas',
		'add_or_remove_items' => 'Add or remove Equipment Tags',
		'choose_from_most_used' => 'Choose from the most used Equipment Tags',
	);

	$args_equipment = array(
		'labels' => $labels_equipment,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'equipment'), // Замените slug на желаемый
	);

	register_taxonomy('equipment', 'company', $args_equipment);


	$labels_Processes = array(
		'name' => 'Processes',
		'singular_name' => 'Processes Tag',
		'menu_name' => 'Processes',
		'search_items' => 'Search Processes Tags',
		'popular_items' => 'Popular Processes Tags',
		'all_items' => 'All Processes Tags',
		'edit_item' => 'Edit Processes Tag',
		'update_item' => 'Update Processes Tag',
		'add_new_item' => 'Add New Processes Tag',
		'new_item_name' => 'New Processes Tag Name',
		'separate_items_with_commas' => 'Separate Processes Tags with commas',
		'add_or_remove_items' => 'Add or remove Processes Tags',
		'choose_from_most_used' => 'Choose from the most used Processes Tags',
	);

	$args_Processes = array(
		'labels' => $labels_Processes,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'processes'), // Замените slug на желаемый
	);

	register_taxonomy('processes', 'company', $args_Processes);

	$labels_services = array(
		'name' => 'Services',
		'singular_name' => 'Services Tag',
		'menu_name' => 'Services',
		'search_items' => 'Search Services Tags',
		'popular_items' => 'Popular Services Tags',
		'all_items' => 'All Services Tags',
		'edit_item' => 'Edit Services Tag',
		'update_item' => 'Update Services Tag',
		'add_new_item' => 'Add New Services Tag',
		'new_item_name' => 'New Services Tag Name',
		'separate_items_with_commas' => 'Separate Services Tags with commas',
		'add_or_remove_items' => 'Add or remove Services Tags',
		'choose_from_most_used' => 'Choose from the most used Services Tags',
	);

	$args_services = array(
		'labels' => $labels_services,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'services'), // Замените slug на желаемый
	);

	register_taxonomy('services', 'company', $args_services);

	$labels_products= array(
		'name' => 'Products',
		'singular_name' => 'Products Tag',
		'menu_name' => 'Products',
		'search_items' => 'Search Products Tags',
		'popular_items' => 'Popular Products Tags',
		'all_items' => 'All Products Tags',
		'edit_item' => 'Edit Products Tag',
		'update_item' => 'Update Products Tag',
		'add_new_item' => 'Add New Products Tag',
		'new_item_name' => 'New Products Tag Name',
		'separate_items_with_commas' => 'Separate Products Tags with commas',
		'add_or_remove_items' => 'Add or remove Products Tags',
		'choose_from_most_used' => 'Choose from the most used Products Tags',
	);

	$args_products = array(
		'labels' => $labels_products,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'products'), // Замените slug на желаемый
	);

	register_taxonomy('products', 'company', $args_products);
}
add_action('init', 'custom_register_taxonomy');




