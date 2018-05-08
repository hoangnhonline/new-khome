@extends('frontend.layout') 
  
@include('frontend.partials.meta')
@section('content')

		<div class="block2 block-breadcrumb">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="{{ route('home')}}">Trang chủ</a></li>
					<li><a href="{{ route('services')}}">Dịch vụ</a></li>
					<li class="active">{!! $detail->title !!}</li>
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
							{!! $detail->title !!}
						</h1>
					</div>
					<div class="block-content">
						<div class="block-article">
							<div class="block block-content">						
								{!! $detail->content !!}
							</div>
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
								<li><a @if(isset($detail) && $detail->id == $ser->id) class="active" @endif href="{{ route('services-detail', [ $ser->slug, $ser->id ]) }}" title="{!! $ser->title !!}">{!! $ser->title !!}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div><!-- /block-col-right -->			
		</div><!-- /container-->
		</div>
@stop
  