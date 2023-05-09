<?php 
/**
 * All important functon will stay here.
 */

if( !function_exists('dd') ){
	function dd($val){
		echo "<pre>";
			var_dump($val);
		echo "</pre>";
	 }
}

