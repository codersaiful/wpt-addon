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
        $this->action('woocommerce_product_options_inventory_product_data');        
        $this->action('woocommerce_process_product_meta');   
        // $this->action('wpt_column_top');   
        $this->action('wpt_table_row');   

        
        $this->filter('wpt_table_row_attr',10 ,2 );         
    }

    /**
     * Add new input box under the general menu
     *  @author Fazle Bari <fazlebarisn@gmail.com>
     */
    function woocommerce_product_options_inventory_product_data(){
        global $post;

        // Retrieve the current value of the custom field
        $wpt_row_bg = get_post_meta($post->ID, 'wpt_row_bg', true);
        $wpt_row_color = get_post_meta($post->ID, 'wpt_row_color', true);

        woocommerce_wp_text_input(
            array(
                'id'          => 'wpt_row_bg',
                'class'         => 'wpt-addon-color-picker',
                'label'       => __( 'Row Background', 'wpt-row-bg' ),
                // 'desc_tip'    => true,
                // 'description' => __( 'Enter a value for the Row Background. Color code eg: #abcabc or name eg: red', 'wpt-row-bg' ),
                'type' => 'text',
                'value' => $wpt_row_bg,
            )
        );

        woocommerce_wp_text_input(
            array(
                'id'          => 'wpt_row_color',
                'class'         => 'wpt-addon-color-picker',
                'label'       => __( 'Row Text Color', 'wpt-row-bg' ),
                // 'desc_tip'    => true,
                // 'description' => __( 'Enter a value for the Row Background. Color code eg: #abcabc or name eg: red', 'wpt-row-bg' ),
                'type' => 'text',
                'value' => $wpt_row_color,
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
        $wpt_row_color = isset( $_POST['wpt_row_color'] ) ? sanitize_text_field( $_POST['wpt_row_color'] ) : '';

        update_post_meta( $product_id, 'wpt_row_bg', $row_bg_value );
        update_post_meta( $product_id, 'wpt_row_color', $wpt_row_color );

    }

    /**
     * add new attr to the product table
     * @param $attr
     * @param $row_object
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    function wpt_table_row_attr( $attr, $row_object ){

        $product_id = $row_object->product_id;
        $bg_color = get_post_meta($product_id, 'wpt_row_bg', true);
        

        return "style='background-color:$bg_color;'";
    }
    /**
     * add new attr to the product table
     * @param $attr
     * @param $row_object
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    function wpt_table_row($row ){

        $product_id = $row->product_id;
        $text_color = get_post_meta($product_id, 'wpt_row_color', true);
        if(empty($text_color)) return;
        ?>
        <style>
            tr#product_id_<?php echo $product_id; ?> td a,
            tr#product_id_<?php echo $product_id; ?> td p,
            tr#product_id_<?php echo $product_id; ?> td span,
            tr#product_id_<?php echo $product_id; ?> td td.wpt-replace-td-in-tr,
            tr#product_id_<?php echo $product_id; ?> td.td_or_cell.no-inner{
                color: <?php echo $text_color; ?>;
            }
        </style>
        <?php 
        
    }

}