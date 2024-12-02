<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminSliderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    function add()
    {
        return view('admin.slider.add');
    }
    //xử lý form add slider
    function store(Request $request)
    {
        if ($request->input('btn-add')) {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255',
                    'order' => 'required',
                    'status' => 'required|in:public,pending'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có ký tự tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tên slider',
                    'slug' => 'Link thân thiện',
                    'order' => 'Thứ tự',
                    'status' => 'Trạng thái'
                ]

            );
            if($request->input('image_id_slider')){
                $image_id_slider = $request->input('image_id_slider');
            }
            $slider = Slider::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('slug')),
                'url' => $request->input('url'),
                'description' => $request->input('description'),
                'order' => $request->input('order'),
                'status' => $request->input('status'),
                'user_id' => Auth::id(),
                'image_id' =>  $image_id_slider

            ]);
            return redirect('admin/slider/list')->with(['status' => 'Bạn đã thêm slider thành công']);
        }
    }
    //list slider
    function list(Request $request){
        $keyword = "";
        $status = "";
        $list_act = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',
            'temporary_deletion' => 'Xóa tạm thời'
        ];
        if($request->input('status')){
            $status = $request->input('status');
        }
        
        if($status == "public"){
           $sliders = Slider::where('status','=',$status)->paginate(10);
        }elseif($status == "pending"){
            $sliders = Slider::where('status','=',$status)->paginate(10);
        }elseif($status == "trash"){
            $list_act = [
                'restore' => 'Khôi phục'
            ];
            $sliders = Slider::onlyTrashed()->paginate(10);
        }else{
            if($request->input('keyword')){
                $keyword =  $request->input('keyword');
             }
            $sliders = Slider::where('name','LIKE',"%{$keyword}%")
                        ->orderBy('order')
                        ->paginate(10);
        }
        

        $count_slider_all = Slider::count();
        $count_slider_public = Slider::where('status','=','public')->count();
        $count_slider_pending = Slider::where('status','=','pending')->count();
        $count_slider_trash = Slider::onlyTrashed()->count();
        $count = [
            $count_slider_all,
            $count_slider_public,
            $count_slider_pending,
            $count_slider_trash
        ];
        return view('admin.slider.list',compact('sliders','count','list_act','status'));
    }
    //action 
    function action(Request $request){
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if(!empty($list_check)){
            if(!empty($act)){
                //public
                if($act == "public"){
                    $success =  Slider::whereIn('id',$list_check)
                            ->update([
                                'status' => $act
                            ]);
                    if($success>0){
                        return redirect('admin/slider/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //pending
                if($act == "pending"){
                    $success =  Slider::whereIn('id',$list_check)
                            ->update([
                                'status' => $act
                            ]);
                    if($success>0){
                        return redirect('admin/slider/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //temporary_deletion
                if($act == "temporary_deletion"){
                    $success = Slider::destroy($list_check);
                    if($success > 0 ){
                        return redirect('admin/slider/list')->with(['status' => 'Bạn đã xóa tạm thời thành công']);
                    }
                }
                if($act == "restore"){
                    $success = Slider::withTrashed()
                    ->whereIn('id',$list_check)
                    ->restore();
                    if($success > 0 ){
                        return redirect('admin/slider/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                    }
                }
            }else{
                return redirect('admin/slider/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
            }
        }else{
            return redirect('admin/slider/list')->with(['status' => 'Bạn vui lòng chọn phần tử cẩn thực thi']);
        }
    }
    //delete
    function delete(Request $request, $id){
        if($request->input('status') == "trash"){
            $slider = Slider::withTrashed()->find($id);
            $image_url = $slider->image->image_url;
            $file_path = public_path($image_url);
            $success = $slider->image->delete();
            if($success>0){
                if(File::exists($file_path)){
                    File::delete($file_path);
                }
                return redirect('admin/slider/list')->with(['status' => 'Bạn đã xóa bản ghi vĩnh viễn thành công']);
            }
        }else{
            $slider = Slider::find($id);
            $success = $slider->delete();
            if($success > 0){
             return redirect('admin/slider/list')->with(['status' => 'Bạn đã xóa bản ghi tạm thời thành công']);
            }
        }
       
    }  
    //edit 
    function edit($id){
        $slider = Slider::find($id);
        return view('admin.slider.edit',compact('slider'));
    } 
    //xử lý form '
    function update(Request $request ,$id){
        if($request->input('btn-edit')){
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255',
                    'order' => 'required',
                    'status' => 'required|in:public,pending'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có ký tự tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tên slider',
                    'slug' => 'Link thân thiện',
                    'order' => 'Thứ tự',
                    'status' => 'Trạng thái'
                ]

            );
            Slider::where('id',$id)
                    ->update([
                        'name' => $request->input('name'),
                        'slug' => Str::slug($request->input('slug')),
                        'url' => $request->input('url'),
                        'description' => $request->input('description'),
                        'order' => $request->input('order'),
                        'status' => $request->input('status')
                    ]);
        }
            return redirect('admin/slider/list')->with(['status' => 'Bạn đã cập nhập bản ghi thành công']);
    }
}
