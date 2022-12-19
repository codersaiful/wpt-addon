<?php 
$index = $keyword-1;
$product_var_id = $id;
$my_data = getSpecifcSetting($product_var_id);
$this_col_data = $my_data[$index] ?? [];
$price = $this_col_data['pricing_value'] ?? '';
if(!empty($price)){
    echo $price;
}