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

 /**
 * There will stay HTML Field or input filed of
 * active deactive button. 
 * 
 * @author Saiful Islam <codersaiful@gmail.com>
 */

$prefix = $this->hook_prefix;

if( did_action( $prefix . '_addon_license_area' ) ) return;


$settings = $this->settings;


?>
<div class="ca-license-bottom-area <?php echo esc_attr( $prefix ); ?>-license-bottom-area">
    <?php
    // var_dump($this);
    do_action( $prefix . '_license_bottom_area' );
    ?>
</div>
<div class="ca-addon-license-area <?php echo esc_attr( $prefix ); ?>-addon-license-area">
    <?php
    do_action( $prefix . '_addon_license_area' );
    ?>
</div>