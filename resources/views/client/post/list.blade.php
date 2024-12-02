@extends('layouts.client')
@section('title', 'TIN TỨC 2VEXPRESS')
@section('content')
    <div id="wp-content" class="container">
        <nav aria-label="breadcrumb" id="breadcrumb-nav" class="post">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Tin Tức</a></li>
            </ol>
        </nav>
        <div class="container" id="lastest-blog">
            <div class="row">
                <div class="col-md-12">
                    <div class="box lastest-blog">
                        <div class="box-head text-left">
                            <h2 class="font-weight-bold" style="color: #343434;">TIN TỨC</h2>
                            <p style="color: #aaa8a8;">Những bài viết tin tức bạn có thể xem bây giờ</p>
                        </div>
                        {{-- start box body  --}}
                        @foreach ($list_posts->chunk(3) as $chunk)
                            <!-- Chia danh sách thành các nhóm 3 bài viết -->
                            <div class="box-body">
                                <div class="row"> <!-- Sử dụng grid row của Bootstrap -->
                                    @foreach ($chunk as $post)
                                        <!-- Duyệt qua từng bài viết trong mỗi nhóm -->
                                        <div class="col-md-4 @if (count($chunk) == 1) col-12 @endif mb-4">
                                            <!-- Nếu chỉ có 1 bài thì full chiều rộng -->
                                            <div class="card">
                                                <a href="{{ route('post.detail', ['slug' => $post->post_slug]) }}" class="product-thumb d-block">
                                                    <img src="{{ asset($post->image->image_url) }}" alt=""
                                                        class="card-img-top">
                                                </a>
                                                <div class="card-body text-center">
                                                    <span
                                                        class="text-center d-block fashion p-2">{{ $post->category->category_name}}</span>
                                                    <h5 class="card-title">
                                                        <a href="{{ route('post.detail', ['slug' => $post->post_slug]) }}" class="text-decoration-none text-dark">
                                                            {{ $post->post_title }}
                                                        </a>
                                                    </h5>
                                                    <span
                                                        class="date d-block p-2">{{ $post->created_at->format('F d, Y') }}</span>
                                                    <p class="card-text">{{ $post->post_description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- end lastest-blog -->
                <!-- pagination  -->
                <div class="container mt-2 mb-3" id="pagination-post">
                    <div class="pagination">
                        {{ $list_posts->links() }}
                    </div>
                </div>
                <!-- end pagination  -->
            </div>
        </div>
    </div>
    </div>
@endsection
