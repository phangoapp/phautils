<?php

namespace PhaUtils;

/**
* Class with text utilities and more
*/

class Utils {

	/**
	* Function for normalize texts for use on urls or other things...
	*
	* This function is used for convert text in a format useful for cleaning and beauty urls or cleaning text
	*
	* @param string $text String for normalize
	* @param boolean $respect_upper If true or 1 respect uppercase, if false or 0 convert to lowercase the $text
	* @param string $replace Character used for replace text spaces.
	*
	*
	*/

	static public function slugify($text, $respect_upper=0, $replace_space='-', $replace_dot=0, $replace_barr=0)
	{

		$from='àáâãäåæçèéêëìíîïðòóôõöøùúûýþÿŕñÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÐÒÓÔÕÖØÙÚÛÝỲŸÞŔÑ¿?!¡()"|#*%,;+&$ºª<>`çÇ{}@~=^:´[]';
		$to=  'aaaaaaaceeeeiiiidoooooouuuybyrnAAAAAACEEEEIIIIDOOOOOOUUUYYYBRN---------------------------------';
		
		if($replace_dot==1)
		{
		
			$from.='.';
			$to.='-';
		
		}
		
		if($replace_barr==1)
		{
		
			$from.="/";
			$to.="-";
		
		}

		$text = utf8_decode(urldecode($text));    
		
		$text=trim(str_replace(" ", $replace_space, $text));
		
		$text = strtr($text, utf8_decode($from), $to);
		
		//Used for pass base64 via GET that use upper, for example.
		
		if($respect_upper==0)
		{
		
			$text = strtolower($text);
			
		}

		return utf8_encode($text); 

	}
	
}

?>
