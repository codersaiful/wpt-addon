<?php 

// add_action('wp',function(){
//     $product = wc_get_product(get_the_ID());
//     // var_dump($product);
//     // For return True and any kind amount cart adding
//     remove_filter('woocommerce_add_to_cart_validation', 'wcmmq_min_max_valitaion', 10);
//     remove_filter('woocommerce_update_cart_validation', 'wcmmq_update_cart_validation', 10);
//     add_filter('woocommerce_add_to_cart_validation', '__return_true', 0); 
//     add_filter('woocommerce_update_cart_validation', '__return_true', 0); 
// });
add_action('wp','wcmmq_group_addons_detect_grouped');

function wcmmq_group_addons_detect_grouped(){

    $product = wc_get_product(get_the_ID());
    if(!$product) return;
    if( ! is_a($product,'WC_Product_Grouped')) return;

    // add_filter('wcmmq_single_product_min_max_condition','wcmmq_group_addons_args_manage',999,2);
    add_filter('woocommerce_loop_add_to_cart_args','wcmmq_group_addons_args_manage',999,2);
    add_filter('woocommerce_quantity_input_args','wcmmq_group_addons_args_manage',999,2);
    add_filter('woocommerce_available_variation','wcmmq_group_addons_args_manage',999,2); 


    
    // remove_filter('woocommerce_add_to_cart_validation', 'wcmmq_min_max_valitaion', 10);
    // remove_filter('woocommerce_update_cart_validation', 'wcmmq_update_cart_validation', 10);
    // add_filter('woocommerce_add_to_cart_validation', '__return_true', 0); 
    // add_filter('woocommerce_update_cart_validation', '__return_true', 0); 


    add_filter('woocommerce_add_to_cart_validation', 'wcmmq_group_return_true', 0); 
    // add_filter('woocommerce_update_cart_validation', 'wcmmq_group_return_true', 0); 
    

}

remove_filter('woocommerce_update_cart_validation', 'wcmmq_update_cart_validation', 10);
remove_filter('woocommerce_add_to_cart_validation', 'wcmmq_min_max_valitaion', 10);
function wcmmq_group_return_true(){
    return true;
}
function wcmmq_group_addons_args_manage( $args, $product ){
    
    if(empty( $args['input_value'] )){
        $args['input_value'] = 1;
    }
    // var_dump($args);
    $args['min_value'] = $args['step'] = $args['min_qty'] = 1;
    $args['max_value'] = $args['max_qty'] = '';
    return $args;
}