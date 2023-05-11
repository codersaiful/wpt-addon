<?php 
namespace WPT_ADDON\Inc;
use WPT_ADDON\Inc\App\Hook_Base;

/**
 * All Basic Hook will control from 
 * here.
 * 
 * If you are not interested using class Object,
 * write your hook use at inc/functions.php file
 * 
 * Normall we will use this Hook.
 * 
 */
class Hook extends Hook_Base{

    public function __construct(){

        
        // $this->action('example_hook');        
        // $this->filter('example_filter');  
        
        //add_filter('wpt_query_args','codeastrology_args_manipulation');
        $this->filter('wpt_query_args');   
    }


    function example_hook(){
        echo '<h2>Example Hook</h2>';
    }
    function example_filter(){
        return 'Example Hook';
    }


    /**
     *  Display variable and simple product together
     * @author Fazle Bari
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    function wpt_query_args( $args ){

        $post_type = $args['post_type'] ?? 'product';
        if( 'product_var_and_simple' !== $post_type ) return $args;

        $args['post_type'] = 'product';

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
                $variable = new \WC_Product_Variable( $id );

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



}