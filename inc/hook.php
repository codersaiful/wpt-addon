<?php 
namespace WCMMQ_ADDON\Inc;
use WCMMQ_ADDON\Inc\App\Hook_Base;

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
        
        $this->filter('cwg_default_allowed_status', 10, 3 );        
        $this->filter('woocommerce_product_add_to_cart_text', 10, 2);  
        
        add_filter('cwginstock_display_subscribe_form',function($bool, $product, $variation){
            if($variation){

                $variation_id = $variation->get_id();
                $stock = get_post_meta($variation_id, '_stock', true);

                $min_quantity = get_post_meta($variation_id, WC_MMQ_PREFIX . 'min_quantity', true);

                if($stock && $stock < $min_quantity){
                    return true;
                }
                return false;
            }else{
                $product_id = $product->get_id();
                $stock = get_post_meta($product_id, '_stock', true);

                $min_quantity = get_post_meta($product_id, WC_MMQ_PREFIX . 'min_quantity', true);

                if($stock && $stock < $min_quantity){
                    return true;
                }
                return false;
            }
            
            return $bool;
        },99,3);
    }

    /**
     * There is a filter hook in 'Back In Stock Notifier' plugin. That hook is returing the stock status. Notifacation box will appar if 
     * product is out of stock. Here i am changing  stock status. 
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function cwg_default_allowed_status( $status, $product, $variation ){

        if($variation){
            $variation_id = $variation->get_id();
            $stock = get_post_meta($variation_id, '_stock', true);
            $min_quantity = get_post_meta($variation_id, WC_MMQ_PREFIX . 'min_quantity', true);
            if($stock && $stock < $min_quantity){
                return ['instock','outofstock'];
            }
            return ['outofstock'];
        }else{
            $product_id = $product->get_id();
            $stock = get_post_meta($product_id, '_stock', true);
            $min_quantity = get_post_meta($product_id, WC_MMQ_PREFIX . 'min_quantity', true);
            if($stock && $stock < $min_quantity){
                add_action('wp_footer', [ $this , 'hide_add_to_cart'] );
                return ['instock','outofstock'];
            }
            return ['outofstock'];
        }
        return $status;
    }

    /**
     * I am adding some css to hide add to cart and 'in stock' text and add 'out of stock' text
     *  @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function hide_add_to_cart(){
        ?>
        <style>
            button.single_add_to_cart_button.button.alt {
                display: none !important;
            }
			p.stock.in-stock {
				display: none;
			}
			.single-product-summary .quantity::before {
				content: "Out of stock";
				font-size: 13px;
				font-weight: normal;
				display: inline;
			}
        </style>
        <?php
    }

    /**
     *  If stock quantity lower than min quantity, Add To Cart button text will change on archive page. 
     *  @return $add_to_cart text
     *  @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function woocommerce_product_add_to_cart_text( $text, $product ){
        $product_id = $product->get_id();
        $product_data= $product->get_data();
        $stock_qty = $product_data['stock_quantity'];
    
        $min_quantity = get_post_meta($product_id, WC_MMQ_PREFIX . 'min_quantity', true);
    
        if( ! empty( $min_quantity ) && ! empty( $stock_qty ) && $min_quantity > $stock_qty ){
            $text = 'Read More';
        }
    
        return $text;
    }

}