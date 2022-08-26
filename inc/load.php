<?php 
namespace WPT_ADDON\Inc;

class Load{
    public static $_instance;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new static;
        }
        return self::$_instance;
    }

    public function __construct(){
        
    }

}