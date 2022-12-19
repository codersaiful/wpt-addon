<?php 
/**
 * All important functon will stay here.
 */

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
