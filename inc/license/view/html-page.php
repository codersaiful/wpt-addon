<?php

/**
 * All of setting Constant available here.
 * Actually this file is loaded or included inside the 
 * \CodeAstrology_License\Manage class
 * 
 * So all property will available here.
 * //If Need
        //$this->get_live_license_data(); //Getting licens data
        //$this->get_live_license_status(); //Getting licens data Live
 */
$settings = $this->settings;

/**
 * There will stay HTML Field or input filed of
 * active deactive button. 
 * 
 * @author Saiful Islam <codersaiful@gmail.com>
 */

$license_data  = $this->get_license_data();// get_option( $this->settings->license_data_key );

if($this->status === 'valid' && is_object($license_data) ){
    $customer_name = $license_data->customer_name;
    ?>
<div class="license-module-parent">
    <div class="license-form-result">
    <p class="attr-alert attr-alert-success">
        <?php 
        echo sprintf( esc_html__( "Congratulations %s%s%s! Your product is activated for '%s'.", 'wpt_pro' ), '<b>',$customer_name,'</b>', parse_url( home_url(), PHP_URL_HOST ) );
        ?>
    </p>
    <?php
    ?>

        <div class="user-info-edd">
            <h3 class="sec-title">Your Details</h3>
            <div class="user-details">

                <div class="edd-single-user-ifno item_name">
                    <p class="field-name">Product</p>
                    <p class="field-value"><?php echo esc_html( $license_data->item_name ); ?></p>
                </div>
                
                <div class="edd-single-user-ifno customer_name">
                    <p class="field-name">Name</p>
                    <p class="field-value"><?php echo esc_html( $license_data->customer_name ); ?></p>
                </div>
                <div class="edd-single-user-ifno customer_email">
                    <p class="field-name">Email</p>
                    <p class="field-value"><?php echo esc_html( $license_data->customer_email ); ?></p>
                </div>
                <div class="edd-single-user-ifno license">
                    <p class="field-name">license</p>
                    <p class="field-value"><?php echo esc_html( $license_data->license ); ?></p>
                </div>
                <div class="edd-single-user-ifno license_limit">
                    <p class="field-name">license_limit</p>
                    <p class="field-value"><?php echo esc_html( $license_data->license_limit ); ?></p>
                </div>
                <div class="edd-single-user-ifno site_count">
                    <p class="field-name">site_count</p>
                    <p class="field-value"><?php echo esc_html( $license_data->site_count ); ?></p>
                </div>
                <div class="edd-single-user-ifno activations_left">
                    <p class="field-name">activations_left</p>
                    <p class="field-value"><?php echo esc_html( $license_data->activations_left ); ?></p>
                </div>
                <div class="edd-single-user-ifno expires">
                    <p class="field-name">expires</p>
                    <p class="field-value">
                        <?php 
                        try{
                            $dateObj = new DateTime($license_data->expires);
                            $formattedDate = $dateObj->format('j F, Y');
                            echo esc_html( $formattedDate ); 
                        }catch( Exception $eee ){
                            echo esc_html( $license_data->expires ); 
                        }
                        ?>
                    </p>
                </div>
                
                <div class="edd-single-user-ifno my-account">
                    <p class="field-name">Login</p>
                    <p class="field-value">
                        <?php
                        $payment_id = $license_data->payment_id ?? '';
                        ?>
                        <a href="https://codeastrology.com/my-account/?target_tab=purches_history&action=manage_licenses&payment_id=<?= $payment_id ?>&utm=User Details Page" target="_blank">
                            My Account (Check license/Upgrade/Manage Site)  
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
<?php 
}
 ?>

<div class="ca-linces-field-wrapper">
    <p class="description">
        <?php esc_html_e( 'Enter your license key.' ); ?>
    </p>
    
    <?php
    printf(
        '<input type="password" class="regular-text" id="' . $this->license_key_name . '" name="' . $this->license_key_name . '" value="%s" />',
        esc_attr( $this->license_key )
    );

    $button = array(
        'name'  => $this->btn_deactivate,
        'label' => __( 'Deactivate License' ),
    );
    if ( 'valid' !== $this->status ) {
        $button = array(
            'name'  => $this->btn_activate,
            'label' => __( 'Activate License' ),
        );
    }
    wp_nonce_field( $this->nonce, $this->nonce );
    ?>
    <input type="submit" class="button-secondary" name="<?php echo esc_attr( $button['name'] ); ?>" value="<?php echo esc_attr( $button['label'] ); ?>"/>

    
</div>

 
