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

    public $behavior;
    protected $attributes = [];
    protected $Product_Variable;
    protected $childrens = [];

    public function __construct(){
        $this->action('wpt_load');        
        $this->filter('wpt_query_args');   
    }

    public function array_insert_before( array $existing_array, array $new_array, string $target_array_key, bool $bottom = true ) {
        $keys   = array_keys( $existing_array );
        $index  = array_search( $target_array_key, $keys, true );
        // $pos    = false === $index ? 0 : $index; //if not found target index of array, this will add array at the begining.
        //$pos    = false === $index ? count($keys) : $index; //If not found, array will at the last 
        
        /**
         * uporer duita condition ke notun param er jayajje korechi, jate dutoi kora jay.
         * asole bottom true hole, not found key er khetre laste add korobe
         * ar false hole total array'r surute add korobe.
         */
        $count = $bottom ? count($keys) : 0;        
        $pos    = false === $index ? $count: $index; //If not found, array will at the last 
    
        return array_slice( $existing_array, 0, $pos, true ) + $new_array + array_slice( $existing_array, $pos, count( $existing_array ), true );
    }

    public function wpt_load( $shortcode ){
        
        global $product;
        if( ! is_product() ) return;
        $is_variable = $product->is_type( 'variable' );
        if( ! $is_variable ) return;

        /**
         * On variable product, I disabled Pagination
         * using following property
         * $shortcode->pagination_ajax = 'no_ajax'
         * 
         * @since 8.3.0.0
         */
        $shortcode->pagination_ajax = 'no_ajax';
        $this->behavior = $shortcode->args['behavior'] ?? '';
        if($this->behavior == 'normal') return;        

        $maArr = [];
        
        $shortcode->search_box = false;
        $shortcode->search_n_filter['cf_search_box'] = 'no';

        //Unset action column
        unset($shortcode->_enable_cols['attribute']);
        unset($shortcode->_enable_cols['product_title']);
        unset($shortcode->_enable_cols['variations']);
        // unset($shortcode->_enable_cols['variation_name']);

        $this->Product_Variable = new \WC_Product_Variable( get_the_ID() ); 
        $this->attributes = $this->Product_Variable->get_variation_attributes();

        $arrtibutes = array_keys( $this->attributes );

        if( empty( $arrtibutes ) ){
            $shortcode->table_display = false;
            add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            return;
        }

        foreach( $arrtibutes as $key ){
            $label = wc_attribute_label($key);
            $maArr[$key] = $label;
            $shortcode->column_settings[$key] = [
                'type' => 'single_variation',
                'type_name' => 'Single Variation',
                'variation_name' => $label,
                'tag_class' => 'auto-generated_variation_column wpt-auto-gen_product_id' . $shortcode->table_id,
            ];
        }

        //Mini filter handle on Variable product has fixed here.
        $shortcode->search_n_filter['filter'] = array_keys( $maArr );

        $quick_qty = $shortcode->_enable_cols['quick_qty'] ?? false;
        $action = $shortcode->_enable_cols['action'] ?? false;
        if( $quick_qty ){
            unset($shortcode->_enable_cols['quantity']);
            unset($shortcode->_enable_cols['action']);
        }else{
            $shortcode->_enable_cols['action'] = 'action';
        }
        $final_target = ! empty( $quick_qty ) ? $quick_qty : $action;
        

        $target_key = isset( $shortcode->_enable_cols['quantity'] ) ? 'quantity' : $final_target;
        $target_key = $shortcode->_enable_cols['variation_name'] ?? $target_key;
        $shortcode->_enable_cols = $this->array_insert_before( $shortcode->_enable_cols,$maArr,$target_key );
        unset($shortcode->_enable_cols['variation_name']);
    }

    function wpt_query_args( $args ){

        if( empty($this->Product_Variable) ){
            $_ID = get_the_ID();
            if( empty( $_ID ) || ! is_product() ) return $args;
            $product_includes = [];
            $this->Product_Variable = new \WC_Product_Variable( $_ID );
            // $this->Product_Variable = $this_post_variable->get_children();
        }

        if( empty($this->Product_Variable) ) return $args;
        //Args Management
        $product_includes = [];
        $this->childrens = $this->Product_Variable->get_children();
        foreach( $this->childrens as $per ){
            $product_includes[$per] = $per;
        }
        $args['post__in'] = $product_includes;
        $args['post_type'] = array( 'product', 'product_variation' );
        unset($args['tax_query']);
        // $args['paged'] = $_GET[$this->pageNumberKey] ?? 1;
        return $args;
    }


}