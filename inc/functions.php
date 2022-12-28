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
    $my_id = $atts['id'] ?? 0;
    $posts_per_page = get_post_meta($my_id,'posts_per_page', true);
    $amount = $atts['amount'] ?? 10;
    $col = $atts['col'] ?? '';
    if(empty($col)) return 'Please choos a col';
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
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




// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Post Type', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Post Types', 'text_domain' ),
		'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Post Type', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'bari', $args );

}
add_action( 'init', 'custom_post_type', 0 );