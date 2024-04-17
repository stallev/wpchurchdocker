<?php

function get_upcoming_events_list() {
	$association = carbon_get_theme_option('upcoming_events_association');
  $events_data = [];

  foreach ($association as $item) {
    $post_id = $item['id'];
    $post = get_post($post_id);

    if ($post) {
      $events_data[] = [
        'id' => $post_id,
        'title' => $post->post_title,
        'slug' => $post->post_name,
        'upcoming_event_start' => carbon_get_post_meta($post_id, 'upcoming_event_start'),
        'upcoming_event_end' => carbon_get_post_meta($post_id, 'upcoming_event_end'),
        'upcoming_event_short_description' => carbon_get_post_meta($post_id, 'upcoming_event_short_description'),
        'created_at' => $post->post_date_gmt,
        'updated_at' => get_the_modified_date('Y-m-d H:i:s', $post_id),
      ];
    }
  }

  return $events_data;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'events', '/upcoming-events-list', array(
    'methods' => 'GET',
    'callback' => 'get_upcoming_events_list',
    'permission_callback' => '__return_true',
  ) );
});


// events/upcoming-events-list
