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
        add_filter("wpt_query_args", [ $this, 'wpt_query_args'], 10, 2 );  
        add_filter("wpt_product_loop", [ $this, 'product_loop'], 10, 2 );  
        $this->add_filter('product_loop');
    }


    public function wpt_query_args( $args, $shortcode ){
        // $args['orderby'] = 'title';
        
        return $args;
    }
    public function product_loop( $loop, $shortcode ){
        // var_dump($loop);
        
        return $loop;
    }

}