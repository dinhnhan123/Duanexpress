@extends('layouts.client')
@section('title', 'GIỚI THIỆU 2VEXPRESS')
@section('content')
<div id="wp-content" class="container">
    <nav aria-label="breadcrumb" id="breadcrumb-nav">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="trang-chu.html">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{route('page.detail',$page->slug)}}">Giới thiệu về V2EXPRESS</a></li>
        </ol>
      </nav>
      <div class="box-head text-left mb-5">
        {!! $page->content !!}
    </div>                 
               
    </div>
@endsection