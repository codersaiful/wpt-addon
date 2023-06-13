<?php 
/**
 * All important functon will stay here.
 */

// add_filter('wpt_design_tab_fields','wpt_custom_design_tab');
function wpt_custom_design_tab( $args ){
    $args['body']['item'][] = [
        'title' => 'Table Border Width',
        'selector' => 'tbody tr td',
        'property' => 'border-width',
        'type'  => 'text'
    ];
    $args['body']['item'][] = [
        'title' => 'Table Border Width',
        'selector' => 'tbody tr td',
        'property' => 'border-style',
        'value'     => 'solid',
        'type'  => 'text'
    ];
    // var_dump($args['body']['item']);
    return $args;
}


if( ! function_exists( 'cynthia_crafts_color_swatch_visibility_handle' ) ){
    function cynthia_crafts_color_swatch_visibility_handle(){

        $id = get_the_ID();
        $hello = get_post($id);
        $hello = wc_get_product($id);
        var_dump($hello);

        if( function_exists('is_product') && ! is_product()){
            remove_all_filters( 'woocommerce_dropdown_variation_attribute_options_html' );
        }
        // if( is_singular() && get_post_type() == 'page'  ){
        //     remove_all_filters( 'woocommerce_dropdown_variation_attribute_options_html' );
        // }
// 		 remove_all_filters( 'woocommerce_dropdown_variation_attribute_options_html' );
 
    }
}
// add_action( 'init', 'cynthia_crafts_color_swatch_visibility_handle', PHP_INT_MAX );
// add_filter('wpto_template_loc_item_action',function(){
//     return __DIR__ . '/saiful.php';
// });