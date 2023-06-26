<?php 
/**
 * All important functon will stay here.
 */
add_filter( 'woocommerce_loop_add_to_cart_args', 'wcmmq_custom_min_max_arg_regen', 999999, 2 );
add_filter( 'woocommerce_quantity_input_args', 'wcmmq_custom_min_max_arg_regen', 999999, 2 );
add_filter( 'woocommerce_available_variation', 'wcmmq_custom_min_max_arg_regen', 999999, 2 );

function wcmmq_custom_min_max_arg_regen($args, $product)
{

	$product_id = $product->get_id();
    $stock_status = get_post_meta($product_id,'_stock_status',true);

	if( $stock_status !== 'onbackorder' ){


		$args['quantity'] = 1;
		$args['step'] = 1;
		$args['input_value'] = 1;
		$args['min_qty'] = $args['min_value'] = 1;
		$args['max_value'] = $args['max_qty'] = false;

		return $args;
	}

	return $args;
}


//add_filter('woocommerce_update_cart_validation', 'wcmmq_update_cart_validation', 10, 4);
add_filter('woocommerce_add_to_cart_validation','wcmmq_custom_cartvalidation_removed', 999, 5);	
function wcmmq_custom_cartvalidation_removed($bool,$product_id,$quantity,$variation_id = 0, $variations = false){
	// $product = wc_get_product($product_id);
	$stock_status = get_post_meta($product_id,'_stock_status',true);
	if($stock_status !== 'onbackorder'){
		remove_filter('woocommerce_add_to_cart_validation','wcmmq_min_max_valitaion', 10);
		return true;
	}
	return $bool;
	// var_dump($stock_status);
	// $stock_qty = $product->get_stock_quantity();
	// $get_stock_status = $product->get_stock_status();
	// var_dump($stock_qty,$get_stock_status,$product_id,$quantity,$product);
	// remove_filter('woocommerce_add_to_cart_validation','wcmmq_min_max_valitaion', 10);
}