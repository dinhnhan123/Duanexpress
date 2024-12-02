<?php

use App\Models\PostCat;
use App\Models\PostCatHome;

if(!function_exists('getSubCategories') && !function_exists('hasCatChild')){
    
    function hasCatChild($category_id, $data){
        foreach($data as $category){
            if($category->parent_id == $category_id) return true;
        }
        return false;
    }
    function getSubCategories($category_id, $data ,$isFirstCatId = false){
        $subCategories = [];
        if($isFirstCatId){
            $subCategories[] = $category_id;
        }
       
        foreach($data as $category){
            if($category->parent_id == $category_id){
                $subCategories[] = $category->id;
                if(hasCatChild($category->id,$data)){
                    $catChild = getSubCategories($category->id, $data,true);
                    $subCategories = array_merge($subCategories,$catChild );
                }
            }
        }
        return $subCategories;
      
    }
    function getListPostCatHomeById($category_id){
        $post_cat_homes = PostCatHome::all();
        $list_sub_category_id = [];
        if($post_cat_homes){
            foreach($post_cat_homes as $category){
                if($category->parent_id == $category_id){
                    $list_sub_category_id = getSubCategories($category->id,$post_cat_homes);
                }
            }
            $list_post_cat_home = PostCatHome::whereIn('id',$list_sub_category_id)->get();
            return $list_post_cat_home;
        }
    }
    function checkHasChildPostCatHome($category_id){
        $category = PostCatHome::where('parent_id',$category_id)->first();
        return $category->id;
    }
    function getListPostCatHome($category_id) {
        $post_cat_homes = PostCatHome::all();
        $list_cat_id = [];
        foreach($post_cat_homes as $post_cat) {
            if($post_cat->parent_id == $category_id) {
                $list_cat_id[] = $post_cat->id;
            }
        }
        $list_post_cat_home = PostCatHome::whereIn('id', $list_cat_id)->get();
        return $list_post_cat_home;
    }
    
}

?>