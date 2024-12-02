@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa ảnh tin nhắn khách hàng
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('messageCustomer.update',$slider->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên slider</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{$slider->name}}">
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug ( Friendly_url )</label>
                        <input class="form-control" type="text" name="slug" id="slug" value="{{$slider->slug}}">
                        @error('slug')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="url">link</label>
                        <input class="form-control" type="text" name="url" id="url" value="{{$slider->url}}">
                    </div>
                    <div class="form-group">
                        <label for="description_slider">Mô tả:</label>
                        <textarea name="description" class="form-control" id="description_slider" cols="30" rows="5">{{$slider->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <input type="text" id="image_id_messageCusomer" name="image_id_messageCusomer" hidden>
                        <div id="uploadFile">
                            <input type="file" name="file-image-messageCutomer" id="file-image-messageCutomer" data-url="{{ route('updateImageMessageCustomer') }}"> 
                            <input type="submit" name="Upload" value="Upload" id="update-Upload-image-messageCustomer">
                            <div id="show_image_messageCutomer">
                                <img src="{{asset($slider->image->image_url)}}" alt="" id="image-messageCutomer" data-id-slider="{{$slider->id}}" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order">Thứ tự:</label>
                        <input class="form-control" type="number" min="1" name="order" id="order" value="{{$slider->order}}">
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
                            <option value="public" {{$slider->status == 'public'?'selected':''}}>Công khai</option>
                            <option value="pending" {{$slider->status == 'pending'?'selected':''}}>Chờ duyệt</option>
                        </select>
                        @error('status')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>




                    <button type="submit" class="btn btn-primary" name="btn-edit" value="Chỉnh sửa">Chỉnh sửa</button>
                </form>
            </div>
        </div>
    </div>
@endsection
