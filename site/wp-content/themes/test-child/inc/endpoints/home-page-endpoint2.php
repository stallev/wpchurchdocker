<?php
// Регистрируем новый эндпоинт REST API
add_action('rest_api_init', 'register_custom_endpoint2');

function register_custom_endpoint2() {
    register_rest_route( 'custom/v1', '/custom-endpoint', array(
        'methods' => 'GET',
        'callback' => 'get_data_callback2',
        'permission_callback' => '__return_true',
    ) );
}

// Обработчик запроса к кастомному эндпоинту
function get_data_callback2( $request ) {
    $post_id = 60;
    $data = array();

    // Получаем данные из кастомных полей используя Carbon Fields
    $blocks = carbon_get_post_meta( $post_id, 'blockscomplex' );

    if ( !empty( $blocks ) ) {
        foreach ( $blocks as $block ) {
            $slides = carbon_get_complex_fields( $block['header_slides_list'] );
            $slides_data = array();

            foreach ( $slides as $slide ) {
                $image_id = $slide['header-slide-bg'];
                $image_data = wp_get_attachment_image_src( $image_id, 'full' );

                // Добавляем информацию об URL-адресе медиа элемента для каждого размера изображения
                $image_sizes = array();
                $sizes = get_intermediate_image_sizes();

                foreach ( $sizes as $size ) {
                    $image_sizes[$size] = wp_get_attachment_image_src( $image_id, $size );
                }

                $slides_data[] = array(
                    'image_id' => $image_id,
                    'image_url' => $image_data[0],
                    'image_sizes' => $image_sizes,
                    'slide_title' => $slide['header-slide_title'],
                    'slide_description' => $slide['header-slide_descr'],
                );
            }

            $data[] = array(
                'slides' => $slides_data,
            );
        }
    }

    return $data;
}