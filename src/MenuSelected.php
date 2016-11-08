<?php

/**
*
* @author  Antonio de la Rosa <webmaster@web-t-sys.com>
* @file
* @package ExtraUtils/Menus
*
*
*/

namespace PhangoApp\PhaUtils;

use PhangoApp\PhaView\View;

class MenuSelected {

    static public function menu_selected($activation, $arr_op, $type=0)
    {

        return View::load_view(array($activation, $arr_op, $type), 'common/utils/menuselected');

    }
    
}

?>
