@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<article class="mar-top40">
  <div class="container">
      <div class="breadcrumbs">
          <ul>
              <li><a href="/">Trang chủ</a></li>
              <li>Thông tin đặt hàng</li>
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
                      <div class="col-xs-4 bs-wizard-step complete">
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot">1</a>
                          <div class="bs-wizard-info text-center">Thời gian & địa chỉ nhận hàng</div>
                      </div>

                      <div class="col-xs-4 bs-wizard-step complete"><!-- complete -->
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot">2</a>
                          <div class="bs-wizard-info text-center">Thông tin đơn hàng</div>
                      </div>

                      <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot">3</a>
                          <div class="bs-wizard-info text-center">Hoàn tất</div>
                      </div>
                  </div>
              </div>
              <div class="body-box">
                  <p class="marg30"><b>Cảm ơn quý khách đã mua hàng</b></p>
                  <p><b>Đơn hàng của bạn đã được đặt thành công! </b>Chúng tôi sẽ liên hệ lại bạn để xác nhận đơn hàng</p>
                  <p>Mọi thắc mắc quý khách vui lòng liên hệ <strong>0981 323 232</strong> để được hỗ trợ.</p>
                    <p style="margin-top:30px;text-align:center">
                  <a class="btn btn-yellow btn-flat" href="{{ route('home') }}">Trở về trang chủ</a>
                  </p>
              </div>
          </div>
      </div>
  </section>
</article>
@stop