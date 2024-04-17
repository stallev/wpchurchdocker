<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_carbon_fields_custom_page');
function register_carbon_fields_custom_page() {
    Container::make( 'post_meta', 'Page information' )
    ->add_fields( array(
      Field::make( 'complex',  'page_info' , 'Custom page information' )
        ->set_visible_in_rest_api( $visible = true )
        ->set_layout( 'grid' )
        ->set_max(1)

        ->add_fields( 'page_data', 'Page data' ,array(
          Field::make( 'text', 'page_description', 'Page description' )->set_width(100),
        ))
    ));
}
