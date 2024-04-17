<?php

class Crb_Timeline_REST_Controller extends WP_REST_Controller {

    public function __construct() {
        $this->namespace = 'carbonfields/v1';
        $this->rest_base = 'timeline';
    }

    public function get($request) {
        $timeline_data = carbon_get_theme_option('timeline');
        $formatted_timeline = [];

        foreach ($timeline_data as $year_data) {
            $formatted_year = [
                'year' => $year_data['timeline_event_year_number'],
                'events' => [],
            ];
            
            foreach ($year_data['selected_timeline_events_list'] as $event_item) {
                $event_post = get_post($event_item['id']);

                if ($event_post) {
                    $formatted_year['events'][] = [
                        'id' => $event_post->ID,
                        'title' => $event_post->post_title,
                        'event_date' => carbon_get_post_meta($event_post->ID, 'timeline_event_date'),
                        'featured_image' => get_the_post_thumbnail_url($event_item['id']),
                        'slug' => $event_post->post_name,
                    ];
                }
            }

            $formatted_timeline[] = $formatted_year;
        }

        return new WP_REST_Response($formatted_timeline, 200);
    }
}

add_action('rest_api_init', function() {
    register_rest_route('carbonfields/v1', 'timeline', array(
        'methods' => 'GET',
        'callback' => 'Crb_Timeline_REST_Controller::get',
        'permission_callback' => function() {
            return true;
        },
    ));
});

