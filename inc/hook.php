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
        // $this->filter('example_filter');   
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