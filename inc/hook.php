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
        $this->filter('wpto_short_message_box_type',10,6); 

        $this->filter('woocommerce_product_data_tabs'); 
        $this->filter('woocommerce_product_data_panels'); 
        $this->filter('wpt_template_loc',2); 
        $this->action('wpt_add_field_in_panel');    
        $this->action('woocommerce_process_product_meta');    
        $this->action('wpt_load');    
        $this->action('save_post');    
    }

    // public function wpto_short_message_box_type( $val , $settings, $product, $keyword, $table_ID, $column_settings ){
    //     echo ''
    //     var_dump($column_settings);
    //     return false;
    // }
    
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
            'label' => __('Wpt Column Filter','wpt_pro'),
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
        $var_ids = $Product_Variable->get_children();
        $arrtibute_keys = array_keys( $attributes );

        $args = array();
        $args[] = array(
            'id'        =>'wpt_filter_col',
            'name'      => 'wpt_filter_col',
            'label'     =>  __( 'Column List', 'wpt_pro' ),
            'class'     =>  'wpt_input',
            'type'      =>  'text',
            // 'desc_tip'  =>  true,
            'description'=> implode(', ',$arrtibute_keys),
            // 'data_type' => 'decimal'
        );

        // $args[] = array(
        //     'id'        =>'wpt_var_id',
        //     'name'      => 'wpt_var_id',
        //     'label'     =>  __( 'Variation Id', 'wpt_pro' ),
        //     'class'     =>  'wpt_input',
        //     'type'      =>  'text',
        //     // 'desc_tip'  =>  true,
        //     'description'=> implode(', ',$var_ids),
        //     // 'data_type' => 'decimal'
        // );
        

        
        $args = apply_filters('wpt_field_args_in_panel', $args);
    
        foreach($args as $arg){
            woocommerce_wp_text_input($arg);
        }

        $args = array();

        $args[] = array(
            'id'        =>'wpt_var_hide_col',
            'name'      => 'wpt_var_hide_col',
            'label'     =>  __( 'Hide Message Column', 'wpt_pro' ),
            // 'description'=> "Type 'hide', if you want to hide message column",
        );

        $args[] = array(
            'id'        =>'wpt_var_hide_msg2',
            'name'      => 'wpt_var_hide_msg2',
            'label'     =>  __( 'Hide 2nd Message Column', 'wpt_pro' ),
            // 'description'=> "Type 'hide', if you want to hide message column",
        );

        $args[] = array(
            'id'        =>'wpt_var_hide_img',
            'name'      => 'wpt_var_hide_img',
            'label'     =>  __( 'Hide Image Column', 'wpt_pro' ),
            // 'description'=> "Type 'hide', if you want to hide message column",
        );

        foreach($args as $arg){
            woocommerce_wp_checkbox($arg);
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
        // $wpt_var_id = $_POST['wpt_var_id'] ?? false;
        $wpt_var_hide_col = $_POST['wpt_var_hide_col'] ?? false;
        $wpt_var_hide_msg2 = $_POST['wpt_var_hide_msg2'] ?? false;

        $wpt_var_hide_img = $_POST['wpt_var_hide_img'] ?? false;
        
        //Updating Here
        update_post_meta( $post_id, 'wpt_filter_col', esc_attr( $wpt_filter_col ) );
        // update_post_meta( $post_id, 'wpt_var_id', esc_attr( $wpt_var_id ) );
        update_post_meta( $post_id, 'wpt_var_hide_col', esc_attr( $wpt_var_hide_col ) );
        update_post_meta( $post_id, 'wpt_var_hide_msg2', esc_attr( $wpt_var_hide_msg2 ) );

        update_post_meta( $post_id, 'wpt_var_hide_img', esc_attr( $wpt_var_hide_img ) );
    }

 
    /**
     * Diaplay Filter box on variation product
     */
    public function wpt_load( $shortcode ){

        if( ! is_product() ) return;
 
        global $product;

        // Get product ID
        $product_id = $product->get_id();

        // get value form product meta box 
        $columns_kaywords = get_post_meta( $product_id,'wpt_filter_col', true );

        $filter_kaywords = explode(",", trim($columns_kaywords));
        
        // Check Mini filter on or off
        if( !empty( $columns_kaywords) && $shortcode->search_n_filter['filter_box']  == 'yes' ){
            $shortcode->filter_box= true;
            $filter_kaywords = array_filter( $filter_kaywords );
            $filter_kaywords = array_map(function($item){
                $item = ltrim($item);
                $item = rtrim($item);
                return $item;//trim( $item);
            }, $filter_kaywords);
            
            $shortcode->search_n_filter['filter'] = $filter_kaywords;
        }else{
            $shortcode->filter_box = false;
        }

        

        $wpt_var_hide_col = get_post_meta( $product_id,'wpt_var_hide_col', true );
        $wpt_var_hide_msg2 = get_post_meta( $product_id,'wpt_var_hide_msg2', true );
        $wpt_var_hide_img = get_post_meta( $product_id,'wpt_var_hide_img', true );

        // var_dump($shortcode->_enable_cols);

        if( 'yes' == $wpt_var_hide_col ){
            unset($shortcode->_enable_cols['message']);
        }

        if( 'yes' == $wpt_var_hide_msg2 ){
            unset($shortcode->_enable_cols['new_message']);
        }

        if( 'yes' == $wpt_var_hide_img ){
            unset($shortcode->_enable_cols['thumbnails']);
        }
    }

}