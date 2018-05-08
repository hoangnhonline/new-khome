@extends('frontend.layout')
@include('frontend.partials.meta')

@section('content')
<article>
  <section class="block-image marg40">
      <img src="img/banner.png" alt=""/>
  </section>
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
                        ĐƠN HÀNG CỦA TÔI
                    </div>
                    <table class="table bill-booked">
                        <thead>
                            <tr>
                                <th class="text-center">Mã ĐH</th>
                                <th class="text-center">Ngày mua</th>
                                <th class="text-left">Sản phẩm</th>
                                <th class="text-center">Tổng tiền</th>
                                <th class="text-center">Trạng thái ĐH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="text-center cl_ea0000">
                                    <a href="{{ route('order-detail', $order->id) }}">{{ str_pad($order->id, 6, "0", STR_PAD_LEFT) }}</a>
                                </td>
                                <td class="text-center">{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                                <td>
                                    @foreach($order->order_detail()->get() as $detail)
                                    <p>{{ Helper::getName($detail->sp_id, 'product') }}</p>
                                    @endforeach
                                </td>
                                <td class="text-center"><strong>{{ number_format($order->tong_tien) }}đ</strong></td>
                                <td class="text-center text-success">{{ isset($status[$order->status]) ? $status[$order->status] : ""  }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
             
          </div><!--End tab custom-->
      </div>
    </section><!-- End News -->
</article>
@stop