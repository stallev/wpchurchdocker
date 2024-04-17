<?php
// Регистрация REST API endpoint
add_action('rest_api_init', 'register_custom_endpoint');

function register_custom_endpoint() {
    register_rest_route('custom/v1', '/home-page/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_home_page_data',
    ));
}

// Обработчик запроса
function get_home_page_data($data) {
    $post_id = $data['id'];

    // Проверка наличия кастомных полей для данного поста
    if (class_exists('Carbon_Fields\Container')) {
        $fields = Carbon_Fields\Container::make('post_meta', 'Home page information')->get_fields();
        if ($fields) {
            // Получение данных для нужного поста
            $home_page_data = get_post_meta($post_id, 'home_page_information', true);

            // Обработка данных, включая медиа-элементы
            $processed_data = process_home_page_data($home_page_data);

            return rest_ensure_response($processed_data);
        }
    }

    return rest_ensure_response(array('error' => 'Custom fields not found'));
}

// Обработка данных о домашней странице, включая медиа-элементы
function process_home_page_data($home_page_data) {
    // Реализуйте вашу логику обработки данных, включая медиа-элементы
    // Возможно, вам нужно будет воспользоваться функциями, такими как wp_get_attachment_image_src

    // Пример обработки изображений
    $processed_images = array();
    foreach ($home_page_data['header_slides_list'] as $slide) {
        $image_id = $slide['header-slide-bg'];
        $image_url = wp_get_attachment_image_src($image_id, 'full');
        $processed_images[] = array(
            'id' => $image_id,
            'url' => $image_url[0],
            'sizes' => wp_get_attachment_image_sizes($image_id),
        );
    }

    // Замените этот возврат на вашу обработанную структуру данных
    return array('header_slides_list' => $processed_images);
}
