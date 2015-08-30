<?php

/**
*
* @author  Antonio de la Rosa <webmaster@web-t-sys.com>
* @file
* @package ExtraUtils/HtmlTable
*
*
*/
namespace PhangoApp\PhaUtils;
use PhangoApp\PhaView\View;

class SimpleTable {

    /**
    * Header for an simple table_config
    * @param array $fields This fields is a list with the titles of the tr cells.
    * @param array $cell_sizes An Array where you can define the width or other properties of the table with the format 'key' => ' width=25%'
    */

    static public function top_table_config($fields, $cell_sizes=array())
    {

        echo View::load_view(array($fields, $cell_sizes), 'common/tables/headtable');
    }

    /**
    * Function for make rows in a html table
    * @param array $fill The values for any row in the table.
    * @param array $cell_sizes An Array where you can define the width or other properties of the table with the format 'key' => ' width=25%'
    */

    static public function middle_table_config($fill, $cell_sizes=array())
    {
        echo View::load_view(array($fill, $cell_sizes), 'common/tables/middletable');
    }

    /**
    * Bottom of a html table
    *
    */

    static public function bottom_table_config()
    {
        echo View::load_view(array(), 'common/tables/bottomtable');
    }

    /**
    * Function  used for show pagination on a table.
    * @param string $pages A string from a pagination function
    * @param string $more data If you want add more data, fill this element.
    */

    static public function pages_table($pages, $more_data='')
    {
        
        echo View::load_view(array(), 'common/tables/pagestable');

    }

}

?>