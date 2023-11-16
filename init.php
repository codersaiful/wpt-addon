<?php
/**
 * Plugin Name: Addons WPT - Size Attribute Dropdown
 * Plugin URI: https://wooproducttable.com/
 * Description: WooProductTable Addons Plugin for specific task.
 * Author: Saiful Islam
 * Author URI: https://profiles.wordpress.org/codersaiful/#content-plugins
 * 
 * Version: 1.0
 * Requires at least:    4.0.0
 * Tested up to:         6.1
 * WC requires at least: 3.0.0
 * WC tested up to: 	 7.1.0
 * 
 * 
 * IMPORTANT:
 * pa_size Attribute automatically show hobe zodi deya thake.
 * 
 * IMPORTANT NOTICE:
 * custom filed 'cut_to_size_off' == 'off' 
 * then Cut to Size will disable
 * 
 * 
 */


if ( ! defined( 'ABSPATH' ) ) {
    die();
}

if ( ! defined( 'WPT_DEV_VERSION' ) ) {
    return;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !defined( 'WPT_ADDON_BASE_URL' ) ) {
    define( "WPT_ADDON_BASE_URL", plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/' );
}

if ( !defined( 'WPT_ADDON_VERSION' ) ) {
    define( "WPT_ADDON_VERSION", '1.0.0' );
}

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
        load_plugin_textdomain( 'wpt_addon' );
    }

    public function init(){
        /**
		 * Auto Loader
         * @since 1.0.0
		 */
		include_once __DIR__ . '/autoloader.php';
	
	
		//Including Function File. It will stay at the Top of the File
		include_once __DIR__ . '/inc/functions.php';

        WPT_ADDON\Inc\Load::instance();

    }
}
WPT_Addons::instace();
register_activation_hook( __FILE__, 'wpt_addon_activation' );

function wpt_addon_activation(){
    $key = 'wpt_addon_date';
    $ins_dt = get_option( $key );
    if( ! empty( $ins_dt ) ) return;
    update_option( $key, time());
}

