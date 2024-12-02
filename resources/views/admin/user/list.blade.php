@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" class="form-control form-search form-control-sm" name="keyword"
                            placeholder="Tìm kiếm" value="{{ request()->input('keyword') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-sm btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{request()->fullUrlWithQuery(['status' => 'active' , 'keyword' => null , 'btn-search'=>null])}}" class="text-primary">Kích Hoạt<span class="text-muted">({{$counts[0]}})</span></a>
                    <a href="{{request()->fullUrlWithQuery(['status' => 'trash' , 'keyword' => null ,'btn-search'=>null ])}}" class="text-primary">Vô Hiệu Hóa<span class="text-muted">({{$counts[1]}})</span></a>
                </div>
                <form action="{{url('admin/user/action')}}">
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="act">
                        <option value="">Chọn</option>
                       @foreach ($list_act as $k => $v)
                       <option value="{{$k}}">{{$v}}</option>
                       @endforeach
                    </select>
                    <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->total() > 0)
                            @php
                                $temp = 0;
                            @endphp
                            @foreach ($users as $user)
                                @php
                                    $temp++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{$user->id}}">
                                    </td>
                                    <th scope="row">{{ $temp }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>Admin</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a href="{{ route('edit_user', $user->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @if (Auth::id() != $user->id)
                                            <a href="{{ route('delete_user', $user->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không?')"><i
                                                    class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="bg-white text-black">Không tìm thấy bản ghi</td>
                            </tr>
                        @endif

                    </form>
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
