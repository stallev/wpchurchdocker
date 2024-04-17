<?php
 
//создаем новый тип поста 
add_action( 'init', 'register_post_types_timeline_event' );
function register_post_types_timeline_event() {
  register_post_type('timeline_event', [
    'labels' => [
      'name'               => 'Timeline event',
      'singular_name'      => 'Timeline event',
      'add_new'            => 'Add Timeline event',
      'add_new_item'       => 'Timeline event adding',
      'edit_item'          => 'Edit Timeline event',
      'new_item'           => 'New Timeline event',
      'view_item'          => 'View Timeline event item',
      'search_items'       => 'Search Timeline event',
      'not_found'          => 'Not found',
      'not_found_in_trash' => 'Not found in the trash',
      'menu_name'          => 'Timeline events',
    ],
    'menu_icon'          => 'dashicons-businessperson',
    'public'             => true,
    'menu_position'      => 3,
    'supports'           => ['title', 'excerpt', 'thumbnail', 'editor'],
    'has_archive'        => true,
    'show_ui'            => true,
    'show_in_rest'       => true,
    'show_in_graphql'    => true,
    'graphql_single_name' => 'TimelineEvent',
    'graphql_plural_name' => 'TimelineEvent',
    'rest_base'          => 'timeline_events',
    'rewrite'            => ['slug' => 'timeline_event']
   ] );

   register_taxonomy('timeline_event-categories', 'timeline_event', [
    'labels'        => [
      'name'                        => 'Categories of the Timeline events',
      'singular_name'               => 'Category of the Timeline events',
      'search_items'                => 'Search categories',
      'popular_items'               => 'Popular categories',
      'all_items'                   => 'All categories',
      'edit_item'                   => 'Edit category',
      'update_item'                 => 'Update category',
      'add_new_item'                => 'Add new category',
      'new_item_name'               => 'New category name',
      'separate_items_with_commas'  => 'Separate items with commas',
      'add_or_remove_items'         => 'Add or delete categories',
      'choose_from_most_used'       => 'Choose from most used',
      'menu_name'                   => 'TimelineEvent event categories',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'timeline_event_category',
    'graphql_plural_name' => 'timeline_events_categories',
    'rest_base'     => 'timeline_event_category',
  ]);
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_timeline_event');
function register_carbon_fields_timeline_event() {
    Container::make( 'post_meta', 'Timeline event information' )
    ->where( 'post_type', '=', 'timeline_event' )    
    ->add_tab( 'Timeline event data', [
        Field::make( 'date', 'timeline_event_date', 'Event date' )
          ->set_required(true)
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
      ]);
}


add_action( 'graphql_register_types', 'add_timeline_event_custom_fields_to_graphql' );

function add_timeline_event_custom_fields_to_graphql() {

  register_graphql_field( 'TimelineEvent', 'timeline_event_date', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'timeline_event_date' );
    },
  ] );
}
