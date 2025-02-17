<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <script src="https://cdn.tiny.cloud/1/34ij9vq29lzbjly8wc5jtunxlgiu4463hgl5vlun3lt9b06x/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: 'textarea:not(#product_desc,#description_permission,#description_role,#description_slider,#post_description,#shipping-address,#page_desc)',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern forecolor backcolor emoticons"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media |forecolor backcolor emoticons",
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 1,
                    height: y * 1,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    <link rel="stylesheet" href="{{ asset('admincss/style.css') }}">
    <title>Admintrator</title>
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="{{url('dashboard')}}">2VEXPRESSGLOBAL ADMIN</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?view=add-post">Thêm bài viết</a>
                        <a class="dropdown-item" href="?view=add-product">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="?view=list-order">Thêm đơn hàng</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @php
            $module_active = session('module_active');
        @endphp
        <!-- end nav  -->
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    <li class="nav-link {{$module_active == 'dashboard'?'active' :''}}">
                        <a href="{{url('dashboard')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li>
                    <li class="nav-link {{$module_active == 'page'?'active' :''}}">
                        <a href="{{url('admin/page/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Trang
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{url('admin/page/add')}}">Thêm mới</a></li>
                            <li><a href="{{url('admin/page/list')}}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{$module_active == 'post'?'active' :''}}">
                        <a href="{{ url('admin/post/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/post/add') }}">Thêm mới bài viết</a></li>
                            <li><a href="{{ url('admin/post/list') }}">Danh sách bài viết</a></li>
                            <li><a href="{{ url('admin/post/cat/add') }}">Thêm mới danh mục</a></li>
                            <li><a href="{{ url('admin/post/cat/list') }}">Danh sách danh mục</a></li>
                        </ul>
                    </li>
                   {{-- slider  --}}
                   <li class="nav-link {{$module_active == "slider" ? 'active':''}}">
                    <a href="{{ url('admin/slider/list') }}">
                        <div class="nav-link-icon d-inline-flex">
                            <i class="far fa-folder"></i>
                        </div>
                        Slider
                    </a>
                    <i class="arrow fas fa-angle-right"></i>
                    <ul class="sub-menu">
                        <li><a href="{{ url('admin/slider/add') }}">Thêm mới</a></li>
                        <li><a href="{{ url('admin/slider/list') }}">Danh sách slider</a></li>
                    </ul>
                </li>
                   {{-- end slider  --}}
                   {{-- 2vexpress image  --}}
                   <li class="nav-link {{$module_active == "Image2vexpress" ? 'active':''}}">
                    <a href="{{ url('admin/Image2vexpress/list') }}">
                        <div class="nav-link-icon d-inline-flex">
                            <i class="far fa-folder"></i>
                        </div>
                        Ảnh cty 2vexpress
                    </a>
                    <i class="arrow fas fa-angle-right"></i>
                    <ul class="sub-menu">
                        <li><a href="{{ url('admin/Image2vexpress/add') }}">Thêm mới</a></li>
                        <li><a href="{{ url('admin/Image2vexpress/list') }}">Danh sách ảnh</a></li>
                    </ul>
                </li>
                   {{-- end 2vexpress image  --}}
                    {{-- fastMoving image --}}
                    <li class="nav-link {{$module_active == "fastMovingPartner" ? 'active':''}}">
                        <a href="{{ url('admin/fastMovingPartner/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Ảnh đối tác 2vexpress
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/fastMovingPartner/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/fastMovingPartner/list') }}">Danh sách ảnh</a></li>
                        </ul>
                    </li>
                       {{-- end fastMoving image  --}}
                        {{-- messageCustomer image --}}
                    <li class="nav-link {{$module_active == "MessageCustomer" ? 'active':''}}">
                        <a href="{{ url('admin/messageCustomer/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Ảnh message KH
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/messageCustomer/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/messageCustomer/list') }}">Danh sách ảnh</a></li>
                        </ul>
                    </li>
                       {{-- end messageCustomer image  --}}
                          {{-- postCatHome --}}
                    <li class="nav-link {{$module_active == "PostCatHome" ? 'active':''}}">
                        <a href="{{ url('admin/PostCatHome/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            PostCatHome
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/PostCatHome/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/PostCatHome/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                       {{-- end PostCatHome  --}}
                    <li class="nav-link  {{$module_active == 'user'?'active' :''}}">
                        <a href="{{ url('admin/user/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Users
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/user/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/user/list') }}">Danh sách</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div id="wp-content">
                @yield('content')
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('adminjs/app.js') }}"></script>
    <script src="{{ asset('adminjs/uploadImage.js') }}"></script>
    <script>
        var urlAsset = "{{ asset('') }}";
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
