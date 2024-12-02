@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách ảnh tin nhắn khách hàng</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" class="form-control form-control-sm form-search" placeholder="Tìm kiếm" name="keyword" value="{{request()->input('keyword')}}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary btn-sm">
                </form>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status' => 'all','keyword' => null,'btn-search' => null])}}" class="text-primary">Tất cả <span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status' => 'public','keyword' => null,'btn-search' => null])}}" class="text-primary">Công khai<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status' => 'pending','keyword' => null,'btn-search' => null])}}" class="text-primary">Chờ duyệt<span class="text-muted">({{$count[2]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status' => 'trash','keyword' => null,'btn-search' => null])}}" class="text-primary">Thùng rác<span class="text-muted">({{$count[3]}})</span></a>
            </div>
            <div class="form-action form-inline py-3">
                <form action="{{ url('admin/messageCustomer/action') }}">
                <select class="form-control mr-1" id="" name="act">
                    <option value="">Chọn</option>
                    @foreach ($list_act as $k=>$act)
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
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên slider</th>
                        <th scope="col">Link</th>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Người tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $temp = 0;
                    @endphp
                    @forelse ($sliders as $slider)
                    @php
                        $temp++;
                    @endphp
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{$slider->id}}">
                        </td>
                        <td>{{$temp}}</td>
                        <td class="wp-image-messageCustomer"><img src="{{ asset($slider->image->image_url) }}" alt="" id="image-messageCustomer"></td>
                        <td><a href="#">{{$slider->name}}</a></td>
                        <td><a href="{{$slider->url}}" target="_blank" id="slider_url">{{$slider->url}}</a></td>
                        <td>{{$slider->order}}</td>
                        <td>{{$slider->user->name}}</td>
                        @if ($slider->status == "public")
                        <td><span class="badge badge-success">{{translate($slider->status)}}</span></td>
                        @else
                        <td><span class="badge badge-warning">{{translate($slider->status)}}</span></td>
                        @endif
                        
                        <td>
                            <a href="{{ route('messageCustomer.edit',$slider->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-edit"></i></a>
                           @if ($status == "trash")
                           <a href="{{ route('messageCustomer.delete',$slider->id) }}?status={{$status}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="if(!confirm('Bạn có muốn xóa vĩnh viễn không?')) {event.preventDefault();}"><i class="fa fa-trash"></i></a>
                           @else
                           <a href="{{ route('messageCustomer.delete',$slider->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="if(!confirm('Bạn có muốn xóa tạm thời không?')) {event.preventDefault();}"><i class="fa fa-trash"></i></a>
                           @endif
                           
                        </td>
                    </tr>
                    @empty
                    <td colspan="9" class="bg-white">
                       Không có bản ghi nào
                    </td>
                    @endforelse
                    
                </tbody>
            </table>
        </form>
           {{$sliders->links()}}
        </div>
    </div>
</div>
</div>
@endsection