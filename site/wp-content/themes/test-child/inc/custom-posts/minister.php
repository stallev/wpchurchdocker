<?php
 
//создаем новый тип поста 
add_action( 'init', 'register_post_types_minister' );
function register_post_types_minister() {
  register_post_type('minister', [
    'labels' => [
      'name'               => 'Minister', // основное название для типа записи
      'singular_name'      => 'Minister', // название для одной записи этого типа
      'add_new'            => 'Add minister', // для добавления новой записи
      'add_new_item'       => 'Minister adding', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Edit minister', // для редактирования типа записи
      'new_item'           => 'New minister', // текст новой записи
      'view_item'          => 'View minister item', // для просмотра записи этого типа.
      'search_items'       => 'Search minister', // для поиска по этим типам записи
      'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Not found in the trash', // если не было найдено в корзине
      'menu_name'          => 'Ministers', // название меню
    ],
    'menu_icon'          => 'dashicons-businessperson',
    'public'             => true,
    'menu_position'      => 2,
    'supports'           => ['title', 'excerpt', 'revisions'],
    'capability_type'    => array('minister','ministers'),
    'map_meta_cap'       => true,
    'has_archive'        => true,
    'show_ui'            => true,
    'show_in_rest'       => true,
    'show_in_graphql'    => true,
    'graphql_single_name' => 'minister',
    'graphql_plural_name' => 'ministers',
    'rest_base'          => 'ministers',
    'rewrite'            => ['slug' => 'minister']
   ] );

   register_taxonomy('minister-categories', 'minister', [
    'labels'        => [
      'name'                        => 'Categories of the ministers',
      'singular_name'               => 'Category of the ministers',
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
      'menu_name'                   => 'Minister categories',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'minister_category',
    'graphql_plural_name' => 'ministers_categories',
    'rest_base'     => 'minister_category',
  ]);
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_minister');
function register_carbon_fields_minister() {
    Container::make( 'post_meta', 'Minister information' )
    ->where( 'post_type', '=', 'minister' )    
    ->add_tab( 'Minister data', [
        Field::make( 'image', 'minister_photo', 'Photo' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'minister_first_name', 'First name' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'minister_last_name', 'Last name' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'minister_position', 'Position' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'text', 'minister_department', 'Department' )
          ->set_width(20)
          ->set_visible_in_rest_api( $visible = true ),
        Field::make( 'rich_text', 'minister_description', 'Description' )
          ->set_width(100)
          ->set_visible_in_rest_api( $visible = true ),
      ]);
}


add_action( 'graphql_register_types', 'add_minister_custom_fields_to_graphql' );

function add_minister_custom_fields_to_graphql() {  
  register_graphql_field( 'Minister', 'minister_photo', [
    'type' => [ 'list_of' => 'MinisterPhoto' ],
    'resolve' => function( $post ) {
      $photo_id = carbon_get_post_meta( $post->ID, 'minister_photo' );

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

  register_graphql_field( 'Minister', 'minister_first_name', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'minister_first_name' );
    },
  ] );

  register_graphql_field( 'Minister', 'minister_last_name', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'minister_last_name' );
    },
  ] );

  register_graphql_field( 'Minister', 'minister_position', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'minister_position' );
    },
  ] );

  register_graphql_field( 'Minister', 'minister_department', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'minister_department' );
    },
  ] );

  register_graphql_field( 'Minister', 'minister_description', [
    'type' => 'String',
    'resolve' => function( $post ) {
      return carbon_get_post_meta( $post->ID, 'minister_description' );
    },
  ] );
}

register_graphql_object_type(
  'MinisterPhoto',
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
