@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                       Chỉnh sửa danh mục trang chủ
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.PostCatHome.editStore',$PostCatHome->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="post_title">Tên bài viết danh mục:</label>
                                <input class="form-control" type="text" name="post_title" id="post_title" value="{{$PostCatHome->post_title}}">
                                @error('post_title')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_name">Tên danh mục</label>
                                <input class="form-control" type="text" name="category_name" id="category_name" value="{{$PostCatHome->category_name}}">
                                @error('category_name')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_slug">Slug( Friendly_url )</label>
                                <input class="form-control" type="text" name="category_slug" id="category_slug"  value="{{$PostCatHome->category_slug}}">
                                @error('category_slug')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_content">Nội dung danh mục</label>
                                <textarea name="category_content" class="form-control" id="category_content" cols="30" rows="10">{{$PostCatHome->category_content}}</textarea>
                                @error('category_content')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            {{-- image  --}}
                            <div class="form-group">
                                <label for="">Hình ảnh</label>
                                <input type="hidden" id="image_id_postCatHome" name="image_id_postCatHome">
                                <div id="uploadFile">
                                    <input type="file" name="file-image-postCatHome" id="file-image-postCatHome" data-url="{{ route('updateImagePostCatHome') }}"> 
                                    <input type="submit" name="Upload" value="Upload" id="update-Upload-image-postCatHome">
                                    <div id="show_image_postCatHome">
                                        <img src="{{asset($PostCatHome->image->image_url??'http://via.placeholder.com/80X80')}}" alt="" id="image-postCatHome" data-id-slider="{{$PostCatHome->id}}" >
                                    </div>
                                </div>
                            </div>
                            {{-- end image  --}}
                            <div class="form-group">
                                <label for="category_parent">Danh mục cha:</label>
                                <select class="form-control" id="category_parent" name="category_parent">
                                    <option value="">--Chọn danh mục--</option>
                                    @if (count($list_category) > 0)
                                    @foreach ($list_category as $category)
                                    <option value="{{$category->id}}" {{$category->id == $PostCatHome->parent_id?'selected':''}}>{{str_repeat('|--',$category->level).$category->category_name}}</option>
                                        @endforeach
                                         @endif
                                </select>
                                @error('category_parent')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="category_status">Trạng thái:</label>
                                <select class="form-control" id="category_status" name="category_status">
                                    <option value="">--Chọn trạng thái--</option>
                                    <option value="public" {{$PostCatHome->category_status == 'public'?'selected':''}}>Công khai</option>
                                    <option value="pending" {{$PostCatHome->category_status == 'pending'?'selected':''}}>Chờ duyệt</option>
                                </select>
                                @error('category_status')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>



                            <button type="submit" class="btn btn-primary" name="btn-edit" value="Chỉnh sửa">Chỉnh sửa</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
