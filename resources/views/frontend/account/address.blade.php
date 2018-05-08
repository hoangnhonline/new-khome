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
                      <li><a href="{{ route('order-history') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> Quản lý đơn hàng</a></li>
                      <li class="active"><a href="{{ route('account-address') }}" ><i class="fa fa-home" aria-hidden="true"></i> Số địa chỉ</a></li>
                      <!--<li><a href="javascript:void(0)" ><i class="fa fa-star" aria-hidden="true"></i> Điểm tích luỹ</a></li>-->
                  </ul>
              </div>
              <div class="col-tab-content admin-content" id="all">
                    <div class="title-section">
                        Số địa chỉ
                    </div>
                    @if(Session::has('message'))                        
                        <p class="alert alert-info" >{{ Session::get('message') }}</p>                  
                    @endif
                    <div class="box-acount-address text-center">
                        <a href="{{ route('account-address-create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Thêm địa chỉ mới</a>
                    </div>
                    @if ($addressPrimary)
                        <div class="box-acount-address">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p>
                                                <b>{{ $addressPrimary->fullname }}</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Địa chỉ chính</span>
                                            </p>
                                            <p>
                                                Địa chỉ: <b>{{ $addressPrimary->address }}, {{ $addressPrimary->ward->name }}, {{ $addressPrimary->district->name }}, {{ $addressPrimary->city->name }}</b>
                                            </p>
                                            <p>
                                                Điện thoại: <b>{{ $addressPrimary->phone }}</b>
                                            </p>
                                            @if ($addressPrimary->email)
                                                <p>
                                                    Email: <b>{{ $addressPrimary->email }}</b>
                                                </p>
                                            @endif
                                        </td>
                                        <td></td>
                                        <td><a href="{{ route('account-address-edit', [$addressPrimary->id]) }}">Chỉnh sửa</a></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if (!$listAddress->isEmpty())
                        @foreach ($listAddress as $address)
                            <div class="box-acount-address">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p>
                                                    <b>{{ $address->fullname }}</b>
                                                </p>
                                                <p>
                                                    Địa chỉ: <b>{{ $address->address }}, {{ $address->ward->name }}, {{ $address->district->name }}, {{ $address->city->name }}</b>
                                                </p>
                                                <p>
                                                    Điện thoại: <b>{{ $address->phone }}</b>
                                                </p>
                                                @if ($address->email)
                                                    <p>
                                                        Email: <b>{{ $address->email }}</b>
                                                    </p>
                                                @endif
                                            </td>
                                            <td></td>
                                            <td><a href="{{ route('account-address-edit', [$address->id]) }}">Chỉnh sửa</a></td>
                                            <td><a href="{{ route('account-address-destroy', [$address->id]) }}" class="text-danger">Xóa</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
              </div>
          </div><!--End tab custom-->
      </div>
    </section><!-- End News -->
</article>
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.box-acount-address').on('click', 'a.text-danger', function(evt){
            evt.preventDefault();
            var obj = $(this);
            
            if (confirm('Bạn có chắc là muốn xóa địa chỉ này không?')) {
                $.ajax({
                    url: obj.attr('href'),
                    type: 'POST',
                    success: function(data){
                        if (data.error == 0) {
                            alert(data.message);
                            obj.parents('.box-acount-address').remove();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection