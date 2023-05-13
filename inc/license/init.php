<?php
namespace WPT_ADDON\Inc;

use \CodeAstrology_License\Manage as License_Manage;

if ( ! class_exists('\CodeAstrology_License\Plugin_Updater') ) {
	// load our custom updater
	include dirname( __FILE__ ) . '/resource/updater.php';
}
if ( ! class_exists( 'CodeAstrology_License\Manage' ) ) {
	// load our custom updater
	include dirname( __FILE__ ) . '/resource/manage.php';
}
include dirname( __FILE__ ) . '/settings.php';


class Init
{

    //Most Important, It's Obvously should change, Otherwise conflict
    public $prefix = 'wpt';

    public $item_id = 6553;
    public $item_name = 'Woo Product Table Pro';
    public $help_url = 'https://wooproducttable.com/docs/doc/license/where-is-my-license-key/';

    public $plugin_root_file = WPTP_PLUGIN_FILE_NAME; //Need plugin's main root file data of __FILE__.
    public $plugin_version = WPT_PRO_DEV_VERSION;//current version of plugin

    public $page_title = 'License Page';

    public $page_slug = 'woo-product-table-license';
    public $parent_page = 'edit.php?post_type=wpt_product_table';

    //specially for redirection
    public $license_page_link = 'edit.php?post_type=wpt_product_table&page=woo-product-table-license';


    //Static but Dynamic (No need change)
    public $store_url = 'https://staging19.codeastrology.com/'; //https://codeastrology.com/
    public $author_name = 'CodeAstrology Team';
    public $permission = 'manage_options';//Manage or edit permission


    public $license_root_file = __FILE__;
    public $license_data_key;
    public function __construct()
    {

        $this->license_data_key = $this->prefix . '_license_data';
        $this->license_page_link = admin_url( $this->license_page_link );
        
        // $manage = new License_Manage($this, '_pro'); //This only for Product table actually.
        $manage = new License_Manage($this);
        

        //If Need
        //$manage->get_live_license_data(); //Getting licens data
        //$manage->get_live_license_status(); //Getting licens data Live
        //8.2.2.9.test_license_for_addon
        return $manage;
    }
}