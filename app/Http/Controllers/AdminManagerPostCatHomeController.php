<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\PostCat;
use App\Models\PostCatHome;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminManagerPostCatHomeController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'PostCatHome']);
            return $next($request);
        });
    }
    //add
    public function add()
    {
        $list_category = PostCatHome::all();
        $list_category = data_tree($list_category);
        return view('admin.postCatHome.add',compact('list_category'));
    }
    //list
    function list(Request $request)
    {
        $status = $request->input('status');
        $keyword = "";
        $list_act = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',

        ];
        //public
        if ($status == "public") {
            $listPostCatHome = PostCatHome::where('category_status', '=', 'public')->get();
        } elseif ($status == "pending") {
            $listPostCatHome = PostCatHome::where('category_status', '=', 'pending')->get();
        } elseif ($status == "trash") {
            $list_act = [
                'restore' => 'Khôi phục'
            ];
            $listPostCatHome = PostCatHome::onlyTrashed()->get();
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $listPostCatHome = PostCatHome::where('category_name', 'LIKE', "%{$keyword}%")->get();
            if (empty($keyword)) {
                $listPostCatHome = data_tree($listPostCatHome);
            }
        }


        $count_post_cat_all = PostCatHome::count();
        $count_post_cat_public = PostCatHome::where('category_status', '=', 'public')->count();
        $count_post_cat_pending = PostCatHome::where('category_status', '=', 'pending')->count();
        $count_post_cat_trash = PostCatHome::onlyTrashed()->count();
        $count = [
            $count_post_cat_all,
            $count_post_cat_public,
            $count_post_cat_pending,
            $count_post_cat_trash
        ];

        return view('admin.postCatHome.list', compact('listPostCatHome', 'count', 'keyword', 'list_act', 'status'));
    }
    
    //process form 
    function store(Request $request)
    {
        if ($request->input('btn-add')) { //nếu như nó tồn tại và có giá trị 
            $request->validate(
                [
                     'post_title' => 'required|string|max:255',
                    'category_name' => 'required|string|max:255',
                    'category_slug' => 'required|string|max:255',
                    'category_content' => 'required',
                    'category_status' => 'required|in:public,pending'
                ],

                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài ký tự tối đa :max ký tự'
                ],
                [
                    'category_name' => 'Tên danh mục',
                    'category_slug' => 'Link thân thiện',
                    'category_status' => 'Trạng thái danh mục',
                    'category_content' => 'Nội dung danh mục',
                    'post_title' => 'Tên bài viết danh mục'
                ]
            );
            $image_id_postCatHome = null;
            if ($request->input('image_id_postCatHome')) {
                $image_id_postCatHome = $request->input('image_id_postCatHome');
            }
            $parent_id = $request->input('category_parent');
            if (empty($parent_id)) {
                $parent_id = 0;
            }
            PostCatHome::create([
                'post_title' => $request->input('post_title'),
                'category_name' => $request->input('category_name'),
                'category_slug' =>  Str::slug($request->input('category_slug')),
                'category_status' => $request->input('category_status'),
                'category_content' => $request->input('category_content'),
                'image_id' => $image_id_postCatHome,
                'parent_id' => $parent_id,
                'user_id' => Auth::id()
            ]);

              return redirect('admin/PostCatHome/list')->with(['status' => 'Thêm danh mục thành công']);
        }
    }
    //action 
    function action(Request $request){
        $list_check = $request->input('list_check');
        $act = $request->input('act');
       if(!empty($list_check)){
        if(!empty($act)){
            if ($act == "public") {
                $success = PostCatHome::whereIn('id', $list_check)
                    ->update(['category_status' => 'public']);
                if ($success > 0) {
                    return redirect('admin/PostCatHome/list')->with(['status' => 'Bạn đã cập nhập trạng thái công khai thành công']);
                }
            }
            if ($act == "pending") {
                $success = PostCatHome::whereIn('id', $list_check)
                    ->update(['category_status' => 'pending']);
                if ($success > 0) {
                    return redirect('admin/PostCatHome/list')->with(['status' => 'Bạn đã cập nhập trạng thái công khai thành công']);
                }
            }
            if ($act == "restore") {
                $success = PostCatHome::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                if ($success > 0) {
                    return redirect('admin/PostCatHome/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                }
            }

        }else{
            return redirect('admin/PostCatHome/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
        }
       }else{
        return redirect('admin/PostCatHome/list')->with(['status' => 'Bạn vui lòng chọn phần tử cần thực thi']);
       }
    }

    //end action

    function delete(Request $request, $id){
        if ($request->input('status') == "trash") {
            $PostCatHome = PostCatHome::withTrashed()->where('id', $id)->first();
            $image_id = $PostCatHome->image_id;
            if(!empty($image_id)){
                $image_url = $PostCatHome->image->image_url;
                $PostCatHome->forceDelete();
                Image::find($image_id)->delete();
                $file_path = public_path($image_url);
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }
            }else{
                $PostCatHome->forceDelete();
            }
           
            return redirect('admin/PostCatHome/list')->with(['status' => 'Bạn đã xóa bản ghi vĩnh viễn thành công']);
        }else{
            $list_category = PostCatHome::all();
            $category = PostCatHome::find($id);
           
            $check_has_child = check_has_child($list_category, $category->id);
            if(!$check_has_child){
                $success = PostCatHome::withTrashed()
                ->find($id)
                ->delete();
            if ($success > 0) {
                return redirect('admin/PostCatHome/list')->with(['status' => 'Bạn đã xóa bản ghi tạm thời thành công']);
            }
            }else{
                return redirect('admin/PostCatHome/list')->with(['status' => 'Vui lòng xóa con trước khi xóa cha']);
            }
           
        }
    }

    //edit 
    function edit($id){
        $list_category = PostCatHome::all();
        $list_category = data_tree($list_category);
        $PostCatHome = PostCatHome::find($id);
        return view('admin.postCatHome.edit', compact('PostCatHome', 'list_category'));
    }

    //process edit 
    function editStore(Request $request, $id){
        if ($request->input('btn-edit')) {
            $request->validate(
                [
                     'post_title' => 'required|string|max:255',
                    'category_name' => 'required|string|max:255',
                    'category_slug' => 'required|string|max:255',
                    'category_content' => 'required',
                    'category_status' => 'required|in:public,pending'
                ],

                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài ký tự tối đa :max ký tự'
                ],
                [
                    'category_name' => 'Tên danh mục',
                    'category_slug' => 'Link thân thiện',
                    'category_status' => 'Trạng thái danh mục',
                    'category_content' => 'Nội dung danh mục',
                    'post_title' => 'Tên bài viết danh mục'
                ]
            );
            
            $parent_id = $request->input('category_parent');
            if (empty($parent_id)) {
                $parent_id = 0;
            }
            PostCatHome::where('id', $id)->update([
                'post_title' => $request->input('post_title'),
                'category_name' => $request->input('category_name'),
                'category_slug' =>  Str::slug($request->input('category_slug')),
                'category_status' => $request->input('category_status'),
                'category_content' => $request->input('category_content'),
                'parent_id' => $parent_id,
                'user_id' => Auth::id()
            ]);

              return redirect('admin/PostCatHome/list')->with(['status' => 'Chỉnh sửa danh mục thành công']);
        
        }
    }

}
