<?php 
/**
 * All important functon will stay here.
 */
// function dd($val){
// 	echo "<pre>";
// 		var_dump($val);
// 	echo "</pre>";
//  }

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

/**
 * Add new column type for product table;
 */
function wpt_add_dynamic_price_column( $add_new_col_type, $columns_array, $column_settings, $post ){
    $add_new_col_type['dynamic_price'] = 'Dynamic Price';
    return $add_new_col_type;
}
add_filter( 'wpto_addnew_col_arr', 'wpt_add_dynamic_price_column', 10, 4 );


if( !function_exists( 'codeastrology_dynamic_price_file' ) ){
    function codeastrology_dynamic_price_file( $file ){
        $file = __DIR__ . '/../file/dynamic_price.php';
        //$file = $your_file_location;
        // dd($file);
        return $file;
    }
 }
 add_filter( 'wpto_template_loc_item_dynamic_price', 'codeastrology_dynamic_price_file', 10 );
 
//  if( !function_exists( 'codeastrology_single_attribute' ) ){

//     function codeastrology_single_attribute( $column_array ) {
//         dd($column_array);
//         return $column_array;
//     }
 
//  }
//  add_filter( 'wpto_default_column_arr', 'codeastrology_single_attribute' );