<?php 

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
 *  Display variable and simple product together
 * @author Fazle Bari
 */
function codeastrology_args_manipulation( $args ){
    dd($args['post_type']);
   $query = new \WP_Query($args);
   $p_products = array();
   if($query->have_posts()):
      while( $query->have_posts() ): $query->the_post();
        global $product;
        $id = get_the_id();
        if( $product->get_type() !== 'variable' ){
            $p_products[] = $id;
        }

        if( $product->get_type() == 'variable' ){
            $variable = new WC_Product_Variable( $id );

            $available_variations = $variable->get_available_variations();
            $variations_id = wp_list_pluck( $available_variations, 'variation_id' );
            $p_products = array_merge($p_products, $variations_id);

        }

      endwhile;
    endif;
    $args['post_type'] = array('product', 'product_variation',);
    $args['post__in'] = $p_products;
    $args['tax_query'] = false;
    $args['meta_query'] = false;

   return $args;
}

add_filter('wpto_table_query_args','codeastrology_args_manipulation');
add_filter('wpto_query_arg_ajax','codeastrology_args_manipulation');


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