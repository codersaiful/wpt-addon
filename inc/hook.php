<?php 
namespace WPT_ADDON_LUD\Inc;
use WPT_ADDON_LUD\Inc\App\Hook_Base;

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
        //$this->action('example_hook');        
        add_filter('wpt_query_args' , [$this, 'tableQuery'], 10, 2 );  
        //add_filter('wpto_table_query_args' , [$this, 'tableQuery'] );  
    }


    /**
     * Here we are changining the default argument of the table
     * This will set product tag id which we got from the plugin query tag
     * @param [array] $args
     * @return $args
     * @author Fazle Bari
     */
    public function tableQuery( $args, $shortcode ){
        $args['tax_query']=[
            'product_tag_IN' => [
                'taxonomy' => 'product_tag',
                'field' => 'id',
                'terms' => $shortcode->basics['data']['terms']['product_tag'] ?? [],
                'operator' => 'IN'
            ],

        ];

        $args['posts_per_page'] = 1000;
        
        return $args;

    }
}