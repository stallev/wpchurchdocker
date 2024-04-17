<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

require_once('theme-fields/Crb_All_Fields.php');
require_once('endpoints/upcoming_events_custom_rest_endpoint.php');
require_once('endpoints/timeline_custom_rest_endpoint.php');
require_once('endpoints/ministers_custom_rest_endpoint.php');

// Common Settings
add_action( 'carbon_fields_register_fields', 'carbon_fields_settings_common' );
function carbon_fields_settings_common() {
    $Container = new Crb_All_Fields('theme_options', 'Настройка сайта');
    $Container->settings_common();
    return $Container;
}
