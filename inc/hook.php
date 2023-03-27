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
        //$this->action('example_hook');        
        add_filter('wpt_query_args' , [$this, 'tableQuery'] );  
        //add_filter('wpto_table_query_args' , [$this, 'tableQuery'] );  
    }


    /**
     * Here we are changining the default argument of the table
     * If the table is displying is group product page on then we will chenge the argument
     * @param [array] $args
     * @return $args
     * @author Fazle Bari
     */
    public function tableQuery( $args ){
        //$behavior = $args['behavior'] ?? '';
       //$args['behavior'] = 'normal';
       //$args['posts_per_page'] = 2;
       global $wpdb;
       $query_vars = isset( $GLOBALS['wp_query']->query_vars ) ? $GLOBALS['wp_query']->query_vars : false;
       dd( $query_vars );
       if($query_vars ) return $args;

        //dd($args);
        return $args;
    }
}