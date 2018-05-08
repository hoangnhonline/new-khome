@extends('frontend.layout') 

@include('frontend.partials.meta') 

@section('content')
<article class="mar-top20">
  <div class="container">
      <div class="breadcrumbs">
          <ul>
              <li><a href="{{ route('home') }}" title="Trở về trang chủ">Trang chủ</a></li>            
                <li class="active">Tags</li>
          </ul>
      </div>
  </div>
  <section id="promotion" class="marg40 mar-top10">
      <div class="container">
          <div class="title-section">
             HIỂN THỊ KẾT QUẢ CHO “{!! $detail->name !!}”
          </div>
      </div>
      <div class="container">
          <div class="list-promotions">
              @foreach( $articlesArr as $articles )
              <div class="item-promotion">
                  <div class="image">
                    <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}">
                      <img title="{!! $articles->title !!}" src="{{ $articles->image_url ? Helper::showImage($articles->image_url) : URL::asset('public/assets/img/no-img.png') }}" alt="{!! $articles->title !!}">
                    </a>
                  </div>
                  <div class="info-item-promotion">
                      <div class="title-item-promotion">
                        <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}">{!! $articles->title !!}</a>
                      </div>
                      <div class="date-item"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('d/m/Y', strtotime($articles->created_at)) }}</div>
                      <p>{!! $articles->description!!}</p>
                  </div>
              </div>
              @endforeach          
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
@stop