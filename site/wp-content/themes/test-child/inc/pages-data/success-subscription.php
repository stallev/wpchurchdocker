<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_success_subscriptions');
function register_carbon_fields_success_subscriptions() {
  Container::make( 'post_meta', 'Success subscription page information' )
    ->where( 'post_id', '=', 508 )
    ->or_where( 'post_id', '=', 510 )
    ->add_tab( 'Subscribe info' , array(
      Field::make( 'complex',  'subscribed_info' , 'Data on the success subscription' )
        ->set_visible_in_rest_api( $visible = true )
        ->add_fields( 'success_subscribed_info', 'Subscribe info' ,array(
          Field::make( 'text', 'subscribed_part1', 'Subscribed text, first part' )->set_width(50),
          Field::make( 'text', 'subscribed_part2', 'Subscribed text, second part' )->set_width(50),
          Field::make( 'text', 'already_subscribed_part1', 'Already subscribed text, first part' )->set_width(50),
          Field::make( 'text', 'already_subscribed_part2', 'Already subscribed text, second part' )->set_width(50),
        ))
    ));
}
