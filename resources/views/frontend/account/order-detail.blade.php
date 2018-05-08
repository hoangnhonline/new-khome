@extends('frontend.layout')
@include('frontend.partials.meta')

@section('content')
<article>
  <div class="container">
      <div class="breadcrumbs">
          <ul>
              <li><a href="/">Trang chủ</a></li>
              <li>Tài khoản</li>
          </ul>
      </div>
  </div>
  <section id="account" class="marg40">
      <div class="container">
          <div class="tabs-custom">
              <div class="col-tab-menu">
                  <div class="clearfix marg10 user-account">
                      <div class="image"><img src="{{ URL::asset('public/assets/img/icon.png') }}" alt="avatar"/></div>
                      <span>
                          Tài khoản của<br/>
                          <b>{!! $customer->fullname !!}</b>
                      </span>
                  </div>
                  <ul class="tab-menu">
                      <li ><a href="{{ route('account-info') }}"><i class="fa fa-user" aria-hidden="true"></i> Thông tin tài khoản</a></li>
                      <li class="active"><a href="{{ route('order-history') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> Quản lý đơn hàng</a></li>
                      <li><a href="{{ route('account-address') }}" ><i class="fa fa-home" aria-hidden="true"></i> Số địa chỉ</a></li>
                      <!--<li><a href="javascript:void(0)" ><i class="fa fa-star" aria-hidden="true"></i> Điểm tích luỹ</a></li>-->
                  </ul>
              </div>              
              <div class="col-tab-content admin-content" id="all">
                  <div class="title-section">
                      CHI TIẾT ĐƠN HÀNG #{{ $str_order_id }} - {{ $status[$order->status] }}
                  </div>                                    
                  <div class="marg10">
                      <!--<div class="little-title">THÔNG BÁO</div>
                      <div class="well wll">
                          <table>
                              <tr>
                                  <td>11:35:25</td>
                                  <td>20/08/2017</td>
                                  <td>Chúng tôi vừa bàn giao đơn hàng của quý khách đến đối tác vận chuyển KAFFEE Team. Dự kiến giao hàng vào Thứ 2 - 21/08/2017 Thứ 2 - 21/08/2017</td> 
                              </tr>
                          </table>
                      </div>-->
                      <div class="row clearfix">
                          <div class="col-md-6">
                              <div class="little-title">ĐỊA CHỈ NGƯỜI NHẬN</div>
                              <div class="well wll">
                                  <p>
                                      Tên người nhận: <b>{{ $order->address->fullname }}</b>
                                  </p>
                                  <p>
                                      Địa chỉ: <b>{{ $order->address->address }}, {{ $order->address->ward->name }}, {{ $order->address->district->name }}, {{ $order->address->city->name }}</b>
                                  </p>
                                  <p>
                                      Điện thoại: <b>{{ $order->address->phone }}</b>
                                  </p>
                                  @if($order->address->email)
                                  Email: <b>{{ $order->address->email }}</b>
                                  @endif
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="little-title">HÌNH THỨC THANH TOÁN</div>
                              <div class="well wll">
                                  @if($order->method_id == 1)
                                    COD
                                  @elseif($order->method_id == 2)
                                    Thanh toán bằng thẻ của K KAFFEE
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="clearfix">
                      <div class="little-title">SẢN PHẨM ĐƯỢC ĐẶT</div>
                      <table class="table booked">
                          <thead>
                              <tr>
                                  <th>Sản phẩm</th>
                                  <th>Giá</th>
                                  <th>Số lượng</th>
                                  <th>Coupon giảm giá</th>
                                  <th>Tạm tính</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php 
                              $totalTamTinh = 0;
                            ?>
                              @foreach($orderDetail as $rowOrder)
                              <?php 
                                $totalTamTinh += $rowOrder->tong_tien;
                              ?>
                              <tr>
                                  <td>
                                      <div class="image"><img src="{{ Helper::showImage($rowOrder->product->image_url) }}" alt="{!! $rowOrder->product->name !!}"/></div>
                                      <div class="title">
                                          {!! $rowOrder->product->name !!}
                                          <a href="javascript:;" data-id="{{ $rowOrder->sp_id }}" class="btn btn-order">Mua lại</a>
                                      </div>
                                  </td>
                                  <td class="cl_ea0000">{{ number_format($rowOrder->don_gia) }}đ</td>
                                  <td>
                                      <b>{{ $rowOrder['so_luong'] }}</b>
                                  </td>
                                  <td></td>
                                  <td><strong>{{ number_format($rowOrder->tong_tien) }}đ</strong></td>
                              </tr>
                               @endforeach
                             
                          </tbody>
                          <tfoot>
                              <tr>
                                  <td></td>
                                  <td colspan="2" class="text-left"><b>Tổng phụ</b></td>
                                  <td></td>
                                  <td class="text-right"><b>{!! number_format($totalTamTinh) !!}đ</b></td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td colspan="2" class="text-left"><b>Phí vận chuyển</span></b></td>
                                  
                                  <td></td>
                                  <td class="text-right"><b>{{ number_format($order->phi_van_chuyen) }}đ</b></td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td colspan="2" class="text-left"><b>Phí phục vụ</b><br/><small>(<span class="cl_ea0000">10%</span> trên tổng đơn hàng)</small></td>
                                  
                                  <td></td>
                                  <td class="text-right"><b>{{ number_format($totalTamTinh*10/100) }}đ</b></td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td colspan="2" class="text-left"><b>Tổng cộng</b></td>
                                  
                                  <td></td>
                                  <td class="text-right"><b class="cl_ea0000">{{ number_format($order->tien_thanh_toan) }}đ</b></td>
                              </tr>
                          </tfoot>
                      </table>
                      @if($order->status == 0)
                      <button id="btnHuy" class="btn btn-danger btn-sm" style="float:right"><i class="fa fa-times"></i>  Hủy đơn hàng</button>
                      @endif
                  </div>
              </div>
          </div><!--End tab custom-->
      </div>
    </section><!-- End News -->
</article>
@endsection
@section('js')
   <script type="text/javascript">
    $(document).ready(function() {

      $('#btnHuy').click(function(){ 
        $(this).attr('disabled', 'disabled');
        var obj = $(this);       
        if(confirm('Chắc chắn hủy đơn hàng?')){
          $.ajax({
            url : '{{ route('order-cancel') }}',
            type  : 'POST',
            data : {
              id : {{ $order->id }}
            },
            success : function(){
              alert('Hủy đơn hàng #{{ $str_order_id }} thành công');
              window.location.reload();
            }
          });
        }
      });
       $('.btn-order').click(function() {
          var product_id = $(this).data('id');
          addToCart(product_id);          
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
  </script>
@endsection