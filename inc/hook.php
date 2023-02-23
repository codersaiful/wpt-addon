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
        $this->action('wpt_load');    
        $this->action('save_post');    
    }

    
    public  function save_post( $post_id ) {
        if ( isset( $_POST['_product_categories'] ) ) {
            $categories = array_map( 'sanitize_text_field', $_POST['_product_categories'] );
            update_post_meta( $post_id, '_product_categories', maybe_serialize( $categories ) );
        } else {
            delete_post_meta( $post_id, '_product_categories' );
        }
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

        global $post;
        $id = $post->ID;
        $Product_Variable = new \WC_Product_Variable( $id ); 
        $attributes = $Product_Variable->get_variation_attributes();
        $arrtibute_keys = array_keys( $attributes );
        // $des = implode($arrtibute_keys,'');
        
        // var_dump();
        // woocommerce_wp_select(
        //     array(
        //         'id'          => 'wpt_filter_colss',
        //         'label'       => __('Testing', 'woocommerce'),
        //         'options'     => array(
        //             'red'      => __('Red', 'woocommerce'),
        //             'green'    => __('Green', 'woocommerce'),
        //             'blue'     => __('Blue', 'woocommerce'),
        //         ),
        //         'value' => 'blue',
        //         'desc_tip'    => true,
        //         'multiple' => true,
        //         'description' => __('Please select a color for the product', 'woocommerce'),
        //         // 'custom_attributes'=> array(
        //         //     'multiple' => 'multiple'
        //         // )
        //     )
        // );


        // $columns_kaywords = get_post_meta( $id,'wpt_filter_colss', true );

        $args = array();
        $args[] = array(
            'id'        =>'wpt_filter_col',
            'name'      => 'wpt_filter_col',
            'label'     =>  __( 'Column List', 'wpt_pro' ),
            'class'     =>  'wpt_input',
            'type'      =>  'text',
            // 'desc_tip'  =>  true,
            'description'=> implode(',',$arrtibute_keys),
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

    public function wpt_load( $shortcode ){

        if( ! is_product() ) return;
 
        global $product;

        // Get product ID
        $product_id = $product->get_id();

        // get value form product meta box 
        $columns_kaywords = get_post_meta( $product_id,'wpt_filter_col', true );

        $filter_kaywords = explode(",", $columns_kaywords);

        // Check Mini filter on or off
        if( $shortcode->search_n_filter['filter_box']  == 'yes' ){
            $shortcode->filter_box= true;
        }else{
            $$shortcode->filter_box = false;
        }

        // If set column list then replace default value 
        if( !empty($columns_kaywords) ){
            $shortcode->search_n_filter['filter'] = $filter_kaywords;
        }

    }

}