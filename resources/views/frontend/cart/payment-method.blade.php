@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<article class="mar-top40">
  <div class="container">
      <div class="breadcrumbs">
          <ul>
              <li><a href="/">Trang chủ</a></li>
              <li>Thông tin đặt hàng</li>
          </ul>
      </div>
  </div>
  <section id="checkout-page">
      <div class="container">
          <div class="title-section">
              THÔNG TIN ĐẶT HÀNG
          </div>
      </div>
      <div class="container">
          <div class="box-checkout marg40">
              <div class="header-box">
                  <div class="row bs-wizard" style="border-bottom:0;">
                      <div class="col-xs-4 bs-wizard-step complete">
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot">1</a>
                          <div class="bs-wizard-info text-center">Thời gian & địa chỉ nhận hàng</div>
                      </div>

                      <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot">2</a>
                          <div class="bs-wizard-info text-center">Thông tin đơn hàng</div>
                      </div>

                      <div class="col-xs-4 bs-wizard-step disabled"><!-- complete -->
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot">3</a>
                          <div class="bs-wizard-info text-center">Hoàn tất</div>
                      </div>
                  </div>
              </div>
              <div class="body-box order_cart_item">
                  <div class="row">
                      <div class="col-md-6">
                          <p>Chi tiết đơn hàng</p>
                          <div class="well customer">
                              <div class="image"><img src="{{ URL::asset('public/assets/img/icon.png') }}" alt="{!! $detailPrimary->fullname !!}"/></div>
                              {!! $detailPrimary->fullname !!}
                              <div class="sum-order pull-right">{{ count($listProductId) }} món</div>
                          </div>
                          <table class="table">
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
                                  <tr class="cart_item">
                                      <td class="text-left">
                                          <strong class="product-quantity cl_ea0000">{{ $getlistProduct[$product->id] }} ×</strong>&nbsp;{!! $product->name !!}
                                      </td>
                                      <td class="text-right">
                                          <span class="">{{ number_format($total_per_product) }}đ</span>
                                      </td>
                                  </tr>
                                  @endforeach
                        
                                  @endif 
                                  @endif
                              </tbody>
                              <tfoot>
                                  <tr class="cart-subtotal">
                                      <th class="text-left">Tiền hàng</th>
                                      <td class="text-right"><strong><span>{{ number_format($total) }}đ</span></strong></td>
                                  </tr>
                                  <tr>
                                      <th class="text-left">Phí phục vụ<br/><small>(<span class="cl_ea0000">10%</span> trên tổng đơn hàng)</small></th>
                                      <td class="text-right"><strong><span>{{ number_format($total*10/100) }}đ</span></strong> </td>
                                  </tr>
                                  <tr>
                                      <th class="text-left">Phí vận chuyển <span class="cl_ea0000">{!! Session::get('phi_van_chuyen')['text'] !!}</span><br>
                                        (Giá 5.000đ/km)
                                      </th>
                                      <td class="text-right"><strong><span>{!! number_format(Session::get('phi_van_chuyen')['phi']) !!}đ</span></strong> </td>
                                  </tr>
                                  <tr class="order-total">
                                  </tr>
                              </tfoot>
                          </table>
                      </div>
                      <div class="col-md-6">
                        <form role="form" id="paymentForm" action="{{ route('payment') }}" method="post">
                          {{ csrf_field() }} 
                          <div class="order-total clearfix">
                              <div class="pull-left">
                                  <b>Tổng cộng</b>
                              </div>
                              <div class="pull-right text-right">
                                  <b class="cl_ea0000">{!! number_format($total + $total*10/100 + Session::get('phi_van_chuyen')['phi']) !!}đ</b><br/>
                                  
                              </div>
                          </div>
                          <p><b>Hình thức thanh toán</b></p>
                          <div class="radio">
                              <label><input type="radio" name="method_id" value="1" checked>COD</label>
                          </div>
                          <div class="radio">
                              <label><input type="radio" name="method_id" value="2">Thanh toán bằng thẻ của K KAFFEE</label>
                          </div>
                          <div class="form-group clearfix checkout-action">
                              <div class="pull-right" style="margin-left:5px"><button type="button" id="btnPayment" class="btn btn-yellow btn-flat">THANH TOÁN</button></div>
                              <div class="pull-right"><a href="{{ route('address-info')}}" class="btn btn-grey btn-flat">QUAY LẠI</a></div>
                          </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</article>
@stop
@section('js')
   <script type="text/javascript">
   $(document).ready(function(){
    $('#btnPayment').click(function(){            
        $(this).html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled', 'disabled');
        $('#paymentForm').submit();      
    });
  });
  </script>
@stop








