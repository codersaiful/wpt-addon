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

$sentence = "Flachbeutel / Säcke 0,050 mm 80 x 120 x 0,050";
$pattern = "/mm (\d+)/"; // Regular expression pattern to match "mm" followed by digits

preg_match($pattern, $sentence, $matches); // Match the pattern in the sentence

if (!empty($matches)) {
    $number = $matches[1]; // Get the number captured in the first capturing group
    echo $number; // Output: 80
}
