<?php 
namespace MMQ_USERS\Inc\App;

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
class Hook_Base extends Base{

    /**
     * Collection of add action
     *
     * @var array
     */
    public $add_action = [];

    /**
     * Collection of Filter Hook
     *
     * @var array
     */
    public $add_filter = [];

    public function __construct(){
        parent::__construct();
             
    }

    /**
     * Calling Action Hook
     *
     * @param string $action_hook_name [Required] and make a method by this name
     * @param integer $accepted_args [Optional]
     * @param integer $priority [Optional]
     * @param string $method_name [Optional] Actually Default method as same as hook name
     * @return void
     */
    protected function action( string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        $this->hook('add_action', $action_hook_name, $accepted_args, $priority, $method_name);
    }

    /**
     * Calling Filter Hook.
     *
     * @param string $action_hook_name [Required] and make a method by this name
     * @param integer $accepted_args [Optional]
     * @param integer $priority [Optional]
     * @param string $method_name [Optional] Actually Default method as same as hook name
     * @return void
     */
    protected function filter( string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        $this->hook('add_filter', $action_hook_name, $accepted_args, $priority, $method_name);
    }
    
    protected function hook( string $hook_type, string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        if( empty( $method_name ) ){
            $method_name = $action_hook_name;
        }

        if( ! method_exists($this,$method_name) ) return;
        $this->$hook_type[] = $action_hook_name;
        $hook_type( $action_hook_name, [$this, $method_name], $priority, $accepted_args );
    }

}