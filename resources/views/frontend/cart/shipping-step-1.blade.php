@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')

<!-- page wapper-->
<div class="columns-container" style="margin-top:20px">
    <div class="container" id="columns">    
        <div class="page-content">
          <!-- row -->
          <div class="shipping-address-page">

                <div class="shipping-header">
                  <div class="row bs-wizard">
                    <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 bs-wizard-step active">
                      <div class="text-center bs-wizard-stepnum"> <span>{{ trans('text.dang-nhap') }}</span> </div>
                      <div class="progress">
                        <div class="progress-bar"></div>
                      </div>
                      <span class="bs-wizard-dot">1</span> </div>
                    <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 bs-wizard-step disabled">
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
                    <h3 style="font-size:15px">1. {{ trans('text.khach-hang-moi') }} / {{ trans('text.dang-nhap') }}</h3>
                  </div>
                </div>

                <div class="row row-style-2">
                  <div class="payment-right visible-lg-block">
                    <p class="text">{{ trans('text.thanh-toan-don-hang-trong-1-buoc-voi') }}:</p>
                    <div class="form-group last"> 
                      <a class="btn btn-block btn-social btn-facebook user-name-loginfb login-by-facebook-popup"> 
                        <i class="fa fa-facebook"></i> 
                        <span>{{ trans('text.dang-nhap-bang-facebook') }}</span>                        
                      </a> 
                    </div>
                  </div><!--payment-right visible-lg-block-->
                  <div class="payment-top hidden-lg">
                    <p class="text">{{ trans('text.thanh-toan-don-hang-trong-1-buoc-voi') }}:</p>
                    <div class="form-group last"> <a class="btn btn-block btn-social btn-facebook user-name-loginfb login-by-facebook-popup" > <i class="fa fa-facebook"></i> 
                      <span>{{ trans('text.dang-nhap-bang-facebook') }}</span> </a> 
                    </div>
                  </div><!--payment-top hidden-lg-->
                  <div class="clearfix"></div>
                  <div class="col-md-8 has-padding">
                    
                      
                        
                        <div class="box-login-register-arround">
                          
                          <!-- required for floating -->
                          <!-- Nav tabs -->
                          <ul class="nav-register">
                              <li class="active">
                                <a href="#home" alt="login-form" data-toggle="tab">
                                  <span>{{ trans('text.dang-nhap') }}</span>
                                  <i>{{ trans('text.da-la-thanh-vien') }}</i>
                                </a>
                              </li>
                              <li><a href="#profile" data-toggle="tab" alt="register-form">
                                <span>{{ trans('text.tao-tai-khoan') }}</span>
                              <i>{{ trans('text.danh-cho-khach-hang-moi') }}</i>
                              </a></li>                                
                          </ul>
                         
                          <div class="register-content">
                              <!-- Tab panes -->
                              
                              @include('frontend.cart.blocks.login-form')
                        
                              @include('frontend.cart.blocks.register-form')
                        
                              
                          </div><!--register-content-->                 
                        </div>                             
                        <div class="clearfix"></div>
                  </div><!--col-lg-8 has-padding-->
                  @include('frontend.cart.blocks.reset-password-form')
                  <div class="col-md-4">
                    @include('frontend.cart.blocks.panel-cart')
                  </div><!--col-lg-4-->
                </div><!-- /.row -->
            </div><!-- ./shipping-address-page-->
        </div><!-- /.page-content -->
    </div>
</div>
<style type="text/css">
.nav-register {
    padding: 0;
    list-style: none;
    overflow: hidden;
    border-top: 1px solid #d4d4d4;
    border-bottom: 1px solid #d4d4d4;
    margin-bottom: 15px;
}  
.nav-register li a i {
    color: #818181;
    font-size: 11px;
    font-style: normal;
}
.nav-register li a span {
    display: block;
    width: 100%;
    font-size: 16px;
    text-transform: uppercase;
}
@media (min-width: 1200px){
  .register-content {
      width: 484px;
  }
  .nav-register{
    width: 329px !important;
  }
}
@media (min-width: 992px){
  .register-content {
      width: 350px;
  }
}
@media (min-width: 768px) and (max-width: 1024px){
  .nav-register{
    width: 200px !important;
  }
} 
@media (min-width: 768px){
  .register-content {
      float: right;
      background: #fff;
      border-left: 1px solid #ccc;
      padding: 15px 25px 5px;
      width: 439px;
  }
}
@media (min-width: 768px){
  .nav-register {
    position: absolute;
    left: 0;
    top: 0;
    width: 280px;
    z-index: 4;
    border: none;
}
.box-login-register-arround {
    border: 1px solid #ddd;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    background: #f1f1f1;
    overflow: hidden;
    min-height: 120px;
    position: relative;
}
  .nav-register li {
      border-bottom: 1px solid #ccc;
      position: relative;
      width: 100%;
      float: none;
  }
  .nav-register li.active, .nav-register li:hover {
      background: #fff;
  }
  .nav-register li.active:before, nav-register li:hover:before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 2px;
      height: 100%;
      border: 2px solid #28AA4A;
  }
  .nav-register li a:hover, .nav-register li a:link {
      text-decoration: none;
  }
  .nav-register li.active a, .nav-register li:hover a {
    border-bottom: none;
  }
  .nav-register li:first-child a {
      border-right: none;
  }
  .nav-register li a {
      padding: 10px 10px 10px 20px;
      display: inline-block;
      color: #4a4a4a;
      width: 100%;
  }
  .nav-register li a {
      display: block;
      width: 100%;
      padding: 10px 1px;
      color: #434343;
      text-align: center;
      position: relative;
  }
}
</style>
@endsection
@section('javascript')
   <script type="text/javascript">
   
    $(document).ready(function() {
      $('.nav-register li a').click(function(){
        var alt = $(this).attr('alt');
        $('.member-form').hide();
        $('.register-content #' + alt).show();
      });      
      $('#login-form > .bv-form').submit(function() {
        var error = [];
        var list_check = ['login_email', 'login_password'];
        var login_email    = $(this).find('#login_email').val();
        var login_password = $(this).find('#login_password').val();
        if(!login_email) {
          error.push('login_email');
        }

        if(!login_password) {
          error.push('login_password');
        }

        for(i in list_check) {
          $('#'+list_check[i]).parent().removeClass('has-error');
          $('#'+list_check[i]).next().hide();
        }

        if(error.length) {
          for(i in error) {
            $('#'+error[i]).parent().addClass('has-error');
            $('#'+error[i]).next().show();
          }
          return false;
        }

        return true;
      });

      

      @if(Session::has('validate') || Session::has('fb_id'))
       // $('#register-form').show();
       // $('#login-form').hide();
       // $('#radioIsNotUserIcho').iCheck('check');
        $('#email').hide();
        // $('#fullname').val();
        @if(Session::has('fb_name'))
            $('#fullname').val(' {{Session::get('fb_name') }}');
        @endif

        @if(Session::has('fb_email'))
            $('#email').val('{{ Session::get('fb_email') }}');
        @endif

      @endif
      function validateEmail(email) {
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
      }

      $('#register_popup_submit_1').click(function () {
        var error = [];
        var list_check = ['email_register_1', 'password_register_1', 'fullname_register_1'];
        var email = $('#email_register_1').val();
        var password = $('#password_register_1').val();
        var fullname = $('#fullname_register_1').val();

        if(!email || !validateEmail(email)) {
          error.push('email_register_1');
        }

        if(password.length < 6 || password.length > 32) {
          error.push('password_register_1');
        }

        if(!fullname) {
          error.push('fullname_register_1');
        }

        for(i in list_check) {
          $('#'+list_check[i]).parent().removeClass('has-error');
          $('#'+list_check[i]).parent().find('.help-block').hide();
        }

        if(error.length) {
          for(i in error) {
            $('#'+error[i]).parent().addClass('has-error');
            $('#'+error[i]).next().show();
          }
        } else {
          $.ajax({
            url: "{{route('register-customer')}}",
            method: "POST",
            data : {
              email: email,
              password: password,
              fullname: fullname
            },
            success : function(data){
              if(+data){
                location.reload();
              } else {
                swal({ title: '', text: 'Email này đã được đăng kí rồi.', type: 'error' });
              }
            },
            error : function(e) {
              alert( JSON.stringify(e));
            }
          });
        }
      });
    });
  </script>
@endsection








