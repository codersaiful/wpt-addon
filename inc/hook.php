<?php 
namespace WPT_ADDON\Inc;
use WPT_ADDON\Inc\App\Base;

/**
 * All Basic Hook will control from 
 * here.
 * 
 * If you are not interested using class Object,
 * write your hook use at inc/functions.php file
 * 
 * Normall we will use this Hook.
 * 
 */
class Hook extends Base{

    public function __construct(){
        parent::__construct();

        
        $this->action('example_hook');        
        $this->filter('example_filter');        
    }






    function example_hook(){
        echo 'Example Hook';
    }
    function example_filter(){
        return 'Example Hook';
    }

    /**
     * Calling Action Hook
     *
     * @param string $action_hook_name
     * @param integer $accepted_args
     * @param integer $priority
     * @param string $method_name
     * @return void
     */
    private function action( string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        $this->hook('add_action', $action_hook_name, $accepted_args, $priority, $method_name);
    }

    /**
     * Calling Filter Hook.
     *
     * @param string $action_hook_name
     * @param integer $accepted_args
     * @param integer $priority
     * @param string $method_name
     * @return void
     */
    private function filter( string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        $this->hook('add_filter', $action_hook_name, $accepted_args, $priority, $method_name);
    }
    
    private function hook( string $hook_type, string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        if( empty( $method_name ) ){
            $method_name = $action_hook_name;
        }

        if( ! method_exists($this,$method_name) ) return;

        $hook_type( $action_hook_name, [$this, $method_name], $priority, $accepted_args );
    }

}