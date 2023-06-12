<?php 
/**
 * All important functon will stay here.
 */
function codeastrology_single_product_summary(){
    global $product;
    $product_data= $product->get_data();
    $product_id= $product->id;

    $stock_status = $product_data['stock_status'];
    $stock_qty = $product_data['stock_quantity'];

    $min_quantity = get_post_meta($product_id, 'min_quantity', true);

    //  dd(ABSPATH);

    if( $min_quantity > $stock_qty ) :
        ?>
            <div class="wcmmq-notify">
                <form method="post" action="">
                    <input type="email" name="wcmmq_stock_email" placeholder="Enter your email" required>
                    <input type="submit" value="Notify me when available">
                    <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>">
                    <?php wp_nonce_field( 'wcmmq_stock_email', 'wcmmq_stock_email_nonce' ); ?>
                </form>
            </div>
        <?php
    endif;
}
add_action( 'woocommerce_single_product_summary', 'codeastrology_single_product_summary', 35 );