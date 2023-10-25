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
        $this->filter( 'wcmmq_single_product_min_max_condition', 10, 2 );   
    }

    /**
     * Set the stock quantity as the min quantity
     * @return array $args
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    function wcmmq_single_product_min_max_condition( $args , $product ){

        $stock_quantity = $product->stock_quantity;
        
        if( $product->manage_stock ){
            $args['min_value'] = $stock_quantity;
        }
        if( is_archive() ){
            $args['quantity'] = $stock_quantity;
        }
        return $args;
    }

}