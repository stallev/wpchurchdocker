<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

require_once('inc/common-carbonfields.php');

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'libs/carbon-fields/vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}

function create_faq_fields() {
  Container::make( 'post_meta', 'FAQ' )
      ->where( 'post_type', '=', 'post' )
      ->add_fields( array(
          Field::make( 'complex', 'faq', 'FAQ' )
              ->set_visible_in_rest_api( $visible = true )
              ->add_fields( array(
                  Field::make( 'text', 'question', 'Question' ),
                  Field::make( 'text', 'answer', 'Answer' ),
              ) ),
      ) );
}

add_theme_support( 'post-thumbnails', array( 'post', 'upcoming_event' ) );

add_action( 'carbon_fields_register_fields', 'create_faq_fields' );

require_once('inc/menus-info/menus.php');
require_once('inc/custom-posts/custom-posts-functions.php');
require_once('inc/custom-posts/broadcast.php');
require_once('inc/custom-posts/sermon.php');
require_once('inc/custom-posts/minister.php');
require_once('inc/custom-posts/timeline-event.php');
require_once('inc/custom-posts/pastors-post.php');
require_once('inc/custom-posts/upcoming_event.php');
require_once('inc/custom-roles/roles.php');

require_once('inc/pages-data/pages-data-index.php');


@ini_set( 'upload_max_size' , '900M' );
@ini_set( 'post_max_size', '900M');
@ini_set( 'max_execution_time', '300' );
