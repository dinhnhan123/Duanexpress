<?php

namespace App\Http\Controllers;

use App\Models\PostCat;
use App\Models\Post;
use App\Models\Image;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\returnSelf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\VarDumper\VarDumper;

class AdminPostController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    //Thêm bài viết
    function addPost()
    {
        $list_category = PostCat::all();
        $list_category = data_tree($list_category);
        return view('admin.post.addPost', compact('list_category'));
    }
    //Thêm danh mục bài viết
    function addCat()
    {
        $list_category = [];
        $initial_category_list = PostCat::all();
        foreach ($initial_category_list as $category) {
            if ($category->id != 2) {
                $list_category[] = $category;
            }
        }
        $list_category = data_tree($list_category);
        return view('admin.post.addCat', compact('list_category'));
    }
    //xử lý form khi add post 
    function store(Request $request)
    {
        if ($request->input('btn-add')) {
            $request->validate(
                [
                    'post_title' => 'required|string|max:255',
                    'post_slug' => 'required|string|max:255',
                    'post_content' => 'required|string',
                    'post_status' => 'required|in:public,pending',
                    'category_id' => 'required'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có ký tự tối đa là :max ký tự'
                ],
                [
                    'post_title' => "Tiêu đề",
                    'post_slug' => "Link thân thiện ",
                    'post_content' => "Nội dung",
                    'post_status' => "Trạng thái",
                    'category_id' => "Danh mục"
                ]
            );
            Post::create([
                'post_title' => $request->input('post_title'),
                'post_slug' => Str::slug($request->input('post_slug')),
                'content' => $request->input('post_content'),
                'post_status' => $request->input('post_status'),
                'category_id' => $request->input('category_id'),
                'image_id' => $request->input('image_id'),
                'user_id' => Auth::id(),
                'post_description' => $request->input('post_description')
            ]);

            return redirect('admin/post/list')->with((['status' => 'Thêm bài viết thành công']));
        }
    }
    //Danh sách bài viết
    function listPost(Request $request)
    {
        $list_act = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',
            'temporary_deletion' => 'Xóa tạm thời'
        ];
        $keyword = "";
        $status = "";
        if ($request->input('status')) {
            $status = $request->input('status');
        }

        //public
        if ($status == "public") {
            $list_posts = Post::where('post_status', '=', $status)->paginate(10);
        } elseif ($status == "pending") {
            $list_posts = Post::where('post_status', '=', $status)->paginate(10);
        } elseif ($status == 'trash') {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $list_posts = Post::onlyTrashed()->paginate(10);
        } else {
            if ($request->input('keyword')) { //nếu nó có giá trị thì gán 
                $keyword = $request->input('keyword');
            }
            $list_posts = Post::where('post_title', 'LIKE', "%{$keyword}%")->paginate(10);
        }



        $count_post_all = Post::count();
        $count_post_public = Post::where('post_status', '=', 'public')->count();
        $count_post_pending = Post::where('post_status', '=', 'pending')->count();
        $count_post_trash = Post::onlyTrashed()->count();
        $count = [$count_post_all, $count_post_public, $count_post_pending, $count_post_trash];
        return view('admin.post.listPost', compact('list_posts', 'count', 'keyword', 'list_act', 'status'));
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if (!empty($list_check)) {
            if (!empty($act)) {
                //public
                if ($act == "public") {
                    $success  = Post::whereIn('id', $list_check)
                        ->update(['post_status' => $act]);
                    if ($success > 0) {
                        return redirect('admin/post/list')->with(['status' => 'Bạn đã cập nhập trạng thái công khai thành công']);
                    }
                }
                //pending
                if ($act == "pending") {
                    $success = Post::whereIn('id', $list_check)
                        ->update(['post_status' => $act]);
                    if ($success > 0) {
                        return redirect('admin/post/list')->with(['status' => 'Bạn đã cập nhập trạng thái chờ duyệt thành công']);
                    }
                }
                //temporary_deletion : xóa tạm thời
                if ($act == "temporary_deletion") {
                    $success = Post::destroy($list_check);
                    if ($success > 0) {
                        return redirect('admin/post/list')->with(['status' => 'Bạn đã xóa tạm thời thành công']);
                    }
                }
                //restore
                if ($act == "restore") {
                    $success = Post::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    if ($success > 0) {
                        return redirect('admin/post/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                    }
                }
                //xóa vĩnh viễn forceDelete

                if ($act == "forceDelete") {
                    $posts = Post::withTrashed()->whereIn('id', $list_check)->get();
                    foreach ($posts as $post) {
                        $image_id = $post->image->id;
                        $image_url = $post->image->image_url;
                        $post->forceDelete();
                        Image::where('id', $image_id)->delete();
                        $file_path = public_path($image_url); //lấy đường dẫn tuyệt đối

                        if (File::exists($file_path)) {
                            File::delete($file_path);
                        }
                    }
                    return redirect('admin/post/list')->with(['status' => 'Bạn đã xóa vĩnh viễn thành công']);
                }
            } else {
                return redirect('admin/post/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
            }
        } else {
            return redirect('admin/post/list')->with(['status' => 'Bạn vui lòng chọn phần tử cần thực thi']);
        }
    }
    //delete Post
    function delete(Request $request, $id)
    {
        if ($request->input('status') == "trash") {
            //khi bạn sử dụng first() nó sẽ trả về bản ghi đầu tiên trong mảng
            $post = Post::withTrashed()->where('id', $id)->first();
            $image_id = $post->image_id;
            $image_url = $post->image->image_url;
            $post->forceDelete();
            Image::find($image_id)->delete();
            $file_path = public_path($image_url);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
            return redirect('admin/post/list')->with(['status' => 'Bạn đã xóa bản ghi vĩnh viễn thành công']);
        } else {
            $success = Post::find($id)
                ->delete();
            if ($success > 0) {
                return redirect('admin/post/list')->with(['status' => 'Bạn đã xóa bản ghi thành công']);
            }
        }
    }
    //edit post
    function edit($id)
    {
        $list_category = PostCat::all();
        $list_category = data_tree($list_category);
        $post = Post::find($id);
        return view('admin.post.editPost', compact('post', 'list_category'));
    }
    //nơi xử lý form chỉnh sửa post
    function editStorePost(Request $request, $id)
    {
        if ($request->input('btn-edit')) { //nếu thằng btn-edit tồn tại và không rỗng thì thực thi
            $request->validate(
                [
                    'post_title' => 'required|string|max:255',
                    'post_slug' => 'required|string|max:255',
                    'post_content' => 'required|string',
                    'post_status' => 'required|in:public,pending',
                    'category_id' => 'required'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có ký tự tối đa là :max ký tự'
                ],
                [
                    'post_title' => "Tiêu đề",
                    'post_slug' => "Link thân thiện ",
                    'post_content' => "Nội dung",
                    'post_status' => "Trạng thái",
                    'category_id' => "Danh mục"
                ]
            );
            Post::find($id)
                ->update([
                    'post_title' => $request->input('post_title'),
                    'post_slug' => Str::slug($request->input('post_slug')),
                    'content' => $request->input('post_content'),
                    'post_status' => $request->input('post_status'),
                    'category_id' => $request->input('category_id'),
                    'post_description' => $request->input('post_description')
                ]);

            return redirect('admin/post/list')->with((['status' => 'Chỉnh sửa bài viết thành công']));
        }
    }
    //Nơi xử lý form khi submit addCat
    function catStore(Request $request)
    {
        Session::flash('category_name', $request->input('category_name'));
        Session::flash('category_slug', $request->input('category_slug'));
        Session::flash('category_parent', $request->input('category_parent'));
        Session::flash('category_status', $request->input('category_status'));
        if ($request->input('btn-add')) { //nếu như nó tồn tại và có giá trị 
            $request->validate(
                [
                    'category_name' => 'required|string|max:255',
                    'category_slug' => 'required|string|max:255',
                    'category_status' => 'required|in:public,pending'
                ],

                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài ký tự tối đa :max ký tự'
                ],
                [
                    'category_name' => 'Tên danh mục',
                    'category_slug' => 'Link thân thiện',
                    'category_status' => 'Trạng thái danh mục'
                ]
            );
            $parent_id = $request->input('category_parent');
            if (empty($parent_id)) {
                $parent_id = 0;
            }
            PostCat::create([
                'category_name' => $request->input('category_name'),
                'category_slug' =>  Str::slug($request->input('category_slug')),
                'category_status' => $request->input('category_status'),
                'parent_id' => $parent_id,
                'user_id' => Auth::id()
            ]);

            return redirect('admin/post/cat/list')->with(['status' => 'Thêm danh mục thành công']);
        }

        //    return $request->input();
    }

    //danh sách bài viết
    //Danh sách danh mục bài viết
    function listCat(Request $request)
    {
        $status = $request->input('status');
        $keyword = "";
        $list_act = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',

        ];
        //public
        if ($status == "public") {
            $list_post_cat = PostCat::where('category_status', '=', 'public')->get();
        } elseif ($status == "pending") {
            $list_post_cat = PostCat::where('category_status', '=', 'pending')->get();
        } elseif ($status == "trash") {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $list_post_cat = PostCat::onlyTrashed()->get();
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $list_post_cat = PostCat::where('category_name', 'LIKE', "%{$keyword}%")->get();
            if (empty($keyword)) {
                $list_post_cat = data_tree($list_post_cat);
            }
        }


        $count_post_cat_all = PostCat::count();
        $count_post_cat_public = PostCat::where('category_status', '=', 'public')->count();
        $count_post_cat_pending = PostCat::where('category_status', '=', 'pending')->count();
        $count_post_cat_trash = PostCat::onlyTrashed()->count();
        $count = [
            $count_post_cat_all,
            $count_post_cat_public,
            $count_post_cat_pending,
            $count_post_cat_trash
        ];

        return view('admin.post.listCat', compact('list_post_cat', 'count', 'list_act', 'keyword'));
    }
    function catAction(Request $request)
    {
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if (!empty($list_check)) {
            if (!empty($act)) {
                //public
                if ($act == "public") {
                    $success = PostCat::whereIn('id', $list_check)
                        ->update(['category_status' => 'public']);
                    if ($success > 0) {
                        return redirect('admin/post/cat/list')->with(['status' => 'Bạn đã cập nhập trạng thái công khai thành công']);
                    }
                }
                //pending
                if ($act == "pending") {
                    $success = PostCat::whereIn('id', $list_check)
                        ->update(['category_status' => 'pending']);
                    if ($success > 0) {
                        return redirect('admin/post/cat/list')->with(['status' => 'Bạn đã cập nhập trạng thái chờ duyệt thành công']);
                    }
                }
                // //temporary_deletion: xóa tạm thời
                // if ($act == "temporary_deletion") {
                //     $category_id_default = 48;
                //     $list_category = PostCat::all();;
                //     $list_category_by_list_check = PostCat::withTrashed()
                //                 ->whereIn('id',$list_check)
                //                 ->get();

                //     foreach($list_category_by_list_check as $category){
                //         if(CheckCatIdListCheckHasChild($list_category, $category->id)){
                //             return '<script>
                //             alert("Vui lòng xóa danh mục con trước khi xóa danh mục cha '.$category->category_name.'");
                //             window.location.href = "'.url('admin/post/cat/list').'";
                //         </script>';
                //         }

                //         if(count($category->posts)>0){
                //                 foreach($category->posts as $post){
                //                         $post->update([
                //                             "category_id" => $category_id_default,
                //                             "category_id_before" =>  $category->id 
                //                         ]);
                //                 }
                //             }


                //     }
                //     $success = PostCat::destroy($list_check);
                //     if ($success > 0) { //nếu số bản ghi được xóa lớn hơn 0 thì thực thi 
                //         return redirect('admin/post/cat/list')->with(['status' => 'Bạn đã xóa bản ghi thành công']);
                //     }
                // }
                //restore
                if ($act == "restore") {
                    $category_id_default = 2;
                    $post_cats = PostCat::withTrashed()
                        ->whereIn('id', $list_check)
                        ->get();
                    $posts =  Post::where('category_id', $category_id_default)->get();

                    foreach ($post_cats as $post_cat) {
                        foreach ($posts as $post) {
                            if ($post_cat->id == $post->category_id_before) {
                                $post->update([
                                    'category_id' => $post_cat->id,
                                    'category_before_id' => NULL
                                ]);
                            }
                        }
                    }


                    $success = PostCat::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();

                    if ($success > 0) {
                        return redirect('admin/post/cat/list')->with(['status' => 'Bạn đã khôi phục bản ghi thành công']);
                    }
                }
                //forceDelete
                if ($act == "forceDelete") {
                    $success = PostCat::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    if ($success > 0) { //nếu số bản ghi được xóa lớn hơn 0 thì thực thi 
                        return redirect('admin/post/cat/list')->with(['status' => 'Bạn đã xóa vĩnh viễn bản ghi thành công']);
                    }
                }
            } else {
                return redirect('admin/post/cat/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
            }
        } else {
            return redirect('admin/post/cat/list')->with(['status' => 'Bạn vui lòng chọn phần tử cần thực thi']);
        }
    }

    //xóa danh mục
    function catDelete(Request $request, $id)
    {
        if ($request->input('status') == "trash") {
            $success = PostCat::withTrashed()
                ->find($id)
                ->forceDelete();
            if ($success > 0) {
                return redirect('admin/post/cat/list')->with(['status' => 'Bạn đã xóa bản ghi vĩnh viễn thành công']);
            }
        } else {
            $list_category = PostCat::all();
            $category = PostCat::find($id);
           
            $check_has_child = check_has_child($list_category, $category->id);
            if (!$check_has_child) { // nếu không có con
                 //kiểm tra category_id đang xóa nó có đang được lưu trong bảng post hay không nếu không thì xóa còn có thì thông báo lỗi
            $category_id_default = 2;
            $category_id = $category->id;
            //nếu danh sách post của category đó lớn hơn không
            if (count($category->posts) > 0) {
                foreach ($category->posts as $post) {
                    $post->update([
                        "category_id" => $category_id_default,
                        "category_id_before" =>  $category_id
                    ]);
                }
            }
                $success = PostCat::find($id)
                    ->delete();
                if ($success > 0) {
                    return redirect('admin/post/cat/list')->with(['status' => 'Bạn đã xóa bản ghi tạm thời thành công']);
                }
            } else {
                return redirect('admin/post/cat/list')->with(['status' => 'Vui lòng xóa danh mục con trước khi xóa danh mục cha']);
            }
        }
    }
    //end xóa danh mục

    // edit cat
    function catEdit($id)
    {
        $list_category = PostCat::all();
        $list_category = data_tree($list_category);
        $post_cat = PostCat::find($id);
        return view('admin.post.editCat', compact('post_cat', 'list_category'));
    }
    //xử lý form edit catEditStore
    function catEditStore(Request $request, $id)
    {
        if ($request->input('btn-edit')) { //nếu tồn tại giá trị thì sẽ thực thi
            $request->validate(
                [
                    'category_name' => 'required|string|max:255',
                    'category_slug' => 'required|string|max:255',
                    'category_status' => 'required|in:public,pending'
                ],

                [
                    'required' => ':attribute không được để trống',
                    'max' => ':attribute có độ dài ký tự tối đa :max ký tự'
                ],
                [
                    'category_name' => 'Tên danh mục',
                    'category_slug' => 'Link thân thiện',
                    'category_status' => 'Trạng thái danh mục'
                ]
            );
            $parent_id = $request->input('category_parent');
            if (empty($parent_id)) {
                $parent_id = 0;
            }
            PostCat::where('id', $id)->update([
                'category_name' => $request->input('category_name'),
                'category_slug' =>  Str::slug($request->input('category_slug')),
                'category_status' => $request->input('category_status'),
                'parent_id' => $parent_id
            ]);

            return redirect('admin/post/cat/list')->with(['status' => 'Chỉnh sửa danh mục thành công']);
        }
    }

    //end cat
}
