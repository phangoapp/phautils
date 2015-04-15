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
	
	/**
	* This function is used to clean up the text of undesirable elements
	* @param string $text Text to clean
	* @param string $br Boolean variable used for control if you want br tags or \n symbon on input text
	*/

	static public function form_text( $text ,$br=1)
	{

	settype( $text, "string" );

	$text = trim( $text );

	$arr_tags=array('/</', '/>/', '/"/', '/\'/', "/  /");
	$arr_entities=array('&lt;', '&gt;', '&quot;', '&#39;', '&nbsp;');
		
	if($br==1)
	{

		$text = preg_replace($arr_tags, $arr_entities, $text);
		
		$arr_text = explode("\n\r\n", $text);

		$c=count($arr_text);

		if($c>1)
		{
			for($x=0;$x<$c;$x++)
			{

				$arr_text[$x]='<p>'.trim($arr_text[$x]).'&nbsp;</p>';

			}
		}


		$text=implode('', $arr_text);

		$arr_text = explode("\n", $text);

		$c=count($arr_text);

		if($c>1)
		{
			for($x=0;$x<$c;$x++)
			{

				$arr_text[$x]=trim($arr_text[$x]).'<br />';

			}
		}

		$text=implode('', $arr_text);
		
	}
	
		
	$text = Utils::make_slashes( $text );
	
	return $text;
	
	}
	
	/**
	* Function used for add slashes from _POST and _GET variables.
	*
	*
	* @param string $string String for add slashes
	*/

	static public function make_slashes( $string )
	{
		return addslashes( $string );
	} 

	/**
	* Function used for strip slashes from _POST and _GET variables.
	*
	*
	* @param string $string String for strip slashes
	*/

	static public function unmake_slashes( $string )
	{
		return stripslashes( $string );
	}

	
}

?>
