@extends('frontend.layout')
@section('header')
    @include('frontend.partials.main-header')
    @include('frontend.partials.home-menu')
  @endsection
@include('frontend.partials.meta')
@section('content')

<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="{{ route('home') }}" title="Trở về trang chủ">Trang chủ</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a href="#" title="Giỏ hàng"> Cập nhật thông tin tài khoản </a>
        </div>
        <!-- ./breadcrumb -->
        <div class="page-content">
          <!-- row -->
          <div class="shipping-address-page">
                <div class="row visible-lg-block">
                  <div class="col-lg-12">
                    <h3 style="font-size:15px"> Cập nhật thông tin </h3>
                  </div>
                </div>

                <div class="row row-style-2">
                  <div class="col-lg-12">
                    @if(Session::has('update-information'))
                    <div class="panel panel-default address-list">
                      <div class="panel-body">
                        <p style="color:red"> * Xin vui lòng cập nhật thông tin </p>
                      </div>
                    </div>
                    @endif
                    <div class="panel panel-default address-form is-edit">
                      <div class="panel-heading hidden-lg">Cập nhật địa chỉ giao hàng mới</div>
                      <div class="panel-body">
                        <form class="form-horizontal bv-form" role="form" id="address-info" novalidate>
                          <button type="submit" class="bv-hidden-submit" style="width: 0px; height: 0px;"></button>
                          <div class="form-group row">
                            <label for="fullname" class="col-lg-4 control-label visible-lg-block">Họ tên </label>
                            <div class="col-lg-8 input-wrap has-feedback">
                                <input type="text" name="fullname" class="form-control address" id="fullname" value="{{$customer->fullname}}" placeholder="Nhập họ tên" data-bv-field="fullname">
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="telephone" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng nhập Họ và tên</small>
                           </div>
                          </div>
                          <div class="form-group row">
                            <label for="telephone" class="col-lg-4 control-label visible-lg-block">Điện thoại di động</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <input type="tel" name="telephone" class="form-control address" id="telephone" value="{{$customer->phone}}" placeholder="Nhập số điện thoại" data-bv-field="telephone">
                              <small class="help-block" data-bv-validator="notEmpty" data-bv-for="telephone" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng nhập Số điện thoại từ 9 - 15 chữ số</small></div>
                          </div>
                          <div class="form-group row">
                            <label for="country_id" class="col-lg-4 control-label visible-lg-block">{{ trans('text.quoc-gia') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="country_id" class="form-control address" id="country_id" data-bv-field="country_id">
                                <option value="">{{ trans('text.chon') }} {{ trans('text.quoc-gia') }}</option>
                                @foreach($listCountry as $country)
                                  <option value="{{$country->id}}"
                                  @if($customer->country_id == $country->id)
                                  selected
                                  @endif
                                  >{{$country->name}}</option>
                                @endforeach
                              </select>
                              <small class="help-block" data-bv-validator="notEmpty" data-bv-for="country_id" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-chon') }} {{ trans('text.quoc-gia') }}</small></div>
                          </div>
                          <div class="form-group row viet">
                            <label for="city_id" class="col-lg-4 control-label visible-lg-block">Tỉnh/Thành phố</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="city_id" class="form-control address" id="city_id" data-bv-field="city_id">
                                <option value="">Chọn Tỉnh/Thành phố</option>
                                @foreach($listCity as $city)
                                  <option value="{{$city->id}}"
                                  @if($customer->city_id == $city->id)
                                  selected
                                  @endif
                                  >{{$city->name}}</option>
                                @endforeach
                              </select>
                              <small class="help-block" data-bv-validator="notEmpty" data-bv-for="city_id" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng chọn Tỉnh/Thành phố</small></div>
                          </div>
                          <div class="form-group row viet">
                            <label for="district_id" class="col-lg-4 control-label visible-lg-block">Quận/Huyện</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="district_id" class="form-control address" id="district_id">
                                <option value="0">Chọn Quận/Huyện</option>                               
                              </select>
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="district_id" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng chọn Quận/Huyện</small></div>
                          </div>
                          <div class="form-group row viet">
                            <label for="ward_id" class="col-lg-4 control-label visible-lg-block">Phường/Xã</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="ward_id" class="form-control address" id="ward_id">
                                <option value="0">Chọn Phường/Xã</option>
                              </select>
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="ward_id" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng chọn Phường/Xã</small></div>
                          </div>
                          <div class="form-group row">
                            <label for="street" class="col-lg-4 control-label visible-lg-block">Địa chỉ</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <textarea name="street" class="form-control address" id="street" placeholder="Ví dụ: 52, đường Trần Hưng Đạo" data-bv-field="street" style="height:100px">{{$customer->address}}</textarea>
                               <span class="help-block"></span> <small class="help-block" data-bv-validator="notEmpty" data-bv-for="street" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng nhập Địa chỉ</small></div>
                          </div>
                          <div class="form-group row form-group-radio group-radio-k-address">
                            <label class="col-lg-4 control-label visible-lg-block"></label>
                            <div class="col-lg-8 input-wrap"> <span style="font-size: 11px;font-style: italic;">Để nhận hàng thuận tiện hơn, bạn vui lòng cho icho.vn biết loại địa chỉ.</span> </div>
                          </div>
                          <div class="form-group row form-group-radio group-radio-k-address">
                            <label class="col-lg-4 control-label visible-lg-block">Loại địa chỉ</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                                <label class="checkbox-inline">
                                  <input type="radio" name="delivery_address_type" value="0" data-bv-field="delivery_address_type"
                                  @if($customer->address_type == 0)
                                  checked
                                  @endif
                                  >
                                   Nhà riêng / Chung cư
                                </label>

                                <label class="checkbox-inline">
                                  <input type="radio" name="delivery_address_type" value="1" data-bv-field="delivery_address_type"
                                  @if($customer->address_type == 1)
                                  checked
                                  @endif
                                  >
                                   Cơ quan / Công ty
                                </label>
                            </div>
                          </div>
                          <div class="form-group row end">
                            <div class="col-lg-offset-4 col-lg-8">
                              @if(!Session::has('new-register'))
                              <button type="button" class="btn btn-default btn-custom2 visible-lg-inline-block js-hide">Hủy bỏ</button>
                              @endif
                              <div id="btn-address" class="btn btn-primary btn-custom3" value="update">Cập nhật</div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="shiping_plan"></div>
                  </div>
                </div>

           </div><!-- /.shipping-address-page -->

        </div><!-- /.page-content -->
    </div>
</div>
@endsection
@include('frontend.partials.footer')
@section('javascript')
   <script type="text/javascript">
    $(document).ready(function() {

      var customer_district_id = '{{ $customer->district_id }}';
      var customer_ward_id = '{{ $customer->ward_id }}';
      var customer_country_id = '{{ $customer->country_id }}';
      if(customer_country_id == 235){
        $('div.viet').show();
      }else{
        $('div.viet').hide();
      }
      $('.edit-address').click(function() {
        $('.address-form').show();
      });

      $('.address-form').show();
      $('#form-address').hide();



      $('#btn-address').click(function() {
        $(this).attr('disabled', '');
        validateData();
      });

      function validateData() {
        var error = [];

        var fullname = $('#fullname').val();
        var city_id   = $('#city_id').val();
        var country_id   = $('#country_id').val();
        var district_id   = +$('#district_id').val();
        var ward_id   = +$('#ward_id').val();
        var street    = $('#street').val();
        var telephone = $('#telephone').val();
        var email = $('#email_form').val();

        if(!fullname.length)
        {
          error.push('fullname');
        }
        if(!country_id)
        {
          error.push('country_id');
        }
        if(country_id == 235){
          if(!city_id)
          {
            error.push('city_id');
          }

          if(!district_id)
          {
            error.push('district_id');
          }

          if(!ward_id)
          {
            error.push('ward_id');
          }
        } 

        if(!street)
        {
          error.push('street');
        }

        if(!(/\d{8,15}$/g.test(telephone)) ) {
          error.push('telephone');
        }

        var list = ['fullname', 'city_id', 'district_id', 'ward_id', 'street', 'telephone'];

        for( i in list ) {
            $('#' + list[i]).next().hide();
            $('#' + list[i]).parent().removeClass('has-error');
        }

        if(error.length) {
          for( i in error ) {
            $('#' + error[i]).parent().addClass('has-error');
            $('#' + error[i]).next().show();
          }

          $('#btn-address').removeAttr('disabled');
        } else {
          $.ajax({
            url: "{{ route('update-customer') }}",
            method: "POST",
            data : {
              fullname : fullname,
              city_id : city_id,
              district_id : district_id,
              ward_id : ward_id,
              address : street,
              phone : telephone,
              address_type : $('input[name=delivery_address_type]:checked').val()
            },
            success : function(data){
              @if(Session::get('products') && !empty(Session::get('products')))
                location.href = "{{route('shipping-step-3')}}";
              @else 
                location.href = "/";
              @endif
            }
          });
        }
      }

      $('.js-hide').click(function() {
        $('.address-form').hide();
      });

      $('#city_id').change(function() {
        var city_id = $(this).val();

        customer_district_id = '';
        getDistrict(city_id);
      });
      if( $('#city_id').val() > 0){
        getDistrict($('#city_id').val());
      }
      $('#country_id').change(function(){
        var country_id = $(this).val();
        if( country_id != 235){
          $('div.viet').hide();
        }else{
          $('div.viet').show();
        }
      });
      $('#district_id').change(function() {
        var district_id = $(this).val();

        customer_ward_id = '';
        getWard(district_id);
      });
      if( $('#district_id').val() > 0){
        getWard($('#district_id').val());
      }
      function getDistrict(city_id) {

        if(!city_id) {
          $('#district_id').empty();
          $('#district_id').append('<option value="0">Chọn Quận/Huyện</option>');
          return;
        }

        $.ajax({
          url: "{{ route('get-district') }}",
          method: "POST",
          data : {
            id: city_id
          },
          success : function(list_ward){
            $('#district_id').empty();
            $('#district_id').append('<option value="0">Chọn Quận/Huyện</option>');

            for(i in list_ward) {
              $('#district_id').append('<option value="'+list_ward[i].id+'">'+list_ward[i].name+'</option>');
            }
            if( customer_district_id > 0){
              $('#district_id').val(customer_district_id);
              getWard(customer_district_id);
            }

          }
        });
      }
      function getWard(district_id) {

        if(!district_id) {
          $('#ward_id').html('<option value="0">Chọn Phường/Xã</option>');
          return;
        }

        $.ajax({
          url: "{{route('get-ward')}}",
          method: "POST",
          data : {
            id: district_id
          },
          success : function(list_ward){
            $('#ward_id').empty();
            $('#ward_id').append('<option value="0">Chọn Phường/Xã</option>');

            for(i in list_ward) {
              $('#ward_id').append('<option value="'+list_ward[i].id+'">'+list_ward[i].name+'</option>');
            }

            $('#ward_id').val(customer_ward_id);

          }
        });
      }

    });
  </script>
@endsection








