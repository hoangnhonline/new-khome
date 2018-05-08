@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<article>
            <section class="marg40">
<div class="content-shop left-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12 main-content">
                <div class="main-content-shop">                 
                     <h3>Tạo mật khẩu mới</h3>
                <div class="shipping-address-page">              
                  <div class="row row-style-2">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                        
                        <div class="panel-body">
                          @if (session('error'))
                              <div class="alert alert-danger">
                                  <ul>                                  
                                    <li>{{ session('error') }}</li>                                  
                                  </ul>
                              </div>
                          @endif 
                          @if (session('success'))
                              <div class="alert alert-success">
                                  <ul>                                  
                                    <li>{{ session('success') }}</li>                                  
                                  </ul>
                              </div>
                          @endif   
                        <form method="POST" class="form-new-password" id="changePasswordForm" action="{{ route('save-reset-password') }}">
                          {{ csrf_field() }}                         
                          
                          <div class="form-group row">
                            
                            <div class="col-lg-12 input-wrap has-feedback">
                                <input type="password" name="new_pass" class="form-control address" id="new_pass" value="" placeholder="Nhập mật khẩu mới" data-bv-field="new_pass" maxlength="30">
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="new_pass" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng nhập mật khẩu mới từ 6 đến 30 ký tự.</small>
                           </div>
                          </div> 
                          <div class="form-group row">
                            
                            <div class="col-lg-12 input-wrap has-feedback">
                                <input type="password" name="re_new_pass" class="form-control address" id="re_new_pass" value="" placeholder="Nhập lại mật khẩu mới" data-bv-field="re_new_pass" maxlength="30">
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="re_new_pass" data-bv-result="NOT_VALIDATED" style="display: none;">Nhập lại mật khẩu mới từ 6 đến 30 ký tự và trùng khớp với mật khẩu vừa nhập.</small>
                           </div>
                           <input type="hidden" name="email" value="{{ $detailCustomer->email }}">
                          </div> 
                          <div class="form-group action-button">
                            <button type="submit" id="btnSavePassword" class="btn btn-danger btn-block">Đổi mật khẩu</button>
                          </div>
                      
                        </form>
                        </div>
                      </div>
                      <div class="shiping_plan"></div>
                    </div>
                  </div>

                </div><!-- /.shipping-address-page -->
                </div>
                <!-- End Main Content Shop -->
            </div>
       
            
        </div>
    </div>
</div>
</section>
</article>
<!-- ./page wapper--> 
@endsection
@section('javascript')
<script type="text/javascript">
  $(document).ready(function() {
         @if (session('success'))
         setTimeout(function(){
          location.href='{{ route('home')}}';
         }, 3000);
         @endif
        $('#btnSavePassword').click(function() {
            $(this).attr('disabled', '');
            validateData();
          });
        
    });
  function validateData() {
        var error = [];
        
        var new_pass   = $('#new_pass').val();
        var re_new_pass   = $('#re_new_pass').val();
       

               
        if(!new_pass.length || new_pass.length < 6 || new_pass.length > 30)
        {
          error.push('new_pass');
        }

        if(!re_new_pass.length || new_pass.length < 6 || new_pass.length > 30 || new_pass != re_new_pass)
        {
          error.push('re_new_pass');
        }

        var list = ['new_pass', 're_new_pass'];

        for( i in list ) {
            $('#' + list[i]).next().hide();
            $('#' + list[i]).parent().removeClass('has-error');
        }

        if(error.length) {
          for( i in error ) {
            $('#' + error[i]).parent().addClass('has-error');
            $('#' + error[i]).next().show();
          }

          $('#btnSavePassword').removeAttr('disabled');
        } else {
          $('#changePasswordForm').submit();
        }
      }
</script>
@endsection