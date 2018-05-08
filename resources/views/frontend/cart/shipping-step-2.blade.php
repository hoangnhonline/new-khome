@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
       
        <div class="page-content" style="margin-top:20px">
          <!-- row -->
          <div class="shipping-address-page">

                <div class="shipping-header">
                  <div class="row bs-wizard">
                    <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 bs-wizard-step complete">
                      <div class="text-center bs-wizard-stepnum"> <span>{{ trans('text.dang-nhap') }}</span> </div>
                      <div class="progress">
                        <div class="progress-bar"></div>
                      </div>
                      <span class="bs-wizard-dot">1</span> </div>
                    <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 bs-wizard-step active">
                      <div class="text-center bs-wizard-stepnum"> <span class="hidden-xs">{{ trans('text.dia-chi-giao-hang') }}</span> <span class="visible-xs-inline-block">{{ trans('text.dia-chi') }}</span> </div>
                      <div class="progress">
                        <div class="progress-bar"></div>
                      </div>
                      <span class="bs-wizard-dot">2</span> </div>
                    <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 bs-wizard-step disabled">
                      <div class="text-center bs-wizard-stepnum"> <span class="hidden-xs">{{ trans('text.thanh-toan-va-dat-mua') }}</span> <span class="visible-xs-inline-block">{{ trans('text.thanh-toan') }}</span> </div>
                      <div class="progress">
                        <div class="progress-bar"></div>
                      </div>
                      <span class="bs-wizard-dot">3</span> </div>
                  </div>
                </div>

                <div class="row visible-lg-block">
                  <div class="col-lg-12">
                    <h3 style="font-size:15px">2. {{ trans('text.dia-chi-giao-hang') }}</h3>
                  </div>
                </div>

                <div class="row row-style-2">
                  <div class="col-md-8 has-padding">
                    <div class="panel panel-default address-list">
                      <div class="panel-body" style="padding:0px 0px">
                        <form id="form-address" method="post" action="">
                          <h5 class="visible-lg-block" style="margin-top:20px"> {{ trans('text.chon-dia-chi-giao-hang-co-san-ben-duoi') }}: </h5>                          
                          <div class="row row-address-list">
                            <div class="col-lg-6 col-md-6 col-sm-6 item">
                              <div class="panel panel-default address-item is-default">
                                <div class="panel-body">
                                
                                  <p class="name">{{ $customer->fullname }}</p>
                                  <p class="address">
                                    @if($customer->country_id == 235)
                                      @if( isset( $customer->tinh->name ))
                                        {{ $customer->tinh->name }},
                                      @endif
                                      @if( isset( $customer->huyen->name ) )
                                        {{ $customer->huyen->name }},
                                      @endif
                                      @if( isset($customer->xa->name ))
                                        {{ $customer->xa->name }},
                                      @endif
                                      @else
                                        @if( isset($customer->country->name ))
                                          {{ $customer->country->name }},
                                        @endif
                                      @endif
                                      {{$customer->address}}
                                  </p>
                                  <p class="phone">{{ trans('text.dien-thoai') }}: {{ $customer->phone }}</p>
                                 
                                  <p class="action">
                                    <button type="button" class="btn btn-default btn-custom1 saving-address is-red" onclick="location.href='{{route('shipping-step-3')}}'"> {{ trans('text.giao-den-dia-chi-nay') }} </button>
                                    <button type="button" class="btn btn-default btn-custom1 edit-address">{{ trans('text.sua') }}</button>
                                  </p>                                  
                                </div><!--panel-body-->
                            </div><!--panel panel-default address-item is-default-->
                          </div><!--col-lg-6 col-md-6 col-sm-6 item-->
                          </div><!--row row-address-list-->
                        </form>
                      </div>
                    </div>
                    <div class="panel panel-default address-form is-edit">
                      <div class="panel-heading hidden-lg">{{ trans('text.cap-nhat') }} địa chỉ giao hàng mới</div>
                      <div class="panel-body">
                        <form class="form-horizontal bv-form" role="form" id="address-info" novalidate>                         
                          <div class="form-group row">
                            <label for="fullname" class="col-lg-4 control-label visible-lg-block">{{ trans('text.ho-ten') }} </label>
                            <div class="col-lg-8 input-wrap has-feedback">
                                <input type="text" name="fullname" class="form-control address" id="fullname" value="{{ $customer->fullname }}" placeholder="Nhập họ tên" data-bv-field="fullname">
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="telephone" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-nhap') }} {{ trans('text.ho-ten') }}</small>
                           </div>
                          </div>
                          <div class="form-group row">
                            <label for="telephone" class="col-lg-4 control-label visible-lg-block">{{ trans('text.dien-thoai') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <input type="tel" name="telephone" class="form-control address" id="telephone" value="{{ $customer->phone}}" placeholder="Nhập số điện thoại" data-bv-field="telephone">
                              <small class="help-block" data-bv-validator="notEmpty" data-bv-for="telephone" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-nhap') }} Số điện thoại từ 9 - 15 chữ số</small></div>
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
                            <label for="city_id" class="col-lg-4 control-label visible-lg-block">{{ trans('text.tinh-thanh-pho') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="city_id" class="form-control address" id="city_id" data-bv-field="city_id">
                                <option value="">{{ trans('text.chon') }} {{ trans('text.tinh-thanh-pho') }}</option>
                                @foreach($listCity as $city)
                                  <option value="{{$city->id}}"
                                  @if($customer->city_id == $city->id)
                                  selected
                                  @endif
                                  >{{$city->name}}</option>
                                @endforeach
                              </select>
                              <small class="help-block" data-bv-validator="notEmpty" data-bv-for="city_id" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-chon') }} {{ trans('text.tinh-thanh-pho') }}</small></div>
                          </div>
                          <div class="form-group row viet">
                            <label for="district_id" class="col-lg-4 control-label visible-lg-block">{{ trans('text.quan-huyen') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="district_id" class="form-control address" id="district_id">
                                <option value="0">{{ trans('text.chon') }} {{ trans('text.quan-huyen') }}</option>                            
                              </select>
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="district_id" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-chon') }} {{ trans('text.quan-huyen') }}</small></div>
                          </div>
                          <div class="form-group row viet">
                            <label for="ward_id" class="col-lg-4 control-label visible-lg-block">{{ trans('text.phuong-xa') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="ward_id" class="form-control address" id="ward_id">
                                <option value="0">{{ trans('text.chon') }} {{ trans('text.phuong-xa') }}</option>
                              </select>
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="ward_id" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-chon') }} {{ trans('text.phuong-xa') }}</small></div>
                          </div>
                          <div class="form-group row">
                            <label for="street" class="col-lg-4 control-label visible-lg-block">{{ trans('text.dia-chi') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <textarea name="street" class="form-control address" id="street" placeholder="Ví dụ: 52, đường Trần Hưng Đạo" data-bv-field="street" style="height:100px">{{ $customer->address }}</textarea>
                               <span class="help-block"></span> <small class="help-block" data-bv-validator="notEmpty" data-bv-for="street" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-nhap') }} {{ trans('text.dia-chi') }}</small></div>
                          </div>
                         
                          <div class="form-group row form-group-radio group-radio-k-address">
                            <label class="col-lg-4 control-label visible-lg-block">{{ trans('text.loai-dia-chi') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                                <label class="checkbox-inline">
                                  <input type="radio" name="delivery_address_type" value="0" data-bv-field="delivery_address_type"
                                  @if($customer->address_type == 0)
                                  checked
                                  @endif
                                  >
                                   {{ trans('text.nha-rieng-chung-cu') }}
                                </label>

                                <label class="checkbox-inline">
                                  <input type="radio" name="delivery_address_type" value="1" data-bv-field="delivery_address_type"
                                  @if($customer->address_type == 1)
                                  checked
                                  @endif
                                  >
                                   {{ trans('text.co-quan-cong-ty') }}
                                </label>
                            </div>
                          </div>
                          <div class="form-group row end">
                            <div class="col-lg-offset-4 col-lg-8">
                              @if(!Session::has('new-register'))
                              <button type="button" class="btn btn-default btn-custom2 visible-lg-inline-block js-hide">{{ trans('text.huy') }}</button>
                              @endif
                              <div id="btn-address" class="btn btn-primary btn-custom3" value="update">{{ trans('text.cap-nhat') }}</div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="shiping_plan"></div>
                  </div>
                  <div class="col-md-4">
                    @include('frontend.cart.blocks.panel-cart')
                  </div>
                </div>

           </div><!-- /.shipping-address-page -->

        </div><!-- /.page-content -->
    </div>
</div>
@endsection
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
   

      @if(Session::has('new-register') || Session::has('register') ||
         !$customer->fullname ||
         !$customer->email ||
         !$customer->address ||
         !$customer->phone ||
         !$customer->country_id ||
         ( $customer->country_id == 235 && ( !$customer->district_id || !$customer->city_id || !$customer->ward_id )
        ))        
        $('.address-form').show();
        $('#form-address').hide();
      @endif
      

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
        //alert(validateEmail(email));
        if(!(/\d{8,15}$/g.test(telephone)) && !email && validateEmail(email) == false) {
          error.push('telephone');
        }
        if(email && validateEmail(email)==false){    
         error.push('email_form'); 
        }

        if((!telephone && !email)){
          error.push('email_form'); 
        }


        var list = ['fullname', 'city_id', 'district_id', 'ward_id', 'street', 'telephone' ];

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
              country_id : country_id,
              ward_id : ward_id,
              address : street,
              phone : telephone,
              address_type : $('input[name=delivery_address_type]:checked').val()
            },
            success : function(data){
              location.reload();
            }
          });
        }
      }

      $('.js-hide').click(function() {
        $('.address-form').hide();
      });
      $('#country_id').change(function(){
        var country_id = $(this).val();
        if( country_id != 235){
          $('div.viet').hide();
        }else{
          $('div.viet').show();
        }
      });
      $('#city_id').change(function() {
        customer_district_id = 0;
        getDistrict($(this).val());
      });
      if( $('#city_id').val() > 0){
        getDistrict($('#city_id').val());
      }

      $('#district_id').change(function() {       
        customer_ward_id = 0;
        getWard($(this).val());
      });
      if( $('#district_id').val() > 0){
        getWard($('#district_id').val());
      }
      function validateEmail(email) {
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
      }
      function getDistrict(city_id) {

        if(!city_id) {
          $('#district_id').empty();
          $('#district_id').append('<option value="0">{{ trans('text.chon') }} {{ trans('text.quan-huyen') }}</option>');
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
            $('#district_id').append('<option value="0">{{ trans('text.chon') }} {{ trans('text.quan-huyen') }}</option>');

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
          $('#ward_id').html('<option value="0">{{ trans('text.chon') }} {{ trans('text.phuong-xa') }}</option>');
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
            $('#ward_id').append('<option value="0">{{ trans('text.chon') }} {{ trans('text.phuong-xa') }}</option>');

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








