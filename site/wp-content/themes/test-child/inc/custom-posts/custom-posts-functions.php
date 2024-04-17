<?php
function get_field_link( $post_id, $object_field ) {
  $post_field_value = carbon_get_post_meta( $post_id, $object_field );

  if ( ! empty( $post_field_value ) ) {
      $attachment_id = $post_field_value['id']; // Получаем ID вложения
      $attachment_url = wp_get_attachment_url( $attachment_id ); // Получаем URL вложения

      return $attachment_url;
  }

  return '';
}