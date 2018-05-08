<!-- reset password -->
<div class="modal" id="reset-password-form" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="head">
        <h2>Quên mật khẩu?</h2>
        <p> <span>Vui lòng gửi email. Chúng tôi sẽ gửi link khởi tạo mật khẩu mới qua email của bạn.</span> </p>
      </div>
    </div>
    <div class="modal-body">
      <form method="POST" action="" class="content" id="reset_popup_form">
        <div id="forgot_successful"> <span></span> </div>
        <div class="form-group" id="forgot_pass">
          <input type="text" name="email" id="email" class="form-control" value="" required="required" placeholder="Nhập email">
          <span class="help-block"></span> </div>
        <div class="form-group last">
          <button type="button" id="reset_form_submit" class="btn btn-info">Gửi</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- end reset password -->