<?php 
 if(!function_exists('has_child')){
    function has_child($data , $id){
        foreach($data as $v){
            if($v->parent_id == $id) return true;
        }
        return false;
    }
}
  if(!function_exists('data_tree')){
    function data_tree($data  , $parent_id = 0 , $level = 0){
        $result = array();
        foreach($data as $v){//$v là từng phần tử mảng
            if($v->parent_id == $parent_id){
                $v->level = $level;
                $result[] = $v;
                if(has_child($data , $v->id)){
                    $result_child = data_tree($data,$v->id,$level+1);
                    $result = array_merge($result,$result_child);
                }
            }
        }
        return $result;
    }
   }
?>