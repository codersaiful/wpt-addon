<?php

if( !function_exists( 'mio_new_message_column' ) ){
    function mio_new_message_column( $column_array ) {
        $column_array['new_message'] = 'New Message';
        return $column_array;
    }
 }
 add_filter( 'wpto_default_column_arr', 'mio_new_message_column' );


//Filter wpto_template_loc_item
if( !function_exists( 'mio_temp_file_for_new_message' ) ){
    function mio_temp_file_for_new_message( $file ){
        $file = __DIR__ . '/../file/new-message.php';
        return $file;
    }
}
add_filter( 'wpto_template_loc_item_new_message', 'mio_temp_file_for_new_message', 10 );


if( !function_exists( 'mio_new_message_in_meta' ) ){

    function mio_new_message_in_meta( $cart_data, $cart_item = null ) {
        $custom_items = array();


        if( ! empty( $cart_data ) ) {
            $custom_items = $cart_data;
        }
        if( isset( $cart_item['color_2'] ) ) {
            $msg_label = __( '2nd Color', 'wpt_pro' );
            $args['cart_item'] = $cart_item;
            $custom_items[] = array( "name" => $msg_label, "value" => $cart_item['color_2'] );
        }
        return $custom_items;
    }
}
add_filter( 'woocommerce_get_item_data', 'mio_new_message_in_meta', 10, 2 );


//Alada function banate hobe. for Bari
add_filter('wpto_cart_meta_by_additional_json',function($cart_item_meta, $additional_json){
    if(empty( $additional_json )) return $cart_item_meta;
    $cart_item_meta['color_2'] = $additional_json;
    return $cart_item_meta;
}, 10, 2);

if( ! function_exists( 'mio_order_meta_handler' ) ){
    /**
     * Adding Customer Message to Order
     * 
     * @param type $item_id Session ID of Item's
     * @param type $item Value's Array of Customer message
     * @param type $order_id
     * 
     * @since 1.9 6.6.2018 d.m.y
     * @fixed 8.2.2021 d.m.y fixed to this date
     * @return Void This Function will add Customer Custom Message to Order
     */
    function mio_order_meta_handler( $item_id, $item, $order_id ) {
        $values = $item->legacy_values;
        $custom_msg_2nd_color = isset( $values['color_2'] ) && !empty( $values['color_2'] ) ? $values['color_2'] : false;
        if( $custom_msg_2nd_color ) {
            $msg_label = __( '2nd Color', 'wpt_pro' );
            $args['item_id'] = $item_id;
            $args['values'] = $values;
            $args['item'] = $item;
            $args['cart_item_key'] = $order_id;
            $unique = md5( $order_id . '_' . $custom_msg_2nd_color);
            wc_add_order_item_meta( $item_id, $msg_label, $custom_msg_2nd_color, $unique );
        }
    }
}
add_action( 'woocommerce_new_order_item', 'mio_order_meta_handler', 1, 3 );
