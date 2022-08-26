<?php 
namespace WPT_ADDON\Inc;

/**
 * Full Plugin Load Manager is here
 * 
 * @since 1.0.0
 */
class Load{
    public static $_instance;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new static;
        }
        return self::$_instance;
    }

    public function __construct(){
        //Load Enqueue
        $enqueue = new Enqueue();
        $enqueue->frontend();
        $enqueue->admin();

        
    }

}