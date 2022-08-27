<?php 
namespace WPT_ADDON\Inc;

use WPT_ADDON\Inc\App\Enqueue;
use WPT_ADDON\Inc\App\Base;

/**
 * Full Plugin Load Manager is here
 * Load Manager Means:
 *  * Assets Load Manager
 * * Other Object Load Manager
 * 
 * @since 1.0.0
 * @author Saiful Islam <codersaiful@gmail.com>
 */
class Load extends Base{
    
    public static $_instance;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new static;
        }
        return self::$_instance;
    }

    public function __construct(){
        // parent::__construct();
        //Load Enqueue
        $enqueue = new Enqueue();
        $enqueue->set('admin');
        $enqueue->set('frontend');
        $enqueue->run();

        $hook = new Hook();
        
    }

}