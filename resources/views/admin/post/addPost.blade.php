@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form  action="{{ url('admin/post/store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="post_title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="post_title" id="post_title">
                    @error('post_title')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post_slug">Slug ( Friendly_url )</label>
                    <input class="form-control" type="text" name="post_slug" id="post_slug">
                    @error('post_slug')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="post_description">Mô tả ngắn:</label>
                    <textarea name="post_description" id="post_description" class="form-control" rows="4">{{old('post_description')}}</textarea>
                    @error('post_description')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                </div>
                <div class="form-group">
                    <label for="post_content">Nội dung bài viết</label>
                    <textarea name="post_content" class="form-control" id="post_content" cols="30" rows="10"></textarea>
                    @error('post_content')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="text" id="image_id" name="image_id" hidden>
                    <div id="uploadFile">
                        <input type="file" name="file-image-post" id="file-image-post" data-url="{{ route('uploadImagePost') }}">
                        <input type="submit" name="Upload" value="Upload" id="Upload-image-post">
                        <div class="show_image_post">
                
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="" name="category_id">
                        <option value="">Chọn danh mục</option>
                        @if (count($list_category) > 0)
                            @foreach ($list_category as $category)
                            <option value="{{$category->id}}">{{str_repeat('|--',$category->level).$category->category_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('category_id')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <select class="form-control" id="" name="post_status">
                        <option value="">Chọn trạng thái:</option>
                        <option value="public">Công khai</option>
                        <option value="pending">Chờ duyệt</option>
                    </select>
                    @error('post_status')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>



                <button type="submit" class="btn btn-primary" name="btn-add" value="Thêm mới">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection