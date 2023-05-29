<?php
/**
 * Plugin Name: Addons Min Max - Control for Group Product by CodeAstrology
 * Plugin URI: https://codeastrology.com/
 * Description: Min max disable for group product.
 * Author: Saiful Islam
 * Author URI: https://profiles.wordpress.org/codersaiful/#content-plugins
 * 
 * Version: 1.0
 * Requires at least:    4.0.0
 * Tested up to:         6.1
 * WC requires at least: 3.0.0
 * WC tested up to: 	 7.1.0
 * 
 */


if ( ! defined( 'ABSPATH' ) ) {
    die();
}

if ( ! defined( 'WC_MMQ_VERSION' ) ) {
    return;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !defined( 'WCMMQ_GROUP_ADDON_BASE_URL' ) ) {
    define( "WCMMQ_GROUP_ADDON_BASE_URL", plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/' );
}

if ( !defined( 'WCMMQ_GROUP_ADDON_VERSION' ) ) {
    define( "WCMMQ_GROUP_ADDON_VERSION", '1.0.0' );
}

class WCMMQ_GROUP_Addons{

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
        load_plugin_textdomain( 'wcmmq_group_addon' );
    }

    public function init(){
        /**
		 * Auto Loader
         * @since 1.0.0
		 */
		include_once __DIR__ . '/autoloader.php';
	
	
		//Including Function File. It will stay at the Top of the File
		include_once __DIR__ . '/inc/functions.php';

        WCMMQ_GROUP_ADDON\Inc\Load::instance();

    }
}
WCMMQ_GROUP_Addons::instace();
register_activation_hook( __FILE__, 'wcmmq_group_addon_activation' );

function wcmmq_group_addon_activation(){
    $key = 'wcmmq_group_addon_date';
    $ins_dt = get_option( $key );
    if( ! empty( $ins_dt ) ) return;
    update_option( $key, time());
}

