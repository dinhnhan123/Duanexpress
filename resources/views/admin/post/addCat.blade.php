@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm danh mục
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/post/cat/catStore') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="category_name">Tên danh mục</label>
                                <input class="form-control" type="text" name="category_name" id="category_name" value="{{old('category_name')}}">
                                @error('category_name')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_slug">Slug( Friendly_url )</label>
                                <input class="form-control" type="text" name="category_slug" id="category_slug"  value="{{old('category_slug')}}">
                                @error('category_slug')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="category_parent">Danh mục cha:</label>
                                <select class="form-control" id="category_parent" name="category_parent">
                                    <option value="">--Chọn danh mục--</option>
                                    @if (count($list_category) > 0)
                                        @foreach ($list_category as $category)
                                        <option value="{{$category->id}}" {{old('category_parent') == $category->id?'selected':''}}>{{str_repeat("|--",$category->level).$category->category_name}}</option>
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
                                    <option value="public" {{old('category_status') == 'public'?'selected':''}}>Công khai</option>
                                    <option value="pending">Chờ duyệt</option>
                                </select>
                                @error('category_status')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>



                            <button type="submit" class="btn btn-primary" name="btn-add" value="Thêm mới">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
