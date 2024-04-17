<?php

add_action('rest_api_init', function() {
	register_rest_route('carbonfields/v1', 'selected-ministers-list', array(
		'methods' => 'GET',
		'callback' => 'Crb_Selected_Ministers_REST_Controller::get',
		'permission_callback' => function() {
            return true; // Разрешить всем пользователям
          },
	));
});

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