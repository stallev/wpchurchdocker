<?php

class Crb_Selected_Ministers_REST_Controller extends WP_REST_Controller {

	public function __construct() {
		$this->namespace = 'carbonfields/v1';
		$this->rest_base = 'selected-ministers';
	}

	public function get($request) {
		$value = carbon_get_theme_option('selected_ministers_list');
		return new WP_REST_Response($value, 200);
	}
}

add_action('rest_api_init', function() {
	register_rest_route('carbonfields/v1', 'selected-ministers-list', array(
		'methods' => 'GET',
		'callback' => 'Crb_Selected_Ministers_REST_Controller::get',
		'permission_callback' => function() {
            return true; // Разрешить всем пользователям
          },
	));
});