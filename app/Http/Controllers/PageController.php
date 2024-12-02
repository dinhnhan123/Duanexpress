<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PostCatHome;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function detail($slug){
        $post_cat_homes = PostCatHome::all();
        $page = Page::where('slug', $slug)->first();
        return view('client.page.detail',compact('page','post_cat_homes'));
    }
}
