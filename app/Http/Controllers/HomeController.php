<?php

namespace App\Http\Controllers;

use App\Models\FastMovingPartner;
use App\Models\Image2vexpress;
use App\Models\messageCustomer;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCatHome;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $page = Page::find(8);
        $post_cat_homes = PostCatHome::all();
        $listImage2vexpress = Image2vexpress::where('status','=','public')->orderBy('order','ASC')->get();
        $listFastMoving = FastMovingPartner::where('status','=','public')->orderBy('order','ASC')->get();
        $listMessageCustomer = messageCustomer::where('status','=','public')->orderBy('order','ASC')->get();
        $sliders = Slider::where('status','=','public')->orderBy('order','ASC')->get();
        $listPost = Post::limit(3)->get();
        return view('client.home.home' , compact('page','sliders','post_cat_homes','listImage2vexpress','listFastMoving','listMessageCustomer','listPost'));
    }
}
