<?php 
/**
 * All important functon will stay here.
 */

 function codeAstrology_set_default_qty(){
	return 0;
}
add_filter("woocommerce_quantity_input_min","codeAstrology_set_default_qty");