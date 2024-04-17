<?php
 
//создаем новый тип поста 
add_action( 'init', 'register_post_types_upcoming_event' );
function register_post_types_upcoming_event() {
  register_post_type('upcoming_event', [
    'labels' => [
      'name'               => 'Upcoming event', // основное название для типа записи
      'singular_name'      => 'Upcoming event', // название для одной записи этого типа
      'add_new'            => 'Add upcoming event', // для добавления новой записи
      'add_new_item'       => 'Upcoming event adding', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Edit upcoming event', // для редактирования типа записи
      'new_item'           => 'New upcoming event', // текст новой записи
      'view_item'          => 'View upcoming event item', // для просмотра записи этого типа.
      'search_items'       => 'Search upcoming event', // для поиска по этим типам записи
      'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Not found in the trash', // если не было найдено в корзине
      'menu_name'          => 'Upcoming events', // название меню
    ],
    'menu_icon'          => 'dashicons-businessperson',
    'public'             => true,
    'menu_position'      => 3,
    'supports'           => ['title', 'excerpt', 'thumbnail', 'revisions'],
    'has_archive'        => true,
    'show_ui'            => true,
    'show_in_rest'       => true,
    'show_in_graphql'    => true,
    'graphql_single_name' => 'upcoming',
    'graphql_plural_name' => 'upcoming',
    'rest_base'          => 'upcoming_events',
    'rewrite'            => ['slug' => 'upcoming_event']
   ] );

   register_taxonomy('upcoming_event-categories', 'upcoming_event', [
    'labels'        => [
      'name'                        => 'Categories of the upcoming events',
      'singular_name'               => 'Category of the upcoming events',
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
      'menu_name'                   => 'Upcoming event categories',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'upcoming_event_category',
    'graphql_plural_name' => 'upcoming_events_categories',
    'rest_base'     => 'upcoming_event_category',
  ]);
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_upcoming_event');
function register_carbon_fields_upcoming_event() {
    Container::make( 'post_meta', 'Upcoming event information' )
    ->where( 'post_type', '=', 'upcoming_event' )    
    ->add_tab( 'Upcoming event data', [
        Field::make( 'image', 'upcoming_event_photo', 'Photo' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'date_time', 'upcoming_event_start', 'Start date' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'date_time', 'upcoming_event_end', 'End date' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'upcoming_event_short_description', 'Short description' )
          ->set_width(100)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'rich_text', 'upcoming_event_description', 'Description' )
          ->set_width(100)
          ->set_visible_in_rest_api( $visible = true ),
      ]);
}


add_action( 'graphql_register_types', 'add_upcoming_event_custom_fields_to_graphql' );

function add_upcoming_event_custom_fields_to_graphql() {  
  register_graphql_field( 'Upcoming', 'itemPhoto', [
    'type' => [ 'list_of' => 'UpcomingPhoto' ],
    'resolve' => function( $post ) {
      $photo_id = carbon_get_post_meta( $post->ID, 'upcoming_event_photo' );

      // Получаем ссылку на изображение и разные размеры
      $image_data = wp_get_attachment_image_src( $photo_id, 'full' );
      $thumbnail_data = wp_get_attachment_image_src( $photo_id, 'thumbnail' );
      $medium_data = wp_get_attachment_image_src( $photo_id, 'medium' );
      $large_data = wp_get_attachment_image_src( $photo_id, 'large' );

      return [
        [
          'name' => 'full',
          'sourceUrl' => $image_data[0]
        ],
        [
          'name' => 'thumbnail',
          'sourceUrl' => $thumbnail_data[0]
        ],
        [
          'name' => 'medium',
          'sourceUrl' => $medium_data[0]
        ],
        [
          'name' => 'large',
          'sourceUrl' => $large_data[0]
        ],
      ];
    },
  ] );

  register_graphql_field( 'Upcoming', 'upcoming_event_start', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'upcoming_event_start' );
    },
  ] );

  register_graphql_field( 'Upcoming', 'upcoming_event_end', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'upcoming_event_end' );
    },
  ] );
  
  register_graphql_field( 'Upcoming', 'upcoming_event_short_description', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'upcoming_event_short_description' );
    },
  ] );

  register_graphql_field( 'Upcoming', 'upcoming_event_description', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'upcoming_event_description' );
    },
  ] );
}

register_graphql_object_type(
  'UpcomingPhoto',
  [
    'fields' => [
      'name' => [
        'type' => 'String',
        'description' => __( 'Size of the photo', 'your-textdomain' ),
      ],
      'sourceUrl' => [
        'type' => 'String',
        'description' => __( 'URL of the photo', 'your-textdomain' ),
      ],
    ],
  ]
);
