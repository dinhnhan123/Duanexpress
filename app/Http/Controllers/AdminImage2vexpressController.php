<?php

namespace App\Http\Controllers;

use App\Models\Image2vexpress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class AdminImage2vexpressController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'Image2vexpress']);
            return $next($request);
        });
    }

    function add()
    {
        return view('admin.image2vexpress.add');
    }

    //xử lý form add image
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
                    'name' => 'Tên ảnh',
                    'slug' => 'Link thân thiện',
                    'order' => 'Thứ tự',
                    'status' => 'Trạng thái'
                ]

            );
            if($request->input('image_id_imageV2express')){
                $image_id_imageV2express = $request->input('image_id_imageV2express');
            }
            $Image2Vexpress = Image2vexpress::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('slug')),
                'url' => $request->input('url'),
                'description' => $request->input('description'),
                'order' => $request->input('order'),
                'status' => $request->input('status'),
                'user_id' => Auth::id(),
                'image_id' =>  $image_id_imageV2express

            ]);
            return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã thêm ảnh thành công']);
        }
    }

    //end form image
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
           $sliders = Image2vexpress::where('status','=',$status)->paginate(10);
        }elseif($status == "pending"){
            $sliders = Image2vexpress::where('status','=',$status)->paginate(10);
        }elseif($status == "trash"){
            $list_act = [
                'restore' => 'Khôi phục'
            ];
            $sliders = Image2vexpress::onlyTrashed()->paginate(10);
        }else{
            if($request->input('keyword')){
                $keyword =  $request->input('keyword');
             }
            $sliders = Image2vexpress::where('name','LIKE',"%{$keyword}%")
                        ->orderBy('order')
                        ->paginate(10);
        }
        

        $count_slider_all = Image2vexpress::count();
        $count_slider_public = Image2vexpress::where('status','=','public')->count();
        $count_slider_pending = Image2vexpress::where('status','=','pending')->count();
        $count_slider_trash = Image2vexpress::onlyTrashed()->count();
        $count = [
            $count_slider_all,
            $count_slider_public,
            $count_slider_pending,
            $count_slider_trash
        ];
        return view('admin.image2vexpress.list',compact('sliders','count','list_act','status'));
    }
     //action 
     function action(Request $request){
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if(!empty($list_check)){
            if(!empty($act)){
                //public
                if($act == "public"){
                    $success =  Image2vexpress::whereIn('id',$list_check)
                            ->update([
                                'status' => $act
                            ]);
                    if($success>0){
                        return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //pending
                if($act == "pending"){
                    $success =  Image2vexpress::whereIn('id',$list_check)
                            ->update([
                                'status' => $act
                            ]);
                    if($success>0){
                        return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //temporary_deletion
                if($act == "temporary_deletion"){
                    $success = Image2vexpress::destroy($list_check);
                    if($success > 0 ){
                        return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã xóa tạm thời thành công']);
                    }
                }
                if($act == "restore"){
                    $success = Image2vexpress::withTrashed()
                    ->whereIn('id',$list_check)
                    ->restore();
                    if($success > 0 ){
                        return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                    }
                }
            }else{
                return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
            }
        }else{
            return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn vui lòng chọn phần tử cẩn thực thi']);
        }
    }
    //delete
    function delete(Request $request, $id){
        if($request->input('status') == "trash"){
            $slider = Image2vexpress::withTrashed()->find($id);
            $image_url = $slider->image->image_url;
            $file_path = public_path($image_url);
            $success = $slider->image->delete();
            if($success>0){
                if(File::exists($file_path)){
                    File::delete($file_path);
                }
                return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã xóa bản ghi vĩnh viễn thành công']);
            }
        }else{
            $slider = Image2vexpress::find($id);
            $success = $slider->delete();
            if($success > 0){
             return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã xóa bản ghi tạm thời thành công']);
            }
        }
       
    }  
    //edit 
    function edit($id){
        $slider = Image2vexpress::find($id);
        return view('admin.Image2vexpress.edit',compact('slider'));
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
                    'name' => 'Tên ảnh',
                    'slug' => 'Link thân thiện',
                    'order' => 'Thứ tự',
                    'status' => 'Trạng thái'
                ]

            );
            Image2vexpress::where('id',$id)
                    ->update([
                        'name' => $request->input('name'),
                        'slug' => Str::slug($request->input('slug')),
                        'url' => $request->input('url'),
                        'description' => $request->input('description'),
                        'order' => $request->input('order'),
                        'status' => $request->input('status')
                    ]);
        }
            return redirect('admin/Image2vexpress/list')->with(['status' => 'Bạn đã cập nhập bản ghi thành công']);
    }
}
