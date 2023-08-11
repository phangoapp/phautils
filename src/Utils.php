<?php

namespace PhangoApp\PhaUtils;

use PhangoApp\PhaRouter\Routes;
use RandomLib;

/**
* Class with text utilities and more
*/

class Utils {
	
	/**
	* An array for cache loaded libraries
	*/
	
	static public $cache_libraries=array();
	
	static public $cache_config=array();
	
	static public $textbb_type='';

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

        /*$text=iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        $text=trim(preg_replace('~'.$replace_space.'+~', $replace_space, $text), '-');
        
        $text=preg_replace('~[^-\w]+~', '', $text);
        echo $text."\n";
        if (empty($text)) { 
            
            return ''; 
            
        }else {

            return iconv('us-ascii//TRANSLIT', 'utf-8', $text);   // utf8_encode($text); 
            
        }*/
        
        $from=iconv('utf-8', 'us-ascii//TRANSLIT', '¿?{}@~=^:´[]#*·');
		$to= iconv('utf-8', 'us-ascii//TRANSLIT', '---------------');
		
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
        
        //utf8_decode(urldecode($text));    
		
		$text=trim(str_replace(" ", $replace_space, $text));
        
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        $text=preg_replace('~[^-\w]+~', '', $text);
        
        //$text = strtr($text, $from, $to);
		
		//Used for pass base64 via GET that use upper, for example.
		
		if($respect_upper==0)
		{
		
			$text = strtolower($text);
			
		}

		return $text; //iconv('us-ascii//TRANSLIT', 'utf-8', $text); 

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
	
	/**
	* This function is used to clean up the text of undesirable html tags
	*
	* @param string $text Input text for clean undesirable html tags
	* @param array $allowedtags An array with allow tags on the text.
	*/

	static public function form_text_html( $text , $allowedtags=array())
	{

		settype( $text, "string" );
		
		//If no html editor \r\n=<p>

		/*$text=preg_replace("/<br.*?>/", "\n", $text);*/
		
		/*if(Utils::$textbb_type!='')
		{
			
			$text=str_replace("\r", '', $text);
			$text=str_replace("\n", '', $text);

		}
		else
		{

			//Make <p>

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

		}*/
		/*echo htmlentities($text);
		die;*/
			
		//Check tags

		//Bug : tags deleted ocuppied space.

		//First strip_tags

		$text = trim( $text );

		//Trim html

		/*$text=str_replace('&nbsp;', ' ', $text);

		while(preg_match('/<p>\s+<\/p>$/s', $text))
		{

			$text=preg_replace('/<p>\s+<\/p>$/s', '', $text);
		
		}*/

		//Now clean undesirable html tags
		
		if(count($allowedtags)>0)
		{

			$text=strip_tags($text, '<'.implode('><', array_keys($allowedtags)).'>' );
			
			$arr_tags=array('/</', '/>/', '/"/', '/\'/', "/  /");
			$arr_entities=array('&lt;', '&gt;', '&quot;', '&#39;', '&nbsp;');
			
			$text=preg_replace($arr_tags, $arr_entities, $text);
			
			$text=str_replace('  ', '&nbsp;&nbsp;', $text);
			
			$arr_tags_clean=array();
			$arr_tags_empty_clean=array();

			//Close tags. 

			//Filter tags

			$final_allowedtags=array();
			
			foreach($allowedtags as $tag => $parameters)
			{
				//If mark how recursive, make a loop

				settype($parameters['recursive'], 'integer');

				$c_count=0;
				$x=0;

				if($parameters['recursive']==1)
				{

					$c_count = substr_count( $text, '&lt;'.$tag.'&gt;');

				}
				
				for($x=0;$x<=$c_count;$x++)
				{

					$text=preg_replace($parameters['pattern'], $parameters['replace'], $text);
					
				}
				
				$pos_=strpos($tag, '_');
				
				if($pos_!==false)
				{

					$tag=substr($tag, 0, $pos_);

				}
				
				$final_allowedtags[]=$tag.'_tmp';

				//Destroy open tags.
				
				$arr_tags_clean[]='/&lt;(.*?)'.$tag.'(.*?)&gt;/';
				
				$arr_tags_empty_clean[]='';
				$arr_tags_empty_clean[]='';

			}
			
			$text=preg_replace($arr_tags_clean, $arr_tags_empty_clean, $text);
		}

		//With clean code, modify <tag_tmp
		
		$text=str_replace('_tmp', '', $text);
		
		//Close tags
		
		$text = Utils::unmake_slashes( $text );
		
		return $text;

	}
	
	/**
	* function for clean newlines
	* 
	* @param string $text Text to clean.
	*/

	static public function unform_text( $text )
	{

		$text = preg_replace( "/<p>(.*?)<\/p>/s", "$1\n\r\n", $text );
		$text = str_replace( "<br />", "", $text );

		return $text;

	}
	
	
	/**
	* A function for generate a rand token used on sessions.
	*
	*/

	static public function get_token($length_token=24)
	{

		$rand_prefix=Utils::generate_random_password($length_token);
		
		return $rand_prefix;

	}
	
	/**
	* Function used for generate a simple random password. Used RamdomLib from Ircmaxell
	*
	* @param string $length_pass A variable used for set the character's length the password. More length, password more secure
	*
	*/

	static public function generate_random_password($length_pass=32)
	{

		$x=0;
		$z=0;

		$abc=array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '*', '+', '!', '-', '_', '@', '#', '$');
		
		$factory=new RandomLib\Factory;
		
		$generator=$factory->getMediumStrengthGenerator();
		
		$password_final=$generator->generateString($length_pass, implode('', $abc));

		return $password_final;

	}
	
	
	/**
	* Load libraries, well, simply an alternative include
	*
	* Very important function used for load the functions and method necessaries on your projects. Is simple, you create a file php and put in a libraries folder. Use the name without php used in file and magically the file is loaded. You can use this function in many places, phango use a little cache for know who file is loaded.
	*
	* @param string $names The name of php file without .php extension. If you want specific many libraries you can use an array 
	* @param string $path The base path where search the library if is not in standard path. By default the path is on Utils::$base_path/libraries/ or Utils::$base_path/modules/$module/libraries/
	* @deprecated Use namespaces and composer instead.
	*/ 

	static public function load_libraries($names, $path='')
	{
		
		if(gettype($names)!='array')
		{
			
			$arr_names[]=$names;

		}
		else
		{
		
			$arr_names=&$names;
		
		}

		if($path=='')
		{

			$path=Routes::$base_path.'/vendor/'.Routes::$app.'/libraries/';

		}
		else
		{
			
			$path=Routes::$base_path.'/'.$path.'/';
            
		}
		
		
		foreach($arr_names as $library) 
		{
			

			if(!isset(Utils::$cache_libraries[$library]))
			{
			
				$old_path=$path;
				
				if(is_file($path.'/'.$library.'.php'))
				{
					include($path.$library.'.php');
					
					Utils::$cache_libraries[$library]=1;
					
				}
				else
				{
					//Libraries path
					
					$path=Routes::$base_path.'/libraries/';
					
					if(!include($path.$library.'.php')) 
					{
				
						
						die();
						
					}
					else
					{

						Utils::$cache_libraries[$library]=1;

					}
									
				}

			}

		}

		return true;

	}
	
	/**
	*  Simple function for replate real quotes for quote html entities.
	* 
	* @param string $text Text to clean.
	*/

	static public function replace_quote_text( $text )
	{

		$text = str_replace( "\"", "&quot;", $text );

		return $text;

	}
	
	/**
	* Internal function for set array values without keys inside $array_strip
	* 
	* @param array $array_strip The array with key values for set
	* @param array $array_source The array that i want fill with default values 
	*
	*/

	static public function filter_fields_array($array_strip, $array_source)
	{

		$array_final=array();
		
		if(count($array_strip)>0)
		{
			foreach($array_strip as $field_strip)
			{

				$array_final[$field_strip]=@$array_source[$field_strip];

			}

			return $array_final;

		}
		else
		{
		
			return $array_source;
		
		}
	}
	
	/**
	* Function used for show on stdout a csrf_token used by POST phango controllers for check if is a real POST from phango.
	*
	*/

	static public function set_csrf_key($name_token='csrf_token', $length_token=80)
	{
	
		/*if(!isset($_SESSION['csrf_token']))
		{*/

        $_SESSION['csrf_token']=Utils::get_token($length_token);

		//}

		return "\n".\PhangoApp\PhaModels\CoreForms::HiddenForm($name_token, '', $_SESSION['csrf_token'])."\n";

	}
	
    /**
	* Function used for show on stdout a csrf_token used by POST phango controllers for check if is a real POST from phango.
	*
	*/

	static public function generate_csrf_key($length_token=80)
	{
	
        $_SESSION['csrf_token']=Utils::get_token($length_token);
        
        return $_SESSION['csrf_token'];

	}
    
	/**
	* Function for load config for modules.
	*
	*
	* @param $name_config Name of the config file, optional. Normally load config.php file on folder config.
	* @param $path Path where search the config.
	*/
	
	static public function load_config($name_config, $path="./settings")
    {

        //load_libraries(array($name_config), PhangoVar::$base_path.'/modules/'.$module.'/config/');
        
        $file=$path.'/'.$name_config.'.php';
        
        if(is_file($file) && !isset(Utils::$cache_config[$file]))
        {
            include($file);
            
            Utils::$cache_config[$file]=1;
            
            return true;
        }
        else
        {
        
            return false;
        
        }
        
    }
	
	/**
	* Function for reload config.
	*
	* @warning WARNING, use this method only if you don't have any alternative
	*
	* @param $module Name of the module
	* @param $name_config Name of the config file, optional. Normally load config.php file on folder config.
	*/
    
	static public function reload_config($name_config, $path="./settings")
	{

		//load_libraries(array($name_config), PhangoVar::$base_path.'/modules/'.$module.'/config/');
		
		$file=$path.'/'.$name_config.'.php';
		
		if(is_file($file))
		{
			
			$cont_file_config=file_get_contents($file);
			
			$cont_file_config=str_replace('<?php', '', $cont_file_config);
			
			$cont_file_config=str_replace('?>', '', $cont_file_config);
			
			if(eval($cont_file_config)===FALSE)
			{
			
				throw new \Exception('Error: cannot reload the config file: '.$file);
			
			}
			
		}
		
	}
	
	/**
	* Method for wrap words of a string
	*
	* @param string $text The text to wrap
	* @param integer $num_words The number of words of returned text
	* @param string $text_explain The string used for show that the texts is more longer
	* @param boolean $yes_more_ever Boolean used for activate or disable $text_explain if the size of real string is the same of the new string
	*/
	
	static public function wrap_words($text, $num_words, $text_explain='...', $yes_more_ever=0)
    {

        $arr_text=explode(' ', $text);
        
        $final_text='';

        $total_num_text=count($arr_text);
        
        if($total_num_text<$num_words)
        {

            $num_words=$total_num_text;
            
            if($yes_more_ever==0)
            {
                $text_explain='';
            }

        }

        for($x=0;$x<$num_words;$x++)
        {

            $arr_final_text[]=$arr_text[$x];

        }

        return implode(' ', $arr_final_text).' '.$text_explain;

    }
    

}

?>
