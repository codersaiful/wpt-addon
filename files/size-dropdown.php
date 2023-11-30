<?php
$term_list = get_the_terms($id,'pa_size');
if(empty($term_list) || !is_array($term_list)) return;
$extraOption = 'Cut to size';
$cut_to_size_off = get_post_meta($id,'cut_to_size_off',true);

// var_dump($term_list);
?>

<select class="wpt-extra-size-column" data-product_id="<?php echo esc_attr($id); ?>">
<option value="">Choose</option>
<?php
foreach($term_list as $eachTerm){
?>
    <option value="<?php echo esc_attr($eachTerm->name); ?>"><?php echo esc_attr($eachTerm->name); ?></option>
<?php
}
if($cut_to_size_off !== 'off'){
?>
<option value="0"><?php echo esc_attr($extraOption); ?></option>
<?php
}

?>
    
</select>
