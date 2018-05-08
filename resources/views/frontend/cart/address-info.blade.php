@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<?php $total = 0; ?>
<article class="mar-top40">
  <div class="container">
      <div class="breadcrumbs">
          <ul>
              <li><a class="home" href="{{ route('home') }}" title="Trở về trang chủ">Trang chủ</a></li>             
              <li><a href="{{ route('cart') }}">Giỏ hàng</a></li>
              <li>Thời gian & địa chỉ nhận hàng</li>
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
                      <div class="col-xs-4 bs-wizard-step active">
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="{{ route('address-info') }}" class="bs-wizard-dot">1</a>
                          <div class="bs-wizard-info text-center">Thời gian & địa chỉ nhận hàng</div>
                      </div>

                      <div class="col-xs-4 bs-wizard-step disabled"><!-- complete -->
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="{{ route('order-info') }}" class="bs-wizard-dot">2</a>
                          <div class="bs-wizard-info text-center">Thông tin đơn hàng</div>
                      </div>

                      <div class="col-xs-4 bs-wizard-step disabled"><!-- complete -->
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot">3</a>
                          <div class="bs-wizard-info text-center">Hoàn tất</div>
                      </div>
                  </div>
              </div>
              <div class="body-box">
                <form id="dataForm" action="{{ route('store-address') }}" method="POST">
                {{ csrf_field() }}
                  <p><i class="fa fa-circle cl_ea0000" aria-hidden="true"></i> Chọn chi nhánh</p>
                  <?php 
                  $arrCityBranch = [];
                  foreach($loadDistrict as $dis){
                    $arrCityBranch[] = $dis->city_id;
                  }

                  ?>
                  <div class="row div-parent" id="branch-info" >
                      <div class="col-md-6">
                           <select name="branch_city_id" class="form-control req" id="branch_city_id" data-bv-field="branch_city_id">
                              <option value="">Tỉnh/TP</option>
                              @foreach($cityList as $city)
                              @if(in_array($city->id, $arrCityBranch))
                                <option value="{{$city->id}}"
                                @if(old('branch_city_id') == $city->id)
                                selected
                                @endif
                                >{{$city->name}}</option>
                                @endif
                              @endforeach
                            </select>
                      </div>
                      <div class="col-md-6">
                          <select class="form-group form-control district_id req" id="branch_district_id" name="branch_district_id">
                              <option value="">Quận/Huyện</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group" id="branch_div">
                                        
                  </div>
                  <p><i class="fa fa-circle text-success" aria-hidden="true"></i> Địa chỉ nhận hàng</p>
                  @if($addressList->count() == 0)
                  <div class="row">
                      <div class="form-group col-md-4">
                        <input type="text" class="form-control no-round req" id="fullname" name="fullname" placeholder="Họ tên" value="{{ old('fullname', $customer->fullname) }}">
                      </div>
                      <div class="form-group col-md-4">
                        <input type="text" class="form-control no-round req" id="phone" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}">
                      </div>
                      <div class="form-group col-md-4">
                        <input type="email" class="form-control no-round" @if($customer->email) readonly="readonly" @endif id="email" name="email" placeholder="Email" value="{{ old('email', $customer->email) }}">
                      </div>
                  </div>
                  
                  <div class="div-parent" id="primary_address">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-group form-control no-round city_id req" name="city_id" id="city_id">
                                <option>Tỉnh/TP</option>
                                @foreach($cityList as $city)
                                  <option value="{{$city->id}}"
                                  @if(old('branch_city_id') == $city->id)
                                  selected
                                  @endif
                                  >{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-group form-control no-round district_id req" name="district_id" id="district_id">
                                <option>Quận/Huyện</option>                              
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="form-control no-round ward_id req" name="ward_id" id="ward_id">
                                <option>Phường/Xã</option>
                            </select>
                        </div>
                    </div>                    
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12"><input type="text" class="form-control no-round req" id="address" name="address" placeholder="Địa chỉ người đặt hàng" value="{{ old('address') }}"></div>
                  </div>
                  @endif
                  <div class="form-group" id="addressList">
                      @foreach($addressList as $address)
                      <div>
                          <label class="checkbox-inline"><input @if($address->is_primary == 1) checked @endif class="reqAddressId req" type="radio" name="address_id" value="{{ $address->id }}"> <b>{!! $address->fullname !!}</b>,  {!! $address->address !!}, {!! $address->ward->name !!}, {!! $address->district->name !!}, {!! $address->city->name !!}</label>
                      </div>
                      @endforeach                    
                  </div>
                  
                  <div class="form-group">
                      <label class="checkbox-inline"><input class="action-other-address" name="choose_other" type="checkbox" value="1"><b>Giao đến địa chỉ khác</b></label>
                  </div>
                  <div class="other-address">
                      <div class="row">
                          <div class="form-group col-md-4">
                            <input type="text" class="form-control no-round" id="other_fullname" name="other_fullname" placeholder="Họ tên" value="{{ old('other_fullname') }}">
                          </div>
                          <div class="form-group col-md-4">
                            <input type="text" class="form-control no-round" id="other_phone" name="other_phone" placeholder="Số điện thoại" value="{{ old('other_phone') }}">
                          </div>
                          <div class="form-group col-md-4">
                            <input type="email" class="form-control no-round" id="other_email" name="other_email" placeholder="Email" value="{{ old('other_email') }}">
                          </div>
                      </div>
                      
                      <div class="div-parent" id="primary_address">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-group form-control no-round city_id" name="other_city_id" id="other_city_id">
                                    <option>Tỉnh/TP</option>
                                    @foreach($cityList as $city)
                                      <option value="{{$city->id}}"
                                      @if(old('other_city_id') == $city->id)
                                      selected
                                      @endif
                                      >{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-group form-control no-round district_id" name="other_district_id" id="other_district_id">
                                    <option>Quận/Huyện</option>                              
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control no-round ward_id" name="other_ward_id" id="other_ward_id">
                                    <option>Phường/Xã</option>
                                </select>
                            </div>
                        </div>                    
                      </div>
                      <div class="form-group row">
                          <div class="col-md-12"><input type="text" class="form-control no-round" id="other_address" name="other_address" placeholder="Địa chỉ" value="{{ old('other_address') }}"></div>
                      </div>
                  </div>
                   <p><i class="fa fa-circle cl_ffd900" aria-hidden="true"></i> Thời gian nhận hàng</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                       <input type="text" name="date_delivery" id="date_delivery" class="form-control">
                                    </div>
                                    <div class="form-group col-xs-6" style="width:120px">
                                        <input type="text" name="time_delivery" id="time_delivery" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                  <p><i class="fa fa-circle text-primary" aria-hidden="true"></i> Ghi chú cho đơn hàng</p>
                  <div class="form-group">
                      <textarea class="form-control no-round" name="notes" id="notes" rows="7" placeholder="Nhập thông tin ghi chú của bạn"></textarea>
                  </div>
                  <input type="hidden" name="k_branch_id" id="k_branch_id" value="">
                  <div class="form-group clearfix checkout-action">
                      <div class="pull-right" style="margin-left:5px"><button id="btnSave" type="button" class="btn btn-yellow btn-flat">Tiếp theo</button></div>
                      <div class="pull-right"><a href="#" class="btn btn-grey btn-flat">Hủy bỏ</a></div>
                  </div>
                  </form>
              </div>
          </div>
      </div>
  </section>
</article>
<style type="text/css">
  .error{
    border : 1px solid red;
  }
</style>
<link rel="stylesheet" href="{{ URL::asset('public/admin/dist/css/datetimepicker.css') }}">  
@stop
@section('js')
<script type="text/javascript" src="{{ URL::asset('public/admin/dist/js/datetimepicker.js') }}"></script>
   <script type="text/javascript">
   $(document).ready(function(){   
    $('#time_delivery').datetimepicker({
      format:'H:i',
      step:15,
      minDate:0,
      datepicker: false   

    });
    $('#date_delivery').datetimepicker({
      format:'d/m/Y',      
      minDate:0,
      timepicker: false
    });
    $('#dataForm .req').blur(function(){    
        if($(this).val() != ''){
          $(this).removeClass('error');
        }else{
          $(this).addClass('error');
        }
      });
      $('#btnSave').click(function(){
        var errReq = 0;
        $('#dataForm .req').each(function(){
          var obj = $(this);      
          if(obj.val() == '' || obj.val() == '0' || obj.val() == 'Tỉnh/TP' || obj.val() == 'Quận/Huyện' || obj.val() == 'Phường/Xã'){
            errReq++;
            obj.addClass('error');
          }else{
            obj.removeClass('error');
          }
        });
        if( $(':radio[name="branch_id"]:checked').length == 0){
          alert('Vui lòng chọn chi nhánh'); return false;
        }
        if(errReq > 0){          
         $('html, body').animate({
              scrollTop: $("#branch-info").offset().top
          }, 500);
          return false;
        }        

        $('#dataForm').submit();
        $(this).html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled', 'disabled');
      });
      $('#branch_city_id').val({{ Session::get('choose_city') ? Session::get('choose_city') : "294" }});   
       $.ajax({
            url : '{{ route('get-child') }}',
            data : {
              mod : 'district',
              col : 'city_id',
              is_branch : 1,
              id : {{ Session::get('choose_city') ? Session::get('choose_city') : "294" }}
            },
            type : 'POST',
            dataType : 'html',
            success : function(data){
              $('#branch_district_id').html(data);
              @if(Session::get('choose_district'))
              $('#branch_district_id').val({{ Session::get('choose_district') }});
              $.ajax({
                url : '{{ route('get-branch') }}',
                data : {                
                  district_id : {{ Session::get('choose_district') }}
                },
                type : 'GET',
                dataType : 'html',
                success : function(data){
                  $('#branch_div').html(data);
                  var br = $('input[name="branch_id"]').eq(0);
                  br.prop('checked', true);
                  $('#k_branch_id').val(br.val());
                }
              });
              @endif 
                                             
            }
          });
      $(document).on('click', '.reqBranchId', function(){
        var obj = $(this);
        $('#k_branch_id').val(obj.val());
      });
      $('.city_id').change(function(){         
        var obj = $(this);
            $.ajax({
              url : '{{ route('get-child') }}',
              data : {
                mod : 'district',
                col : 'city_id',
                id : obj.val()
              },
              type : 'POST',
              dataType : 'html',
              success : function(data){
                obj.parents('.div-parent').find('.district_id').html(data);      
              }
            });
          
        });
      $('#branch_city_id').change(function(){         
        var obj = $(this);
            $.ajax({
              url : '{{ route('get-child') }}',
              data : {
                mod : 'district',
                col : 'city_id',
                id : obj.val(),
                is_branch : 1
              },
              type : 'POST',
              dataType : 'html',
              success : function(data){
                obj.parents('.div-parent').find('.district_id').html(data);      
                $('#branch_div').html('');                          
              }
            });
          
        });
      jQuery(".other-address").hide();
        jQuery(".action-other-address").click(function () {
            if (jQuery(this).is(":checked")) {
                jQuery(".other-address").show(300);
                $('.other-address input, .other-address select').addClass('req');
                $('#addressList input.reqAddressId, #other_email').removeClass('req');
            } else {
                jQuery(".other-address").hide(200);
                $('.other-address input, .other-address select').removeClass('req');
                $('#addressList input.reqAddressId').addClass('req');
            }
        });
      $('#primary_address .district_id').change(function(){         
        var obj = $(this);
            $.ajax({
              url : '{{ route('get-child') }}',
              data : {
                mod : 'ward',
                col : 'district_id',
                id : obj.val()
              },
              type : 'POST',
              dataType : 'html',
              success : function(data){
                $('#primary_address .ward_id').html(data);                                
              }
            });
          
        });
      $('#branch_district_id').change(function(){         
        var obj = $(this);
            $.ajax({
              url : '{{ route('get-branch') }}',
              data : {                
                district_id : obj.val()
              },
              type : 'GET',
              dataType : 'html',
              success : function(data){
                $('#branch_div').html(data);
              }
            });
          
        });
    });

  </script>
@endsection








