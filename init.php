<?php
/**
 * Plugin Name: Low stock email notify 
 * Plugin URI: https://codeastrology.com/min-max-quantity/
 * Description: When the stock quantity is lower than the minimum quantity, an email input box appears. customer can submit their email
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

// if ( ! defined( 'WC_MMQ_VERSION' ) ) {
//     return;
// }
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !defined( 'WCMMQ_ADDON_BASE_URL' ) ) {
    define( "WCMMQ_ADDON_BASE_URL", plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/' );
}

if ( !defined( 'WCMMQ_ADDON_VERSION' ) ) {
    define( "WCMMQ_ADDON_VERSION", '1.0.0' );
}

class WCMMQ_Addons{

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
        load_plugin_textdomain( 'wcmmq_addon' );
    }

    public function init(){
        /**
		 * Auto Loader
         * @since 1.0.0
		 */
		include_once __DIR__ . '/autoloader.php';
	
	
		//Including Function File. It will stay at the Top of the File
		include_once __DIR__ . '/inc/functions.php';

		//Including admin menu 
		// include_once __DIR__ . '/admin/menu-page.php';

        WCMMQ_ADDON\Inc\Load::instance();

    }
}
WCMMQ_Addons::instace();
register_activation_hook( __FILE__, 'wcmmq_addon_activation' );

function wcmmq_addon_activation(){

    // create a new table (wcmmq_low_stock_emails) to save data
    global $wpdb;
    $table_name = $wpdb->prefix . 'wcmmq_low_stock_emails';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT(9) NOT NULL AUTO_INCREMENT,
        email VARCHAR(100) NOT NULL,
        product_id INT(9) NOT NULL,
        sent_status VARCHAR(3) NOT NULL DEFAULT 'No',
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // save info
    $key = 'wcmmq_addon_date';
    $ins_dt = get_option( $key );
    if( ! empty( $ins_dt ) ) return;
    update_option( $key, time());
}

