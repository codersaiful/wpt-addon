<?php 
/**
 * All important functon will stay here.
 */

  /**
 * Only for developer
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
if( ! function_exists('dd') ){
	function dd( ...$vals){
		if( ! empty($vals) && is_array($vals) ){
			foreach($vals as $val ){
				echo "<pre>";
				    var_dump($val);
				echo "</pre>";
			}
		}
	}
}



if( !function_exists( 'wpt_custom_new_message_in_meta' ) ){

    function wpt_custom_new_message_in_meta( $cart_data, $cart_item = null ) {
        $custom_items = array();

        if( ! empty( $cart_data ) ) {
            $custom_items = $cart_data;
        }

        if( isset( $cart_item['wpt_size_attr'] ) ) {
            $msg_label = __( 'Size', 'wpt_pro' );
            $args['cart_item'] = $cart_item;
            $custom_items[] = array( "name" => $msg_label, "value" => $cart_item['wpt_size_attr'] );
        }

        return $custom_items;
    }
}
add_filter( 'woocommerce_get_item_data', 'wpt_custom_new_message_in_meta', 10, 2 );

//Alada function banate hobe. for Bari
add_filter('wpto_cart_meta_by_additional_json',function($cart_item_meta, $additional_json){
    
    if(empty( $additional_json )) return $cart_item_meta;

    $cart_item_meta['wpt_size_attr'] = $additional_json;
    return $cart_item_meta;


    $myData = json_decode($additional_json,true);
    $cart_item_meta['wpt_size_attr'] = $myData['wpt_size_attr'];
    return $cart_item_meta;
}, 10, 2);

if( ! function_exists( 'wpt_custom_order_meta_handler' ) ){
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
    function wpt_custom_order_meta_handler( $item_id, $item, $order_id ) {
        $values = $item->legacy_values;
        $custom_msg_2nd_color = isset( $values['wpt_size_attr'] ) && !empty( $values['wpt_size_attr'] ) ? $values['wpt_size_attr'] : false;
        if( $custom_msg_2nd_color ) {
            $msg_label = __( 'Size', 'wpt_pro' );
            $args['item_id'] = $item_id;
            $args['values'] = $values;
            $args['item'] = $item;
            $args['cart_item_key'] = $order_id;
            $unique = md5( $order_id . '_' . $custom_msg_2nd_color);
            wc_add_order_item_meta( $item_id, $msg_label, $custom_msg_2nd_color, $unique );
        }


    }
}
add_action( 'woocommerce_new_order_item', 'wpt_custom_order_meta_handler', 1, 3 );


add_action( 'wp_footer', 'wpt_custom_popup_footer_content' );

function wpt_custom_popup_footer_content(){
?>
<div id="wpt-custom-footer-content-wrapper" class="wpt-custom-footer-content-wrapper" style="display: none !important;">
    

    <div class="row"> <div class="col-xs-12 custom-cut-disclaimer"> <strong>Custom cut tolerances = plus / minus 1/16 in.</strong><br> <span id="custom-cut-call">Call Us for Mitering and Large Quantities.</span> </div> </div>
    <div class="row"> <div class="col-xs-12 custom-cut-disclaimer"> <strong>NOTICE:</strong> Custom Cut material is non-returnable and not cancelable once processing begins. Custom cutting may require additional processing time. </div> </div>

</div>

<?php
}