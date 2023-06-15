<?php
namespace WCMMQ_ADDON\Admin;

use WCMMQ_ADDON\Inc\App\Enqueue;
use WCMMQ_ADDON\Inc\App\Base;
use WCMMQ_ADDON\Inc\App\Hook_Base;

class Menu_Page_Table extends Hook_Base
{

    public $page_slug = 'wcmmq_addon_email_notify';
    public $posts_per_page = 50;
    public $page_number = 1;

    /**
     *  all action will call from here.
     *  @since 1.0.0 
     */
    public function __construct()
    {
        if( isset($_GET['page_number']) && ! empty( $_GET['page_number'] )){
            $this->page_number = $_GET['page_number'] ?? 1;
        }

        $this->action('admin_menu');  
    }

    /**
     *  This will add a new submenu undrer the Woocommerce menu
     *  New submenu name will be 'Low Stock Emails'. All email lists will there
     *  @since 1.0.0 
     */
    public function admin_menu()
    {
        $capability = apply_filters( 'wcmmq_addon_menu_capability', 'manage_woocommerce' );
        add_submenu_page( 'woocommerce', 'Low Stock Email', 'Low Stock Emails', $capability, $this->page_slug, [$this, 'notify_page'] );

    }
    /**
     *  To delete any email from the list
     *  @since 1.0.0 
     */
    public function delete_email($row_id){
        if(empty($row_id)) return;

        global $wpdb;
        $table_name = $wpdb->prefix . $this->notify_table_name; //'wcmmq_low_stock_emails' 

        $wpdb->delete($table_name, ['id'=>$row_id]);
    }

    /**
     *  Chnage the email send status 
     *  @since 1.0.0 
     */
    public function change_sent_status($row_id, $sent_status){
        if(empty($row_id)) return;
        if(empty($sent_status)) return;

        global $wpdb;
        $table_name = $wpdb->prefix . $this->notify_table_name; //'wcmmq_low_stock_emails' 

        $wpdb->update($table_name, ['sent_status'=>$sent_status], ['id'=>$row_id]);
    }

    /**
     *  This is main admin page. Page data will show here.
     * 
     *  @author Fazle Bari <fazlebarisn@gmail.com>
     *  @since 1.0.0
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
        //Added LIMIT 10
        $offset = ($this->page_number - 1 ) * $this->posts_per_page;
        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC LIMIT " . $this->posts_per_page . " OFFSET $offset");
        $serialNumber = 1;
        //$page_number
        $basic_admin_url = 'admin.php?page=' . $this->page_slug . '&page_number=' . $this->page_number;
        ?>
            <div class="low-stock-email">
                <h1>Email lists</h1>
                <?php $this->pagination(); ?>
                <div class="wcmmq-email-table-wrapper">
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
                                <td class="wcmmq-td wcmmq-td-serial"><?php echo $serialNumber ?></td>
                                <td class="wcmmq-td wcmmq-td-title"><a href="<?php echo get_the_permalink($row->product_id ); ?>" target="_blank" ><?php echo get_the_title( $row->product_id ); ?></a></td>
                                <td class="wcmmq-td wcmmq-td-email"><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
                                <td class="wcmmq-action wcmmq-status">
                                    <?php
                                    $status = $row->sent_status;
                                    $do_change_status = 'Yes';
                                    if($status ==='Yes'){
                                        $do_change_status = 'No';
                                    }
                                    ?>
                                    <b><?php echo esc_html( $status ); ?></b> | 
                                    <a class="wcmmq-action-btn" href="<?php echo esc_url( admin_url( $basic_admin_url . '&sent_status=' . $do_change_status . '&row_id=' . $row->id ) ); ?>">Change</a>
                                </td>
                                <td class="wcmmq-action wcmmq-delete"><a class="wcmmq-action-btn" href="<?php echo esc_url( admin_url( $basic_admin_url . '&delete=' . $row->id ) ); ?>">Delete</a></td>
                            </tr>
                        <?php $serialNumber++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php $this->pagination('footer'); ?>
            </div>
        <?php
    }

    /**
     *  Add pagination in to the table. By default pagination will start after 50 email
     *  @since 1.0.0 
     */
    public function pagination($position_name = ''){
        echo '<div class="wcmmq-pagination-wrapper wcmmq-pagination-wrapper-' . $position_name . '">';
        global $wpdb;
        $table_name = $wpdb->prefix . $this->notify_table_name; //'wcmmq_low_stock_emails' 
        
        $total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

        // Calculate the total number of pages
        $total_pages = ceil($total_rows / $this->posts_per_page);

        $basic_admin_url = 'admin.php?page=' . $this->page_slug . '&page_number=' . $this->page_number;


        // Display pagination links
        if ($total_pages > 1) {
            echo '<div class="wcmmq-pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($this->page_number == $i) ? 'active' : '';
                echo '<a href="' . admin_url( 'admin.php?page=' . $this->page_slug . '&page_number=' . $i ) . '" class="' . $active_class . '">' . $i . '</a>';
            }
            echo '</div>';
        }


        echo '</div>';///.wcmmq-pagination-wrapper
    }

    /**
     *  This will create a new table in to the database when plugin is install.
     *  @since 1.0.0 
     */
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
