<?php 

/**
 * Check plugin pro version
 */
if( !function_exists('wpt_is_pro') ){
    function wpt_is_pro(){
        if( defined( 'WPT_PRO_DEV_VERSION' ) ) return true;
        return false;
    }
}

/**
 *  Display variable and simple product together
 * @author Fazle Bari
 */
function codeastrology_args_manipulation( $args ){
   $query = new \WP_Query($args);
   $p_products = array();
   if($query->have_posts()):
      while( $query->have_posts() ): $query->the_post();
        global $product;
        $id = get_the_id();
        if( $product->get_type() !== 'variable' ){
            $p_products[] = $id;
        }

        if( $product->get_type() == 'variable' ){
            $variable = new WC_Product_Variable( $id );

            $available_variations = $variable->get_available_variations();
            $variations_id = wp_list_pluck( $available_variations, 'variation_id' );
            $p_products = array_merge($p_products, $variations_id);

        }

      endwhile;
    endif;
    $args['post_type'] = array('product', 'product_variation');
    $args['post__in'] = $p_products;
    $args['tax_query'] = false;
    $args['meta_query'] = false;

   return $args;
}

add_filter('wpto_table_query_args','codeastrology_args_manipulation');
add_filter('wpto_query_arg_ajax','codeastrology_args_manipulation');


/**
 * This will add new section at the end of queary tab. 
 * Sama as pro version, the idea is when this add on will active then 
 * original pro section will hide.
 */
function wpto_admin_basic_tab_var_simple( $meta_basics ){
    ?>
        <div class="wpt_column">
            <table class="ultraaddons-table wpt-table-separator-light">
                <tr>
                    <th>
                        <label class="wpt_label wpt_table_ajax_action" for='wpt_table_product_type'><?php esc_html_e('Product Type (Product/Variation Product)','wpt_pro');?></label>
                    </th>
                    <td>
                        <select name="basics[product_type]" data-name='product_type' id="wpt_table_product_type" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                            <option value="" <?php echo isset( $meta_basics['product_type'] ) && $meta_basics['product_type'] == '' ? 'selected' : false; ?>><?php esc_html_e('Product','wpt_pro');?></option>
                            <?php if ( wpt_is_pro() ): ?>
                                <option value="product_variation" <?php echo isset( $meta_basics['product_type'] ) && $meta_basics['product_type'] == 'product_variation' ? 'selected' : false; ?>><?php esc_html_e('Only Variation Product','wpt_pro');?></option>
                            <?php endif; ?>
                            <option value="product_var_and_simple" <?php echo isset( $meta_basics['product_type'] ) && $meta_basics['product_type'] == 'product_var_and_simple' ? 'selected' : false; ?>><?php esc_html_e('Variation and Simple Product','wpt_pro');?></option>
                        </select><?php wpt_doc_link('Product Type (Product/Variation Product)'); wpt_doc_link('https://demo.wooproducttable.com/product-variant-in-separate-row/','See demo'); ?>
                        <p>
                            <?php esc_html_e('If select Variation product, you have to confirm, your all Variation is configured properly. Such: there will not support "any attribute" option for variation. eg: no support "Any Size" type variation.','wpt_pro');?>
                            <br><?php esc_html_e('And if enable Variation product, Some column and feature will be disable. such: Attribute, category, tag Column, Advernce Search box.','wpt_pro');?>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    <?php
}

add_action('wpto_admin_basic_tab_bottom' , 'wpto_admin_basic_tab_var_simple');