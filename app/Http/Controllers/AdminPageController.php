<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    function __construct()
    {
        $this -> middleware(function($request,$next){
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    //add
    function add(){
       return view('admin.page.add');
    }
    //store
    function store(Request $request){
       if($request->input('btn-add')){//nếu người dùng đã submit thì mình mới làm việc
        $request->validate(
            [
                'page_name' => 'required|string|max:255',
                'page_slug' => 'required|string|max:255',
                'page_desc' => 'required|string',
                'page_content' => 'required|string',
                'page_status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa là :max ký tự'
            ],
            [
                'page_name'=>'Tiêu đề trang',
                'page_slug'=>'Link thân thiện',
                'page_content' => 'Nội dung trang',
                'page_status' => 'Trạng thái trang',
                'page_desc' => 'Mô tả'
            ]
            );
            Page::create([
                'title' => $request->input(['page_name']),
                'slug' => Str::slug($request->input('page_slug')),
                'desc' => $request->input('page_desc'),
                'content' => $request->input('page_content'),
                'status' => $request->input('page_status'),
                'user_id' => Auth::id()
            ]);

            return redirect('admin/page/list')->with(['status' => 'Đã thêm bài viết thành công']);

        
       }    

       
    }
    function list(Request $request){
        $keyword = "";
        $status = "";
        if(!empty($request->input('status'))){
            $status = $request->input('status');
        }
            $list_act = [
                'public' => 'Công khai',
                'pending' => 'Chờ duyệt',
                'temporary_deletion' => 'Xóa tạm thời'
            ];
            if($status == "public"){
                $pages = Page::where('status', '=' ,'public')->paginate(10);
            }elseif($status == "pending"){
                $pages = Page::where('status', '=' ,'pending')->paginate(10);
            }elseif($status == "trash"){
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $pages = Page::onlyTrashed()->paginate(10);
            }else{
                if(!empty($request->input('keyword'))){//nếu có gisá trị
                    $keyword = $request->input('keyword');
                }
                $pages = Page::where('title','LIKE',"%{$keyword}%")->paginate(10);
            }
        $count_page_all = Page::count();
        $count_page_public = Page::where('status', '=' , 'public')->count();
        $count_page_pending = Page::where('status', '=', 'pending')->count();
        $count_page_trash = Page::onlyTrashed()->count();
        $counts = [$count_page_all,$count_page_public, $count_page_pending,$count_page_trash];
        return view('admin.page.list',compact('pages','counts','list_act','keyword','status'));
    }

    //delete page
    function delete(Request $request, $id){
        if($request->input('status')){
            $page = Page::withTrashed()->find($id);
            $success = $page->forceDelete();
            if($success){ //nếu xóa thành công 
                return redirect('admin/page/list')->with(['status' => 'Xóa trang vĩnh viễn thành công']);
             }
        }else{
            $page = Page::find($id);
            $success = $page->delete();
            if($success){ //nếu xóa thành công 
               return redirect('admin/page/list')->with(['status' => 'Xóa trang tạm thời thành công']);
            }
        }
        
        
    }
    //action page
    function action(Request $request){
        $list_check =  $request->input('list_check');
        $act = $request->input('act');
        if(!empty($list_check)){
            if(!empty($act)){
                //public
                if($act == "public"){
                    $success = Page::whereIn('id',$list_check)
                    ->update(['status'=> $act]);
                    if($success>0){//nếu số bản ghi cập nhập lớn hơn 0 thì thực thi
                        return redirect('admin/page/list')->with(['status' => 'Bạn đã cập nhập trạng thái công khai thành công']);
                    }
                }
                //pending
                if($act == "pending"){
                    $success = Page::whereIn('id',$list_check)
                    ->update(['status'=> $act]);
                    if($success>0){//nếu số bản ghi cập nhập lớn hơn 0 thì thực thi
                        return redirect('admin/page/list')->with(['status' => 'Bạn đã cập nhập trạng thái chờ duyệt thành công']);
                    }
                }
                //temporary deletion : xóa tạm thời
                if($act == "temporary_deletion"){
                    $success = Page::destroy($list_check);
                    if($success>0){//nếu số bản ghi xóa lớn hơn 0 thì thực thi
                        return redirect('admin/page/list')->with(['status' => 'Bạn đã xóa tạm thời bản ghi thành công']);
                    }
                }
                //restore: khôi phục 
                if($act == "restore"){
                    $success = Page::withTrashed()
                                ->whereIn('id', $list_check)
                                ->restore();
                    if($success>0){
                        return redirect('admin/page/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                    }
                }

                //forceDelete : Xóa vĩnh viễn
                if($act == "forceDelete"){
                    $success = Page::withTrashed()
                            ->whereIn('id',$list_check)
                            ->forceDelete();
                    if($success>0){
                        return redirect('admin/page/list')->with(['status' => 'Bạn đã xóa vĩnh viễn bản ghi thành công']);
                    }
                }

            }else{
                return redirect('admin/page/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
            }
        }else{
            return redirect('admin/page/list')->with(['status' => 'Bạn vui lòng chọn phần tử cần thực thi']);
        }
    }

    //edit page
    function edit($id){
        $page = Page::find($id);
        return view('admin.page.edit',compact('page'));
    }
    //xử lý form khi edit 
    function update(Request $request , $id){
        $request->validate(
            [
                'page_name' => 'required|string|max:255',
                'page_slug' => 'required|string|max:255',
                'page_content' => 'required|string',
                'page_desc' => 'required|string',
                'page_status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa là :max ký tự'
            ],
            [
                'page_name'=>'Tiêu đề trang',
                'page_slug'=>'Link thân thiện',
                'page_content' => 'Nội dung trang',
                'page_status' => 'Trạng thái trang',
                'page_desc' => 'Mô tả'
            ]
            );

            Page::where('id',$id)->update([
                'title' => $request->input(['page_name']),
                'slug' => Str::slug($request->input('page_slug')),
                'desc' => $request->input('page_desc'),
                'content' => $request->input('page_content'),
                'status' => $request->input('page_status')
            ]);

            return redirect('admin/page/list')->with(['status' => 'Bạn đã chỉnh sửa trang thành công']);
    }

}
