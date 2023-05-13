<?php

/**
* For further details please visit http://docs.easydigitaldownloads.com/article/383-automatic-upgrades-for-wordpress-plugins
 */

//  define( 'WPT_EDD_STORE_URL', 'https://codeastrology.com/' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
//  define( 'WPT_EDD_ITEM_ID', 6553 ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
//  define( 'WPT_EDD_ITEM_NAME', __( 'Woo Product Table Pro', 'wpt_pro' ) ); // you should use your own CONSTANT name, and be sure to replace it throughout this file
//  define( 'WPT_EDD_AUTHOR_NAME', 'CodeAstrology Team' );
//  define( 'WPT_EDD_LICENCE_HELP_URL', 'https://wooproducttable.com/docs/doc/license/where-is-my-license-key/' );


// define( 'WPT_EDD_PLUGIN_ROOT__FILE__', WPTP_PLUGIN_FILE_NAME );
// define( 'WPT_EDD_CURRENT_VERSION', WPT_PRO_DEV_VERSION );

define( 'WPT_EDD_PARENT_MENU', 'edit.php?post_type=wpt_product_table' ); //There will be parent menu slug if already available.    
define( 'WPT_EDD_LICENSE_PAGE', 'woo-product-table-license' );
// define( 'WPT_EDD_PLUGIN_LICENSE_DATA', 'wpt_license_data' );

//Only one page rest

define( 'WPT_EDD_LICENSE_PAGE_LINK', admin_url( 'edit.php?post_type=wpt_product_table&page=' . WPT_EDD_LICENSE_PAGE ) );

// define( 'WPT_EDD_LICENSE_KEY', 'wpt_pro_license_key' );//
// define( 'WPT_EDD_LICENSE_STATUS', 'wpt_pro_license_status' );

// define( 'WPT_EDD_LICENSE_PAGE_TITLE', __( 'License', 'wpt_pro' ) );


// define( 'WPT_EDD_LICENSE_NONCE', 'wpt_license_nonce' );
// define( 'WPT_EDD_FORM_REGISTER_SETTING', 'wpt_license_license' );
// define( 'WPT_EDD_LICENSE_BTN_ACTIVATE_NAME', 'wpt_edd_license_activate' );
// define( 'WPT_EDD_LICENSE_BTN_DEACTIVATE_NAME', 'wpt_edd_license_deactivate' );





/************************************
* the code below is just a standard
* options page. Substitute with
* your own.
*************************************/






/**
 * Adds content to the settings section.
 *
 * @return void
 */
function wpt_license_key_settings_section() {
	esc_html_e( 'This is where you enter your license key.' );
}















