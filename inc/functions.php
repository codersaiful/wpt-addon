<?php 
/**
 * All important functon will stay here.
 */
// function woocommerce_wp_select_multiple( $field ) {
//     global $thepostid, $post, $woocommerce;

//     $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
//     $field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
//     $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
//     $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
//     $field['value']         = isset( $field['value'] ) ? $field['value'] : ( get_post_meta( $thepostid, $field['id'], true ) ? get_post_meta( $thepostid, $field['id'], true ) : array() );

//     echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . esc_attr( $field['class'] ) . '" multiple="multiple">';

//     foreach ( $field['options'] as $key => $value ) {

//         echo '<option value="' . esc_attr( $key ) . '" ' . ( in_array( $key, $field['value'] ) ? 'selected="selected"' : '' ) . '>' . esc_html( $value ) . '</option>';

//     }

//     echo '</select> ';

//     if ( ! empty( $field['description'] ) ) {

//         if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
//             echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
//         } else {
//             echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
//         }

//     }
//     echo '</p>';
// }