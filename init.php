<?php
/**
 * Plugin Name: MMQ By User Roles ( Addons)
 * Plugin URI: https://codeastrology.com/min-max-quantity/
 * Description: An addons plugin of Min Max Quantity & Step Control. This plugin remove all condition for administrator and shop manager.
 * Author: Saiful Islam
 * Author URI: https://profiles.wordpress.org/codersaiful/#content-plugins
 * 
 * Version: 1.0
 * Requires at least:    4.0.0
 * Tested up to:         6.3.1
 * WC requires at least: 3.0.0
 * WC tested up to: 	 8.0.3
 * 
 */


if ( ! defined( 'ABSPATH' ) ) {
    die();
}

if ( ! defined( 'WC_MMQ_VERSION' ) ) {
    return;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !defined( 'MMQ_USERS_BASE_URL' ) ) {
    define( "MMQ_USERS_BASE_URL", plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/' );
}

if ( !defined( 'MMQ_USERS_VERSION' ) ) {
    define( "MMQ_USERS_VERSION", '1.0.0' );
}

class MMQ_USERS_RULS{

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
        load_plugin_textdomain( 'MMQ_USERS' );
    }

    public function init(){
        /**
		 * Auto Loader
         * @since 1.0.0
		 */
		include_once __DIR__ . '/autoloader.php';
	
	
		//Including Function File. It will stay at the Top of the File
		include_once __DIR__ . '/inc/functions.php';

        MMQ_USERS\Inc\Load::instance();

    }
}
MMQ_USERS_RULS::instace();
register_activation_hook( __FILE__, 'mmq_users_activation' );

function mmq_users_activation(){
    $key = 'mmq_users_date';
    $ins_dt = get_option( $key );
    if( ! empty( $ins_dt ) ) return;
    update_option( $key, time());
}

