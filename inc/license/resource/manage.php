<?php
namespace CodeAstrology_License;
use \CodeAstrology_License\Plugin_Updater as Plugin_Updater;
class Manage
{

    protected $prefix;

    /**
     * It's actually parent prefix
     * We will use it for parent prefix
     * jodi child addon banay ar sekhane parent pro nai, tokhon
     * amora eta bebohar korbo.
     * license menu and main hook prefix hisbe
     *
     * @var string 
     */
    protected $hook_prefix;
    protected $settings;
    protected $status;
    protected $license_key;

    protected $license_key_name;
    protected $license_status_name;
    
    //Specially nonce for Input Field of License input box
    protected $nonce;

    //Specially  register setting name for Input Field of License input box
    protected $register_sett;

    protected $btn_activate;
    protected $btn_deactivate;

    // protected
    protected $enequeue_handle = 'ca-license-style';
    protected $form_section;


    protected $main_license_slug;
    protected $manage_loc;

    public function __construct( object $settings, $pro = '')
    {
        $this->prefix = $settings->prefix;
        $this->hook_prefix = $this->prefix;
        $this->settings = $settings;

        $this->license_key_name = $this->prefix . $pro . '_license_key';
        $this->license_status_name = $this->prefix . $pro . '_license_status';

        $this->nonce = $this->prefix . '_license_nonce';
        $this->register_sett = $this->prefix . '_license_sett';
        $this->btn_activate = $this->prefix . '_btn_activate_license';
        $this->btn_deactivate = $this->prefix . '_btn_deactivate_license';
        $this->form_section = $this->settings->page_slug . '_' . $this->prefix;
        

        $this->license_key = trim( get_option( $this->license_key_name ) );
        $this->status = get_option( $this->license_status_name );
        $this->manage_loc = __FILE__;

        add_action('init', [$this, 'plugin_updater']);

        
        //Menu and Page Settings
        add_action('admin_init', [$this, 'register_option']);

        
        if( ! empty( $this->settings->parent_addon_prefix ) ){
            if( ! empty( $this->settings->parent_exists_class ) && ! class_exists( $this->settings->parent_exists_class ) ){
                $this->hook_prefix = $this->settings->parent_addon_prefix;
                $this->main_license_slug = $this->hook_prefix . '-all-license';
                $this->settings->license_page_link = admin_url( 'admin.php?page=' .$this->main_license_slug );
                add_action( 'admin_menu', [$this, 'license_menu_empty'] );
            }
            $this->settings->page_title = "License";
            add_action( $this->settings->parent_addon_prefix . '_addon_license_area', [$this, 'license_page']);
            // $this->license_page();
        }else{
            add_action( 'admin_menu', [$this, 'license_menu'] );
        }
        

        //Activate and Deactivate License.
        add_action('admin_init', [$this, 'activate_license']);
        add_action('admin_init', [$this, 'deactivate_license']);

        //Notice Handle
        add_action('admin_notices', [$this, 'notice_activation_status']);
        if($this->status !== 'valid'){
            add_action('admin_notices', [$this, 'notice_to_activate']);
        }

        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue']);

    }

    /**
     * Registers the license key setting in the options table.
     *
     * @return void
     */
    function register_option()
    {
        register_setting($this->register_sett, $this->license_key_name, [$this, 'sanitize_license']);
    }    

    /**
     * Adds the plugin license page to the admin menu.
     *
     * @return void
     */
    function license_menu() {
        // add_plugins_page(
        //     __( $this->settings->page_title ),
        //     __( $this->settings->page_title ),
        //     $this->settings->permission,
        //     $this->settings->page_slug,
        //     [$this, 'license_page']
        // );

        add_submenu_page(
            $this->settings->parent_page,
            __( $this->settings->page_title ),
            __( $this->settings->page_title ),
            $this->settings->permission,
            $this->settings->page_slug,
            [$this, 'license_page']
        );
    }    
    function license_menu_empty() {
        global $submenu;

        if( ! isset( $submenu[$this->settings->parent_page] ) ) return;
        // $current_menus = wp_list_pluck( $submenu['edit.php?post_type=wpt_product_table'], 2 );
        $current_menus = wp_list_pluck( $submenu[$this->settings->parent_page], 2 );
        if(in_array( $this->main_license_slug, $current_menus )) return;

        add_submenu_page(
            $this->settings->parent_page,
            __( $this->settings->page_title ),
            __( $this->settings->page_title ),
            $this->settings->permission,
            $this->main_license_slug,
            [$this, 'license_page_empty']
        );
    }    

    function license_page() {
        add_settings_section(
            $this->register_sett,
            __( $this->settings->page_title ),
            [$this, 'license_key_settings_field'],
            $this->form_section
        );
        // add_settings_field(
        //     $this->license_key_name,
        //     '<label for="' . $this->license_key_name . '">' . __( 'License Key' ) . '</label>',
        //     [$this, 'license_key_settings_field'],
        //     $this->form_section,
        //     $this->register_sett,
        // );
        
        ?>
        <div class="outer-wrap prefix-<?php echo esc_attr( $this->prefix ); ?> hookprefix-<?php echo esc_attr( $this->hook_prefix ); ?>">
            <h2 class="plugin-name"><?php esc_html_e( $this->settings->item_name ); ?></h2>
            <form method="post" action="options.php">
    
                <?php
                do_settings_sections( $this->form_section );
                settings_fields( $this->register_sett );
                submit_button();
                ?>
    
            </form>

            <div class="license-key-doc">
                <p class="license-key"><strong>Tips: </strong><a href="<?php echo esc_url( $this->settings->help_url ); ?>" target="_black"><?php echo esc_html__( 'Where is my license key? Click Here', 'wpt_pro' ); ?></a></p>
            </div>
            <?php
            include_once dirname( $this->settings->license_root_file ) . '/view/html-page-bottom.php';
            ?>

        </div>
        <?php
    }
    
    function license_page_empty() {
        add_settings_section(
            $this->register_sett,
            __( $this->settings->page_title ),
            [$this, 'license_key_settings_field'],
            $this->form_section
        );

        ?>
           
            <?php
            include_once dirname( $this->settings->license_root_file ) . '/view/html-page-bottom.php';
            ?>

        
        <?php
    }


    /**
     * Outputs the license key settings field.
     *
     * @return void
     */
    function license_key_settings_field() {
        include dirname( $this->settings->license_root_file ) . '/view/html-page.php';
    }



    /**
     * Activates the license key.
     *
     * @return void
     */
    function activate_license()
    {


        // listen for our activate button to be clicked
        if (!isset($_POST[$this->btn_activate])) {
            return;
        }

        // run a quick security check
        if (!check_admin_referer($this->nonce, $this->nonce)) {
            return; // get out if we didn't click the Activate button
        }

        // retrieve the license from the database
        $license = trim(get_option($this->license_key_name));
        if (!$license) {
            $license = !empty($_POST[$this->license_key_name]) ? sanitize_text_field($_POST[$this->license_key_name]) : '';
        }
        if (!$license) {
            return;
        }

        // data to send in our API request
        $api_params = array(
            'edd_action'  => 'activate_license',
            'license'     => $license,
            'item_id'     => $this->settings->item_id,
            'item_name'   => rawurlencode($this->settings->item_name), // the name of our product in EDD
            'url'         => home_url(),
            'environment' => function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production',
        );

        // Call the custom API.
        $response = wp_remote_post(
            $this->settings->store_url,
            array(
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => $api_params,
            )
        );


        // make sure the response came back okay
        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

            if (is_wp_error($response)) {
                $message = $response->get_error_message();
            } else {
                $message = __('An error occurred, please try again.');
            }
        } else {




            $license_data = json_decode(wp_remote_retrieve_body($response));

            if (false === $license_data->success) {

                switch ($license_data->error) {

                    case 'expired':
                        $message = sprintf(
                            /* translators: the license key expiration date */
                            __('Your license key expired on %s.', 'bbbaa'),
                            date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                        );
                        break;

                    case 'disabled':
                    case 'revoked':
                        $message = __('Your license key has been disabled.', 'bbbaa');
                        break;

                    case 'missing':
                        $message = __('Invalid license.', 'bbbaa');
                        break;

                    case 'invalid':
                    case 'site_inactive':
                        $message = __('Your license is not active for this URL.', 'bbbaa');
                        break;

                    case 'item_name_mismatch':
                        /* translators: the plugin name */
                        $message = sprintf(__('This appears to be an invalid license key for %s.', 'bbbaa'), $this->settings->item_name);
                        break;

                    case 'no_activations_left':
                        $message = __('Your license key has reached its activation limit.', 'bbbaa');
                        break;

                    default:
                        $message = __('An error occurred, please try again.', 'bbbaa');
                        break;
                }
            }
        }

        update_option($this->settings->license_data_key, $license_data);
        // Check if anything passed on a message constituting a failure
        if (! empty($message)) {
            $redirect = add_query_arg(
                array(
                    'page'          => $this->main_license_slug ?? $this->settings->page_slug,
                    'sl_activation' => 'false',
                    'message'       => rawurlencode($message),
                ),
                $this->settings->license_page_link //admin_url('plugins.php')
            );

            wp_safe_redirect($redirect);
            exit();
        }

        // $license_data->license will be either "valid" or "invalid"
        if ('valid' === $license_data->license) {
            update_option($this->license_key_name, $license);
        }
        update_option($this->license_status_name, $license_data->license);
        

        // $redirect = add_query_arg(
        //     array(
        //         'page'          => $this->settings->page_slug,
        //         'sl_activation' => 'true',
        //         'barta'       => rawurlencode( $message ),
        //     ),
        //     $this->settings->license_page_link
        // );

        // wp_safe_redirect( $redirect );
        // exit();
        // // wp_safe_redirect(admin_url('plugins.php?page=' . $this->settings->page_slug));
        // exit();
    }

    /**
     * Deactivates the license key.
     * This will decrease the site count.
     *
     * @return void
     */
    function deactivate_license()
    {

        // var_dump('bbbbbwpt-edd',$_POST);
        // listen for our activate button to be clicked
        if (isset($_POST[$this->btn_deactivate])) {

            // run a quick security check
            if (!check_admin_referer($this->nonce, $this->nonce)) {
                return; // get out if we didn't click the Activate button
            }

            // retrieve the license from the database
            $license = trim(get_option($this->license_key_name));

            // data to send in our API request
            $api_params = array(
                'edd_action'  => 'deactivate_license',
                'license'     => $license,
                'item_id'     => $this->settings->item_id,
                'item_name'   => rawurlencode($this->settings->item_name), // the name of our product in EDD
                'url'         => home_url(),
                'environment' => function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production',
            );

            // Call the custom API.
            $response = wp_remote_post(
                $this->settings->store_url,
                array(
                    'timeout'   => 15,
                    'sslverify' => false,
                    'body'      => $api_params,
                )
            );
            // var_dump($response);

            // make sure the response came back okay
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __('An error occurred, please try again.');
                }

                $redirect = add_query_arg(
                    array(
                        'page'          => $this->main_license_slug ?? $this->settings->page_slug,
                        'sl_activation' => 'false',
                        'message'       => rawurlencode($message),
                    ),
                    $this->settings->license_page_link,//admin_url('plugins.php')
                );

                wp_safe_redirect($redirect);
                exit();
            }

            // decode the license data
            $license_data = json_decode(wp_remote_retrieve_body($response));

            // $license_data->license will be either "deactivated" or "failed"
            if ('deactivated' === $license_data->license) {
                delete_option($this->license_status_name);
            }

            delete_option($this->settings->license_data_key);
            return;
            
            exit();
        }
    }



    /**
     * Sanitizes the license key.
     *
     * @param string  $new The license key.
     * @return string
     */
    function sanitize_license($new)
    {
        $old = get_option($this->license_key_name);
        if ($old && $old !== $new) {
            delete_option($this->license_status_name); // new license has been entered, so must reactivate
        }

        return sanitize_text_field($new);
    }


    /**
     * Initialize the updater. Hooked into `init` to work with the
     * wp_version_check cron job, which allows auto-updates.
     */
    public function plugin_updater()
    {

        // To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
        $doing_cron = defined('DOING_CRON') && DOING_CRON;
        if (!current_user_can($this->settings->permission) && !$doing_cron) {
            return;
        }

        // retrieve our license key from the DB
        
        
        // setup the updater
        $edd_updater = new Plugin_Updater(
            $this->settings->store_url,
            $this->settings->plugin_root_file, //__FILE__,
            array(
                'version' => $this->settings->plugin_version,                    // current version number
                'license' => $this->license_key,             // license key (used get_option above to retrieve from DB)
                'item_id' => $this->settings->item_id,       // ID of the product
                'author'  => $this->settings->author_name,
                'beta'    => true,
            )
        );
        // var_dump($edd_updater);
    }


    /**
     * this function added by saiful.
     * 
     * asole eta kothao use hoyni apatot.
     * zodi kono karone status ba license data dekhar proyojon hoy, tokhon
     * eta use kora jabe. multo age thekei chilo seta theke ami eta custom abniyechi.
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     * 
     * //Previous comment:
     * Checks if a license key is still valid.
     * The updater does this for you, so this is only needed if you want
     * to do somemthing custom.
     *
     * @return object|mixed
     */
    public function get_live_license_data()
    {
        $license = trim(get_option($this->license_key_name));

        // var_dump($license);
        $api_params = array(
            'edd_action'  => 'check_license',
            'license'     => $license,
            'item_id'     => $this->settings->item_id,
            'item_name'   => rawurlencode($this->settings->item_name),
            'url'         => home_url(),
            'environment' => function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production',
        );

        // Call the custom API.
        $response = wp_remote_post(
            $this->settings->store_url,
            array(
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => $api_params,
            )
        );

        if (is_wp_error($response)) {
            return false;
        }

        $license_data = json_decode(wp_remote_retrieve_body($response));

        return $license_data;
    }

    /**
     * It's Live status, If you call this method,
     * this method will check again manually
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     * 
     * This method customised by Saiful
     * 
     * **************************
     * Checks if a license key is still valid.
     * The updater does this for you, so this is only needed if you want
     * to do somemthing custom.
     *
     * @return string Example: valid or invalid
     */
    function get_live_license_status()
    {


        $license_data = $this->get_live_license_data();
        if ('valid' === $license_data->license) {
            return 'valid';
        } else {
            return 'invalid';
        }
    }

    /**
     * Get license data from Database.
     * If you want live, need to use 
     * $this->get_live_license_data()
     *
     * @return array||mixed
     */
    public function get_license_data(){
        return get_option( $this->settings->license_data_key );
    }
    public function get_license_status(){
        return $this->status; //get_option( $this->license_status_name );
    }

    /**
     * This is a means of catching errors from the activation method above and displaying it to the customer
     */
    function notice_activation_status()
    {
        if (isset($_GET['sl_activation']) && !empty($_GET['message'])) {
            $message = urldecode($_GET['message'] ?? '');
            switch ($_GET['sl_activation']) {

                case 'false':
                    
                ?>
                    <div class="error">
                        <p><?php echo wp_kses_post($message); ?></p>
                    </div>
                <?php
                    break;

                case 'true':
                default:

                ?>
                    <div id="message" class="updated notice notice-success">
                        <p><?php echo wp_kses_post($message); ?></p>
                        <p>Submitted.</p>
                    </div>
                <?php
                    // Developers can put a custom success message here for when activation is successful if they way.
                    break;
            }
        }
    }

    public function notice_to_activate()
    {

        // var_dump($this->settings->license_page_link);
        $link_label = __( 'Activate License', 'wpt_pro' );
        $link = $this->settings->license_page_link;
        
		$message = esc_html__( 'Please activate ', 'wpt_pro' ) . '<strong>' . esc_html__( $this->settings->item_name ) . '</strong>' . esc_html__( ' license to get automatic updates.', 'wpt_pro' ) . '</strong>';
        printf( '<div class="error error-warning is-dismissible"><p>%1$s <a href="%2$s">%3$s</a></p></div>', $message, $link, $link_label );
        
    }

    public function admin_enqueue()
    {
        $slug = $this->settings->page_slug;
        $parent_page = $this->settings->parent_page;
        $screen = get_current_screen();
        $screen_id = $screen->id;

        if( strpos($screen_id,$slug) || ( ! empty( $this->main_license_slug ) && strpos($screen_id,$this->main_license_slug)) ){
            $src = plugins_url() . '/'. plugin_basename( dirname( $this->settings->license_root_file ) . '/view/license-style.css' );
 
            wp_register_style($this->enequeue_handle,$src, [], '1.0.0', 'all');
            wp_enqueue_style($this->enequeue_handle);
        }
        
    }
}