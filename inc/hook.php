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
        usort($product_loop->posts, [$this, 'compare_product_loop']);
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

    public function my_sort2($prev, $next){
        $a_id = $a2_id = $b_id = $b2_id = 0;
        $prev_title = $prev->post_title;
        $next_title = $next->post_title;
        



        //Now find 2nd number
        $pattern_ext = "/\bx\s*(\d+)\s*x/";
        preg_match($pattern_ext, $prev_title, $matches1_ext);
        if (!empty($matches1_ext)) {
            $number = $matches1_ext[1];
            $a_id = $number;
        }

        preg_match($pattern_ext, $next_title, $matches_ext); 
        if (!empty($matches_ext)) {
            $number = $matches_ext[1];
            $b_id = $number; 
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

    /**
     * It's final user define function for soting.
     * No need Previous two method
     * taken help https://chat.openai.com/c/c8bd5a79-e711-4cf4-8dfe-e04c6ab25437
     * Its only for me.
     *
     * @param [type] $product1
     * @param [type] $product2
     * @return void
     */
    function compare_product_loop($product1, $product2) {
        $product1_title = $product1->post_title;
        $product2_title = $product2->post_title;
        // extract the first and second numbers from each product's dimension
        $pattern = '/(\d+)\s*x\s*(\d+)/';
        preg_match($pattern, $product1_title, $matches1);
        preg_match($pattern, $product2_title, $matches2);
        $first_num1 = $matches1[1];
        $first_num2 = $matches2[1];
        $second_num1 = $matches1[2];
        $second_num2 = $matches2[2];
    
        // sort the array based on the first number in ascending order
        if ($first_num1 < $first_num2) {
            return -1;
        } elseif ($first_num1 > $first_num2) {
            return 1;
        }
    
        // if the first numbers are equal, sort the array based on the second number in ascending order
        if ($second_num1 < $second_num2) {
            return -1;
        } elseif ($second_num1 > $second_num2) {
            return 1;
        }
    
        // if both numbers are equal, maintain the original order
        return 0;
    }
    function compare_products($product1, $product2) {
        $pattern = '/(\d+)\s*x\s*(\d+)/';
        // extract the first and second numbers from each product's dimension
        preg_match($pattern, $product1, $matches1);
        preg_match($pattern, $product2, $matches2);
        $first_num1 = $matches1[1];
        $first_num2 = $matches2[1];
        $second_num1 = $matches1[2];
        $second_num2 = $matches2[2];
    
        // sort the array based on the first number in ascending order
        if ($first_num1 < $first_num2) {
            return -1;
        } elseif ($first_num1 > $first_num2) {
            return 1;
        }
    
        // if the first numbers are equal, sort the array based on the second number in ascending order
        if ($second_num1 < $second_num2) {
            return -1;
        } elseif ($second_num1 > $second_num2) {
            return 1;
        }
    
        // if both numbers are equal, maintain the original order
        return 0;
    }
}