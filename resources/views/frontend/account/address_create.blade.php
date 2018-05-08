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
                    @if (count($errors) > 0)                        
                        <div class="alert alert-danger ">
                            <ul>                           
                                <li>Vui lòng nhập đầy đủ thông tin.</li>                            
                            </ul>
                        </div>                  
                    @endif
                    <form action="{{ route('account-address-create') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="other-address">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control no-round" id="fullname" name="fullname" placeholder="Họ tên" value="{{ old('fullname') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control no-round" id="phone" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="email" class="form-control no-round" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="div-parent" id="primary_address">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-group form-control no-round city_id" name="city_id" id="city_id">
                                            <option value="">Tỉnh/TP</option>
                                            @foreach ($cityList as $city)
                                                <option value="{{ $city->id }}"{!! old('city_id') == $city->id ? ' selected="selected"' : '' !!}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-group form-control no-round district_id" name="district_id" id="district_id" data-id="{{ old('district_id') }}">
                                            <option value="">Quận/Huyện</option>                              
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <select class="form-control no-round ward_id" name="ward_id" id="ward_id" data-id="{{ old('ward_id') }}">
                                            <option value="">Phường/Xã</option>
                                        </select>
                                    </div>
                                </div>                    
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control no-round" id="address" name="address" placeholder="Địa chỉ" value="{{ old('address') }}">
                            </div>
                            <div class="form-group">
                                <label for="is_primary"><input type="checkbox" id="is_primary" name="is_primary" value="1"{!! old('is_primary') == 1 ? ' checked="checked"' : '' !!}> Địa chỉ chính</label>
                            </div>
                            <div class="form-group clearfix checkout-action">
                                <div class="pull-right" style="margin-left:5px"><button type="submit" class="btn btn-yellow btn-flat">Lưu</button></div>
                                <div class="pull-right"><a href="{{ route('account-address') }}" class="btn btn-grey btn-flat">Hủy bỏ</a></div>
                            </div>
                        </div>
                    </form>
                </div>
          </div><!--End tab custom-->
      </div>
    </section><!-- End News -->
</article>
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#city_id').on('change', function(){
            var obj = $(this);
            $.ajax({
                url: "{{ route('get-child') }}",
                data: {
                    mod: 'district',
                    col: 'city_id',
                    id: obj.val()
                },
                type: 'POST',
                dataType: 'html',
                success: function(data){
                    $('#district_id').html(data);
                    $('#district_id').val($('#district_id').data('id'));
                    $('#district_id').trigger('change');
                }
            });
        }).trigger('change');
        
        $('#district_id').on('change', function(){         
            var obj = $(this);
            $.ajax({
                url: "{{ route('get-child') }}",
                data : {
                    mod: 'ward',
                    col: 'district_id',
                    id: obj.val()
                },
                type: 'POST',
                dataType: 'html',
                success: function(data){
                    $('#ward_id').html(data);  
                    $('#ward_id').val($('#ward_id').data('id'));    
                }
            });
        });
    });
</script>
@endsection