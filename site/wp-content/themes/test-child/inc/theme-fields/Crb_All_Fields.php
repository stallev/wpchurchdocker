<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;
class Crb_All_Fields {
	public $container; 
	public function __construct( $type , $name ){ // работает при старте
		$this->container = $container = Container::make( $type , $name);
	}
	// Настройка сайта
	public function settings_common(){
		$this->container

			->add_tab( "Home page" , array(
				Field::make( 'association', 'upcoming_events_association', __( 'Upcoming Events' ) )
					->set_visible_in_rest_api( $visible = true )
					->set_types( array(
							array(
									'type'      => 'post',
									'post_type' => 'upcoming_event',
							)
					) ),
			))

			->add_tab( "Timeline" , array(
        Field::make( 'complex', 'timeline', __( 'Timeline' ) )
          ->set_visible_in_rest_api( $visible = true )
          ->setup_labels( array(
            'plural_name' => 'Years',
            'singular_name' => 'Year info',
          ))
          ->set_layout( 'grid' )
          ->add_fields( 'timeline_year_data', 'Timeline year' ,array(
            Field::make( 'text', 'timeline_event_year_number', 'Year' )
							->set_required(true)
							->set_visible_in_rest_api( $visible = true )
							->set_width(25),
            Field::make( 'association', 'selected_timeline_events_list', __( 'Year Timeline Events List' ) )
							->set_visible_in_rest_api( $visible = true )
							->set_types( array(
								array(
									'type'      => 'post',
									'post_type' => 'timeline_event',
								)
							))
          ))
      ))

			->add_tab( "Ministers" , array(
				Field::make( 'association', 'selected_ministers_list', __( 'Ministers List' ) )
					->set_visible_in_rest_api( $visible = true )
					->set_types( array(
							array(
									'type'      => 'post',
									'post_type' => 'minister',
							)
					) ),
			));
		return;
	}

}


class Crb_All_Fields_Page extends Crb_All_Fields{
	public function __construct( $type , $name , $template){
		$this->container = $container = Container::make( $type , $name)->show_on_template($template);
	}
}

class Crb_All_Fields_Post extends Crb_All_Fields{
	public function __construct( $type , $name , $type_post){
		$this->container = $container = Container::make( $type , $name)->where( 'post_type', '=', $type_post );
//        $this->container = $container = Container::make( $type , $name)->show_on_post_type($type_post);
	}
}
class Crb_All_Fields_Post_And_Hide_Template extends Crb_All_Fields{
	public function __construct( $type , $name , $type_post, $hide_temp_path){
		$this->container = $container = Container::make( $type , $name)->show_on_post_type($type_post)->hide_on_template($hide_temp_path);
	}
}
class Crb_All_Fields_Taxonomy extends Crb_All_Fields{
	public function __construct( $type , $name , $taxonomy){
		$this->container = $container = Container::make( $type , $name)->where( 'term_taxonomy', '=', $taxonomy);
	}
}

