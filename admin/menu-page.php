<?php
/**
 * Adding menu as WooCommerce's menu's Submenu
 * check inside Woocommerce Menu
 * 
 * @since 1.0
 */
function wcmmq_addon_email_menu(){

    $capability = apply_filters( 'wcmmq_addon_menu_capability', 'manage_woocommerce' );
    add_submenu_page( 'woocommerce', 'Low Stock Email', 'Low Stock Emails', $capability, 'wcmmq_addon_email_notify', 'wcmmq_addon_email_notify_page' );

}
add_action( 'admin_menu','wcmmq_addon_email_menu' );

/**
 *  This is a menu page. Page data will show here 
 *  @author Fazle Bari <fazlebarisn@gmail.com>
 *  @since 1.0
 */
function wcmmq_addon_email_notify_page(){

    // Query from 'wcmmq_low_stock_emails' table and retrieve the data
    global $wpdb;
    $table_name = $wpdb->prefix . 'wcmmq_low_stock_emails'; 
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    $serialNumber = 1;

    ?>
        <div class="low-stock-email">
            <h1>Email lists</h1>
            <table class="stock-email-table">
                <thead>
                    <tr class="wcmmq-table-row">
                        <th>Sl No</th>
                        <th>Product Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php echo $serialNumber ?></td>
                        <td><a href="<?php echo get_the_permalink($row->product_id ); ?>" target="_blank" ><?php echo get_the_title( $row->product_id ); ?></a></td>
                        <td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
                        <td>
                            ok
                        </td>
                        <td>Delete</td>
                    </tr>
                <?php $serialNumber++; endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php
}