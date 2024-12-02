<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{ 
    function __construct()
    {
        $this -> middleware(function($request,$next){
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    //process user
    function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời'
        ];
        if ($status == 'trash') {
            $users = User::onlyTrashed()->paginate(10);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $counts = [
            $count_user_active,
            $count_user_trash
        ];
        return view('admin.user.list', compact('users', 'counts', 'list_act'));
    }
    //process add
    function add()
    {
        return view('admin.user.add');
    }
    //store
    function store(Request $request)
    {
        if ($request->input('btn-add')) {
            $request->validate(
                [
                    'name' => "required|string|regex:~^[\p{L}\s']{1,25}$~u|max:255",
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute có độ dài ít nhất :min ký tự',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                    'email' => ':attribute phải là một địa chỉ email hợp lệ vd: example@gmail.com',
                    'unique' => ':attribute đã tồn tại',
                    'confirmed' => 'Xác nhận mật khẩu không thành công',
                    'regex'  => ':attribute không hợp lệ chỉ được chứa các ký tự từ a-zA-Z '
                ],
                [
                    'name' => 'Tên người dùng',
                    'email' => 'Email',
                    'password' => 'Mật khẩu'
                ]
            );

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
            return redirect('admin/user/list')->with('status', 'Bạn đã thêm thành viên thành công');
        }
    }
    //end store
    function delete($id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();

            return redirect('admin/user/list')->with('status', 'Bạn đã xóa thành viên thành công');
        } else {
            return redirect('admin/user/list')->with('status', 'Bạn không thể tự xóa mình ra khỏi hệ thống');
        }
    }

    function action(Request $request)
    {
        if ($request->input('btn-action')) {
            $list_check = $request->input('list_check');
            $act = $request->input('act');
            if (!empty($list_check)) {
                foreach ($list_check as $k => $id) {
                    if (Auth::id() == $id) {
                        unset($list_check[$k]);
                    }
                }

                if (!empty($act)) {
                    if ($act === 'delete') {
                        $result = User::destroy($list_check);
                        if ($result) {
                            return redirect('admin/user/list')->with(['status' => 'Bạn đã xóa thành công']);
                        }
                    }

                    if ($act === 'restore') {
                        User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                        return redirect('admin/user/list')->with(['status' => 'Bạn đã khôi phục user thành công']);
                    }

                    if ($act === 'forceDelete') {
                        User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                        return redirect('admin/user/list')->with(['status' => 'Bạn đã xóa vĩnh viễn user thành công']);
                    }
                } else {
                    return redirect('admin/user/list')->with(['status' => 'Bạn vui lòng chọn tác vụ']);
                }
            } else {
                return redirect('admin/user/list')->with(['status' => 'Bạn vui lòng chọn phần tử cần thực thi']);
            }
        }
    }

    function edit(Request $request, $id){
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    function storeEdit(Request $request , $id){
        if($request->input('btn-edit')){
            $request->validate(
                [
                    'name' => "required|string|regex:~^[\p{L}\s']{1,25}$~u|max:255",
                    'password' => 'required|string|min:8|confirmed',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute có độ dài ít nhất :min ký tự',
                    'max' => ':attribute có độ dài tối đa :max ký tự',
                    'email' => ':attribute phải là một địa chỉ email hợp lệ vd: example@gmail.com',
                    'unique' => ':attribute đã tồn tại',
                    'confirmed' => 'Xác nhận mật khẩu không thành công',
                    'regex'  => ':attribute không hợp lệ chỉ được chứa các ký tự từ a-zA-Z '
                ],
                [
                    'name' => 'Tên người dùng',
                    'password' => 'Mật khẩu'
                ]
            );
            User::where('id', $id)->update([
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password'))
            ]);
            return redirect('admin/user/list')->with('status', 'Bạn đã cập nhập thành viên thành công');
        }
    }
}
