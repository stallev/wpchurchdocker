<?php
 
//создаем новый тип поста 
add_action( 'init', 'register_post_types_broadcast' );
function register_post_types_broadcast() {
  register_post_type('broadcast', [
    'labels' => [
      'name'               => 'Broadcast', // основное название для типа записи
      'singular_name'      => 'Broadcast', // название для одной записи этого типа
      'add_new'            => 'Add broadcast', // для добавления новой записи
      'add_new_item'       => 'Broadcast adding', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Edit broadcast', // для редактирования типа записи
      'new_item'           => 'New broadcast', // текст новой записи
      'view_item'          => 'View broadcast item', // для просмотра записи этого типа.
      'search_items'       => 'Search broadcast', // для поиска по этим типам записи
      'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Not found in the trash', // если не было найдено в корзине
      'menu_name'          => 'Broadcasts', // название меню
    ],
    'menu_icon'          => 'dashicons-businessperson',
    'public'             => true,
    'menu_position'      => 2,
    'supports'           => ['title', 'excerpt', 'revisions'],
    'capability_type'    => array('broadcast','broadcasts'),
    'map_meta_cap'       => true,
    'has_archive'        => true,
    'show_ui'            => true,
    'show_in_rest'       => true,
    'show_in_graphql'    => true,
    'graphql_single_name' => 'broadcast',
    'graphql_plural_name' => 'broadcasts',
    'rest_base'          => 'broadcasts',
    'rewrite'            => ['slug' => 'broadcast']
   ] );

   register_taxonomy('broadcast-locations', 'broadcast', [
    'labels'        => [
      'name'                        => 'Preachers of the broadcasts',
      'singular_name'               => 'Preachers of the broadcasts',
      'search_items'                => 'Search locations',
      'popular_items'               => 'Popular locations',
      'all_items'                   => 'All locations',
      'edit_item'                   => 'Edit location',
      'update_item'                 => 'Update location',
      'add_new_item'                => 'Add new location',
      'new_item_name'               => 'New location name',
      'separate_items_with_commas'  => 'Separate items with commas',
      'add_or_remove_items'         => 'Add or delete locations',
      'choose_from_most_used'       => 'Choose from most used',
      'menu_name'                   => 'Locations',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'broadcast_locations_category',
    'graphql_plural_name' => 'broadcast_locations_categories',
    'rest_base'     => 'broadcast_categories',
  ]);

   register_taxonomy('broadcast-events', 'broadcast', [
    'labels'        => [
      'name'                        => 'Event of the broadcasts',
      'singular_name'               => 'Event of the broadcasts',
      'search_items'                => 'Search event',
      'popular_items'               => 'Popular events',
      'all_items'                   => 'All events',
      'edit_item'                   => 'Edit event',
      'update_item'                 => 'Update event',
      'add_new_item'                => 'Add new event',
      'new_item_name'               => 'New event name',
      'separate_items_with_commas'  => 'Separate items with commas',
      'add_or_remove_items'         => 'Add or delete events',
      'choose_from_most_used'       => 'Choose from most used',
      'menu_name'                   => 'Broadcast events',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'broadcast_event',
    'graphql_plural_name' => 'broadcast_events',
    'rest_base'     => 'broadcast_events',
  ]);
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_broadcast');
function register_carbon_fields_broadcast() {
    Container::make( 'post_meta', 'Broadcast information' )
    ->where( 'post_type', '=', 'broadcast' )    
    ->add_tab( 'Broadcast data', [
        Field::make( 'image', 'broadcast_photo', 'Photo' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'date_time', 'broadcast_date_time', 'Date and time' )
        ->set_width(20)
        ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'broadcast_video_link', 'Video link' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'file', 'broadcast_audio_file', 'Audio file' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'file', 'broadcast_outline', 'Broadcast outline' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'rich_text', 'broadcast_description', 'Description' )
          ->set_width(100)
          ->set_visible_in_rest_api( $visible = true ),  
      ]);
}

add_action( 'graphql_register_types', 'add_broadcast_custom_fields_to_graphql' );

function add_broadcast_custom_fields_to_graphql() {
  register_graphql_field( 'Broadcast', 'broadcast_photo', [
    'type' => [ 'list_of' => 'BroadcastPhoto' ],
    'resolve' => function( $post ) {
      $photo_id = carbon_get_post_meta( $post->ID, 'broadcast_photo' );

      // Получаем ссылку на изображение и разные размеры
      $image_data = wp_get_attachment_image_src( $photo_id, 'full' );
      $thumbnail_data = wp_get_attachment_image_src( $photo_id, 'thumbnail' );
      $medium_data = wp_get_attachment_image_src( $photo_id, 'medium' );
      $large_data = wp_get_attachment_image_src( $photo_id, 'large' );

      return [
        [
          'size' => 'full',
          'url' => $image_data[0]
        ],
        [
          'size' => 'thumbnail',
          'url' => $thumbnail_data[0]
        ],
        [
          'size' => 'medium',
          'url' => $medium_data[0]
        ],
        [
          'size' => 'large',
          'url' => $large_data[0]
        ],
      ];
    },
  ] );

  register_graphql_field( 'Broadcast', 'broadcast_date_time', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'broadcast_date_time' );
    },
  ] );

  register_graphql_field( 'Broadcast', 'broadcast_video_link', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'broadcast_video_link' );
    },
  ] );

  register_graphql_field( 'Broadcast', 'broadcast_description', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'broadcast_description' );
    },
  ] );

  register_graphql_field( 'Broadcast', 'broadcast_audio_file', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return get_field_link( $post, 'broadcast_audio_file' );
    },
  ] );

  register_graphql_field( 'Broadcast', 'broadcast_outline', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return get_field_link( $post, 'broadcast_outline' );
    },
  ] );
}

register_graphql_object_type(
  'BroadcastPhoto',
  [
    'fields' => [
      'size' => [
        'type' => 'String',
        'description' => __( 'Size of the photo', 'your-textdomain' ),
      ],
      'url' => [
        'type' => 'String',
        'description' => __( 'URL of the photo', 'your-textdomain' ),
      ],
    ],
  ]
);
