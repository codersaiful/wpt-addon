<?php 
namespace WPT_ADDON\Inc\App;

class Enqueue extends Base{

    private $frontend = false;
    private $admin = false;


    /**
     * Set enqueue location mean,
     * It's can be for admin and for frontend
     * 
     * We can start indivisual enqueue for any specific locaiton 
     * currently we set only frontend and admin
     *
     * @param String $enq_position
     * @return void
     */
    public function set( string $enq_position ){
        $this->$enq_position = true;
        return $this;
    }

    /**
     * Final method of Enqueue Class
     * need to run method for starting 
     * enqueueing
     * 
     * ________
     * Here we started 
     * $this->frontend(); private
     * $this->admin(); private
     *
     * @return void
     */
    public function run(){
        if( $this->frontend ){
            $this->frontend();
        }
        
        if( $this->admin ){
            $this->admin();
        }
    }

    /**
     * Load Front End Enequeue File
     *
     * @return void
     */
    private function frontend(){
        add_action( 'wp_enqueue_scripts', [$this, 'wp_enqueue_scripts'] );
    }

    

    /**
     * Load Admin Enequeue File
     *
     * @return void
     */
    private function admin(){
        if( ! is_admin() ) return $this;
        add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'] );
    }

    public function wp_enqueue_scripts()
    {
        wp_enqueue_style( $this->prefix . '-style', WPT_RLC_BASE_URL . 'assets/css/style.css', array(), WPT_RLC_VERSION, 'all' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( $this->prefix . '-script', WPT_RLC_BASE_URL . 'assets/js/scripts.js', array( 'jquery','wpt-custom-js' ), WPT_RLC_VERSION, true );

        $ajax_url = admin_url( 'admin-ajax.php' );
        $WPT_ADDON_DATA = array( 
            'ajaxurl'   => $ajax_url,
            'ajax_url'  => $ajax_url,
            'site_url'  => site_url(),
            'checkout_url' => wc_get_checkout_url(),
            'cart_url' => wc_get_cart_url(),
            );
        wp_localize_script( $this->prefix . '-script', $this->data_name, $WPT_ADDON_DATA );
    }
    
    public function admin_enqueue_scripts()
    {
        wp_enqueue_style( $this->prefix . '-admin', WPT_RLC_BASE_URL . 'assets/css/admin-style.css', array(), WPT_RLC_VERSION, 'all' );
        wp_enqueue_script( $this->prefix . '-admin', WPT_RLC_BASE_URL . 'assets/js/admin-script.js', array( 'jquery' ), WPT_RLC_VERSION, true );
    }

}