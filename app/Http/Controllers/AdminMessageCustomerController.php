<?php

namespace App\Http\Controllers;
use App\Models\messageCustomer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminMessageCustomerController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'MessageCustomer']);
            return $next($request);
        });
    }
      //add
      function add()
      {
          return view('admin.messageCustomer.add');
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
            if ($request->input('image_id_messageCusomer')) {
                $image_id_MessageCustomer = $request->input('image_id_messageCusomer');
            }
            $messageCustomer = messageCustomer::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('slug')),
                'url' => $request->input('url'),
                'description' => $request->input('description'),
                'order' => $request->input('order'),
                'status' => $request->input('status'),
                'user_id' => Auth::id(),
                'image_id' =>  $image_id_MessageCustomer

            ]);
            return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã thêm ảnh thành công']);
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
           $sliders = messageCustomer::where('status','=',$status)->paginate(10);
        }elseif($status == "pending"){
            $sliders = messageCustomer::where('status','=',$status)->paginate(10);
        }elseif($status == "trash"){
            $list_act = [
                'restore' => 'Khôi phục'
            ];
            $sliders = messageCustomer::onlyTrashed()->paginate(10);
        }else{
            if($request->input('keyword')){
                $keyword =  $request->input('keyword');
             }
            $sliders = messageCustomer::where('name','LIKE',"%{$keyword}%")
                        ->orderBy('order')
                        ->paginate(10);
        }
        

        $count_slider_all = messageCustomer::count();
        $count_slider_public = messageCustomer::where('status','=','public')->count();
        $count_slider_pending = messageCustomer::where('status','=','pending')->count();
        $count_slider_trash = messageCustomer::onlyTrashed()->count();
        $count = [
            $count_slider_all,
            $count_slider_public,
            $count_slider_pending,
            $count_slider_trash
        ];
        return view('admin.messageCustomer.list',compact('sliders','count','list_act','status'));
    }

     //action 
     function action(Request $request){
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if(!empty($list_check)){
            if(!empty($act)){
                //public
                if($act == "public"){
                    $success =  messageCustomer::whereIn('id',$list_check)
                            ->update([
                                'status' => $act
                            ]);
                    if($success>0){
                        return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //pending
                if($act == "pending"){
                    $success =  messageCustomer::whereIn('id',$list_check)
                            ->update([
                                'status' => $act
                            ]);
                    if($success>0){
                        return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //temporary_deletion
                if($act == "temporary_deletion"){
                    $success = messageCustomer::destroy($list_check);
                    if($success > 0 ){
                        return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã xóa tạm thời thành công']);
                    }
                }
                if($act == "restore"){
                    $success = messageCustomer::withTrashed()
                    ->whereIn('id',$list_check)
                    ->restore();
                    if($success > 0 ){
                        return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                    }
                }
            }else{
                return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
            }
        }else{
            return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn vui lòng chọn phần tử cẩn thực thi']);
        }
    }

     //delete
     function delete(Request $request, $id){
        if($request->input('status') == "trash"){
            $slider = messageCustomer::withTrashed()->find($id);
            $image_url = $slider->image->image_url;
            $file_path = public_path($image_url);
            $success = $slider->image->delete();
            if($success>0){
                if(File::exists($file_path)){
                    File::delete($file_path);
                }
                return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã xóa bản ghi vĩnh viễn thành công']);
            }
        }else{
            $slider = messageCustomer::find($id);
            $success = $slider->delete();
            if($success > 0){
             return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã xóa bản ghi tạm thời thành công']);
            }
        }
       
    } 
    //edit 
    function edit($id){
        $slider = messageCustomer::find($id);
        return view('admin.messageCustomer.edit',compact('slider'));
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
            messageCustomer::where('id',$id)
                    ->update([
                        'name' => $request->input('name'),
                        'slug' => Str::slug($request->input('slug')),
                        'url' => $request->input('url'),
                        'description' => $request->input('description'),
                        'order' => $request->input('order'),
                        'status' => $request->input('status')
                    ]);
        }
            return redirect('admin/messageCustomer/list')->with(['status' => 'Bạn đã cập nhập bản ghi thành công']);
    }
}
