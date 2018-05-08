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
                      <li class="active"><a href="{{ route('account-info') }}"><i class="fa fa-user" aria-hidden="true"></i> Thông tin tài khoản</a></li>
                      <li><a href="{{ route('order-history') }}"><i class="fa fa-list-alt" aria-hidden="true"></i> Quản lý đơn hàng</a></li>
                      <li><a href="{{ route('account-address') }}" ><i class="fa fa-home" aria-hidden="true"></i> Số địa chỉ</a></li>
                      <!--<li><a href="javascript:void(0)" ><i class="fa fa-star" aria-hidden="true"></i> Điểm tích luỹ</a></li>-->
                  </ul>
              </div>
              <div class="col-tab-content admin-content" id="all">
                  <div class="title-section">
                      THÔNG TIN TÀI KHOẢN
                  </div>
                  @if(Session::has('message'))                        
                  <p class="alert alert-info" >{{ Session::get('message') }}</p>                  
                  @endif
                  @if (count($errors) > 0)                        
                    <div class="alert alert-danger ">
                      <ul>                           
                          <li>Vui lòng nhập đầy đủ thông tin.</li>                            
                      </ul>
                    </div>                        
                  @endif 
                  <form class="form" action="{{ route('update-customer') }}" method="POST">
                  {{ csrf_field() }}
                      <div class="row">
                          <div class="col-md-6 form-group clearfix">
                              <div class="col-form-label"><label for="fullname">Họ và tên</label></div>
                              <div class="col-form-input"><input type="text" class="form-control" id="fullname" name="fullname" value="{!! old('fullname', $customer->fullname) !!}"></div>
                          </div>
                          <div class="col-md-6  form-group clearfix">
                              <div class="col-form-label"><label for="phone">Điện thoại</label></div>
                              <div class="col-form-input"><input type="text" class="form-control" id="phone" value="{{ old('phone', $customer->phone) }}" name="phone"></div>
                          </div>
                      </div>
                      <div class="form-group row clearfix">
                          <div class="col-md-6">
                              <div class="col-form-label"><label for="email">Email</label></div>
                              <div class="col-form-input"><input type="email" class="form-control" id="email" value="{{ old('email', $customer->email) }}" disabled></div>
                          </div>
                          <div class="col-md-6">
                              <div class="col-form-label"><label for="optradio">Giới tính</label></div>
                              <div class="col-form-input  row clearfix">
                                  <div class="col-md-6">
                                      <div class="radio">
                                          <label><input type="radio" name="gender" value="1" @if(old('gender', $customer->gender) != 2) checked="checked" @endif>Nam</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="radio">
                                          <label><input type="radio" name="gender" value="2" {{ old('gender', $customer->gender) == 2 ? "checked" : "" }}>Nữ</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>                      
                      <div class="checkbox clearfix">
                          <div class="col-form-label"></div>
                          <div class="col-form-input"><label><input id="isChangePass" name="isChangePass" class="action-change-password" type="checkbox" value="1">Thay đổi mật khẩu</label></div>
                      </div>
                      <div class="info-change-password" style="display:none;">
                          <div class="form-group clearfix">
                              <div class="col-form-label"><label for="oldpwd">Mật khẩu hiện tại</label></div>
                              <div class="col-form-input"><input type="password" class="form-control" id="old_password" name="old_password"></div>                                        
                          </div>
                          <div class="form-group clearfix">
                              <div class="col-form-label"><label for="newpwd">Mật khẩu mới</label></div>
                              <div class="col-form-input"><input type="password" class="form-control" id="new_password" name="new_password"></div>                                        
                          </div>
                          <div class="form-group marg30 clearfix">
                              <div class="col-form-label"><label for="repwd">Nhập lại mật khẩu</label></div>
                              <div class="col-form-input"><input type="password" class="form-control" id="re_new_password" name="re_new_password"></div>                                        
                          </div>
                          
                      </div>
                  
                  <div class="clearfix account-action">
                      <div class="col-form-label"></div>
                      <div class="col-form-input"><button type="submit" id="btnSave" class="btn btn-yellow btn-flat">Cập nhật</button></div>
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
  $('.info-change-password').hide();
  $('.action-change-password').click(function(){
    if($(this).prop('checked') == true){
      $('.info-change-password').show();        
    }else{
      $('.info-change-password').hide();
    }
  });
 });    
</script>
@stop