@extends('layouts.client')
@section('title', $post->post_title)
@section('content')
<div id="wp-content" class="container">
    <nav aria-label="breadcrumb" id="breadcrumb-nav">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="trang-chu.html">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="">{{$post->post_title}}</a></li>
        </ol>
      </nav>
      <div class="box-head text-left mb-5">
        {!! $post->content !!}
    </div>                 
               
    </div>
@endsection