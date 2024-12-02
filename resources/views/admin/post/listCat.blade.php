@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách danh mục bài viết</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search form-control-sm" placeholder="Tìm kiếm"
                            name="keyword" value="{{$keyword}}">
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
                        class="text-primary">Tất cả<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'public', 'keyword' => null, 'btn-search' => null]) }}"
                        class="text-primary">Công khai<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending', 'keyword' => null, 'btn-search' => null]) }}"
                        class="text-primary">Chờ duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash', 'keyword' => null, 'btn-search' => null]) }}"
                        class="text-primary">Thùng rác<span class="text-muted">({{ $count[3] }})</span></a>
                </div>
                <div class="form-action form-inline py-3">
                    <form action="{{ url('admin/post/cat/catAction') }}">
                        <select class="form-control mr-1" id="" name="act">
                            <option value="">Chọn</option>
                            @foreach ($list_act as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">STT</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Thứ tự</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Thời gian tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($list_post_cat) > 0)
                            @php
                                $temp = 0;
                            @endphp
                            @foreach ($list_post_cat as $item)
                                @php
                                    $temp++;
                                @endphp
                                <tr>
                                   @if ($item->id == 2)
                                   <td>
                                       <input type="checkbox"  disabled>
                                   </td>
                                   @else
                                   <td>
                                       <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                   </td>
                                   @endif
                                    <th scope="row">{{ $temp }}</th>
                                    <td><a href="">{{ str_repeat('|---', $item->level).$item->category_name }}</a></td>
                                    <td>{{ $item->parent_id }}</td>
                                    <td><span class="status {{$item->category_status}}">{{ translate($item->category_status) }}</span></td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        
                                        @if (request()->input('status') == 'trash')
                                            <a href="{{ route('post.cat.catDelete', $item->id) }}?status={{ request()->input('status') }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="if (!confirm('Bạn có muốn xóa vĩnh viễn không?')) { event.preventDefault(); }"><i
                                                    class="fa fa-trash"></i></a>
                                        @else
                                        @if ($item->id == 2)
                                        <a href="{{ route('post.cat.catEdit', $item->id) }}"
                                           class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                           data-toggle="tooltip" data-placement="top" title="Edit"><i
                                               class="fa fa-edit"></i></a>
                                        @else
                                        <a href="{{ route('post.cat.catEdit', $item->id) }}"
                                           class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                           data-toggle="tooltip" data-placement="top" title="Edit"><i
                                               class="fa fa-edit"></i></a>
                                            <a href="{{ route('post.cat.catDelete', $item->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="if (!confirm('Bạn có muốn xóa tạm thời không?')) { event.preventDefault(); }"><i
                                                    class="fa fa-trash"></i></a>
                                        @endif
                                        
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                    </tbody>
                </table>
            @else
                <tr>
                   <td colspan="7" class="bg-white text-black">Không có bản ghi nào</td>
                </tr>
                @endif

                </form>
                {{-- {{ $list_post_cat->links() }} --}}
            </div>
        </div>
    </div>
@endsection
