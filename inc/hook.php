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
    }

    /**
     * There is a filter hook in 'Back In Stock Notifier' plugin. That hook is returing the stock status. Notifacation box will appar if 
     * product is out of stock. Here i am changing  stock status. 
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function cwg_default_allowed_status( $status, $product, $variation ){

        $product_type = $product->get_type();

        if( 'variable' == $product_type ) return $status;

        $product_data= $product->get_data();
        $product_id= $product->get_id();
        $stock_status = $product_data['stock_status'];
        $stock_qty = $product_data['stock_quantity'];

        if( ! defined( 'WC_MMQ_PREFIX' ) ){
            define('WC_MMQ_PREFIX', '');
        }

        $min_quantity = get_post_meta($product_id, WC_MMQ_PREFIX . 'min_quantity', true);
    
        if( $stock_qty  < $min_quantity && 'instock' == $stock_status ){
            $status = ['instock'];
            add_action('wp_footer', [ $this , 'hide_add_to_cart'] );
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