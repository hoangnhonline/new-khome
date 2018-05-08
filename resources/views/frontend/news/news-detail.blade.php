@extends('frontend.layout') 

@include('frontend.partials.meta') 

@section('content')
<article class="mar-top40">
    <div class="container">
        <div class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}" title="Trở về trang chủ">Trang chủ</a></li>
                <li><a href="{{ route('cate-parent', $cateDetail->slug ) }}" title="{!! $cateDetail->name !!}">{!! $cateDetail->name !!}</a></li>
                <li>{!! $detail->title !!}</li>
            </ul>
        </div>
    </div>
    <section id="promotion-single" class="marg40">
        <div class="container">
            <div class="title-section">
                {!! $detail->title !!}
            </div>
        </div>
        <div class="container">
        	
            <div class="content-single">
	            <div class="reviews-summary" id="rating-summary" itemscope itemtype="http://schema.org/Review">							
	            </div><!-- /reviews-summary -->
	            <div class="block-author">
	            	<ul>
	            		<li>
	            			<span>Tác giả:</span>
	            			<span class="name">{!! $detail->createdUser->display_name !!}</span>
	            		</li>
	            		<li>
	            			{!! date('d/m/Y', strtotime($detail->created_at)) !!}
	            		</li>
	            		<li>
	            			{!! Helper::view($detail->id, 2) !!} lượt xem
	            		</li>
	            	</ul>
	            </div>
	            <div class="clearfix"></div>
                {!! $detail->content !!}
                <div class="clearfix"></div>
                @if($tagSelected->count() > 0)
        				<div class="tags">
        					Tags:
        						<?php $i = 0; ?>
        				        @foreach($tagSelected as $tag)
        				        <?php $i++; ?>
        						<a href="{{ route('tag', $tag->slug) }}" title="{!! $tag->name !!}">{!! $tag->name !!}</a>
        						@endforeach
        					
        				</div><!-- /block-tags -->
        				@endif
                @if($otherList->count() > 0)
                <div class="related-posts">
                    <div class="title-related"><span>TIN LIÊN QUAN</span></div>
                    <ul>
                        @foreach( $otherList as $articles)
                        <li><a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}" ><i class="fa fa-newspaper-o" aria-hidden="true"></i> {!! $articles->title !!}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>            
            <div class="cart-info cart-side">
              <div class="title-cart-info">THÔNG TIN GIỎ HÀNG</div>
              <div class="content-cart-info">
                  @if(!empty(Session::get('products')))
                  <div class="list-items-cart">                        
                      <?php $total = 0; ?>
                      @if( $arrProductInfo->count() > 0)
                          <?php $i = 0; ?>
                        @foreach($arrProductInfo as $product)
                        <?php 
                        $i++;
                        $price = $product->is_sale ? $product->price_sale : $product->price; 

                        $total += $total_per_product = ($getlistProduct[$product->id]*$price);
                        
                        ?>
                      <div class="item-cart">
                          <div class="info-qty">
                              <a class="qty-up" data-id="{{ $product->id }}" href="javascript:;"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                              <input step="1" name="quantity" value="{{ $getlistProduct[$product->id] }}" class="qty-val">
                              <a class="qty-down" data-id="{{ $product->id }}" href="javascript:;"><i class="fa fa-minus-square" aria-hidden="true"></i></a>
                          </div>
                          <p class="title-item">{!! $product->name !!}</p>
                          <div class="price clearfix" style="font-size:14px">   
                              <p class="pull-left" >{{ $getlistProduct[$product->id] }}x{{ number_format($price) }}</p>                             
                              <p class="pull-right">{!! number_format($total_per_product) !!}đ</p>
                          </div>
                      </div>   
                      
                      @endforeach
                      @endif                     
                  </div>
                  <ul class="">
                      <li>
                          <span class="pull-left cl_666">Cộng</span>
                          <span class="pull-right cl_333">{!! number_format($total) !!}đ</span>
                      </li>
                      <!--<li>
                          <span class="pull-left cl_ea0000">Giảm 30% tổng bill</span>
                          <span class="pull-right cl_ea0000">66.000đ</span>
                      </li>-->
                      <li>
                          <span class="pull-left cl_666">Phí phục vụ<br><small>(10% trên tổng đơn hàng)</small></span>
                          <span class="pull-right cl_333">{{ number_format($total*10/100) }}đ</span>
                      </li>
                      <li class="bg_fffdee">
                          <span class="pull-left cl_666">Tạm tính</span>
                          <span class="pull-right cl_ea0000">{!! number_format($total + $total*10/100) !!}đ</span>
                          <div class="clearfix"></div>
                          <div class="action-cart ">
                              <a href="{{ route('address-info') }}" class="btn btn-yellow">Đặt hàng</a>
                              <a href="{{ route('empty-cart') }}" onclick="return confirm('Quý khách có chắc chắn bỏ hết hàng ra khỏi giỏ?'); " class="btn btn-defaultyellow">Xoá</a>
                          </div>
                      </li>
                  </ul>
                  @else
                  <p class="cart-empty">Chưa có sản phẩm nào.</p>
                  @endif
              </div>
          </div>
        </div>
    </section><!-- End product -->
</article>
<input type="hidden" id="rating-route" value="{{ route('rating') }}">
<form id="rating-form">
	{{ csrf_field() }}
	<input type="hidden" id="object_id" name="object_id" value="{{ $detail->id }}">
	<input type="hidden" id="object_type" name="object_type" value="2">
	<input type="hidden" id="score" name="score" value="">
</form>
@stop
@section('js')
<script src="{{ URL::asset('public/assets/lib/starrating/js/star-rating.js') }}"></script>  
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
	        url : $('#rating-route').val(),
	        type : 'POST',
	        dataType : 'html',
	        data : $('#rating-form').serialize(),
	        success : function(data){
	            $('#rating-summary').html(data);
	            var $input = $('input.rating');
	            if ($input.length) {
	                $input.removeClass('rating-loading').addClass('rating-loading').rating();
	            }
	        }
   		});
	});
</script>  
@stop