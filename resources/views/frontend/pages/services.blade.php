@extends('frontend.layout') 
  
@include('frontend.partials.meta')
@section('content')
<div class="block2 block-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="{{ route('home') }}">Trang chủ</a></li>
			<li class="active">Dịch vụ</li>
		</ul>
	</div>
</div><!-- /block-breadcrumb -->
<div class="block block-two-col container">
	<div class="row">
		<div class="col-sm-9 col-xs-12 block-col-left">
			<div class="block-title-commom block-service clearfix">
				<div class="block block-title">
					<h1>
						<i class="fa fa-home"></i>
						DỊCH VỤ
					</h1>
				</div>
				<div class="block-content">
					<div class="row">
						<?php $i = 0; ?>
						@foreach($servicesList as $ser)
						<?php $i ++ ; ?>
						<div class="col-sm-4 item">
							<div class="thumb">
								<a href="{{ route('services-detail', [ $ser->slug, $ser->id ]) }}" title="{!! $ser->title !!}"><img src="{{ Helper::showImage($ser->image_url) }}" alt="{!! $ser->title !!}"></a>
							</div>
							<div class="des">
								
								<a  class="title" href="{{ route('services-detail', [ $ser->slug, $ser->id ]) }}" title="{!! $ser->title !!}">{!! $ser->title !!}</a>
								
								<p class="description">{!! $ser->description !!}</p>
							</div>
						</div><!-- /item -->
						@if($i%3 == 0)
						</div><div class="row">
						@endif
						@endforeach
					</div>					
				</div>
			</div><!-- /block-ct-news -->
		</div><!-- /block-col-left -->
		<div class="col-sm-3 col-xs-12 block-col-right">
			<div class="block-sidebar">
				<div class="block-module block-links-sidebar">
					<div class="block-title">
						<h2>
							<i class="fa fa-home"></i>
							DANH MỤC DỊCH VỤ
						</h2>
					</div>
					<div class="block-content">
						<ul class="list">
							@foreach($servicesList as $ser)
							<li><a href="{{ route('services-detail', [ $ser->slug, $ser->id ]) }}" title="{!! $ser->title !!}">{!! $ser->title !!}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div><!-- /block-col-right -->
	</div>
</div><!-- /block_big-title -->

@stop
  