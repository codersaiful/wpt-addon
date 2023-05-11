<?php 


function wpt_simpe_var_license(){

    return true;
}

/**
 * Check plugin pro version
 */
if( !function_exists('wpt_is_pro') ){
    function wpt_is_pro(){
        if( defined( 'WPT_PRO_DEV_VERSION' ) ) return true;
        return false;
    }
}




/**
 * This will add a new product type in 'Product Type' option. 'Product Type' option is in the queary tab. 
 * 
 * @author Fazle Bari ( fazlebarisn@gmail.com)
 */
function wpt_simple_vari_product_type( $product_types ){
	$product_types[] = [
		'value' => 'product_var_and_simple',
		'label' => __('Variation and Simple Product', 'wpt_pro')
	];
    return $product_types;
}
add_filter( 'wpt_admin_product_type' , 'wpt_simple_vari_product_type');