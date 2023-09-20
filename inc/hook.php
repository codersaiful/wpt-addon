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

    public function __construct(){

        $this->config = get_option( 'wpt_configure_options' ); 

        $this->action('woocommerce_product_meta_end');        
        $this->action('wpto_admin_configuration_form_top', 10, 2);        
        $this->filter('wpt_query_args');   
    }

    function wpto_admin_configuration_form_top( $settings,$current_config_value ){
        ?>
            <table class="wpt-my-table universal-setting">
                <tbody>
                    <tr>
                        <td>
                            <div class="wpt-form-control">
                                <div class="form-label col-lg-6">
                                    <label class="wpt_label wpt_group_table_on_off" for="wpt_group_table"><?php esc_html_e( 'Single Page SKU Table ID', 'wpt' );?></label>
                                </div>
                                <div class="form-field col-lg-6">
                                    <input type="number" name="data[sku_table_id]" value="<?php echo esc_html(isset( $current_config_value['sku_table_id'] ) ? $current_config_value['sku_table_id'] : '')?>" >
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="wpt-form-info">
                                <?php wpt_doc_link('https://wooproducttable.com/docs/doc/'); ?>
                                <p><?php echo esc_html__( 'You can chnage table position from here.', 'wpt' ); ?></p>
                            </div> 
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php
    }
    /**
     * A query to get product id from sku
     * @return int $product_id
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function get_product_id_from_sku($sku) {
        global $wpdb;
        $product_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='$sku'");
        return $product_id;
    }

    /**
     * Get all sku fron ACF field
     * @return string $sku_from_acf
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function get_sku(){
	    $sku_from_acf = get_field('sku',  get_the_ID() );
        return $sku_from_acf;
    }

    /**
     * Get all product ids that we will display in the table
     * @return array $include_ids
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function get_include_ids(){

        $include_ids = [];

        $all_sku = trim( $this->get_sku() );

        // do not go farther if sku field is empty 
        if( empty ($all_sku) ) return;
        
        $all_sku = str_replace(' ', '', $all_sku);
        $all_sku = explode(',', $all_sku);
        
        if( ! empty( $all_sku ) && is_array( $all_sku ) ){
            foreach( $all_sku as $sku ){
                $include_ids[] = $this->get_product_id_from_sku($sku);
            }
        }

        return $include_ids;
    }

    /**
     * function for check null array
     * @return bool 
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    function containsNonNullValue($arr) {
        $filteredArray = array_filter($arr, function($element) {
            return $element !== NULL;
        });
    
        return !empty($filteredArray);
    }

    /**
     * Push our chooen ids in to the table
     * @return array $args
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function wpt_query_args( $args ){

        if(  is_product() ) {
            $sale_products = $this->get_include_ids();
            $args['post__in'] = $sale_products;
        }

        return $args;
    }

    /**
     * Display the table in the single product page
     * @return void
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function woocommerce_product_meta_end(){

        if ($this->get_include_ids() == null  ) {
            return;
        }
        $table_id =  $this->config['sku_table_id'];

        echo do_shortcode("[Product_Table id='".$table_id."' name='One' behavior='normal']");
    }

}