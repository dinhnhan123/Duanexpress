@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách trang</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" name="keyword"  value="{{!empty($keyword)?$keyword:''}}"  class="form-control form-search form-control-sm"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary btn-sm">
                    </form>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all', 'keyword' => null, 'btn-search' => null]) }}"
                        class="text-primary">Tất cả<span class="text-muted">({{ $counts[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'public', 'keyword' => null, 'btn-search' => null]) }}"
                        class="text-primary">Công khai<span class="text-muted">({{ $counts[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending', 'keyword' => null, 'btn-search' => null]) }}"
                        class="text-primary">Chờ duyệt<span class="text-muted">({{ $counts[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash', 'keyword' => null, 'btn-search' => null]) }}"
                        class="text-primary">Thùng rác<span class="text-muted">({{ $counts[3] }})</span></a>
                </div>
                <div class="form-action form-inline py-3">
                    <form action="{{ url('admin/page/action') }}">
                    <select class="form-control mr-1" id="" name="act">
                        <option value="">Chọn</option>
                        @foreach ($list_act as $k => $act)
                        <option value="{{$k}}">{{$act}}</option>
                        @endforeach
                        
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">STT</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Thời gian tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($pages->total() > 0)
                            @php
                                $temp = 0;
                            @endphp
                            @foreach ($pages as $page)
                                @php
                                    $temp++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{$page->id}}">
                                    </td>
                                    <td scope="row">{{ $temp }}</td>
                                    <td><a href="">{{ $page->title }}</a></td>
                                    <td><span class="status {{$page->status}}">{{ translate($page->status) }}</span></td>
                                    <td>{{ $page->user->name }}</td>
                                    <td>{{ $page->created_at }}</td>
                                    <td>
                                        @if ($status == "trash")
                                        <a href="{{ route('page.delete', $page->id) }}?status={{$status}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không?')"><i
                                                class="fa fa-trash"></i></a>
                                        @else
                                        <a href="{{ route('page.edit', $page->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                                <a href="{{ route('page.delete', $page->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không?')"><i
                                                        class="fa fa-trash"></i></a>
                                        @endif
                                       
                                           
                                    </td>

                                </tr>
                            @endforeach
                        @else
                         <tr>
                            <td colspan="6" class="bg-white text-black">Không tìm thấy bản ghi</td>
                         </tr>
                        @endif

                    </tbody>
                </table>
            </form>
                {{ $pages->links() }}
            </div>
        </div>
    </div>
@endsection
