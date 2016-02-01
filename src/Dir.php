<?php

namespace PhangoApp\PhaUtils;

class Dir {

    static public 

    /**
    *
    * Method for search file types and make an operation
    * 
    */

    static public function ScanDir($directory, $type_file_callback='PhangoApp\PhaUtils\no_check', $success_file_callback='PhangoApp\PhaUtils\success', $fail_file_callback='PhangoApp\PhaUtils\fail')
    {
        
        $arr_dir=scandir($directory);
        
        foreach($arr_dir as $file)
        {
            
            $file_path=$directory.'/'.$file;
            
            if(is_dir($directory.'/'.$file))
            {
                
                Dir::ScanDir($file_path);
                
            }
            else
            {
                
                if(!$type_file_callback($file_path))
                {
                    
                    $fail_file_callback($file_path);
                    
                }
                else
                {
                    $success_file_callback($file_path);
                }
            }
            
        }
    
    }
    
    static public function no_check($file)
    {
        
        return true;
        
    }
    
    static public function sucess($file)
    {
        
        return true;
        
    }

    static public function fail($file)
    {
        
        return false;
        
    }

}



?>
