<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_home_page');
function register_carbon_fields_home_page() {
    $tab_name = 'main_page';
    
    Container::make( 'post_meta', 'Home page information' )
    ->where( 'post_id', '=', 60 )
    ->or_where( 'post_id', '=', 70 )
    ->add_tab( $tab_name , array(
      Field::make( 'complex',  'complex' , 'Blocks on the main page' )
        ->set_visible_in_rest_api( $visible = true )
        ->setup_labels( array(
          'plural_name' => 'Blocks',
          'singular_name' => 'Block',
        ))
        ->set_layout( 'grid' )

        ->add_fields( 'header_info', 'Header info' ,array(
          Field::make( 'text', 'header_h1_title', 'Header title' )->set_width(25),
          Field::make( 'text', 'header_descr', 'Header description' )->set_width(25),
          Field::make( 'text', 'header_button_label', 'Header learn more button text' )->set_width(25),
        ))

        ->add_fields( 'upcoming_events_info', 'Upcoming events info ' ,array(
          Field::make( 'text', 'upcoming_events_title', 'Upcoming events title' )->set_width(50),
          Field::make( 'text', 'upcoming_events_descr', 'Upcoming events description' )->set_width(100),
        ))
        
        ->add_fields( 'subscription_part_info', 'Subscription info ' ,array(
          Field::make( 'text', 'subscription_title', 'Subscription block title' )->set_width(50),
          Field::make( 'text', 'subscription_descr', 'Subscription block description' )->set_width(100),
        ))
    ));
}
