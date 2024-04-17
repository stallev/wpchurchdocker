<?php

function get_selected_ministers_list() {
	$value = carbon_get_theme_option('selected_ministers_list');
  
  return $value;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'ministers', '/selected-ministers-list', array(
    'methods' => 'GET',
    'callback' => 'get_selected_ministers_list',
    'permission_callback' => '__return_true',
  ) );
});


// ministers/selected-ministers-list
