<?php 
namespace WPT_ADDON\Inc;

class Enqueue{

    
    /**
     * Load Front End Enequeue File
     *
     * @return void
     */
    public function frontend(){
        add_action( 'wp_enqueue_scripts', [$this, 'wp_enqueue_scripts'] );
        return $this;
    }

    /**
     * Load Admin Enequeue File
     *
     * @return void
     */
    public function admin(){
        if( ! is_admin() ) return $this;
        add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'] );
        return $this;
    }

    public function wp_enqueue_scripts()
    {
        wp_enqueue_style( 'wpt_addon-style', WPT_ADDON_BASE_URL . 'assets/css/style.css', array(), WPT_ADDON_VERSION, 'all' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'wpt_addon-script', WPT_ADDON_BASE_URL . 'assets/js/scripts.js', array( 'jquery','wpt-custom-js' ), WPT_ADDON_VERSION, true );

        $ajax_url = admin_url( 'admin-ajax.php' );
        $WPT_ADDON_DATA = array( 
            'ajaxurl'   => $ajax_url,
            'ajax_url'  => $ajax_url,
            'site_url'  => site_url(),
            'checkout_url' => wc_get_checkout_url(),
            'cart_url' => wc_get_cart_url(),
            );
        wp_localize_script( 'wpt_addon-script', 'WPT_ADDON_DATA', $WPT_ADDON_DATA );
    }
    
    public function admin_enqueue_scripts()
    {
        wp_enqueue_style( 'wpt_addon-admin', WPT_ADDON_BASE_URL . 'assets/css/admin-style.css', array(), WPT_ADDON_VERSION, 'all' );
        wp_enqueue_script( 'wpt_addon-admin', WPT_ADDON_BASE_URL . 'assets/js/admin-script.js', array( 'jquery' ), WPT_ADDON_VERSION, true );
    }

}