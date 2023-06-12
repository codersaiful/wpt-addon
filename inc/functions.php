<?php 

 /**
  * add a input box on the single product page 
  * @author Fazle Bari <fazlebarisn@gmail.com>
  */
function codeastrology_single_product_summary(){
    global $product;
    $product_data= $product->get_data();
    $product_id= $product->get_id();

    $stock_status = $product_data['stock_status'];
    $stock_qty = $product_data['stock_quantity'];

    $min_quantity = get_post_meta($product_id, 'min_quantity', true);

    if( $min_quantity > $stock_qty ) :
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
add_action( 'woocommerce_single_product_summary', 'codeastrology_single_product_summary', 35 );

/**
 *  Collect data from input box
 *  @author Fazle Bari <fazlebarisn@gmail.com>
 */
function wcmmq_save_low_stock_email() {
    if ( isset( $_POST['wcmmq_stock_email'] ) && isset( $_POST['product_id'] ) && isset( $_POST['wcmmq_stock_email_nonce'] ) && wp_verify_nonce( $_POST['wcmmq_stock_email_nonce'], 'wcmmq_stock_email' ) ) {
        $email = sanitize_email( $_POST['wcmmq_stock_email'] );
        $product_id = absint( $_POST['product_id'] );

        // Save the email and product ID to your database

        $saved = wcmmq_save_email_to_database( $email, $product_id );

        if ( $saved ) {
            echo '<p>Thank you! We will notify you when the product is available.</p>';
        } else {
            echo '<p>There was an error. Please try again later.</p>';
        }
    }
}
add_action( 'init', 'wcmmq_save_low_stock_email' );

/**
 * Save information in to the database
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
function wcmmq_save_email_to_database( $email, $product_id ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'wcmmq_low_stock_emails';

    $data = array(
        'email' => $email,
        'product_id' => $product_id,
    );

    $wpdb->insert($table_name, $data);
}

// function remove_add_to_cart_button() {
//     remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
// }
// add_action( 'init', 'remove_add_to_cart_button' );
