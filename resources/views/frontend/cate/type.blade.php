@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')

<div class="block2 block-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="{{ route('home') }}">Trang chủ</a></li>			
			<li class="active">{!! $typeDetail->name !!}</li>
		</ul>
	</div>
</div><!-- /block-breadcrumb -->
<div class="block block_big-title">
	<div class="container">
		<h2>{!! $typeDetail->name !!}</h2>
		<p class="desc">{!! $typeDetail->description !!}</p>
	</div>
</div><!-- /block_big-title -->
@if($parentList)
@foreach($parentList as $parent)
@if($cateArr[$parent->id])
<div class="block block-product block-title-commom">
  <div class="container">
    <div class="block block-title">
      <h1>
        <i class="fa fa-home"></i>
        <a href="{{ route('cate-parent', [$parent->type->slug, $parent->slug]) }}" title="{!! $parent->name !!}">{!! $parent->name !!}</a>
      </h1>
    </div>
    <div class="block-content">
      <ul class="owl-carousel owl-theme owl-style2" data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":2},"768":{"items":3},"800":{"items":3},"992":{"items":4}}'>
          @if($cateArr[$parent->id])
          @foreach($cateArr[$parent->id] as $cate)
          <li class="item">
            <div class="thumb">
              <a href="{{ route('cate', [$parent->type->slug, $parent->slug, $cate->slug]) }}" title="{!! $cate->name !!}"><img src="{{ Helper::showImageThumb($cate->image_url, 3) }}" alt="{!! $cate->name !!}"></a>
            </div>
            <div class="title">
              <h2><a href="{{ route('cate', [$parent->type->slug, $parent->slug, $cate->slug]) }}" title="{!! $cate->name !!}">{!! $cate->name !!}</a></h2>
            </div>
          </li>
          @endforeach
          @endif
    </div>
  </div>
</div><!-- /block_big-title -->
@endif
@endforeach
@endif
@endsection