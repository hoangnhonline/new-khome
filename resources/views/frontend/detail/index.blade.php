@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<article class="mar-top20">
	<div class="container">
		<div class="breadcrumbs">
	        <ul>
	            <li><a href="{{ route('home') }}">Trang chủ</a></li>
	            <li><a href="{{ route('cate-parent', [$detail->cateParent->slug]) }}">{!! $detail->cateParent->name !!}</a></li>
	            <li><a href="{{ route('cate', [ $detail->cateParent->slug, $detail->cate->slug ]) }}">{!! $detail->cate->name !!}</a></li>
				<li class="active">{!! $detail->name !!}</li>	           
	        </ul>
	    </div>
	</div>
    <section id="detail-product" class="marg40">
        <div class="container marg40">
            <div class="row">
                <div class="col-md-6 feature-image">
                    <img src="{{ Helper::showImage($detail->image_url) }}" alt="{!! $detail->name !!}">
                </div>
                <div class="col-md-6">                    
                    <div class="title-section">
                        {!! $detail->name !!}
                    </div>
                    <div class="price">
                        <i class="fa fa-usd" aria-hidden="true"></i> 
                        @if($detail->is_sale == 1 && $detail->price_sale > 0)
                        	{{ number_format($detail->price_sale) }}đ
                        @else
                        	{{ number_format($detail->price) }}đ
                        @endif
                        
                        @if($detail->is_sale == 1 && $detail->price_sale > 0)
                            <small>{{ number_format($detail->price_sale) }}đ</small>
                        @endif
                    </div>
                    <div class="social block-share">
                        <div class="share-item">
							<div class="fb-like" data-href="{{ url()->current() }}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
						</div>
						<div class="share-item" style="max-width: 65px;">
							<div class="g-plus" data-action="share"></div>
						</div>
						<div class="share-item">
							<a class="twitter-share-button"
						  href="https://twitter.com/intent/tweet?text={!! $detail->name !!}">
						Tweet</a>
						</div>
                    </div>
                    @if($detail->description)
                    <p class="des">
                        {!! $detail->description !!}
                    </p>
                    @endif
                    <button type="button" data-id="{{ $detail->id }}" class="btn btn-yellow btn-flat @if(Session::has('login')) btn-order-main @endif" @if(!Session::has('login')) data-dismiss="modal" data-toggle="modal" data-target="#login-form" @endif>MUA NGAY</button>
                    <button type="button" data-id="{{ $detail->id }}" class="btn btn-grey btn-flat @if(Session::has('login')) btn-order @endif" @if(!Session::has('login')) data-dismiss="modal" data-toggle="modal" data-target="#login-form" @endif>THÊM VÀO GIỎ HÀNG</button>
                </div>
            </div>
        </div>
        @if($otherList)
                    
        <div class="container">
            <div id="nvn_sp_goiy" class="owl-carousel">
            @foreach($otherList as $product)
                <div class="item">
                    <div class="imgleft">
                        <div class="image"><a href="{{ route('product', [$product->slug, $product->id ])}}" title="{!! $product->title !!}"><img src="{{ $product->image_url ? Helper::showImage($product->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $product->name !!}"/></div>
                        <h3><a  style="color:#333" href="{{ route('product', [$product->slug, $product->id ])}}" title="{!! $product->title !!}">{!! $product->name !!}</a></h3>                        
                        <p><b class="cl_ea0000">@if($product->is_sale == 1 && $product->price_sale > 0)
                                            {{ number_format($product->price_sale) }}đ
                                        @else
                                            {{ number_format($product->price) }}đ
                                        @endif</b></p>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
        @endif
        <div class="container">
            <div class="bg-eaeaea">
                <span>THỰC ĐƠN</span>
                <a href="{{ route('cate-parent', $catePromotion->slug) }}">KHUYẾN MÃI</a>
            </div>
        </div>
        <div class="container">
            <div class="tabs-custom">
                <div id="myScrollspy" class="col-tab-menu hidden-xs">
                    <ul class="nav tab-menu affix">                        
                        <li class="active" ><a href="#all" data-target-id="">Sản phẩm hot</a></li>
                        @foreach($cateList as $cate)
                        <li><a href="#{{ $cate->slug }}" data-target-id="">{!! $cate->name !!}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-tab-content admin-content">
                    <!--<p class="blockquote-promotion">
                        <span>Giảm giá 30%</span> cho tất cả các sản phẩm dưới đây
                    </p>-->                    
                    <div class="list-box-items" id="all">
                        <div class="title-admin-content" style="font-size: 15px; color: #ffd900">SẢN PHẨM HOT</div>                        
                        @foreach($hotProductList as $product)
                        <div class="box-item">
                            <div class="image">
                                <img src="{{ $product->image_url ? Helper::showImage($product->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $product->name !!}">
                            </div>
                            <p class="title-box-item">
                                <a class="title-box-item" href="{{ route('product', [$product->slug, $product->id ]) }}" title="{!! $product->name !!}">{!! $product->name !!}</a>
                                </p>
                            <div class="box-price">
                                <a href="javascript:;" class="@if(Session::has('login')) btn-order @endif" @if(!Session::has('login')) data-dismiss="modal" data-toggle="modal" data-target="#login-form" @endif data-id="{{ $product->id }}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                                <div class="price">
                                    @if($product->is_sale == 1 && $product->price_sale > 0)
                                        {{ number_format($product->price_sale) }}đ
                                    @else
                                        {{ number_format($product->price) }}đ
                                    @endif
                                    <!--<small>Giảm 10%</small>-->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($cateList)
                    @foreach($cateList as $cate)
                    @if(isset($productArr[$cate->id]) )
                    <div class="list-box-items" id="{{ $cate->slug }}">
                        
                        <div class="title-admin-content" style="font-size: 15px; color: #ffd900">{!! $cate->name !!}</div>
                        @foreach($productArr[$cate->id] as $product)
                        <div class="box-item">
                            <div class="image">
                                <a href="{{ route('product', [$product->slug, $product->id ]) }}" title="{!! $product->name !!}">
                                <img src="{{ $product->image_url ? Helper::showImage($product->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $product->name !!}"/></a>
                            </div>
                            
                                <a class="title-box-item" href="{{ route('product', [$product->slug, $product->id ]) }}" title="{!! $product->name !!}">{!! $product->name !!}</a>
                                @if(Helper::slm($product->id))
                            <div class="font12 cl_999">Đã được đặt <span class="cl_333">{{ Helper::slm($product->id) }}</span> lần
                           
                        </div> @endif
                            <div class="box-price">
                                <a href="javascript:;" class="@if(Session::has('login')) btn-order @endif" @if(!Session::has('login')) data-dismiss="modal" data-toggle="modal" data-target="#login-form" @endif data-id="{{ $product->id }}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                                <div class="price">
                                    @if($product->is_sale == 1 && $product->price_sale > 0)
                                        {{ number_format($product->price_sale) }}đ
                                    @else
                                        {{ number_format($product->price) }}đ
                                    @endif   
                                    <!--<small>Giảm 10%</small>-->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div><!--End tab custom-->
            <div class="cart-info cart-side">
                <div class="nvn-class-affix">
                <div class="title-cart-info">THÔNG TIN GIỎ HÀNG</div>
                <div class="content-cart-info">
                    <ul class="nvn-user">
                        <li class="bg_ddd">
                            <span class="pull-left cl_333"><img src="{{ Session::get('avatar') ? Session::get('avatar') :  URL::asset('public/assets/img/icon.png') }}" alt="{{ Session::get('username') }}" width="30" style="border-radius: 25px">{{ Session::get('username') }}</span>
                            <span class="pull-right cl_333 cart-number">{{ Session::get('products') ? array_sum(Session::get('products')) : 0 }} món</span>
                        </li>
                    </ul>
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
                        <li>
                            <span class="pull-left cl_666">Phí vận chuyển (Est.)</small></span>
                            <span class="pull-right cl_333">5.000đ/km</span>
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
                     <div class="list-items-cart">           
                    
                    </div>
                     <ul class="">
                     <li><p class="cart-empty">Chưa có sản phẩm nào.</p></li>
                     </ul>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>

            </div>
            <div class="clearfix"></div>
        </div>
    </section><!-- End product -->
</article>
<input type="hidden" id="rating-route" value="{{ route('rating') }}">
<form id="rating-form">
	{{ csrf_field() }}
	<input type="hidden" id="object_id" name="object_id" value="{{ $detail->id }}">
	<input type="hidden" id="object_type" name="object_type" value="1">
	<input type="hidden" id="score" name="score" value="">
</form>
@stop
@section('js')    
<script type="text/javascript">
	$(document).ready(function(){
        jQuery('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                responsive: {
                    380: {
                       items: 2
                    },
                    603: {
                       items: 3
                    },
                    768: {
                       items: 4
                    },
                    1200: {
                        items: 5
                    }
                }
            });
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

        $(document).ready(function($){  
          $('.btn-order').click(function() {
            $(this).html('<i class="fa fa-spin fa-spinner" style="margin-left:5px"></i>');
            var product_id = $(this).data('id');
            addToCart(product_id);
          });
        $('.btn-order-main').click(function() {
            $(this).html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled', 'disabled');
            var product_id = $(this).data('id');
            addToCartMain(product_id);
            
          });
        });
        $(document).on('change', '.change_quantity', function() {
            var quantity = $(this).val();
            var id = $(this).data('id');
            updateQuantity(id, quantity, 'ajax');
        });
        $(document).on('click', '.qty-up', function(){
            var obj = $(this);
            var quantityObj = obj.parents('.item-cart').find('.qty-val');            
            quantityObj.val(parseInt(quantityObj.val()) + 1);
            updateQuantity(obj.data('id'), parseInt(quantityObj.val()), 'normal');
        });
        $(document).on('click', '.qty-down', function(){
            var obj = $(this);
            var quantityObj = obj.parents('.item-cart').find('.qty-val');   
            var currQuantity = parseInt(quantityObj.val());         
            if( currQuantity > 1){
                quantityObj.val(currQuantity - 1);
            }else if(currQuantity == 1){
                obj.parents('.item-cart').remove();
            }
            updateQuantity(obj.data('id'), (currQuantity - 1), 'normal');
        });
        jQuery(document).ready(function () {
                if (jQuery(document).width() >= 992) {
                    
                   var voffset = jQuery("#myScrollspy").offset();
                   var vtop = voffset.top + 50;
                   var vbot = jQuery("footer").height() + 160;
                   jQuery("#myScrollspy ul").affix({
                       offset: {
                           top: vtop,
                           bottom: vbot
                       }
                   });
                   jQuery(".cart-side.cart-info .nvn-class-affix").affix({
                       offset: {
                           top: vtop,
                           bottom: vbot
                       }
                   });
               }
                // Add smooth scrolling on all links inside the navbar
                $("#myScrollspy a").on('click', function (event) {
                    // Make sure this.hash has a value before overriding default behavior
                    if (this.hash !== "") {
                        // Prevent default anchor click behavior
                        event.preventDefault();

                        // Store hash
                        var hash = this.hash;

                        // Using jQuery's animate() method to add smooth page scroll
                        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top
                        }, 300, function () {

                            // Add hash (#) to URL when done scrolling (default click behavior)
                            window.location.hash = hash;
                        });
                    }  // End if
                });
            });

	});	
function addToCart(product_id) {
  $.ajax({
    url: $('#route-add-to-cart').val(),
    method: "GET",
    data : {
      id: product_id
    },
    success : function(data){
       window.location.reload();
    }
  });
}
function addToCartMain(product_id) {
  $.ajax({
    url: $('#route-add-to-cart').val(),
    method: "GET",
    data : {
      id: product_id
    },
    success : function(data){
       location.href="{{ route('cart') }}";
    }
  });
}	
function calTotalProduct() {
    var total = 0;
    $('.change_quantity ').each(function() {
        total += parseInt($(this).val());
    });
    $('.order_total_quantity').html(total);
}

function updateQuantity(id, quantity, type) {
    $.ajax({
        url: $('#route-update-product').val(),
        method: "POST",
        data: {
            id: id,
            quantity: quantity
        },
        success: function(data) {
            location.reload();
            /*
            $.ajax({
                url: $('#route-short-cart').val(),
                method: "GET",

                success: function(data) {
                    if (type == 'ajax') {
                        $('#short-cart-content').html(data);
                        calTotalProduct();
                    } else {
                        window.location.reload();
                    }
                }
            });
            */
        }
    });
}
</script>
@stop
