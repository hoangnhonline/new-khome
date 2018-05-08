@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<?php $total = 0; ?>
<article class="mar-top40">
  <div class="container">
      <div class="breadcrumbs">
          <ul>
              <li><a class="home" href="{{ route('home') }}" title="Trở về trang chủ">Trang chủ</a></li>             
              <li>Giỏ hàng</li>
          </ul>
      </div>
  </div>
  <section id="cart-page" class="marg40">
      <div class="container">
          <div class="title-section">
              GIỎ HÀNG
          </div>
      </div>
      <div class="container">
          <div class="colleft">
              <table class="table table-cart">
                  <thead>
                      <tr>
                          <th>SẢN PHẨM</th>
                          <th>GIÁ SẢN PHẨM</th>
                          <th>SỐ LƯỢNG</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if(!empty(Session::get('products')))
                       <?php $total = 0; ?>
                        @if( $arrProductInfo->count() > 0)
                            <?php $i = 0; ?>
                          @foreach($arrProductInfo as $product)
                          <?php 
                          $i++;
                          $price = $product->is_sale ? $product->price_sale : $product->price; 

                          $total += $total_per_product = ($getlistProduct[$product->id]*$price);
                          
                          ?>
                      <tr>
                          <td class="pos_rel">
                              <div class="image"><img src="{{ $product->image_url ? Helper::showImage($product->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $product->name !!}"/></div>
                              <h3>{!! $product->name !!}</h3>
                              <a class="product-remove" href="#">Xóa</a>
                          </td>
                          <td>
                              <div class="price">
                                  @if($product->is_sale == 1 && $product->price_sale > 0)
                                      {{ number_format($product->price_sale) }}đ
                                  @else
                                      {{ number_format($product->price) }}đ
                                  @endif 
                                  <!--<br/><small>375.000đ</small>-->
                              </div>
                          </td>
                          <td>
                              <div class="info-qty">
                                  <a class="qty-down" data-id="{{ $product->id }}" href="javascript:;">-</a>
                                  <input name="quantity" value="{{ $getlistProduct[$product->id] }}" title="SL" class="qty-val">
                                  <a class="qty-up" data-id="{{ $product->id }}" href="javascript:;">+</a>
                              </div>
                          </td>
                      </tr>  
                      @endforeach
                        
                        @endif   
                      @else
                        <tr>
                          <td colspan="3">Chưa có sản phẩm nào.</td>
                        </tr>  
                      @endif              
                  </tbody>
              </table>
              <div class="clearfix text-right">
                  <a href="{{ route('cate-parent', 'coffee') }}" class="btn btn-yellow"><i class="fa fa-long-arrow-left" aria-hidden="true" ></i> Tiếp tục mua hàng</a>
                  @if(!empty(Session::get('products')))
                  <a href="{{ route('empty-cart') }}" onclick="return confirm('Quý khách có chắc chắn bỏ hết hàng ra khỏi giỏ?'); " class="btn btn-grey"><i class="fa fa-trash-o" aria-hidden="true"></i> Xóa toàn bộ</a>
                  @endif
              </div>
          </div>
          <div class="colright">
              <div class="total-bill">
                  <table class="table">
                    <tr>
                          <td style="text-align: left" >Phí vận chuyển (Est.)</th>
                          <td class="text-left"><b>5.000đ/km</b></td>
                      </tr>
                      <tr>
                          <td style="text-align: left" >Tạm tính:</th>
                          <td class="text-left"><b>{{ number_format($total) }}đ</b></td>
                      </tr>
                      <tr>
                          <td style="text-align: left" class="bd-bt-ffd900">Phí phục vụ (10%)</th>
                          <td class="bd-bt-ffd900"><b>{{ number_format($total*10/100) }}đ</b></td>
                      </tr>                     
                      <tr>
                          <th><b>Tổng cộng <small>(Giá chưa bao gồm COD)</small>:</b></th>
                          <td>
                              <b>{!! number_format($total + $total*10/100) !!}đ</b><br/>                            
                          </td>
                      </tr>
                      <tr>
                          <td colspan="2" class="text-center"><small>Chưa bao gồm phí vận chuyển nếu có</small></td>
                      </tr>
                  </table>
              </div>
              @if(!empty(Session::get('products')))
              <button id="btnDatHang" data-href="{{ route('address-info') }}" class="btn btn-block btn-yellow">Tiến hành đặt hàng</button>
              @endif
          </div>
      </div>
  </section><!-- End product -->
</article>
@stop
@section('js')
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

        $(document).ready(function($){  
          $('a.btn-order').click(function() {
                var product_id = $(this).data('id');
                addToCart(product_id);
                
              });
        });
        $('#btnDatHang').click(function(){
          $(this).html('<i class="fa fa-spin fa-spinner"><i>').attr('disabled', 'disabled');
          location.href=$(this).data('href');
        });
        $(document).on('change', '.change_quantity', function() {
            var quantity = $(this).val();
            var id = $(this).data('id');
            updateQuantity(id, quantity, 'ajax');
        });
        $(document).on('click', '.qty-up', function(){
            var obj = $(this);
            var quantityObj = obj.parents('.info-qty').find('.qty-val');            
            quantityObj.val(parseInt(quantityObj.val()) + 1);
            updateQuantity(obj.data('id'), parseInt(quantityObj.val()), 'normal');
        });
        $(document).on('click', '.qty-down', function(){
            var obj = $(this);
            var quantityObj = obj.parents('.info-qty').find('.qty-val');   
            var currQuantity = parseInt(quantityObj.val());         
            if( currQuantity > 1){
                quantityObj.val(currQuantity - 1);
            }else if(currQuantity == 1){
                obj.parents('.item-cart').remove();
            }
            updateQuantity(obj.data('id'), (currQuantity - 1), 'normal');
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
@endsection








