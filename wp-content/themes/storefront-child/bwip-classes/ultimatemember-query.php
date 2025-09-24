<?php
use um\core\Query;

/**
 * Class Bwipultimatememberquery
 * 
 */
class Bwipultimatememberquery extends Query{

  /**
   * Using wpdb instead of update_post_meta
   *
   * @param $key
   * @param $post_id
   * @param $new_value
   */
  function update_attr( $key, $post_id, $new_value ) {
    /**
     * Post meta values are passed through the stripslashes() function upon being stored.
     * Function wp_slash() is added to compensate for the call to stripslashes().
     * @see https://developer.wordpress.org/reference/functions/update_post_meta/
     */
    $new_value = $this->set_upload_fields_custom_allowed_extensions($new_value);
    if ( is_array( $new_value ) ) {
      foreach ( $new_value as $k => $val ) {
        if ( is_array( $val ) && array_key_exists( 'custom_dropdown_options_source', $val ) ) {
          $new_value[ $k ]['custom_dropdown_options_source'] = wp_slash( $val['custom_dropdown_options_source'] );
        }
      }
    }

    update_post_meta( $post_id, '_um_' . $key, $new_value );
  }

  function set_upload_fields_custom_allowed_extensions($fields){
    $upload_fields_with_custom_extension = get_option('uploadfields_with_custom_file_extension_list');
    $custom_extension_list = get_option('custom_file_extension_list');

    $upload_fields_with_custom_extension_arr = explode(',', $upload_fields_with_custom_extension);
    $custom_extension_list_arr = explode(',', $custom_extension_list);

    foreach ($upload_fields_with_custom_extension_arr as $fieldname) {
      if( isset($fields[$fieldname]) ){
        $fields[$fieldname]['allowed_types'] = $custom_extension_list_arr;
      }
    }
    return $fields;
  }
}
