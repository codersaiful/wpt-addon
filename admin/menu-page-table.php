<?php
namespace WCMMQ_ADDON\Admin;

use WCMMQ_ADDON\Inc\App\Enqueue;
use WCMMQ_ADDON\Inc\App\Base;
use WCMMQ_ADDON\Inc\App\Hook_Base;

class Menu_Page_Table extends Hook_Base
{

    public $page_slug = 'wcmmq_addon_email_notify';

    public function __construct()
    {

        $this->action('admin_menu');  
    }

    public function admin_menu()
    {
        $capability = apply_filters( 'wcmmq_addon_menu_capability', 'manage_woocommerce' );
        add_submenu_page( 'woocommerce', 'Low Stock Email', 'Low Stock Emails', $capability, $this->page_slug, [$this, 'notify_page'] );

    }

    public function delete_email($row_id){
        if(empty($row_id)) return;

        global $wpdb;
        $table_name = $wpdb->prefix . $this->notify_table_name; //'wcmmq_low_stock_emails' 

        $wpdb->delete($table_name, ['id'=>$row_id]);
    }
    public function change_sent_status($row_id, $sent_status){
        if(empty($row_id)) return;
        if(empty($sent_status)) return;

        global $wpdb;
        $table_name = $wpdb->prefix . $this->notify_table_name; //'wcmmq_low_stock_emails' 

        $wpdb->update($table_name, ['sent_status'=>$sent_status], ['id'=>$row_id]);
    }
    /**
     *  This is a menu page. Page data will show here 
     * 
     *  @author Fazle Bari <fazlebarisn@gmail.com>
     *  @since 1.0
     */
    public function notify_page(){

        global $wpdb;
        $table_name = $wpdb->prefix . $this->notify_table_name; //'wcmmq_low_stock_emails' 
        
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
        if(!$table_exists){
            $this->create_table();
            echo 'Reload';
            return;
        }
        //Delete Part
        if( isset($_GET['delete']) && ! empty( $_GET['delete'] )){
            $row_id = $_GET['delete'] ?? false;
            $this->delete_email( $row_id );
        }
        if( isset($_GET['sent_status']) && ! empty( $_GET['sent_status'] ) && isset($_GET['row_id']) && ! empty( $_GET['row_id'] )){
            $row_id = $_GET['row_id'] ?? false;
            $sent_status = $_GET['sent_status'] ?? "No";
            $this->change_sent_status( $row_id,$sent_status );
        }
        
        // Query from 'wcmmq_low_stock_emails' table and retrieve the data
        
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
                        <tr class="wcmmq-row wcmma-row-<?php echo esc_attr( $row->sent_status ); ?>">
                            <td><?php echo $serialNumber ?></td>
                            <td><a href="<?php echo get_the_permalink($row->product_id ); ?>" target="_blank" ><?php echo get_the_title( $row->product_id ); ?></a></td>
                            <td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
                            <td>
                                <?php
                                $status = $row->sent_status;
                                $do_change_status = 'Yes';
                                if($status ==='Yes'){
                                    $do_change_status = 'No';
                                }
                                ?>
                                <b><?php echo esc_html( $status ); ?></b> | 
                                <a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $this->page_slug . '&sent_status=' . $do_change_status . '&row_id=' . $row->id ) ); ?>">Change</a>
                            </td>
                            <td><a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $this->page_slug . '&delete=' . $row->id ) ); ?>">Delete</a></td>
                        </tr>
                    <?php $serialNumber++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php
    }

    public function create_table()
    {
    
        global $wpdb;
        $table_name = $wpdb->prefix . $this->notify_table_name;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT(9) NOT NULL AUTO_INCREMENT,
            email VARCHAR(100) NOT NULL,
            product_id INT(9) NOT NULL,
            sent_status VARCHAR(3) NOT NULL DEFAULT 'No',
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


}
