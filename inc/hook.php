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
        $this->action('woocommerce_single_product_summary');        
        $this->filter('woocommerce_product_add_to_cart_text', 10, 2);   
    }


    /**
     * add a input box on the single product page 
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function woocommerce_single_product_summary(){
        global $wpdb;
        if ( isset( $_POST['wcmmq_stock_email'] ) && isset( $_POST['product_id'] ) && isset( $_POST['wcmmq_stock_email_nonce'] ) && wp_verify_nonce( $_POST['wcmmq_stock_email_nonce'], 'wcmmq_stock_email' ) ) {
            $email = sanitize_email( $_POST['wcmmq_stock_email'] );
            $product_id = absint( $_POST['product_id'] );
            $saved = false;
            if(! empty($email) ){
                $table_name = $wpdb->prefix . $this->notify_table_name; //'wcmmq_low_stock_emails' 
                $saved = wcmmq_save_email_to_database( $email, $product_id, $table_name );
            }

            if ( $saved ) {
                $msessage = "Thank you! We will notify you when the product is available.";
                // wc_add_notice( $msessage, 'success' );
                ?>
                <div class="woocommerce">
                    <div class="woocommerce-message" role="alert"><?php echo esc_html( $msessage ); ?></div>
                </div>
                
                <?php 
                // echo '<p class="wcmmq-message wcmmq-message-success">' . $msessage . '</p>';
            } else {
                $msessage = "There was an error. Please try again later.";
                // wc_add_notice( $msessage, 'error' );
                ?>
                <div class="woocommerce">
                    <ul class="woocommerce-error" role="alert">
                        <li><?php echo esc_html( $msessage ); ?></li>
                    </ul>
                </div>
                <?php 
                // echo '<p class="wcmmq-message wcmmq-message-error">' . $msessage . '</p>';
            }
        }

        global $product;
        $product_data= $product->get_data();
        $product_id= $product->get_id();

        $stock_status = $product_data['stock_status'];
        $stock_qty = $product_data['stock_quantity'];

        if( ! defined( 'WC_MMQ_PREFIX' ) ){
            define('WC_MMQ_PREFIX', '');
        }
        
        // $min_quantity = get_post_meta($product_id, 'min_quantity', true);
        $min_quantity = get_post_meta($product_id, WC_MMQ_PREFIX . 'min_quantity', true);
        
        if( ! empty( $min_quantity ) && ! empty( $stock_qty ) && $min_quantity > $stock_qty ) :
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            ?>
                <div class="wcmmq-notify">
                    <form method="post" action="">
                        <input class="wcmmq-notify-inputbox" type="email" name="wcmmq_stock_email" placeholder="Enter your email" required>
                        <input class="wcmmq-notify-button" type="submit" value="Notify me when available">
                        <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>">
                        <?php wp_nonce_field( 'wcmmq_stock_email', 'wcmmq_stock_email_nonce' ); ?>
                    </form>
                </div>
            <?php
        endif;
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