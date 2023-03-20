<?php 

/**
 *  Display variable and simple product together
 * @author Fazle Bari
 */
function codeastrology_args_manipulation( $args ){
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
    $args['post_type'] = array('product', 'product_variation');
    $args['post__in'] = $p_products;
    $args['tax_query'] = false;
    $args['meta_query'] = false;

   return $args;
}

add_filter('wpto_table_query_args','codeastrology_args_manipulation');
add_filter('wpto_table_query_args_in_row','codeastrology_args_manipulation');
add_filter('wpto_query_arg_ajax','codeastrology_args_manipulation');
