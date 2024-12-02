<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PostCatHome;
use Illuminate\Http\Request;

class PostCatHomeController extends Controller
{
    //
    function detail($slug){
        $post_cat_homes = PostCatHome::all();
        $post_cat_home = PostCatHome::where('category_slug',$slug)->first();
        $page = Page::find(8);
        return view('client.postCatHome.detail',compact('post_cat_home','post_cat_homes','page'));
    }
}
