@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm ảnh cty 2vexpress
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('Image2vexpress.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên ảnh</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug ( Friendly_url )</label>
                        <input class="form-control" type="text" name="slug" id="slug" value="{{old('slug')}}">
                        @error('slug')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="url">link</label>
                        <input class="form-control" type="text" name="url" id="url" value="{{old('url')}}" >
                    </div>
                    <div class="form-group">
                        <label for="description_slider">Mô tả:</label>
                        <textarea name="description" class="form-control" id="description_slider" cols="30" rows="5">{{old('description')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <input type="hidden" id="image_id_imageV2express" name="image_id_imageV2express">
                        <div id="uploadFile">
                            <input type="file" name="file-image-v2express" id="file-image-v2express" data-url="{{ route('uploadImage2vexpress') }}"> 
                            <input type="submit" name="Upload" value="Upload" id="Upload-image-v2express">
                            <div id="show_image_v2express">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order">Thứ tự:</label>
                        <input class="form-control" type="number" min="1" name="order" id="order" value="{{old('order')}}">
                        @error('order')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>


                    <div class="form-group mb-4">
                        <label for="status">Trạng thái:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Chọn trạng thái</option>
                            <option value="public" {{old('status') == 'public'?'selected':''}} >Công khai</option>
                            <option value="pending" {{old('status') == 'pending'?'selected':''}}>Chờ duyệt</option>
                        </select>
                        @error('status')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>




                    <button type="submit" class="btn btn-primary" name="btn-add" value="Thêm mới">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
