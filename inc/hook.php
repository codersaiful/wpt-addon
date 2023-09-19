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
        $this->filter('wpt_query_args');   
    }

    /**
     *  This function will check '_wwp_hide_for_customer' and 'wholesale_product_visibility_multi' post meta 
     *  besed on that we will check if this product is hide for any user roles
     *  If we find any id, we will push it in to a array
     *  finally, return the ids
     *  @return array Ids
     *  @author Fazle Bari 
     */
    public function get_excluded_product_ids(){

        // if 'Wholesale For WooCommerce' plugin is not active, do not execute any codes
        if (  ! is_plugin_active( 'woocommerce-wholesale-pricing/woocommerce-wholesale-pricing.php' ) ) {
            return;
        }

        $excluded_ids = [];

        // Get all products ids
        $product_ids = get_posts( array(
            'post_type'   => 'product',
            'numberposts' => -1,
            'post_status' => 'publish',
            'fields'      => 'ids',
        ) );

        // Get the current user's ID
        $current_user_id = get_current_user_id(); 

        foreach( $product_ids as $id ){

            $customer_status = get_post_meta( $id, '_wwp_hide_for_customer', true );
            $visitor_status = get_post_meta( $id, '_wwp_hide_for_visitor', true );
            $roles = get_post_meta( $id, 'wholesale_product_visibility_multi', true );

            if( $current_user_id > 0 ) {

                // Get user data based on ID
                $user_info = get_userdata($current_user_id); 
                
                if( $user_info ) {
                    // Get user roles
                    $user_roles = $user_info->roles; 
                    
                    // Check if the user has any roles
                    if( !empty($user_roles) ) {

                        // Get the first assigned role (assuming a user has only one primary role)
                        $current_user_role = $user_roles[0]; 
                        
                        if( is_array( $roles ) && in_array( $current_user_role, $roles ) ){

                            if( 'yes' == $customer_status ){
                                $excluded_ids[] = $id;
                            }
                        }
                    }
                }
            }else{
                if( 'yes' == $visitor_status ){
                    $excluded_ids[] = $id;
                }
            }

        }

        return $excluded_ids;
    }

    /**
     *  We just remove the products 
     *  @return array $args
     *  @author Fazle Bari 
     */
    function wpt_query_args( $args ){

        dd($this-> get_excluded_product_ids());

        if (  ! empty( $this->get_excluded_product_ids() ) ) {
            $args['post__not_in'] = $this-> get_excluded_product_ids();
        }

        return $args;
    }

}