@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<article class="mar-top20">
    <div class="container">
        <div class="breadcrumbs">
            <ul>
               	<li><a href="{{ route('home') }}">Trang chủ</a></li>		
				<li>{!! $parentDetail->name !!}</li>
            </ul>
        </div>
    </div>
    <section id="product" class="marg40">
        <div class="container">
            <div class="title-section">
                SẢN PHẨM HOT
            </div>
            <div class="list-products marg20 clearfix">
                <div class="owl-carousel">
                    @foreach($hotProductList as $product)
                    <div class="box-product item">
                        <div class="item-product">
                            <div class="image"><a href="{{ route('product', [$product->slug, $product->id ]) }}" title="{!! $product->name !!}">
                                <img src="{{ $product->image_url ? Helper::showImage($product->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $product->name !!}"/></a>
                            </div>
                            <div class="info-product">
                                <h3><a href="{{ route('product', [$product->slug, $product->id ]) }}" title="{!! $product->name !!}">{!! $product->name !!}</a></h3>
                                <div class="price">
                                    Giá: 
                                    <span>
                                        @if($product->is_sale == 1 && $product->price_sale > 0)
                                            {{ number_format($product->price_sale) }}đ
                                        @else
                                            {{ number_format($product->price) }}đ
                                        @endif                                  
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
                <!--<div class="viewmore-product"><a href="javascript:void(0)">Xem chi tiết</a></div>-->
            </div>
            @if($cateList)
			@foreach($cateList as $cate)
			@if(isset($productArr[$cate->id]) && count($productArr[$cate->id]) > 0 )
            <div class="title-section">
                {!! $cate->name !!}
            </div>
            <div class="list-products marg20 clearfix">
                <div class="owl-carousel">
		  			@foreach($productArr[$cate->id] as $product)
                    <div class="box-product item">
                        <div class="item-product">
                            <div class="image"><a href="{{ route('product', [$product->slug, $product->id ]) }}" title="{!! $product->name !!}">
                            	<img src="{{ $product->image_url ? Helper::showImage($product->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $product->name !!}"/></a>
                            </div>
                            <div class="info-product">
                                <h3><a href="{{ route('product', [$product->slug, $product->id ]) }}" title="{!! $product->name !!}">{!! $product->name !!}</a></h3>
                                <div class="price">
                                    Giá: 
                                    <span>
                                    	@if($product->is_sale == 1 && $product->price_sale > 0)
				                        	{{ number_format($product->price_sale) }}đ
				                        @else
				                        	{{ number_format($product->price) }}đ
				                        @endif                                	
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="viewmore-product"><a href="{{ route('cate', [ $parentDetail->slug, $cate->slug ]) }}">Xem tất cả</a></div>
            </div>
            @endif
			@endforeach
			@endif
        </div>
    </section><!-- End product -->
</article>
@stop
@section('js')
<script src="{{ URL::asset('public/assets/lib/owlcarousel/dist/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		jQuery('.owl-carousel').owlCarousel({
            loop: false,
            margin: 0,
            nav: true,
            responsive: {
                0:{
                    items: 2
                },
                603:{
                    items: 3
                },
                992: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        });
	});
</script>
@stop