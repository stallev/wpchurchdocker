<?php
 
//создаем новый тип поста 
add_action( 'init', 'register_post_types_pastors_post' );
function register_post_types_pastors_post() {
  register_post_type('pastors_post', [
    'labels' => [
      'name'               => 'Pastors post',
      'singular_name'      => 'Pastors post',
      'add_new'            => 'Add Pastors post',
      'add_new_item'       => 'Pastors post adding',
      'edit_item'          => 'Edit Pastors post',
      'new_item'           => 'New Pastors post',
      'view_item'          => 'View Pastors post item',
      'search_items'       => 'Search Pastors post',
      'not_found'          => 'Not found',
      'not_found_in_trash' => 'Not found in the trash',
      'menu_name'          => 'Pastors posts',
    ],
    'menu_icon'          => 'dashicons-businessperson',
    'public'             => true,
    'menu_position'      => 3,
    'supports'           => ['title', 'excerpt', 'thumbnail', 'editor', 'author'],
    'has_archive'        => true,
    'show_ui'            => true,
    'show_in_rest'       => true,
    'show_in_graphql'    => true,
    'graphql_single_name' => 'PastorsPost',
    'graphql_plural_name' => 'PastorsPost',
    'rest_base'          => 'pastors_posts',
    'rewrite'            => ['slug' => 'pastors_post']
   ] );

   register_taxonomy('pastors_post-categories', 'pastors_post', [
    'labels'        => [
      'name'                        => 'Categories of the Pastors posts',
      'singular_name'               => 'Category of the Pastors posts',
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
      'menu_name'                   => 'PastorsPost event categories',
    ],
    'hierarchical'  => true,
    'show_in_rest'  => true,
    'show_in_graphql' => true,
    'graphql_single_name' => 'pastors_post_category',
    'graphql_plural_name' => 'pastors_posts_categories',
    'rest_base'     => 'pastors_post_category',
  ]);
}
