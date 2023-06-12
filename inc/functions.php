<?php 



/**
 * Save information in to the database
 * 
 * @author Fazle Bari <fazlebarisn@gmail.com>
 * @author Saiful Islam <codersaiful@gmail.com>
 */
function wcmmq_save_email_to_database( $email, $product_id, $table_name ) {
    global $wpdb;
    $data = array(
        'email' => $email,
        'product_id' => $product_id,
    );
    return $wpdb->insert($table_name, $data);

}

