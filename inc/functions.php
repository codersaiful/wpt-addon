<?php 
/**
 * All important functon will stay here.
 */
// $dd = rp_wcdpd_get_product_pricing_rules_applicable_to_product(17664,1);
// var_dump($dd);
// ob_start();
// $settings = get_option('rp_wcdpd_settings', array());
// var_dump($settings);
// $dd = ob_get_clean();
// var_dump($dd);
//  add_filter( 'rp_wcdpd_volume_pricing_table_data' , 'rp_wcdpd_volume_pricing_table_data_callback', 10, 3);
// $value = get_option( 'rp_wcdpd_settings' );
// echo '<pre>';
// // print_r($value);
// echo '</pre>';
// // var_dump($value[1]['product_pricing'][0]['quantity_ranges']);
// var_dump($value[1]['product_pricing'][0]['conditions']);
// var_dump($value[1]['product_pricing'][1]['conditions']);
// dd($value[1]['product_pricing'][0]['quantity_ranges']);


// $value = get_option( 'rp_wcdpd_settings' );

// function getValues( $value ){
// 	$asValue = [];
// 	foreach( $value as $asValue ){
// 		$asValue[] = $asValue;
// 	}
// 	return $asValue;
// }

// $pricingArray = getValues($value);
// $product_pricing = getValues( $pricingArray['product_pricing'] );

// $product_variations = getValues($product_pricing['conditions']);

// function variaId( $product_variations ){
// 	foreach( $product_variations['product_variations'] as $id  ){
// 		$id = $id;
// 	}
// 	return $id;
// }

// function quantityRanges( $product_pricing ){
// 	foreach( $product_pricing['quantity_ranges'] as $quantity_ranges ){
// 		$price = $quantity_ranges;
// 	}
// 	return $price;
// }

// $price = quantityRanges( $product_pricing );
// $id = variaId( $product_variations );

add_action("woocommerce_after_main_content",function(){
    global $product;
    echo "HHHHHHHHHHHHHHHHHH<br>";
    echo RP_WCDPD_Promotion_Volume_Pricing_Table::maybe_display_pricing_table($product);
    echo "HHHHHHHHHHHHHHHHHH";
    // var_dump(get_the_ID());
    echo rp_wcdpd_display_volume_pricing_table(17392);
    echo rp_wcdpd_display_volume_pricing_table(17664);
    // var_dump($product->get_id(),$product);
});
add_filter('rp_wcdpd_volume_pricing_table_data',function($data, $product, $rule){
    // var_dump($data, $product, $rule);
    return $data;
},10, 3);