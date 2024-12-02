@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" name="keyword" class="form-control form-control-sm form-search"
                            placeholder="Tìm kiếm" value="{{ !empty($keyword) ? $keyword : '' }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn  btn-sm btn-primary">
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
                    <form action="{{ url('admin/post/action') }}">
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
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- nếu như nó rỗng thì sẽ trả về đối tượng collection nên dùng isEmpty để kiểm tra xem collection đó có phần tử hay không  --}}
                        @if (count($list_posts) > 0)
                            @php
                                $temp = 0;
                            @endphp
                            @foreach ($list_posts as $post)
                                @php
                                    $temp++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $post->id }}">
                                    </td>
                                    <td scope="row">{{ $temp }}</td>
                                    <td class="image-post"><img src="{{ asset($post->image->image_url) }}" alt=""></td>
                                    <td><a class="post-title" href="#">{{ $post->post_title }}</a></td>
                                    <td><span
                                            class="status {{ $post->post_status }}">{{ translate($post->post_status) }}</span>
                                    </td>
                                    <td>{{  $post->category->category_name }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>
                                        @if ($status == "trash")
                                        <a href="{{ route('admin.post.delete', $post->id) }}?status={{$status}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete" onclick="if(!confirm('Bạn có muốn xóa vĩnh viễn không?')) {event.preventDefault();}"><i
                                            class="fa fa-trash"></i></a>
                                        @else
                                        <a href="{{ route('admin.post.edit',$post->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.post.delete', $post->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete" onclick="if(!confirm('Bạn có muốn xóa tạm thời không?')) {event.preventDefault();}"><i
                                            class="fa fa-trash"></i></a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="bg-white">Không có bản ghi nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </form>
                {{ $list_posts->links() }}
            </div>
        </div>
    </div>
@endsection
