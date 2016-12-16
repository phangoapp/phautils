<?php

namespace PhangoApp\PhaUtils;

use PhangoApp\PhaModels\Webmodel;
use PhangoApp\PhaI18n\I18n;
use PhangoApp\PhaView\View;

class MenuHierarchy {

    public $model_name;
    public $identifier_field;
    public $field_parent;

    public function __construct($name, $model, $identifier_field, $field_parent, $where=['WHERE 1=1', []])
    {
    
        $this->name=$name;
        
        $this->model=$model;
        
        $this->identifier_field=$identifier_field;
        
        $this->field_parent=$field_parent;
        
        $this->where=$where;
        
        $this->arr_select=[''];
    
    }
    
    public function show()
    {

        //Need here same thing that selectmodelform...
        
        //$arr_model=array($this->default_value);
        
        /*
        if($this->null_yes==1)
        {
        
            $this->arr_select[0]=I18n::lang('common', 'no_element_chosen', 'No element chosen');
        
        }*/
        
        $arr_elements=array();
        
        $query=$this->model->select([$this->model->idmodel, $this->identifier_field, $this->field_parent]);
        
        while($arr_field=$this->model->fetch_array($query))
        {
            
            $idparent=$arr_field[$this->field_parent];

            $element_model=$this->model->components[$this->identifier_field]->show_formatted($arr_field[ $this->identifier_field ]);

            $arr_elements[$idparent][]=array($element_model, $arr_field[ $this->model->idmodel ]);

        }
        
        /*$result='<ul id="'.$this->name.'0">';
        
        $result=$this->recursive_list_select($arr_elements, 0, $result, 1);
        
        $result.='</ul>';*/
        
        
        $result=View::load_view([$this->name, $arr_elements, 0, '', 1], 'common/utils/menuhierarchy');
        

        return $result;

    }

    public function recursive_list_select($arr_elements, $element_id, $result, $z)
    {
        
        if(isset($arr_elements[$element_id]))
        {
            
            
            foreach($arr_elements[$element_id] as $element)
            {
                //$arr_result[]=$element[1];
                
                $result.='<li>'.$element[0]."\n";
                
                if( isset($arr_elements[$element[1]] ) )
                {
                
                    $result.='<ul id="'.$this->name.$z.'">';

                    $result=$this->recursive_list_select($arr_elements, $element[1], $result, ($z+1));
                    
                    $result.='</ul>';

                }
                
                $result.='</li>'."\n";

            }

        }

        return $result;

    }

}

?>
