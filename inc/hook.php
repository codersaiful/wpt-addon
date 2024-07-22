<?php 
namespace CCD_WPT_ADDON\Inc;
use CCD_WPT_ADDON\Inc\App\Hook_Base;

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

        
        $this->action('wpt_search_box_bottom');        
        $this->filter('wpt_seachbox_tax_args');   


        add_action('wp_ajax_ccd_wpt_addon_subcategory', 'ccd_wpt_addon_sub_taxonomies');
        add_action('wp_ajax_nopriv_ccd_wpt_addon_subcategory', 'ccd_wpt_addon_sub_taxonomies');
    }


    function wpt_search_box_bottom(){
        ?>
        <div class="wpt-addon-extra-searchbox-wrapper search_single search_single_texonomy search_single_product_cat">
            <label class="search_keyword_label product_cat" for="product_cat_wpt-addon-extra">Sub Categories</label>
            <select data-key="product_cat" name="product_cat" id="product_cat_wpt-addon-extra" class="search_select query search_select_product_cat">
            </select>
        </div>
        <?php
    }
    function example_filter(){
        return 'Example Hook';
    }


    /**
     * Code from main plugin in shortcode.php
     * code sample: $defaults = apply_filters( 'wpt_seachbox_tax_args', $defaults, $texonomy_keyword,$taxonomy_details, $temp_number );
     *
     * @return array
     */
    public function wpt_seachbox_tax_args( $defaults )
    {
        $defaults['depth'] = 1;
        return $defaults;
    }

}


/**
ob_start();
/*
* Used following hook to insert two insert other field
* such:
* Order By, Order and On sale
* 
* @author Saiful Islam <codersaiful@gmail.com>
* /
do_action('wpt_search_box_bottom', $shortcode->table_id);
$html .= ob_get_clean();
 */