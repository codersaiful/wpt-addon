<?php 
namespace WPT_ADDON\Inc;
use WPT_ADDON\Inc\App\Hook_Base;

use WOO_PRODUCT_TABLE\Inc\Table\Row;

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
        
        // $this->action('wpt_load');
        // $this->action('example_hook');        
        // $this->filter('example_filter');   

        // $this->filter('wpt_query_args');
        // $this->filter('wpt_table_row');
        $this->action('wpt_table_row'); 
    }

    public function wpt_load( $shortcode ){
        $shortcode->table_display = false;
        // var_dump($shortcode);
    }

    function example_hook(){
        echo '<h2>Example Hook</h2>';
    }
    function example_filter(){
        return 'Example Hook';
    }


    public function wpt_query_args( $args ){
        // var_dump($args);
        return $args;
    }

    /**
     * How it will work.
     * It will filter based on specific variation
     * like: [Product_Table id='19674' name='Nothing For Test Only' custom_variations='small']
     * use showtcode like:
     * [Product_Table id='19674' name='Nothing For Test Only' custom_variations='small']
     *
     * @param Row $row
     * @return void
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    public function wpt_table_row( Row $row ){

        $custom_variations = $row->table_atts['custom_variations'] ?? '';
        $custom_variations = is_string( $custom_variations ) ? $custom_variations : '';
        $custom_variations = trim($custom_variations);
        $custom_variations_arr = explode(',', $custom_variations);
        // var_dump($row->table_atts);
        // $row->display = false;
        // return;
        // $row->display = false;
        // var_dump($row->display_row);
        // var_dump($row);
        // return $row;
        // unset($row->_enable_cols['product_title']);

        $available = $row->product_data['attributes'] ?? [];
        $available = is_array( $available ) ? $available : [];
        $my_items = $custom_variations_arr;// ['small'];
        $common = array_intersect($available, $my_items);
        if( empty( $common ) ){
            $row->display = false;
        };
        return;
        ?>
        <tr>
            <td colspan="7">
                <?php 
                

                // var_dump($row);
                // var_dump($available);
                // var_dump($common);
                // var_dump($row->row_attr);
                 ?>
                <h1>Hello World <?php echo $row->product_id; ?></h1>
            </td>
        </tr>
        <?php 
    }
}