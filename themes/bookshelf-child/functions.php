<?php
require_once 'includes/oneflow-actions.php';
function lab_enqueue_parent_style() { 
	$current_dir = get_template_directory_uri(); 
	$current_child_dir = get_stylesheet_directory_uri(); 
	$rand = rand(256, 568); 
	wp_enqueue_style( 'parent-style', $current_dir.'/style.css?'.$rand ); 
	/*wp_register_script( 'bootstrap-min', $current_child_dir.'/child-assest/js/bootstrap-min.js?' , '', '', true );
    wp_enqueue_script( 'bootstrap-min' );
	wp_register_script( 'slick', $current_child_dir.'/child-assest/js/slick.min.js?'.$rand , '', '', true );
    wp_enqueue_script( 'slick' );
	wp_register_script( 'custop-actions', $current_child_dir.'/child-assest/js/custom-actions.js?'.$rand , '', '', true );
    wp_enqueue_script( 'custop-actions' );*/
}
add_action( 'wp_enqueue_scripts', 'lab_enqueue_parent_style' );