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
        $this->action('woocommerce_product_options_general_product_data');        
        $this->action('woocommerce_process_product_meta');   

        $this->filter('wpt_table_row_attr',10 ,2 );         
    }

    /**
     * Add new input box under the general menu
     *  @author Fazle Bari <fazlebarisn@gmail.com>
     */
    function woocommerce_product_options_general_product_data(){
        woocommerce_wp_text_input(
            array(
                'id'          => 'wpt_row_bg',
                'label'       => __( 'Row Background', 'wpt-row-bg' ),
                'placeholder' => __( 'Color code eg: #abcabc or name eg: red', 'wpt-row-bg' ),
                'desc_tip'    => true,
                'description' => __( 'Enter a value for the Row Background. Color code eg: #abcabc or name eg: red', 'wpt-row-bg' ),
            )
        );
    }

    /**
     *  Save the new custom field value
     *  @param $product_id
     *  @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    function woocommerce_process_product_meta( $product_id ){
        $row_bg_value = isset( $_POST['wpt_row_bg'] ) ? sanitize_text_field( $_POST['wpt_row_bg'] ) : '';
        update_post_meta( $product_id, 'wpt_row_bg', $row_bg_value );
    }

    /**
     * add new attr to the product table
     * @param $attr
     * @param $row_object
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    function wpt_table_row_attr( $attr, $row_object ){
        $product_id = $row_object->product_id;
        $color = get_post_meta($product_id, 'wpt_row_bg', true);
        return "style='background-color:$color;'";
    }

}