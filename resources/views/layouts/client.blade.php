<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="http://127.0.0.1:8001/">
    <link rel="icon" type="image/x-icon" href="{{ asset('client/images/logoExpress.png') }}" />
    <link rel="stylesheet" href="{{ asset('client/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/owlcarousel/assets/owl.theme.default.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('client/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/grid-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('client/fontawesome/css/all.css') }}">
    <title> @yield('title')</title>
</head>

<body>
    <div id="wrapper">
        <div id="header" class="bg-black">
            <div id="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-12 text-md-left text-center mb-3 mb-md-0"><i
                                class="fa-regular fa-clock"></i>&nbsp;Thứ 2 - Thứ 7: 7:00 -
                            17:00</div>
                        <div class="col-md-4 col-12 text-md-center text-center mb-3  mb-md-0"><i
                                class="fa-regular fa-envelope"></i>&nbsp;2VExpress@gmail.com</div>
                        <div class="col-md-4 col-12  text-md-right text-center  mb-md-0"><i
                                class="fa-solid fa-phone"></i>&nbsp;035 4229999</div>
                    </div>
                </div>
            </div>
            <!-- end top-header -->
            <div id="bottom-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 ">
                            <nav class="d-flex justify-content-between align-items-center" id="home-nav">
                                <a href="trang-chu.html" class="navbar-brand">
                                    <img src="{{ asset('client/images/logoExpress.png') }}" alt="logo">
                                </a>
                                <ul id="main-menu" class=" list-unstyled  mb-0 ">
                                    <li class="menu-item"><a href="trang-chu.html">TRANG CHỦ</a></li>
                                    @if ($post_cat_homes)
                                        @foreach ($post_cat_homes as $category)
                                            @if ($category->parent_id == 0)
                                                @php
                                                    $category_id_child = checkHasChildPostCatHome($category->id);
                                                @endphp
                                            @endif

                                            @if ($category->id == $category_id_child)
                                                @php
                                                    $listPostCatHomeById = getListPostCatHome($category_id_child);
                                                @endphp

                                                <li class="menu-item {{ count($listPostCatHomeById) > 0 ? 'has-child' : '' }}"
                                                    style="text-transform: uppercase;"
                                                    value="{{ $category_id_child }}"><a
                                                        href="{{ route('postCatHome.detail', ['slug' => $category->category_slug]) }}">{{ $category->category_name }}</a>
                                                    @if (count($listPostCatHomeById) > 0)
                                                        <ul class="sub-menu shadow">
                                                            @foreach ($listPostCatHomeById as $item)
                                                                <li><a
                                                                        href="{{ route('postCatHome.detail', ['slug' => $item->category_slug]) }}">{{ $item->category_name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                </li>
                                            @endif
                                        @endforeach
                                    @endif

                                    <li class="menu-item"><a href="{{ route('post.list') }}">TIN TỨC</a></li>
                                    <li class="menu-item"> <a
                                            href="{{ route('page.detail', ['slug' => $page->slug]) }}"
                                            title="">GIỚI THIỆU</a></li>
                                </ul>
                                <!-- <div class="wp-search-cart">
                                    <form action="">
                                        <input type="text" class="search-form"  placeholder="Tìm kiếm....">
                                        <button class="search"> <i class=" fa-solid fa-magnifying-glass"></i></button>
                                    </form>
                                    <a href="" class="cart">
                                        <i class=" fa-solid fa-cart-plus"></i>
                                        <span class="num-product-cart">0</span>
                                    </a>
                                </div> -->
                                <!-- <div class="wp-responsive-cart-search-navbar_toggle ">
                                    <div class="wp-responsive-cart-search  align-items-center d-flex">
                                        <a href="" class="cart">
                                            <i class=" fa-solid fa-cart-plus"></i>
                                            <span class="num-product-cart">0</span>
                                        </a>
                                        <form action="#">
                                            <input type="text" class="search-form-responsive display-none"  placeholder="Tìm kiếm....">
                                             <i class="search-responsive fa-solid fa-magnifying-glass"></i>
                                        </form>
                                    </div> -->

                                <div class="navbar-toggle">
                                    <i class="bar fa-sharp fa-solid fa-bars"></i>
                                </div>
                        </div>


                        </nav>
                    </div>
                </div>
            </div>
            <div class="wp-responsive">
                <ul id="menu-responsive" class=" list-unstyled  mb-0 ">
                    <li class="menu-item"><a href="trang-chu.html">TRANG CHỦ</a></li>
                    @if ($post_cat_homes)
                        @foreach ($post_cat_homes as $category)
                            @if ($category->parent_id == 0)
                                @php
                                    $category_id_child = checkHasChildPostCatHome($category->id);
                                @endphp
                            @endif

                            @if ($category->id == $category_id_child)
                                @php
                                    $listPostCatHomeById = getListPostCatHome($category_id_child);
                                @endphp

                                <li class="menu-item"
                                    style="text-transform: uppercase;" value="{{ $category_id_child }}"><a
                                        href="{{ route('postCatHome.detail', ['slug' => $category->category_slug]) }}">{{ $category->category_name }}</a>
                                    @if (count($listPostCatHomeById) > 0)
                                    <i class="responsive-menu-toggle fa-solid fa-angle-down"></i>
                                        <ul class="sub-menu shadow">
                                            @foreach ($listPostCatHomeById as $item)
                                                <li><a href="{{ route('postCatHome.detail', ['slug' => $item->category_slug]) }}">{{ $item->category_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </li>
                            @endif
                        @endforeach
                    @endif
                    
                    <li class="menu-item"><a href="{{ route('post.list') }}">TIN TỨC</a></li>
                    <li class="menu-item"> <a href="{{ route('page.detail', ['slug' => $page->slug]) }}"
                            title="">GIỚI THIỆU</a></li>
                </ul>
            </div>
        </div>
        <!-- end bottom-header -->
    </div>
    <!-- end header  -->
    <div id="wp-content">
        @yield('content')
    </div>
    </div>
    </div>
    <!-- end wp-content  -->
    <div id="footer" class="text-light">
        <div class="container">
            <h5> CÔNG TY TNHH CHUYỂN PHÁT NHANH V2EXPRESS</h5>
            <div class="row">
                <div class="col-md-3">
                    <!-- begin box-address  -->
                    <div class="box box-address">
                        <div class="box-head">
                            <h6>ĐỊA CHỈ</h6>
                        </div>
                        <div class="box-body">
                            <ul id="list-address" class="p-0 m-0 list-unstyled">
                                <li class="list-item ">
                                    <a href="https://maps.app.goo.gl/vJmHNY4hiiMgSuwf6" target="_blank"
                                        class="text-decoration-none text-light d-block py-1"> <i
                                            class="fa-solid fa-location-dot "></i>&nbsp;1122/23/7 Quang Trung, Phường
                                        8, Gò Vấp, Thành phố Hồ Chí Minh
                                    </a>
                                </li>
                                <li class="list-item  py-1">
                                    <div class="phone"> <i class="fa-solid fa-phone"></i>&nbsp; 035 4229999</div>
                                </li>
                                <li class="list-item">
                                    <span 
                                        class="phone py-1 d-block text text-decoration-none text-light"><i
                                            class="fa-regular fa-envelope"></i>&nbsp;2VExpress@gmail.com</span>
                                </li>
                                <li class="list-item">
                                    <span 
                                        class="phone py-1 d-block text text-decoration-none text-light"><i
                                            class="fa-regular fa-envelope"></i>&nbsp;scglobalexpress@gmail.com</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end box-address  -->
                </div>
                <!-- end col  -->
                <div class="col-md-3">
                    <!-- begin box-introduce  -->
                    <div class="box box-introduce">
                        <div class="box-head">
                            <h6>GIỚI THIỆU</h6>
                        </div>
                        <div class="box-body">
                            <ul id="list-introduce" class="p-0 m-0 list-unstyled">
                                <li class="list-item ">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Về chúng
                                        tôi</a>
                                </li>
                                <li class="list-item  py-1">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Chính sách
                                        bảo mật</a>
                                </li>
                                <li class="list-item  py-1">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Chính sách
                                        thanh toán</a>
                                </li>
                                <li class="list-item  py-1">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Liên hệ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end box-introduce  -->
                </div>
                <!-- end col  -->
                <div class="col-md-3">
                    <!-- begin box-category  -->
                    <div class="box box-category">
                        <div class="box-head">
                            <h6>DỊCH VỤ</h6>
                        </div>
                        <div class="box-body">
                            <ul id="list-category" class="p-0 m-0 list-unstyled">
                                <li class="list-item  ">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Gửi hàng đi
                                        Mỹ</a>
                                </li>
                                <li class="list-item ">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Gửi hàng đi
                                        Hàn Quốc</a>
                                </li>
                                <li class="list-item ">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Gửi hàng đi
                                        Đức</a>
                                </li>
                                <li class="list-item ">
                                    <a href="" class="text-decoration-none text-light d-block py-1">Gửi hàng đi
                                        singapo</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end box-category -->
                </div>
                <!-- end col  -->
                <div class="col-md-3">
                    <!-- begin box-social  -->
                    <div class="box box-social">
                        <div class="box-head">
                            <h6>KẾT NỐI</h6>
                        </div>
                        <div class="box-body">
                            <ul id="list-social" class="p-0 m-0 list-unstyled">
                                <li class="list-item ">
                                    <a href="https://www.facebook.com/profile.php?id=100034449913526" target="_blank"
                                        class="text-decoration-none text-light d-block py-1"><i
                                            class="fa-brands fa-facebook"></i>&nbsp;Facebook</a>
                                </li>
                                <li class="list-item ">
                                    <a href="https://www.youtube.com/@Express2VGlobal" target="_blank"
                                        class="text-decoration-none text-light d-block py-1"><i
                                            class="fa-brands fa-youtube"></i>&nbsp;Youtube</a>
                                </li>
                                <li class="list-item ">
                                    <a href="" target="_blank"
                                        class="text-decoration-none text-light d-block py-1"><i
                                            class="fa-brands fa-instagram"></i></i>&nbsp;Instagram </a>
                                </li>
                                <li class="list-item ">
                                    <a href="https://www.tiktok.com/@2vglobalexpress?_t=8rUsCh2wKJj&_r=1&fbclid=IwY2xjawG4BJJleHRuA2FlbQIxMAABHb_oHUhPHh0vURHeaKyeNEkR8FbcQtwC_XH2T1nZQT1haM7-_1Zn_i1aag_aem_9M20PsTeS72DtH8npNWszw#2vglobalexpress"
                                        target="_blank" class="text-decoration-none text-light d-block py-1"><i
                                            class="fa-brands fa-tiktok"></i></i>&nbsp;Tiktok </a>
                                </li>
                                <li class="list-item ">
                                    <a href="https://www.pinterest.com/2vglobalexpress/" target="_blank"
                                        class="text-decoration-none text-light d-block py-1"><i
                                            class="fa-brands fa-pinterest-p"></i></i>&nbsp;Pinterest </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- end box-social  -->
                </div>
                <!-- end col  -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container  -->

    </div>
    <!-- end footer -->
    <div id="copyright">
        <p class="text-copyright text-center text-light"><i class="fa-regular fa-copyright"></i> Copyright 2024 ©
            2VEXPRESS</p>
    </div>
    </div>
    <div class="floating-icons">
        <a href="tel:+84354229999" class="social-icon" id="phone-icon">
            <img src="{{ asset('client/images/phone.png') }}" />
        </a>
        <a href="https://zalo.me/0354229999" target="_blank" class="social-icon" id="zalo-icon">
            <img src="{{ asset('client/images/zalo.png') }}" />
        </a>
        <a href="https://www.facebook.com/profile.php?id=100034449913526" class="social-icon" target="_blank"
            id="facebook-icon">
            <img src="{{ asset('client/images/Facebook.png') }}" />
        </a>
        <a href="https://maps.app.goo.gl/vJmHNY4hiiMgSuwf6" class="social-icon" target="_blank" id="location-icon">
            <img src="{{ asset('client/images/showroom4.png') }}" />
        </a>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="{{ asset('client/js/jquery.com_jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('client/js/popper.js@1.14.7_dist_umd_popper.min.js') }}"></script>
    <script src="{{ asset('client/bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('client/owlcarousel/jquery.min.js') }}"></script>
    <script src="{{ asset('client/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client/js/app.js') }}"></script>

</body>

</html>
