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
        
        // $this->action('salam_sir');        
        $this->action('example_hook');        
        $this->filter('example_filter');   
        // $this->filter('wpt_wrapper_class',2);   
        // $this->filter('wpt_query_args',2);   
    }


    function wpt_query_args($query, $shortcode){
        
        var_dump($query);
        return $query;
    }
    function wpt_wrapper_class($query, $shortcode){
        
        var_dump($query);
        return $query;
    }

    function salam_sir($shortcode){
        $shortcode->set_shortcde_text('Nilam_SIR');
        var_dump($shortcode);
    }

    function example_hook(){
        echo '<h2>Example Hook</h2>';
    }
    function example_filter(){
        return 'Example Hook';
    }


}