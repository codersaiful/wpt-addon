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

    public $config;
    public $table_position;

    public function __construct(){

        $this->config = get_option( 'wpt_configure_options' ); 
        $this->table_position = isset( $this->config['sku_table_position'] ) ? $this->config['sku_table_position'] : false;

        if( $this->table_position  == 'woocommerce_single_product_summary' ){
            add_action('woocommerce_single_product_summary', [ $this, 'displayTable' ] );
        }elseif( $this->table_position  == 'woocommerce_product_meta_start'){
            add_action('woocommerce_product_meta_start', [ $this, 'displayTable' ] );
        }elseif( $this->table_position  == 'woocommerce_product_meta_end'){
            add_action('woocommerce_product_meta_end', [ $this, 'displayTable' ] );
        }elseif( $this->table_position  == 'woocommerce_after_single_product_summary'){
            add_action('woocommerce_after_single_product_summary', [ $this, 'displayTable'] );
        }elseif( $this->table_position  == 'woocommerce_product_after_tabs'){
            add_action('woocommerce_product_after_tabs', [ $this, 'displayTable'] );
        }
     
        $this->action('wpto_admin_configuration_form_top', 10, 2);        

        $this->filter('wpt_query_args');   
    }

    /**
     * Add SKU table options on configure page
     * @return void
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    function wpto_admin_configuration_form_top( $settings,$current_config_value ){
        ?>
            <table class="wpt-my-table universal-setting">
                <tbody>
                    <tr>
                        <td>
                            <div class="wpt-form-control">
                                <div class="form-label col-lg-6">
                                    <label class="wpt_label wpt_rcp_table_on_off" for="wpt_rcp_table"><?php esc_html_e( 'Releted Category Table', 'wpt-rcp' );?></label>
                                </div>
                                <div class="form-field col-lg-6">
                                    <?php 
                                    $product_tables = get_posts( array(
                                        'post_type' => 'wpt_product_table',
                                        'numberposts' => -1,
                                        ) );
                                        if(!empty($product_tables)){
                                            ?>
                                            <select name="data[rcp_table_id]" class="wpt_fullwidth ua_input wpt_table_on_archive">
                                                <option value="">Select a Table</option>
                                                <?php 
                                                
                                                    foreach ($product_tables as $table){
                                                        $selected = isset( $current_config_value['rcp_table_id'] ) && $current_config_value['rcp_table_id'] == $table->ID ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo esc_attr($table->ID) ?>" <?php echo esc_attr( $selected ) ?> ><?php echo esc_attr( $table->post_title ) ?></option>
                                                        <?php
                                                        // echo '<option value="'. $table->ID .'" ' . $selected . '>' . $table->post_title . '</option>'; 
                                                    }
                                                ?>
                                            </select>
                                            <?php
                                    } else { 
                                        echo esc_html( 'Seems you have not created any table yet. Create a table first!', 'wpt-rcp' );
                                    } ?>
                                    <br>
                                    <label class="switch">
                                        <input name="data[rcp_table_on_of]" type="checkbox" id="wpt_rcp_table_on_off" <?php echo esc_html(isset( $current_config_value['rcp_table_on_of'] )) ? 'checked="checked"' : ''; ?>>
                                        <div class="slider round"><!--ADDED HTML -->
                                            <span class="on">Show</span><span class="off">Hide</span><!--END-->
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="wpt-form-info">
                                <?php wpt_doc_link('https://wooproducttable.com/docs/doc/'); ?>
                                <p><?php echo esc_html__( 'Enable table on group product Page. First Select a table and check [Show] to show the table on a group page.', 'wpt-rcp' ); ?></p>
                                <p class="wpt-tips">
                                    <b><?php echo esc_html__( 'Notice:', 'wpt-rcp' ); ?></b>
                                    <span><?php echo esc_html__( 'Make sure you have installed and activated Woo Product Table plugin','wpt-rcp' ); ?></span>
                                </p>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="wpt-form-control">
                                <div class="form-label col-lg-6">
                                    <label class="wpt_label wpt_rcp_table_on_off" for="wpt_rcp_table"><?php esc_html_e( 'Related Category Table Position', 'wpt-rcp' );?></label>
                                </div>
                                <div class="form-field col-lg-6">
                                    <select name="data[rcp_table_position]" class="wpt_fullwidth ua_input wpt_table_on_archive">
                                        <option value="woocommerce_single_product_summary" <?php wpt_selected( 'rcp_table_position', 'woocommerce_single_product_summary' ); ?>><?php esc_html_e( 'After Title', 'wpt-rcp' );?></option>
                                        <option value="woocommerce_product_meta_start" <?php wpt_selected( 'rcp_table_position', 'woocommerce_product_meta_start' ); ?>><?php esc_html_e( 'Before Meta', 'wpt-rcp' );?></option>
                                        <option value="woocommerce_product_meta_end" <?php wpt_selected( 'rcp_table_position', 'woocommerce_product_meta_end' ); ?>><?php esc_html_e( 'After Meta', 'wpt-rcp' );?></option>
                                        <option value="woocommerce_after_single_product_summary" <?php wpt_selected( 'rcp_table_position', 'woocommerce_after_single_product_summary' ); ?>><?php esc_html_e( 'After summary', 'wpt-rcp' );?></option>
                                        <option value="woocommerce_product_after_tabs" <?php wpt_selected( 'rcp_table_position', 'woocommerce_product_after_tabs' ); ?>><?php esc_html_e( 'After Tab', 'wpt-rcp' );?></option>
                                    </select> 
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="wpt-form-info">
                                <?php wpt_doc_link('https://wooproducttable.com/docs/doc/'); ?>
                                <p><?php echo esc_html__( 'You can chnage table position from here.', 'wpt-rcp' ); ?></p>
                            </div> 
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php
    }



    /**
     * Push our chooen ids in to the table
     * @return array $args
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function wpt_query_args( $args ){

        $rpc_table_id = isset( $this->config['rpc_table_id']) ? $this->config['rpc_table_id'] : 1;
        if( $args['table_ID'] != $rpc_table_id ) return $args;

        if(  is_product() ) {

        }

        return $args;
    }

    /**
     * Display the table in the single product page
     * @return void
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function displayTable(){

        $rpc_table_id = isset( $this->config['rpc_table_id']) ? $this->config['rpc_table_id'] : 1;

        // if( $this->get_include_ids() == null || empty($rpc_table_id) ) {
        //     return;
        // }
        
        echo do_shortcode("[Product_Table id='".$rpc_table_id."' behavior='normal']");
    }

}