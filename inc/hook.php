<?php 
namespace WPT_ADDON\Inc;
use WPT_ADDON\Inc\App\Hook_Base;

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
class Hook extends Hook_Base{

    public function __construct(){

        
        $this->action('example_hook');        
        $this->filter('example_filter');   

        $this->filter('wpt_query_args');
        $this->filter('wpt_table_row');
        // $this->action('wpt_table_row'); 
    }


    function example_hook(){
        echo '<h2>Example Hook</h2>';
    }
    function example_filter(){
        return 'Example Hook';
    }


    public function wpt_query_args( $args ){
        var_dump($args);
        return $args;
    }
    public function wpt_table_row( $row ){
        // $row->display = false;
        // var_dump($row->display_row);
        // var_dump($row);
        // return $row;
        unset($row->_enable_cols['product_title']);
        ?>
        <tr>
            <td colspan="7">
                <?php var_dump($row->_enable_cols); ?>
                <h1>Hello World <?php echo $row->product_id; ?></h1>
            </td>
        </tr>
        <?php 
    }
}