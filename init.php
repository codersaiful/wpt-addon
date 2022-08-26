<?php

/**
 * Plugin Name: Addons WPT - Specific
 * Plugin URI: https://wooproducttable.com/
 * Description: WooProductTable Addons Plugin for specific task.
 * Author: Saiful Islam
 * Author URI: https://profiles.wordpress.org/codersaiful/#content-plugins
 * 
 * Version: 1.0
 * Requires at least:    4.0.0
 * Tested up to:         6.0.1
 * WC requires at least: 3.0.0
 * WC tested up to: 	 6.8.2
 * 
 */


if ( ! defined( 'ABSPATH' ) ) {
    die();
}

if ( ! defined( 'WPT_DEV_VERSION' ) ) {
    return;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class WPT_Addons{

    public static $_instance;


    public static function instace(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new static;
        }
        return self::$_instance;
    }

    /**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

    public function i18n(){
        load_plugin_textdomain( 'wpt_addons' );
    }

    public function init(){
        /**
		 * Auto Loader
         * @since 1.0.0
		 */
		include_once __DIR__ . '/autoloader.php';
	
	
		//Including Function File. It will stay at the Top of the File
		include_once __DIR__ . '/inc/functions.php';

    }
}
WPT_Addons::instace();
register_activation_hook( __FILE__, 'wpt_addons_activation' );

function wpt_addons_activation(){
    $key = 'wpt_addons_date';
    $ins_dt = get_option( $key );
    if( ! empty( $ins_dt ) ) return;
    update_option( $key, time());
}

