@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<article class="mar-top40">
    <div class="container">
        <div class="breadcrumbs">
            <ul>
               <li><a href="{{ route('home') }}">Trang chủ</a></li>			
			<li class="active">Tags</li>
            </ul>
        </div>
    </div>
    <section id="product" class="marg40">
        <div class="container">
            <div class="title-section">
                HIỂN THỊ KẾT QUẢ CHO “{!! $detail->name !!}”
            </div>
        </div>
        <div class="container">
            <div class="list-products clearfix">               
            	@if($productList)
				  	@foreach($productList as $product)
				  	<div class="box-product">
					  	<div class="item-product">
	                        <div class="image">
	                        	<a href="{{ route('product', [$product->slug, $product->id ])}}">
	                        		<img src="{{ $product->image_url ? Helper::showImage($product->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $product->name !!}">
	                        	</a>
	                        </div>
	                        <div class="info-product">
	                            <h3><a href="{{ route('product', [$product->slug, $product->id ])}}" title="{!! $product->title !!}">{!! $product->name !!}</a></h3>	                            
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
		  		@endif                
            </div>
            <nav class="block-pagination">
				{{ $productList->links() }}
			</nav><!-- /block-pagination -->
        </div>
    </section><!-- End product -->
</article>
@endsection