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

    public $column_keyword = 'size_attribute_dropdown';

    public function __construct(){

        
        $this->action('example_hook');        
        $this->filter('wpto_default_column_arr');   
        $this->filter('wpto_template_loc_item_' . $this->column_keyword, 1, 10, 'size_attribute_control');   
    }


    function example_hook(){
        echo '<h2>Example Hook</h2>';
    }
    function wpto_default_column_arr( $column_array ){
        $column_array[$this->column_keyword]= 'Size';
        return $column_array;
    }

    public function size_attribute_control($file){
        $file = __DIR__ . '/../files/size-dropdown.php';
        return $file;
    }

}