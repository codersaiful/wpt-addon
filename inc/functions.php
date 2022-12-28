<?php 
/**
 * All important functon will stay here.
 */
add_action('wpto_column_basic_form',function($keyword, $_device_name, $current_colum_settings, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data){
    $name = "column_settings{$_device_name}[$keyword][max]";
    $value = $column_settings[$keyword]['max'] ?? '';

    ?>
    <label>Form</label>
    <input type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
    <?php
}, 10, 8);

add_shortcode('jaccheTai','my_jacchetai');

function my_jacchetai( $atts ){
    ob_start();
    $amount = $atts['amount'] ?? 10;
    $col = $atts['col'] ?? '';
    if(empty($col)) return 'Please choos a col';
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $amount,
        'post_status' => 'publish',

    ];
    $query = new WP_Query( $args );

    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            $id = get_the_ID();
            $price = get_post_meta($id, '_price', true);
            if( $col == 'title' ){
                echo  "title: ". get_the_title();
            }else if( $col == 'price'){
                echo "price: " . $price;
            }
            echo '<br>';

        }
    }else{
        echo "kono product paua jayni";
    }
    return ob_get_clean();
}