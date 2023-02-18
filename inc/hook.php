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
        $this->filter('woocommerce_product_data_tabs'); 
        $this->filter('woocommerce_product_data_panels'); 
        $this->action('wpt_add_field_in_panel');    
        $this->action('woocommerce_process_product_meta');    
    }

    /**
     * To define Tab Menu Under single product edit page
     * We have used a filter: woocommerce_product_data_tabs to To define Tab Menu Under single product edit page
     * 
     * @param Array $product_data_tab
     * @return Array it will return Tabs Array
     */
    public function woocommerce_product_data_tabs( $product_data_tab){
 
        $wpt_tab['wpt_column_filter'] = array(
            'label' => __('Wpt Column Filter','wcmmq'),
            'target'   => 'wpt_column_filter', //This is targetted div's id
            'class'     => array( 'hide_if_downloadable','hide_if_grouped' ), //'hide_if_grouped',
            );

        $position = 1; // Change this for desire position 
        $tabs = array_slice( $product_data_tab, 0, $position, true ); // First part of original tabs 
        $tabs = array_merge( $tabs, $wpt_tab ); // Add new 
        $tabs = array_merge( $tabs, array_slice( $product_data_tab, $position, null, true ) ); // Glue the second part of original 
        return $tabs; //return $product_data_tab;

    }

    /**
     * Tab options of wpt column
     * We also add a new action to this function name: wpt_product_options
     * To add options filed to here
     */
    public function woocommerce_product_data_panels(){
        ?>
            <div  id="wpt_column_filter" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <?php do_action( 'wpt_add_field_in_panel' ); ?>
                </div>
            </div>
        <?php 
        }

    /**
     * generate fild array
     *
     * @return void
     */
    public function wpt_add_field_in_panel(){
        $args = array();
        $args[] = array(
            'id'        =>'wpt_filter_col',
            'name'      => 'wpt_filter_col',
            'label'     =>  __( 'Column List', 'wpt_pro' ),
            'class'     =>  'wpt_input',
            'type'      =>  'text',
            'desc_tip'  =>  true,
            'description'=> __( 'Add column to filter', 'wpt_pro' ),
            // 'data_type' => 'decimal'
        );
        
        $args = apply_filters('wpt_field_args_in_panel', $args);
    
        foreach($args as $arg){
            woocommerce_wp_text_input($arg);
        }
    }

    /**
     * Save column name for filter
     *
     * @param [type] $post_id
     * @return void
     */
    function woocommerce_process_product_meta( $post_id ){
    
        $wpt_filter_col = $_POST['wpt_filter_col'] ?? false;
        
        //Updating Here
        update_post_meta( $post_id, 'wpt_filter_col', esc_attr( $wpt_filter_col ) );
    }

}