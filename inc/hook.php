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
 * // add_filter("wpt_product_loop", [ $this, 'wpt_product_loop'], 10, 2 ); 
 */
class Hook extends Hook_Base{

    public function __construct(){      
        $this->filter('wpt_product_loop', 2);

    }

    public function wpt_product_loop( $product_loop, $shortcode ){
        usort($product_loop->posts, [$this, 'my_sort']);
        return $product_loop;
    }

    public function my_sort($prev, $next){
        $a_id = $b_id = 0;
        $prev_title = $prev->post_title;

        $pattern = "/mm (\d+)/"; // Regular expression pattern to match "mm" followed by digits

        preg_match($pattern, $prev_title, $matches1); // Match the pattern in the sentence

        if (!empty($matches1)) {
            $number = $matches1[1]; // Get the number captured in the first capturing group
            $a_id = $number; // Output: 80
        }
        

        $next_title = $next->post_title;
        preg_match($pattern, $next_title, $matches); 
        if (!empty($matches)) {
            $number = $matches[1]; // Get the number captured in the first capturing group
            $b_id = $number; // Output: 80
        }
  
        if ($a_id < $b_id) {
            return -1;
        } elseif ($a_id > $b_id) {
            return 1;
        } else {
            return 0;
        }
        return 1;
    }
}