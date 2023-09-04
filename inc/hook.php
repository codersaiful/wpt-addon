<?php 
namespace MMQ_USERS\Inc;
use MMQ_USERS\Inc\App\Hook_Base;

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
        $this->filter('wcmmq_single_product_min_max_condition');   
        $this->filter('wcmmq_add_validation_check');   
        $this->filter('wcmmq_cart_validation_check');   
    }

    /**
     * Set default args for administrator and shop manager
     * @return array $args
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function wcmmq_single_product_min_max_condition( $args ){

        if( wc_current_user_has_role('administrator') || wc_current_user_has_role('shop_manager') ){
            $args['max_value'] = -1;
            $args['min_value'] = 1;
            $args['step'] = 1;
            if( ! is_cart() ){
                $args['input_value'] = 1;
            }
            return $args;
        }

        return $args;
    }

    /**
     * Remove add to cart validation check for administrator and shop manager
     * @return bool 
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function wcmmq_add_validation_check(){

        if( wc_current_user_has_role('administrator') || wc_current_user_has_role('shop_manager') ){
            return false;
        }else{
            return true;
        }

    }

    /**
     * Remove cart update validation check for administrator and shop manager
     * @return bool 
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function wcmmq_cart_validation_check(){

        if( wc_current_user_has_role('administrator') || wc_current_user_has_role('shop_manager') ){
            return false;
        }else{
            return true;
        }

    }
}