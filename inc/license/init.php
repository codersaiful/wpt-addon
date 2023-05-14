<?php
namespace WPT_ADDON\Inc\License;

use \CodeAstrology_License\Manage as License_Manage;


if ( ! class_exists('\CodeAstrology_License\Plugin_Updater') ) {
	// load our custom updater
	include dirname( __FILE__ ) . '/resource/updater.php';
}

if ( ! class_exists( 'CodeAstrology_License\Manage' ) ) {
	// load our custom updater
	include dirname( __FILE__ ) . '/resource/manage.php';
}



class Init
{

    //Most Important, It's Obvously should change, Otherwise conflict
    public $prefix = 'wpt_add_sv';

    public $item_id = 12858;//6553;
    public $item_name = 'WPT Addons - Simple and Variation product';
    public $help_url = 'https://wooproducttable.com/docs/doc/license/where-is-my-license-key/';

    public $plugin_root_file = WPT_ADDON_PLUGIN_FILE_NAME; //Need plugin's main root file data of __FILE__.
    public $plugin_version = WPT_ADDON_VERSION;//current version of plugin

    public $page_title = 'License';

    public $page_slug = 'woo-product-table-license';//'wpt-addons-simple-variaton'; //'woo-product-table-license';
    public $parent_page = 'edit.php?post_type=wpt_product_table';

    //specially for redirection
    public $license_page_link = 'edit.php?post_type=wpt_product_table&page=woo-product-table-license';


    //Static but Dynamic (No need change)
    public $store_url = 'https://staging19.codeastrology.com/'; //https://codeastrology.com/
    public $author_name = 'CodeAstrology Team';
    public $permission = 'manage_options';//Manage or edit permission

    /**
     * Following two property
     * $parent_addon_prefix
     * And
     * $parent_exists_class
     * Only need, If you create child addon for any main addon.
     * Otherwise, add as null
     *
     * @var string
     */
    public $parent_addon_prefix = 'wpt';
    public $parent_exists_class = 'WOO_Product_Table';


    public $license_root_file = __FILE__;
    public $license_data_key;
    public function __construct()
    {

        $this->license_data_key = $this->prefix . '_license_data';
        $this->license_page_link = admin_url( $this->license_page_link );
        
        // $manage = new License_Manage($this, '_pro'); 

        $manage = new License_Manage($this);

        // $this->prefix = "saiful";
        // $this->license_data_key = $this->prefix . '_license_data';
        // $this->license_page_link = admin_url( $this->license_page_link );
        // $manage = new License_Manage($this);
        

        //If Need
        //$manage->get_live_license_data(); //Getting licens data
        //$manage->get_live_license_status(); //Getting licens data Live
        //8.2.2.9.test_license_for_addon
        return $manage;
    }
}