<?php

namespace PhangoApp\PhaUtils;

class Size {

    static public function format($size)
    {
    
        if($size==0)
        {
            return '0B';
        }
        
        $size_name=["b", "Kb", "Mb", "Gb", "Tb", "Pb", "Eb", "Zb", "Yb"];
        
        $i=floor(log($size,1024));
        
        settype($i, 'integer');
        
        $p=pow(1024,$i);
        $s=round($size/$p,2);
        
       return $s.' '.$size_name[$i];
    
    }

}

?>
