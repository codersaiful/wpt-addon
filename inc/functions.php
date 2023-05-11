<?php 


function wpt_simpe_var_license(){

    return true;
}

/**
 * Check plugin pro version
 */
if( !function_exists('wpt_is_pro') ){
    function wpt_is_pro(){
        if( defined( 'WPT_PRO_DEV_VERSION' ) ) return true;
        return false;
    }
}
