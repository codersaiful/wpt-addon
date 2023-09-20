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