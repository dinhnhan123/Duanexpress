<?php
if(!function_exists('check_has_child')){
    function check_has_child($data,$category_id){
        foreach($data as $v){
            if($v->parent_id == $category_id) return true;
        }
        return false;
    }

}
?>