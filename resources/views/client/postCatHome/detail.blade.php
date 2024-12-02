
@extends('layouts.client')
@section('title', $post_cat_home->post_title)
@section('content')
<div id="wp-content" class="container">
    <nav aria-label="breadcrumb" id="breadcrumb-nav">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="trang-chu.html">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('postCatHome.detail', ['slug' => $post_cat_home->category_slug]) }}">{{$post_cat_home->post_title}}</a></li>
        </ol>
      </nav>
      <div class="box-head text-left mb-5">
        {!! $post_cat_home->category_content !!}
    </div>                 
               
    </div>
@endsection