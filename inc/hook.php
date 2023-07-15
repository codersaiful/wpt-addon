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

        
        $this->action('wpto_admin_basic_tab', 10, 4 );        
        $this->action('wpt_load' );        
        // $this->filter('example_filter');   
    }

    public function wpt_load( $shortcode )
    {
        $table_id = $shortcode->table_id;
        $order_by_text = $shortcode->basics['order_by_text'] ?? '';

        $order_by_text = wpt_explode_string_to_array( $order_by_text );
        $settings = wp_json_encode( $order_by_text );
        ?>
        <div class="target-order_by_text" data-table_id="<?php echo esc_attr( $table_id ); ?>" data-settings="<?php echo esc_attr( $settings ); ?>">
        </div>
        <!-- <table class="my-table mobile_responsive normal_table device_for_colum wpt_temporary_table_20194 wpt_product_table wpt-tbl default_table  add_cart_left_icon playlist">
        <tr class="table-row">
            <td class="product-title">
                ddd name Product
            </td>
        </tr>
        <tr class="table-row">
            <td class="product-title">
                xxx name Product
            </td>
        </tr>
        <tr class="table-row">
            <td class="product-title">
                Test name Product
            </td>
        </tr>
        <tr class="table-row">
            <td class="product-title">
                Saiful name Product
            </td>
        </tr>
        <tr class="table-row">
            <td class="product-title">
                Abc name Product
            </td>
        </tr>
        <tr class="table-row">
            <td class="product-title">
                aaa name Product
            </td>
        </tr>
        
        <tr class="table-row">
            <td class="product-title">
                yaa name Product
            </td>
        </tr>
        <tr class="table-row">
            <td class="product-title">
                Zamil name Product
            </td>
        </tr>
    </table> -->

    <button class="my-button">Sort Table</button>
    <button class="test-my-button">Sort Table</button>
        <?php 
    }

    public function wpto_admin_basic_tab( $meta_basics, $tab, $post, $tab_array ){

        ?>
        <div class="wpt_column">
            <table class="ultraaddons-table">
                <tr>
                    <th>
                        <label class="wpt_label" for="wpt_text_orderby"><?php esc_html_e( 'Orderby Text', 'wpt_pro' );?></label>
                    </th>
                    <td>
                        <input name="basics[order_by_text]"  class="wpt_data_filed_atts ua_input" data-name="order_by_text" type="text" value="<?php echo isset( $meta_basics['order_by_text'] ) ? $meta_basics['order_by_text'] : ''; ?>" placeholder="Insert text" id="wpt_text_orderby">
                        <p style="color: #006394;"><?php esc_html_e( 'Insert With comma', 'wpt_pro' );?></p>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }



}