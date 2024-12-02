@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
              THÊM TRANG
            </div>
            <div class="card-body">
                <form action="{{ url('admin/page/store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="page_name">Tiêu đề </label>
                        <input class="form-control" type="text" name="page_name"  id="page_name" value="{{old('page_name')}}">
                        @error('page_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="page_slug">Slug ( Friendly_url )</label>
                        <input class="form-control" type="text" name="page_slug" id="page_slug" value="{{old('page_slug')}}">
                        @error('page_slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="page_desc">Mô tả ngắn</label>
                       <textarea class="form-control"  name="page_desc" id="page_desc" cols="30" rows="4"></textarea>
                        @error('page_desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="page_content">Nội dung</label>
                        <textarea name="page_content" class="form-control" placeholder="Nội dung" id="page_content" rows="10">{{old('page_content')}}</textarea>

                        @error('page_content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="" name="page_status">
                            <option value="">Chọn trạng thái:</option>
                            <option value="public" {{old('page_status') == "public"? 'selected' : ''}}>Công khai</option>
                            <option value="pending" {{old('page_status') == "pending"?'selected':''}}>Chờ duyệt</option>
                        </select>
                        @error('page_status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </div>

                    <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
