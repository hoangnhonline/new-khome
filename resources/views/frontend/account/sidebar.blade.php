<div class="col-md-3 col-sm-4 col-xs-12 sidebar">
  <div class="sidebar-shop sidebar-left">
    <div class="widget widget-filter">
      <div class="box-filter category-filter">
        <h2 class="widget-title">Tài khoản</h2>
        <ul>
            <li {{ \Request::route()->getName() == "account-info" ? "class=active" : "" }}>
                <a href="{{ route('account-info') }}" title="Cập nhật thông tin"> Thông tin tài khoản</a>
            </li>
            <li {{ \Request::route()->getName() == "order-history" || \Request::route()->getName() == "order-detail" ? "class=active" : "" }}>
                <a href="{{ route('order-history') }}" title="Đơn hàng của tôi"> Đơn hàng của tôi</a>
            </li>            
            @if(Session::get('facebook_id') == null)
            <li {{ \Request::route()->getName() == "change-password" ? "class=active" : "" }}>
                <a href="{{ route('change-password') }}" title="Đổi mật khẩu"> Đổi mật khẩu</a>
            </li>
            @endif
            <li>
                <a href="{{ route('user-logout') }}" title="Thoát tài khoản">  Thoát tài khoản</a>
            </li>   
        </ul>
      </div>
    </div>  
  </div>
  <!-- End Sidebar Shop -->
</div>