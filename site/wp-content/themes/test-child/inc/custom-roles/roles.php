<?php
function create_custom_roles() {
  // Создание роли "minister_manager"
  add_role(
      'minister_manager',
      'Minister Manager',
      array(
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => false,
        'publish_posts' => false,
        'upload_files' => true,
        'manage_categories' => true,
      )
  );

  // Создание роли "broadcast_manager"
  add_role(
      'broadcast_manager',
      'Broadcast Manager',
      array(
        'read' => true,
        'edit_posts' => false,
        'delete_posts' => false,
        'publish_posts' => false,
        'manage_categories' => true,
      )
  );
}
add_action('init', 'create_custom_roles');

add_action('admin_init','broadcast_manager_add_role_caps',999);
add_action('admin_init','minister_manager_add_role_caps',999);

function broadcast_manager_add_role_caps() {

  // Add the roles you'd like to administer the custom post types
  $roles = array('broadcast_manager','editor','administrator');

  // Loop through each role and assign capabilities
  foreach($roles as $the_role) { 

    $role = get_role($the_role);
  
    // $role->add_cap( 'read' );
    $role->add_cap( 'read_broadcast');
    $role->add_cap( 'read_private_broadcasts' );
    $role->add_cap( 'create_broadcast' );
    $role->add_cap( 'edit_broadcast' );
    $role->add_cap( 'edit_broadcasts' );
    $role->add_cap( 'edit_others_broadcasts' );
    $role->add_cap( 'edit_published_broadcasts' );
    $role->add_cap( 'publish_broadcasts' );
    $role->add_cap( 'delete_broadcast' );
    $role->add_cap( 'delete_others_broadcasts' );
    $role->add_cap( 'delete_private_broadcasts' );
    $role->add_cap( 'delete_published_broadcasts' );
    $role->add_cap( 'manage_categories_broadcasts' );
    $role->add_cap( 'level_0' );
  }
}
function minister_manager_add_role_caps() {

  // Add the roles you'd like to administer the custom post types
  $roles = array('minister_manager','editor','administrator');

  // Loop through each role and assign capabilities
  foreach($roles as $the_role) { 

    $role = get_role($the_role);
  
    // $role->add_cap( 'read' );
    $role->add_cap( 'read_minister');
    $role->add_cap( 'read_private_ministers' );
    $role->add_cap( 'create_minister' );
    $role->add_cap( 'edit_minister' );
    $role->add_cap( 'edit_ministers' );
    $role->add_cap( 'edit_others_ministers' );
    $role->add_cap( 'edit_published_ministers' );
    $role->add_cap( 'publish_ministers' );
    $role->add_cap( 'delete_minister' );
    $role->add_cap( 'delete_others_ministers' );
    $role->add_cap( 'delete_private_ministers' );
    $role->add_cap( 'delete_published_ministers' );
    $role->add_cap( 'manage_categories_ministers' );
    $role->add_cap( 'level_0' );
  }
}
