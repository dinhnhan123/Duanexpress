<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\PostCatHome;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    function list(){
        $page = Page::find(8);
        $post_cat_homes = PostCatHome::all();
        $list_posts = Post::paginate(9);
        return view('client.post.list',compact('page','list_posts','post_cat_homes'));
    }
    function detail($slug){
        $post = Post::where('post_slug',$slug)->first();
        $post_cat_homes = PostCatHome::all();
        $page = Page::find(8);
        return view('client.post.detail',compact('post','page','post_cat_homes'));
    }
}
