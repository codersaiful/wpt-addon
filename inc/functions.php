<?php 
/**
 * All important functon will stay here.
 */

/**
 * 	Set default values for normal products
 * 	@param $args
 * 	@param $product
 * 	@author Fazle Bari <fazlebarisn@gmail.com>
 */
function wcmmq_custom_min_max_arg_regen($args, $product)
{
	$product_id = $product->get_id();

    $stock_status = get_post_meta($product_id,'_stock_status',true);
	
	if( $stock_status !== 'onbackorder' ){
		// dd($args);
		$args['quantity'] = 1;
		$args['step'] = 1;
		$args['min_qty'] = $args['min_value'] = 1;
		$args['max_value'] = $args['max_qty'] = false;
		if( !is_cart() ){
			$args['input_value'] = 1;
		}

		return $args;
	}

	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'wcmmq_custom_min_max_arg_regen', 999999, 2 );
add_filter( 'woocommerce_quantity_input_args', 'wcmmq_custom_min_max_arg_regen', 999999, 2 );
add_filter( 'woocommerce_available_variation', 'wcmmq_custom_min_max_arg_regen', 999999, 2 );

/**
 * 	Remove add to cart validation for normal products
 * 	@param $bool
 * 	@param $product_id
 * 	@param $variation_id
 * 	@param $quantity
 * 	@param $variations
 * 	@author Fazle Bari <fazlebarisn@gmail.com>
 */
function wcmmq_custom_cartvalidation_removed($bool,$product_id,$quantity,$variation_id = 0, $variations = false){
	
	$stock_status = get_post_meta($product_id,'_stock_status',true);

	if($stock_status !== 'onbackorder'){
		remove_filter('woocommerce_add_to_cart_validation','wcmmq_min_max_valitaion', 10);
		return true;
	}
	return $bool;
}
add_filter('woocommerce_add_to_cart_validation','wcmmq_custom_cartvalidation_removed', 999, 5);	

/**
 * 	Remove update cart validation for normal products
 * 	@param $true
 * 	@param $cart_item_key
 * 	@param $values
 * 	@param $quantity
 * 	@author Fazle Bari <fazlebarisn@gmail.com>
 */
function wcmmq_custom_cart_update_validation_removed( $true, $cart_item_key, $values, $quantity ) {
	$product_id = $values['product_id'];

	$stock_status = get_post_meta($product_id,'_stock_status',true);

	if($stock_status !== 'onbackorder'){
		remove_filter('woocommerce_update_cart_validation','wcmmq_update_cart_validation', 10);
		return true;
	}
	return $true;
}
add_filter('woocommerce_update_cart_validation','wcmmq_custom_cart_update_validation_removed', 999, 5);	

/**
 * 	Remove step message for normal products
 * 	@param $message
 * 	@param $product_id
 * 	@author Fazle Bari <fazlebarisn@gmail.com>
 */
add_filter( 'wcmmq_step_error_message', function( $message, $product_id ){
	$stock_status = get_post_meta($product_id,'_stock_status',true);

	if($stock_status !== 'onbackorder'){
		$message = '';
	}

	return $message;
}, 10, 2 );

/**
 * 	For the variable products. I have added stock status and then check backorder
 * 	@author Fazle Bari <fazlebarisn@gmail.com>
 */
function mmq_backorder_js_for_variation(){
	global $product;
	$validation = apply_filters( 'wcmmq_js_variation_script', true, $product );
	
	if( !$validation || 'variable' !== $product->get_type() ){
		return;
	}
	
	$product_id = $product->get_id();
	$product_data[WC_MMQ_PREFIX_PRO . 'min_quantity'] = get_post_meta( $product_id, WC_MMQ_PREFIX_PRO . 'min_quantity', true );
	$product_data[WC_MMQ_PREFIX_PRO . 'default_quantity'] = get_post_meta( $product_id, WC_MMQ_PREFIX_PRO . 'default_quantity', true );
	$product_data[WC_MMQ_PREFIX_PRO . 'max_quantity'] = get_post_meta( $product_id, WC_MMQ_PREFIX_PRO . 'max_quantity', true );
	$product_data[WC_MMQ_PREFIX_PRO . 'product_step'] = get_post_meta( $product_id, WC_MMQ_PREFIX_PRO . 'product_step', true );
	
	$product_data = apply_filters( 'wcmmq_product_data_for_json', $product_data, $product );
	
	$product_data = wp_json_encode( $product_data );
	
	$default_data[WC_MMQ_PREFIX_PRO . 'min_quantity'] = WC_MMQ::getOption( WC_MMQ_PREFIX_PRO . 'min_quantity' );
	$default_data[WC_MMQ_PREFIX_PRO . 'default_quantity'] = WC_MMQ::getOption( WC_MMQ_PREFIX_PRO . 'default_quantity' );
	$default_data[WC_MMQ_PREFIX_PRO . 'max_quantity'] = WC_MMQ::getOption( WC_MMQ_PREFIX_PRO . 'max_quantity' );
	$default_data[WC_MMQ_PREFIX_PRO . 'product_step'] = WC_MMQ::getOption( WC_MMQ_PREFIX_PRO . 'product_step' );
	
	//For Taxonomy
	$terms_data = WC_MMQ::getOption( 'terms' );
	$terms_data = is_array( $terms_data ) ? $terms_data : array();
	foreach( $terms_data as $term_key => $values ){
		$product_term_list = wp_get_post_terms( $product_id, $term_key, array( 'fields' => 'ids' ));
		foreach ( $product_term_list as $product_term_id ){
	
			$my_term_value = isset( $values[$product_term_id] ) ? $values[$product_term_id] : false;
			if( is_array( $my_term_value ) ){
				$default_data[WC_MMQ_PREFIX_PRO . 'min_quantity'] = !empty( $my_term_value['_min'] ) ? $my_term_value['_min'] : $default_data[WC_MMQ_PREFIX_PRO . 'min_quantity'];
				$default_data[WC_MMQ_PREFIX_PRO . 'default_quantity'] = !empty( $my_term_value['_default'] ) ? $my_term_value['_default'] : $default_data[WC_MMQ_PREFIX_PRO . 'default_quantity'];
				$default_data[WC_MMQ_PREFIX_PRO . 'max_quantity'] = !empty( $my_term_value['_max'] )  ? $my_term_value['_max'] : $default_data[WC_MMQ_PREFIX_PRO . 'max_quantity'];
				$default_data[WC_MMQ_PREFIX_PRO . 'product_step'] = !empty( $my_term_value['_step'] ) ? $my_term_value['_step'] : $default_data[WC_MMQ_PREFIX_PRO . 'product_step'];
				break;
			}
		}
	
	}
	
	$default_data = apply_filters( 'wcmmq_default_data_for_json', $default_data, $product );
	
	$default_data = wp_json_encode( $default_data );
	$variables = $product->get_children();
	//var_dump(count( $variables ) > 0);
	$data = array();
	if(!is_array($variables) || ( is_array( $variables ) && count( $variables ) < 1 )) return;
	
	foreach( $variables as $variable_id){
		$variation = wc_get_product($variable_id);
		//$min_qty = get_post_meta( $variable_id, WC_MMQ_PREFIX_PRO . 'min_quantity', true );
		$data[$variable_id] = array(
			WC_MMQ_PREFIX_PRO . 'min_quantity' => get_post_meta( $variable_id, WC_MMQ_PREFIX_PRO . 'min_quantity', true ),
			WC_MMQ_PREFIX_PRO . 'default_quantity' => get_post_meta( $variable_id, WC_MMQ_PREFIX_PRO . 'default_quantity', true ),
			WC_MMQ_PREFIX_PRO . 'max_quantity' => get_post_meta( $variable_id, WC_MMQ_PREFIX_PRO . 'max_quantity', true ),
			WC_MMQ_PREFIX_PRO . 'product_step' => get_post_meta( $variable_id, WC_MMQ_PREFIX_PRO . 'product_step', true ),
			'stock_status' => $variation->get_stock_status(),
		);
	}
	$data = apply_filters( 'wcmmq_variation_data_for_json', $data, $product );
	$data = wp_json_encode( $data );//htmlspecialchars( wp_json_encode( $data ) );
	
	?>
	<script  type='text/javascript'>
	(function($) {
		'use strict';
		$(document).ready(function($) {
			var product_id = "<?php echo $product->get_id(); ?>";
			var default_data = '<?php echo $default_data; ?>';
			var product_data = '<?php echo $product_data; ?>';
			var variation_data = '<?php echo $data; ?>';
	
			default_data = JSON.parse(default_data);
			product_data = JSON.parse(product_data);
			variation_data = JSON.parse(variation_data);
			var form_selector = 'form.variations_form.cart[data-product_id="' + product_id + '"]';
	 
	
	   
			$(document.body).on('change',form_selector + ' input.variation_id',function(){
			   
				var variation_id = $(form_selector + ' input.variation_id').val();
				var qty_box = $(form_selector + ' input.input-text.qty.text');
	
				if(typeof variation_id !== 'undefined' && variation_id !== ''  && variation_id !== ' '){
					var stock_status = variation_data[variation_id]['stock_status'];
	
					var min,max,step,basic;
	
					if (stock_status == 'onbackorder') {
						min = variation_data[variation_id]['<?php echo WC_MMQ_PREFIX_PRO; ?>min_quantity'];
						if(typeof min === 'undefined'){
							return false;
						}
						if(min === '' || min === false){
							min = product_data['<?php echo WC_MMQ_PREFIX_PRO; ?>min_quantity'];
						}
						if(min === '' || min === false){
							min = default_data['<?php echo WC_MMQ_PREFIX_PRO; ?>min_quantity'];
						}
						max = variation_data[variation_id]['<?php echo WC_MMQ_PREFIX_PRO; ?>max_quantity'];
						if(max === '' || max === false){
							max = product_data['<?php echo WC_MMQ_PREFIX_PRO; ?>max_quantity'];
						}
						if(max === '' || max === false){
							max = default_data['<?php echo WC_MMQ_PREFIX_PRO; ?>max_quantity'];
						}
						
						step = variation_data[variation_id]['<?php echo WC_MMQ_PREFIX_PRO; ?>product_step'];
						if(step === '' || step === false){
							step = product_data['<?php echo WC_MMQ_PREFIX_PRO; ?>product_step'];
						}
						if(step === '' || step === false){
							step = default_data['<?php echo WC_MMQ_PREFIX_PRO; ?>product_step'];
						}
						basic = variation_data[variation_id]['<?php echo WC_MMQ_PREFIX_PRO; ?>default_quantity'];
						if(basic === '' || basic === false){
							basic = product_data['<?php echo WC_MMQ_PREFIX_PRO; ?>default_quantity'];
						}
						if(basic === '' || basic === false){
							basic = default_data['<?php echo WC_MMQ_PREFIX_PRO; ?>default_quantity'];
						}
						
						if(basic === '' || basic === false){
							basic = min;
						}
					}else{
						min=1;
						max=false,
						step=1,
						basic=1
					}
					var lateSome = setInterval(function(){
	
						qty_box.attr({
							min:min,
							max:max,
							step:step,
							value:basic
						});
						qty_box.val(basic).trigger('change');
						clearInterval(lateSome);
					},500);
	
				}
				
				
			});
	
		});
	})(jQuery);
	</script>
	<?php
	}
add_action('woocommerce_single_variation','mmq_backorder_js_for_variation');