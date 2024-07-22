<?php 
/**
 * All important functon will stay here.
 */

  /**
 * Only for developer
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
if( ! function_exists('dd') ){
	function dd( ...$vals){
		if( ! empty($vals) && is_array($vals) ){
			foreach($vals as $val ){
				echo "<pre>";
				    var_dump($val);
				echo "</pre>";
			}
		}
	}
}

function ccd_wpt_addon_sub_taxonomies() {
    
	$parent_term_id = $_POST['parent_cat_id'] ?? 0;

	if( empty($parent_term_id) || ! is_numeric( $parent_term_id )){
		echo 'error_founded';
		wp_die();
	}

	$taxonomy = 'product_cat';
	
	$sub_taxonomies = [];

    // Get the direct children of the parent term
    $child_terms = get_terms([
        'taxonomy' => $taxonomy,
        'parent'   => $parent_term_id,
        'hide_empty' => false, // Change to true if you want to hide empty terms
    ]);

	if(empty($child_terms)){
		echo 'no_subcategory';
		wp_die();
	}

	$options_html = '<option value="" selected="selected">Choose Sub Category</option>';
    // dd($parent_term_id);
    // Add the child terms to the sub_taxonomies array
    foreach ($child_terms as $child_term) {
		$term_id = $child_term->term_id;
		$name = $child_term->name;
        $sub_taxonomies[] = $child_term;
		$options_html .= "<option class='level-1' value='{$term_id}'>{$name}</option>";
        // // Recursively get sub-terms of the current child term
        // $sub_sub_taxonomies = get_all_sub_taxonomies($taxonomy, $child_term->term_id);
        // $sub_taxonomies = array_merge($sub_taxonomies, $sub_sub_taxonomies);
    }
	echo $options_html;
	wp_die();
    // return $sub_taxonomies;
}