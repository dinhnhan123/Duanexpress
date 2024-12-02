@extends('layouts.client')
@section('title', '2VExpress | Vận chuyển nhanh')
@section('content')
    <div id="content">
        <div class="carousel slide carousel-fade d-none d-xl-block " id="home-slide" data-ride="carousel">
            <div class="carousel-inner">
                @if (count($sliders) > 0)
                    @foreach ($sliders as $index => $slider)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }} " data-interval="2000">
                            @if ($slider->url)
                                <a href="{{ $slider->url }}">
                                    <img src="{{ asset($slider->image->image_url) }}" alt=""
                                        class="d-block w-100 img-fluid">
                                </a>
                            @else
                                <img src="{{ asset($slider->image->image_url) }}" alt=""
                                    class="d-block w-100 img-fluid">
                            @endif

                        </div>
                    @endforeach
                @endif

                <ol class="carousel-indicators">
                    @if (count($sliders) > 0)
                        @foreach ($sliders as $index => $slider)
                            <li data-target="#home-slide" class="{{ $index == 0 ? 'active' : '' }}"
                                data-slide-to="{{ $index }}"></li>
                        @endforeach
                    @endif
                </ol>

            </div>
            <!-- end carousel-inner  -->
        </div>
        <div class="container" id="category">
            <div class="row no-gutters">
                <div class="col-md-6 p-3 wp-aboutUS">
                    <div class="shoe d-block">
                        <h4 class="aboutUS">Giới Thiệu</h4>
                    </div>
                    <div class="read-more">
                        <p> {{ $page->desc }}</p>
                        <a href="{{ route('page.detail', ['slug' => $page->slug]) }}"><button class="see-more-about-us btn btn-secondary">Xem thêm về chúng tôi</button></a>
                    </div>

                </div>
                <div class="col-md-6 img-express-groupo-of-people p-3">
                    <a href="" class="clock d-block">
                        <img src="{{ asset('client/images/anh-1.jpg') }}" alt="" class="img-fluid">
                    </a>

                </div>
            </div>
        </div>
        <!-- end container category  -->

        <!-- card category  -->
        <div class="container" id="card">
            @if ($post_cat_homes)
                @foreach ($post_cat_homes as $category)
                    @if ($category->parent_id == 0)
                        <h2 class="title-card text-center">{{ $category->category_name }}</h2>
                        @php
                            $listPostCatHomeById = getListPostCatHomeById($category->id);
                        @endphp
                        <div class="row">
                            @foreach ($listPostCatHomeById as $postCatHome)
                            <div class="col-xl-4 col-md-4 col-12 mb-3">
                                <div class="card">
                                    <a href="{{ route('postCatHome.detail', ['slug' => $postCatHome->category_slug]) }}"><img src="{{asset($postCatHome->image->image_url)}}" class="card-img-top" alt="Image 1"></a>
                                    <div class="card-body">
                                        <a href="{{ route('postCatHome.detail', ['slug' => $postCatHome->category_slug]) }}" target="_blank">
                                            <h5 class="card-title text-center">{{$postCatHome->category_name}}</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{-- end col  --}}
                        </div>
                         {{-- end row  --}}
                    
                    @endif
                    @endforeach
                    @endif
                </div>

        <!-- end container card category  -->
       
        <div class="container" id="intro-why">
            <div class="row">
                <!-- Bên trái: Hình ảnh -->
                <div class="col-md-4 px-3 py-3"> <!-- Add padding to the left and right of the column -->
                    <img src="{{asset('client/images/giao-hang-jt-express.jpg')}}" alt="Image Description" class="img-fluid">
                </div>

                <!-- Bên phải: Giới thiệu -->
                <div class="col-md-8 px-3 py-3"> <!-- Add padding to the left and right of the column -->
                    <div>
                        <h2>TẠI SAO CHỌN 2VEXPRESS GỬI HÀNG ĐI NƯỚC NGOÀI</h2>
                        <p>Được thành lập từ năm 2010 chúng tôi đã có hơn 12 năm kinh nghiệm về gửi hàng qua Mỹ, gửi hàng
                            sang Hàn Quốc, chuyển tiền đi Mỹ và quốc tế đáp ứng yêu cầu của hàng nghìn khách hàng.</p>
                        <div class="flex-container">
                            <!-- First pair -->
                            <div class="flex-item">
                                <h5>Giá cước vận chuyển thấp</h5>
                                <p>Chúng tôi là đại lý cấp 1 trực thuộc các hãng chuyển phát nhanh FedEx, UPS, DHL,… do đó
                                    giá gửi hàng từ Việt Nam sang Mỹ sẽ rẻ hơn bạn gửi trực tiếp hãng hoặc bưu điện lên đến
                                    40%.</p>
                            </div>

                            <!-- Second pair -->
                            <div class="flex-item">
                                <h5>Thời gian vận chuyển nhanh</h5>
                                <p>Chuyển hàng đi quốc tế nhanh chóng an toàn với Nhật Minh Express. Người nhận sẽ không
                                    phải chờ đợi đơn hàng, giao hàng siêu tốc từ 4-7 ngày.</p>
                            </div>
                        </div>
                        <div class="flex-container">
                            <!-- First pair -->
                            <div class="flex-item">
                                <h5>Hỗ trợ khách hàng nhanh</h5>
                                <p>Miễn phí hỗ trợ tư vấn giải đáp thắc mắc 24/7. Cam kết hỗ trợ khách hàng cho đến khi đơn
                                    hàng đến tay người nhận an toàn. Chính sách hoàn cước nếu như đơn hàng gặp rủi ro trong
                                    quá trình vận chuyển.</p>
                            </div>

                            <!-- Second pair -->
                            <div class="flex-item">
                                <h5>Nhân viên chuyên nghiệp</h5>
                                <p>Nhân viên được đào tạo với phương châm lấy khách hàng làm trọng tâm, sự hài lòng của
                                    khách hàng là niềm vui của công ty. Nhân viên sẵn sàng lắng nghe, thấu hiểu để giải
                                    quyết vấn đề giúp khách hàng.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- // -->
        <div id="commit-freeship-support" class="mt-4 mb-5
    + mt-xl-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-12 text-center" id="guarantee">
                        <div class="box box-guarantee">
                            <div class="box-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div class="box-text">
                                Uy tín - Chuyên nghiệp
                            </div>
                        </div>
                        <!-- end box  -->
                    </div>
                    <div class="col-md-4 col-12 text-center" id="support">
                        <div class="box box-support">
                            <div class="box-icon">
                                <i class="fa-solid fa-headphones"></i>
                            </div>
                            <div class="box-text">
                                Hỗ trợ 24/7 0862700821
                            </div>
                        </div>
                        <!-- end box  -->
                    </div>
                    <div class="col-md-4 col-12 text-center" id="freeship">
                        <div class="box box-freeship">
                            <div class="box-icon">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div class="box-text">
                                Gửi hàng nhanh
                            </div>
                        </div>
                        <!-- end box  -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end commit-freeship-support  -->


        <!-- //selling-product -->
        <div class="container image2vexpress" id="selling-product">
            <div class="row">
                <div class="col-md-12">
                    <div class="box selling-product">
                        <div class="box-head text-center">
                            <h2 class="font-weight-bold" style="color: #343434;">HÌNH ẢNH TẠI CÔNG TY 2VEXPRESS</h2>
                            <p style="color: #aaa8a8;">Bộ sưu tập những hình ảnh giao hàng cho khách của công ty 2VExpress
                            </p>

                        </div>
                        <div class="box-body">
                            <div class="owl-carousel owl-theme" id="carousel">
                                @if (!empty($listImage2vexpress))
                                    @foreach ($listImage2vexpress as $image2vexpress)
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-top">
                                                <a href="#" class="product-thumb d-block">
                                                    <img src="{{asset($image2vexpress->image->image_url)}}" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end item  -->
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end selling-product -->
                </div>
            </div>
        </div>
        <!-- end container selling-product -->

        <!-- //selling-product -->
        <div class="container fast-moving" id="selling-product">
            <div class="row">
                <div class="col-md-12">
                    <div class="box selling-product">
                        <div class="box-head text-center">
                            <h2 class="font-weight-bold" style="color: #343434;">ĐỐI TÁC CHUYỂN NHANH QUỐC TẾ</h2>
                            <p style="color: #aaa8a8;">Những đối tác của công ty 2VExpress</p>

                        </div>
                        <div class="box-body">
                            <div class="owl-carousel owl-theme" id="carousel">
                                @if (!empty($listFastMoving))
                                    @foreach ($listFastMoving as $fastMoving)
                                    <div class="item">
                                        <div class="product-item">
                                            <div class="product-top">
                                                <a href="#" class="product-thumb fast-moving d-block">
                                                    <img src="{{asset($fastMoving->image->image_url)}}" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end item  -->
                                    @endforeach
                                @endif
                              
                            </div>
                        </div>
                    </div>
                    <!-- end selling-product -->
                </div>
            </div>
        </div>
        <!-- end container selling-product -->

        <div class="container" id="lastest-blog">
            <div class="row">
                <div class="col-md-12">

                    <div class="box lastest-blog">
                        <div class="box-head text-center">
                            <h2 class="font-weight-bold" style="color: #343434;">TIN TỨC</h2>
                            <p style="color: #aaa8a8;">Những bài viết tin tức bạn có thể xem bây giờ</p>
                        </div>
                        <div class="box-body">
                            <div class="card-deck">
                                @if (!empty($listPost))
                                    @foreach ($listPost as $post)
                                    <div class="card">
                                        <a href="{{ route('post.detail', ['slug' => $post->post_slug]) }}" class="product-thumb d-block">
                                            <img src="{{asset($post->image->image_url)}}" alt="" class="card-img">
                                        </a>
                                        <div class="card-body text-center">
                                            <span class="text-center d-block fashion p-2">{{$post->category->category_name}}</span>
                                            <h5 class="card-title"><a href="{{ route('post.detail', ['slug' => $post->post_slug]) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{$post->post_title}}</a></h5>
                                            <span class="date d-block p-2">{{$post->created_at}}</span>
                                            <p class="card-text">{{$post->post_description}}</p>
                                        </div>
                                    </div>
                                    <!-- end card  -->
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end lastest-blog -->

                <div class="container" id="comment-customer">
                    <h2 class="font-weight-bold" style="color: #343434;">BÌNH LUẬN KHÁCH HÀNG VỀ CÔNG TY 2VEXPRESS</h2>
                    <div class="row">
                        <!-- Bình luận khách hàng 1 -->
                        <div class="col-md-6 mb-4">
                            <div class="comment d-flex">
                                <!-- Avatar khách hàng 1 -->
                                <div class="customer-avatar">
                                    <img src="{{asset('client/images/customer1.png')}}" alt="Customer 1" class="img-fluid rounded-circle">
                                </div>
                                <!-- Nội dung bình luận khách hàng 1 -->
                                <div class="comment-text">
                                    <h4>Hữu Dũng</h4>
                                    <p>Chúng tôi đã sử dụng dịch vụ và rất hài lòng với tốc độ giao hàng và sự chuyên nghiệp
                                        của đội ngũ. Rất đáng tin cậy!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bình luận khách hàng 2 -->
                        <div class="col-md-6 mb-4">
                            <div class="comment d-flex">
                                <!-- Avatar khách hàng 2 -->
                                <div class="customer-avatar">
                                    <img src="{{asset('client/images/customer2.png')}}" alt="Customer 2" class="img-fluid rounded-circle">
                                </div>
                                <!-- Nội dung bình luận khách hàng 2 -->
                                <div class="comment-text">
                                    <h4>Nguyễn My</h4>
                                    <p>Dịch vụ tuyệt vời, giao hàng nhanh chóng, tôi sẽ tiếp tục sử dụng dịch vụ trong tương
                                        lai.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end comment  -->
                <!-- //selling-product -->
                <div class="container comment-customer" id="selling-product">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box selling-product">
                                <div class="box-body">
                                    <div class="owl-carousel owl-theme" id="carousel">
                                        @if (!empty($listMessageCustomer))
                                            @foreach ($listMessageCustomer as $messageCustomer)
                                            <div class="item">
                                                <div class="product-item">
                                                    <div class="product-top">
                                                        <a href="#" class="product-thumb fast-moving d-block">
                                                            <img src="{{asset($messageCustomer->image->image_url)}}" alt=""
                                                                class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end item  -->
                                            @endforeach
                                        @endif
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- end selling-product -->
                        </div>
                    </div>
                </div>
                <!-- end container lastest-blog-->
                <!-- <div class="container" id="show-more">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="show-more text-center mb-3">
                                            <a href="" class="see-more d-inline-block py-1 px-5 border">XEM THÊM</a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
            </div>
            <!-- end content  -->
        @endsection
