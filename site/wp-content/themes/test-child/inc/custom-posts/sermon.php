<?php
 
add_action( 'init', 'register_post_types_sermon' );
function register_post_types_sermon() {
  register_post_type('sermon', [
    'labels' => [
      'name'               => 'Sermon', // основное название для типа записи
      'singular_name'      => 'Sermon', // название для одной записи этого типа
      'add_new'            => 'Add sermon', // для добавления новой записи
      'add_new_item'       => 'Sermon adding', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Edit sermon', // для редактирования типа записи
      'new_item'           => 'New sermon', // текст новой записи
      'view_item'          => 'View sermon item', // для просмотра записи этого типа.
      'search_items'       => 'Search sermon', // для поиска по этим типам записи
      'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Not found in the trash', // если не было найдено в корзине
      'menu_name'          => 'Sermons', // название меню
    ],
    'menu_icon'          => 'dashicons-businessperson',
    'public'             => true,
    'menu_position'      => 2,
    'supports'           => ['title', 'excerpt', 'revisions'],
    // 'capability_type'    => array('sermon','sermons'),
    // 'map_meta_cap'       => true,
    'has_archive'        => true,
    'show_ui'            => true,
    'show_in_rest'       => true,
    'show_in_graphql'    => true,
    'graphql_single_name' => 'sermon',
    'graphql_plural_name' => 'sermons',
    'rest_base'          => 'sermons',
    'rewrite'            => ['slug' => 'sermon']
   ] );

  register_taxonomy('sermon-topics', 'sermon', [
    'labels'        => [
      'name'                        => 'Topics of the sermons',
      'singular_name'               => 'Category of the sermons',
      'search_items'                => 'Search topics',
      'popular_items'               => 'Popular topics',
      'all_items'                   => 'All topics',
      'edit_item'                   => 'Edit topic',
      'update_item'                 => 'Update topic',
      'add_new_item'                => 'Add new topic',
      'new_item_name'               => 'New topic name',
      'separate_items_with_commas'  => 'Separate items with commas',
      'add_or_remove_items'         => 'Add or delete topics',
      'choose_from_most_used'       => 'Choose from most used',
      'menu_name'                   => 'Sermon topics',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'sermon_topic',
    'graphql_plural_name' => 'sermons_topics',
    'rest_base'     => 'sermon_topic',
  ]);

  register_taxonomy('sermon-bible_books', 'sermon', [
    'labels'        => [
      'name'                        => 'Bible books',
      'singular_name'               => 'Category of the sermons',
      'search_items'                => 'Search books',
      'popular_items'               => 'Popular books',
      'all_items'                   => 'All books',
      'edit_item'                   => 'Edit book',
      'update_item'                 => 'Update book',
      'add_new_item'                => 'Add new book',
      'new_item_name'               => 'New book name',
      'separate_items_with_commas'  => 'Separate items with commas',
      'add_or_remove_items'         => 'Add or delete books',
      'choose_from_most_used'       => 'Choose from most used',
      'menu_name'                   => 'Sermon books',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'biblebook',
    'graphql_plural_name' => 'biblebooks',
    'rest_base'     => 'sermon_bible_book',
  ]);

  register_taxonomy('sermon-preachers', 'sermon', [
    'labels'        => [
      'name'                        => 'Preachers of the sermons',
      'singular_name'               => 'Category of the sermons',
      'search_items'                => 'Search preachers',
      'popular_items'               => 'Popular preachers',
      'all_items'                   => 'All preachers',
      'edit_item'                   => 'Edit preacher',
      'update_item'                 => 'Update preacher',
      'add_new_item'                => 'Add new preacher',
      'new_item_name'               => 'New preacher name',
      'separate_items_with_commas'  => 'Separate items with commas',
      'add_or_remove_items'         => 'Add or delete preachers',
      'choose_from_most_used'       => 'Choose from most used',
      'menu_name'                   => 'Sermon preachers',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'sermon_preacher',
    'graphql_plural_name' => 'sermons_preachers',
    'rest_base'     => 'sermon_preacher',
  ]);
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_sermon');
function register_carbon_fields_sermon() {
    Container::make( 'post_meta', 'Sermon information' )
    ->where( 'post_type', '=', 'sermon' )
    ->add_tab( 'Sermon data', [
        Field::make( 'image', 'sermon_photo', 'Photo' )
          ->set_required(true)
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'sermon_short_description', 'Short description' )
          ->set_width(50)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'sermon_youtube_link', 'Youtube link' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'file', 'sermon_audio', 'Audio file' )
          ->set_required(true)
          ->set_width(20)
          ->set_type( 'audio/mpeg')
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'date', 'sermon_date', 'Date' )
          ->set_width(20)
          ->set_required(true)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'sermon_book_chapter', 'Chapter of the bible book' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'sermon_book_chapter_text_number', 'Text numbers of the bible book' )
          ->set_width(20)
          ->set_attribute( 'placeholder', 'For example 5 or 5-8' )
          ->set_visible_in_rest_api( $visible = true ),
      ]);
}

function sermon_mime_types( $mimes ) {
  $mimes['pdf']  = 'application/pdf';
  $mimes['mp3'] = 'audio/mpeg';

  return $mimes;
}

add_filter( 'upload_mimes', 'sermon_mime_types' );


add_action( 'graphql_register_types', 'add_sermon_custom_fields_to_graphql' );

function add_sermon_custom_fields_to_graphql() {  
  register_graphql_field( 'Sermon', 'sermon_photo', [
    'type' => [ 'list_of' => 'SermonPhoto' ],
    'resolve' => function( $post ) {
      $photo_id = carbon_get_post_meta( $post->ID, 'sermon_photo' );

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

  register_graphql_field( 'Sermon', 'sermon_short_description', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'sermon_short_description' );
    },
  ] );

  register_graphql_field( 'Sermon', 'sermon_youtube_link', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'sermon_youtube_link' );
    },
  ] );

  register_graphql_field( 'Sermon', 'sermon_audio', [
    'type' => 'String',
    'resolve' => function( $post ) {
      $audioID = carbon_get_post_meta( $post->ID, 'sermon_audio' );
      return wp_get_attachment_url($audioID);
    },
  ] );

  register_graphql_field( 'Sermon', 'sermon_date', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'sermon_date' );
    },
  ] );

  register_graphql_field( 'Sermon', 'sermon_book_chapter', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'sermon_book_chapter' );
    },
  ] );

  register_graphql_field( 'Sermon', 'sermon_book_chapter_text_number', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'sermon_book_chapter_text_number' );
    },
  ] );
}

register_graphql_object_type(
  'SermonPhoto',
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
