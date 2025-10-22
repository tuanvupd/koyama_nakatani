<?php

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style('nkt-google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@400;700&family=Pinyon+Script&display=swap', false ); 
	wp_enqueue_style('theme-styles', get_template_directory_uri() . '/dist/css/style.css', array(), uniqid());
	wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/dist/js/main.bundle.js', array('jquery'), uniqid(), true);

	wp_localize_script('theme-scripts', 'php_data', [
		'admin_logged' => in_array('administrator', wp_get_current_user()->roles) ? 'yes' : 'no',
		'ajax_url' => admin_url('admin-ajax.php'),
		'site_url' => site_url(),
		'rest_url' => get_rest_url(),
	]);

	wp_localize_script('theme-scripts', 'themeData', [
		'templateUrl' => get_template_directory_uri()
	]);
});

