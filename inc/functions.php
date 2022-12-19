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

$product_id = 17664;
$variation_id = 19666;

ob_start();


function get_product_pricing(){
    $value = get_option( 'rp_wcdpd_settings' );
	return $value[1]['product_pricing'] ?? [];
}

$pricingArray = get_product_pricing();
// $key = array_search($variation_id, array_column($userdb, 'uid'));
//If Variation_type
function getIdWiseSetting(){
    $idWiseSetting = [];
    $pricingArray = get_product_pricing();
    foreach($pricingArray as $pricing_key => $eachPricing){
        $conditionsEachPricing = $eachPricing['conditions'] ?? [];

        foreach($conditionsEachPricing as $eachCondEchPricing){
            $type = $eachCondEchPricing['type'] ?? '';
            
            $product_variations = $eachCondEchPricing['product_variations'] ?? [];
            $products = $eachCondEchPricing['products'] ?? [];
            
            $quantity_ranges = $eachPricing['quantity_ranges'] ?? [];
            $ids_collections = [];
            if($type === 'product__product'){
                $ids_collections = $products;
            }elseif($type === 'product__variation'){
                $ids_collections = $product_variations;
            }
            if(empty( $ids_collections ) || ! is_array( $ids_collections )) continue;

            
            foreach($ids_collections as $id_collection){
                $idWiseSetting[$id_collection] = $quantity_ranges;
            }

        }
        
    }
    return $idWiseSetting;
}
echo '<pre>';
print_r(getIdWiseSetting());
echo '</pre>';
