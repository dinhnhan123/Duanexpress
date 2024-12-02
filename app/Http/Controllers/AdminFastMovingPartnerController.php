<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FastMovingPartner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminFastMovingPartnerController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'fastMovingPartner']);
            return $next($request);
        });
    }
    //add
    function add()
    {
        return view('admin.fastMovingPartner.add');
    }
    //end add
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
            if ($request->input('image_id_fastMoving')) {
                $image_id_fastMoving = $request->input('image_id_fastMoving');
            }
            $FastMovingPartner = FastMovingPartner::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('slug')),
                'url' => $request->input('url'),
                'description' => $request->input('description'),
                'order' => $request->input('order'),
                'status' => $request->input('status'),
                'user_id' => Auth::id(),
                'image_id' =>  $image_id_fastMoving

            ]);
            return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã thêm ảnh thành công']);
        }
    }

    //end form image

    //list
    function list(Request $request)
    {
        $keyword = "";
        $status = "";
        $list_act = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',
            'temporary_deletion' => 'Xóa tạm thời'
        ];
        if ($request->input('status')) {
            $status = $request->input('status');
        }

        if ($status == "public") {
            $sliders = FastMovingPartner::where('status', '=', $status)->paginate(10);
        } elseif ($status == "pending") {
            $sliders = FastMovingPartner::where('status', '=', $status)->paginate(10);
        } elseif ($status == "trash") {
            $list_act = [
                'restore' => 'Khôi phục'
            ];
            $sliders = FastMovingPartner::onlyTrashed()->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword =  $request->input('keyword');
            }
            $sliders = FastMovingPartner::where('name', 'LIKE', "%{$keyword}%")
                ->orderBy('order')
                ->paginate(10);
        }


        $count_slider_all = FastMovingPartner::count();
        $count_slider_public = FastMovingPartner::where('status', '=', 'public')->count();
        $count_slider_pending = FastMovingPartner::where('status', '=', 'pending')->count();
        $count_slider_trash = FastMovingPartner::onlyTrashed()->count();
        $count = [
            $count_slider_all,
            $count_slider_public,
            $count_slider_pending,
            $count_slider_trash
        ];
        return view('admin.fastMovingPartner.list', compact('sliders', 'count', 'list_act', 'status'));
    }
    //end list
    //action 
    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if (!empty($list_check)) {
            if (!empty($act)) {
                //public
                if ($act == "public") {
                    $success =  FastMovingPartner::whereIn('id', $list_check)
                        ->update([
                            'status' => $act
                        ]);
                    if ($success > 0) {
                        return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //pending
                if ($act == "pending") {
                    $success =  FastMovingPartner::whereIn('id', $list_check)
                        ->update([
                            'status' => $act
                        ]);
                    if ($success > 0) {
                        return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã cập nhập trạng thái thành công']);
                    }
                }
                //temporary_deletion
                if ($act == "temporary_deletion") {
                    $success = FastMovingPartner::destroy($list_check);
                    if ($success > 0) {
                        return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã xóa tạm thời thành công']);
                    }
                }
                if ($act == "restore") {
                    $success = FastMovingPartner::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    if ($success > 0) {
                        return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                    }
                }
            } else {
                return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
            }
        } else {
            return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn vui lòng chọn phần tử cẩn thực thi']);
        }
    }
    //delete
    function delete(Request $request, $id)
    {
        if ($request->input('status') == "trash") {
            $slider = FastMovingPartner::withTrashed()->find($id);
            $image_url = $slider->image->image_url;
            $file_path = public_path($image_url);
            $success = $slider->image->delete();
            if ($success > 0) {
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }
                return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã xóa bản ghi vĩnh viễn thành công']);
            }
        } else {
            $slider = FastMovingPartner::find($id);
            $success = $slider->delete();
            if ($success > 0) {
                return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã xóa bản ghi tạm thời thành công']);
            }
        }
    }
    //end delete
    //edit 
    function edit($id){
        $slider = FastMovingPartner::find($id);
        return view('admin.fastMovingPartner.edit',compact('slider'));
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
            FastMovingPartner::where('id',$id)
                    ->update([
                        'name' => $request->input('name'),
                        'slug' => Str::slug($request->input('slug')),
                        'url' => $request->input('url'),
                        'description' => $request->input('description'),
                        'order' => $request->input('order'),
                        'status' => $request->input('status')
                    ]);
        }
            return redirect('admin/fastMovingPartner/list')->with(['status' => 'Bạn đã cập nhập bản ghi thành công']);
    }
}
