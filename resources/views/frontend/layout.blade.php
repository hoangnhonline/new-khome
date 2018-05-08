<!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie9 lte9"><![endif]-->
<!--[if IE 10 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie10 lte10"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="vn">
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta name="description" content="@yield('site_description')"/>
    <meta name="keywords" content="@yield('site_keywords')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>    
    <meta property="article:author" content="https://www.facebook.com/KKAFFEE"/>   
    <link rel="canonical" href="{{ url()->current() }}"/>        
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('site_description')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="K KAFFEE.vn" />
    <?php $socialImage = isset($socialImage) ? $socialImage : $settingArr['banner']; ?>
    <meta property="og:image" content="{{ Helper::showImage($socialImage) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="@yield('site_description')" />
    <meta name="twitter:title" content="@yield('title')" />     
    <meta name="twitter:image" content="{{ Helper::showImage($socialImage) }}" />
    <link rel="icon" href="{{ URL::asset('public/assets/favicon.ico') }}" type="image/x-icon">
    <!-- ===== Style CSS ===== -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/lib/owlcarousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/assets/lib/owlcarousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/lib/fontawesome/css/font-awesome.min.css') }}" media="screen"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/bootstrap.min.css') }}" media="screen"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/style.css') }}" media="screen"/>
    <!-- HTML5 Shim and Respond.js') }}" IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js') }}" doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <link href='css/animations-ie-fix.css' rel='stylesheet'>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}""></script>
        <script src="https://oss.maxcdn.com/libs/respond.js') }}"/1.4.2/respond.min.js') }}""></script>
    <![endif]-->
</head>
<body @if($routeName == "product") data-spy="scroll" data-target="#myScrollspy" data-offset="150" @endif>
<div class="fog"></div>
@if($routeName == "product")
<div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=567408173358902";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>
@endif
<div class="wrapper">
    <header>
        <div class="bg_black">
            <div class="container">
               <?php 
                $bannerArr = DB::table('banner')->where(['object_id' => 2, 'object_type' => 3])->orderBy('display_order', 'asc')->get();   
                ?>
                <?php $i = 0; ?>
                @foreach($bannerArr as $banner)
                <?php $i++; ?>
                <div class="banner-top">
                @if($banner->ads_url !='')
                <a href="{{ $banner->ads_url }}" title="banner slide {{ $i }}">
                @endif
                <img src="{{ Helper::showImage($banner->image_url) }}" alt="banner top {{ $i }}">
                @if($banner->ads_url !='')
                </a>
                @endif
                </div>
                @endforeach 
                <nav id="nav">
                            <a class="hidden-sm hidden-md hidden-lg nav-button-mobi" href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a>
                            <ul class="clearfix">                 
                        
                        @foreach($cateParentList as $parent)                                          
                        <li class="">
                            <a  href="{{ route('cate-parent', $parent->slug ) }}" title="{{ $parent->name }}">
                                {{ $parent->name }} <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </a>
                            <?php 
                            $cateList = \DB::table('cate')->where('parent_id', $parent->id)->orderBy('display_order')->get();

                            ?>
                            @if(!empty($cateList))
                            <ul>
                                @foreach($cateList as $cate)
                                <?php 
                                    $grandList = \DB::table('grand')->where('cate_id', $cate->id)->orderBy('display_order')->get();

                                    ?>
                                <li>
                                    <a href="{{ route('cate', [$parent->slug, $cate->slug] ) }}">{!! $cate->name !!}@if(!empty($grandList))<i class="fa fa-chevron-down" aria-hidden="true"></i>@endif</a>
                                    
                                    @if(!empty($grandList))
                                    <ul style="z-index:9999">
                                        @foreach($grandList as $grand)
                                        <li>
                                            <a href="{{ route('grand', [$parent->slug, $cate->slug, $grand->slug]) }}">{!! $grand->name !!}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
        <div class="clearfix">
            <div class="container">
                <div class="pull-left">
                    <div id="logo">
                        <a href="{{ route('home') }}" title="Logo K KAFFEE">
                            <img src="{{ Helper::showImage($settingArr['logo']) }}" alt="Logo K KAFFEE">
                        </a>
                    </div>
                    <div id="custom-search-input" class="pull-left">
                    <form class=""  action="{{ route('search') }}" method="GET">
                        <div class="input-group col-md-12">
                            
                                <input type="text" name="keyword" id="txtSearch" value="{!! isset($tu_khoa) ? $tu_khoa : "" !!}" class="txtSearch form-control" placeholder="Tìm kiếm" />
                                <span class="input-group-btn">
                                    <button class="btn" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                            
                        </div>
                        </form>
                    </div>                    
                </div>
                <div class="pull-right @if(Session::get('login')) logined @endif">
                    <div class="block-login ">
                        <div class="cart-header">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <a href="{{ route('cart') }}">
                                Giỏ hàng<br/>
                                <span><b>{{ Session::get('products') ? array_sum(Session::get('products')) : 0 }}</b> sản phẩm</span>
                            </a>
                        </div>
                        <div class="pull-right dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle login-link" data-toggle="dropdown">
                                Đăng nhập/Đăng ký
                                <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            <div class="dropdown-menu-header">
                                <a class="btn btn-success text-center" title="Đăng Nhập" href="javascript:(void);" data-dismiss="modal" data-toggle="modal" data-target="#login-form"><i class="fa fa-sign-in"></i> Đăng nhập</a>


                                <a href="javascript:;" class="btn btn-primary text-center login-by-facebook-popup"><i class="fa fa-facebook-square " aria-hidden="true"></i> Đăng nhập bằng facebook</a>
                                <a id="btn_register" href="javascript:;" class="btn btn-danger text-center" data-dismiss="modal" data-toggle="modal" data-target="#register-form"><i class="fa fa-user" aria-hidden="true"></i> Đăng ký</a>
                            </div>
                        </div>
                    </div>
                    <div class="block-logined">
                        <div class="cart-header">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <a href="{{ route('cart') }}">
                                Giỏ hàng<br/>
                                <span><b>{{ Session::get('products') ? array_sum(Session::get('products')) : 0 }}</b> sản phẩm</span>
                            </a>
                        </div>
                        <div class="account-header dropdown">                            
                            <img src="{{ Session::get('avatar') ? Session::get('avatar') :  URL::asset('public/assets/img/icon.png') }}" alt="{{ Session::get('username') }}" style="border-radius: 25px">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                Chào, <b>{{ Session::get('username') }}</b><br/>
                                <span class="txt-account">Tài khoản</span>
                            </a>
                            <ul class="dropdown-menu-header">
                                <li> <a href="{{ route('account-info') }}" title="{{ trans('text.thong-tin-tai-khoan') }}"><i class="fa fa-user"></i> Thông tin tài khoản </a> </li>
                                <li> <a href="{{ route('order-history') }}" title="{{ trans('text.don-hang-cua-toi') }}"><i class="fa fa-heart-o"></i> Quản lý đơn hàng </a> </li>                  
                                @if(Session::get('facebook_id') == null)
                                <li> <a href="{{ route('change-password') }}" title="{{ trans('text.doi-mat-khau') }}"><i class="fa fa-unlock-alt"></i> Đổi mật khẩu</a> </li>
                                @endif
                                <li> <a href="{{route('user-logout')}}" title="{{ trans('text.thoat-tai-khoan') }}"><i class="fa fa-sign-in"></i> Thoát tài khoản </a> </li>                                    
                                <!--<li><a href="#">Sổ địa chỉ</a></li>-->
                            </ul>
                        </div>
                    </div>

                </div>
            </div><!-- End container -->
        </div>
    </header>
    @yield('content')
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-footer col-footer-1 col-md-3">
                    <div id="logo-footer"><img src="{{ URL::asset('public/assets/img/logo-2.png') }}" alt=""/></div>
                    <p @if($isEdit) class="edit" @endif" data-text="5">{!! $textList[5] !!}</p>
                </div>
                <div class="col-footer col-footer-2 col-md-3">
                    <div class="title-col-footer">ĐỊA CHỈ</div>
                    <p>
                        <b @if($isEdit) class="edit" @endif" data-text="7">{!! $textList[7] !!}</b><br/>
                        <span @if($isEdit) class="edit" @endif" data-text="8">{!! $textList[8] !!}</span><br/>
                        <span @if($isEdit) class="edit" @endif" data-text="9">{!! $textList[9] !!}</span><br/>
                        <span @if($isEdit) class="edit" @endif" data-text="10">{!! $textList[10] !!}</span>
                    </p>
                </div>
                <div class="col-footer col-footer-3 col-md-3">
                    <div class="title-col-footer">THÔNG TIN</div>                    
                    @if($footerLink)
                    @foreach($footerLink as $link)
                    <a href="{{ $link->link_url }}" title="{!! $link->link_text !!}">{!! $link->link_text !!}</a>
                    @endforeach
                    @endif   
                </div>
                <div class="col-footer col-footer-4 col-md-3">
                    <div class="title-col-footer">APP STORE</div>
                    <a href="#"><img src="{{ URL::asset('public/assets/img/apple.png') }}" alt=""/></a>
                    <a href="#"><img src="{{ URL::asset('public/assets/img/androi.png') }}" alt=""/></a>
                    <p>Hoặc đặt món qua <a href="#">Foody App</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright">
        <div class="container pos_rel">
            <span @if($isEdit) class="edit" @endif" data-text="6">{!! $textList[6] !!}</span>
            <div class="pos_rel hidden-sm hidden-xs">
                <div class="cf_chat">
                    <a href="javascript:void(0)"><i class="fa fa-weixin" aria-hidden="true"></i> Chat tư vấn</a>
                    <div class="fb-page" data-tabs="messages" data-href="{!! $settingArr['facebook_fanpage'] !!}" data-width="280" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">                               
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:void(0)" class="gotop"><img src="{{ URL::asset('public/assets/img/back-to-top.png') }}" alt="Back to Top"/></a>
</div>
<!-- Modal -->
<div class="modal fade" id="login-form" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Đăng nhập</b></h4>
                <div>Bạn chưa có tài khoản? <a href="javascript:;" data-dismiss="modal" data-toggle="modal" data-target="#register-form">Đăng ký ngay</a></div>
            </div>
            <div class="modal-body">
                <form accept-charset="UTF-8" role="form">
                    <fieldset>
                        <div class="form-group">
                            <input data-bv-field="email" id="popup-login-email" class="form-control login" name="email" placeholder="Nhập Email" type="text">
                            <small data-bv-result="NOT_VALIDATED" data-bv-for="email" data-bv-validator="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Email hợp lệ</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input data-bv-field="password" id="popup-login-password" class="form-control login" name="password" placeholder="Nhập mật khẩu" autocomplete="off" type="password">
                            <small data-bv-result="NOT_VALIDATED" data-bv-for="password" data-bv-validator="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Mật khẩu</small>
                        </div>
                        <div class="form-group" id="error_captcha" style="margin-bottom: 15px;color:red;font-style:italic"> <span class="help-block ajax-message"></span> </div>
                        <p>Quên mật khẩu? Nhấn vào <a href="{{ route('gui-lai-mk') }}">đây</a></p>
                        <input class="btn btn-success btn-block" id="login_popup_submit" type="button" value="Đăng nhập">
                        <a href="javascript:;" class="btn btn-primary btn-block text-center login-by-facebook-popup"><i class="fa fa-facebook-square" aria-hidden="true"></i> Đăng nhập bằng facebook</a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="register-form" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Đăng ký</b></h4>
                <div>Bạn đã có tài khoản? <a href="javascript:;" data-dismiss="modal" data-toggle="modal" data-target="#login-form">Đăng nhập</a></div>
                <p>Quên mật khẩu? Nhấn vào <a href="{{ route('gui-lai-mk') }}">đây</a></p>
            </div>
            <div class="modal-body">
                <form accept-charset="UTF-8" role="form">
                    <div class="clearfix">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="regisemail">Email</label>
                                    <input data-bv-field="email" class="form-control register register-email-input" name="email" id="popup-register-email" placeholder="Nhập Email" type="text">
                                    <small data-bv-result="NOT_VALIDATED" data-bv-for="email" er="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Email</small>
                                    <small er="NOT_VALIDATED" data-bv-for="email" data-bv-validator="remote" class="help-block" style="display: none;">Email đã tồn tại</small>
                                </div>
                                <div class="form-group">
                                    <label for="regispassword">Password</label>
                                    <input data-bv-field="password" class="form-control register" name="password" id="popup-register-password" placeholder="Mật khẩu từ 6 đến 32 ký tự" autocomplete="off" type="password">
                                    <small data-bv-result="NOT_VALIDATED" data-bv-for="password" data-bv-validator="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Mật khẩu</small>
                                    <small data-bv-result="NOT_VALIDATED" data-bv-for="password" data-bv-validator="stringLength" class="help-block" style="display: none;">Mật khẩu phải dài từ 6 đến 32 ký tự</small>
                                </div>
                                <div class="form-group">
                                    <label for="regisname">Họ tên</label>
                                    <input class="form-control register" name="fullname" id="popup-register-name" placeholder="Nhập họ tên" data-bv-field="fullname" type="text">
                                    <small class="help-block" data-bv-validator="notEmpty" data-bv-for="fullname" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng nhập Họ tên</small>
                                </div>                                
                                <div class="checkbox">
                                    <label><input type="checkbox">Nhận các thông tin ưu đãi của chúng tôi qua email</label>
                                </div>
                                <input id="register_popup_submit" class="btn btn-success btn-block" type="button" value="Đăng ký">
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <p>Đăng nhập vào web bằng facebook</p>
                            <a href="javascript:;" class="btn btn-primary btn-block text-center login-by-facebook-popup"><i class="fa fa-facebook-square" aria-hidden="true"></i> Đăng nhập bằng facebook</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="success-form" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-primary">Hoàn thành đăng ký</h3>
                <p>Chúc mừng bạn đăng ký tài khoản thành công! chào mừng bạn đến với website chúng tôi</p>
                <a class="btn btn-success btn-block">Vào trang web</a>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="logout-form" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p><b>Đăng xuất</b></p>
                <p>Bạn có muốn đăng xuất</p>
                <div class="clearfix">
                    <div class="row">
                        <div class="col-xs-6">
                            <a class="btn btn-success btn-block" href="#">Đăng xuât</a>
                        </div>
                        <div class="col-xs-6">
                            <a class="btn btn-danger btn-block" href="#">Ở lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="editContentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cập nhật nội dung</h4>
      </div>
      <form method="POST" action="{{ route('save-content') }}">
      {{ csrf_field() }}
      <input type="hidden" name="id" id="txtId" value="">
      <div class="modal-body">
        <textarea rows="5" class="form-control" name="content" id="txtContent"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnSaveContent">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<input type="hidden" id="route-register-customer-ajax" value="{{ route('register-customer-ajax') }}">
<input type="hidden" id="route-register-newsletter" value="{{ route('register.newsletter') }}">
<input type="hidden" id="route-add-to-cart" value="{{ route('add-product') }}" />
<input type="hidden" id="route-short-cart" value="{{ route('short-cart') }}" />
<input type="hidden" id="route-update-product" value="{{ route('update-product') }}" />
<input type="hidden" id="route-ajax-login-fb" value="{{route('ajax-login-by-fb')}}">
<input type="hidden" id="fb-app-id" value="{{ env('FACEBOOK_APP_ID') }}">
<input type="hidden" id="route-cart" value="{{ route('cart') }}" />
<input type="hidden" id="route-auth-login-ajax" value="{{ route('auth-login-ajax') }}">
<script src="{{ URL::asset('public/assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('public/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/assets/js/home.js') }}"></script>
<script src="{{ URL::asset('public/assets/lib/owlcarousel/dist/owl.carousel.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        @if($routeName == "product")
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        @endif
        <script type="text/javascript">
            jQuery(document).ready(function () {                
                jQuery("#btn_logout").click(function () {
                    jQuery("#logout-form").modal();
                });                
            });
            jQuery("a.nav-button-mobi").click(function () {
                if (jQuery("body").hasClass("active-menu"))
                {
                    jQuery("body").removeClass("active-menu");
                }
                else
                {
                    jQuery("body").addClass("active-menu");
                }
            });
             jQuery('#nav ul>li>a i').click(function(){
                jQuery(this).parent().parent().find('>ul').slideToggle('fast');
                return false;
          });
            jQuery(".fog").click(function () {
                jQuery("body").removeClass("active-menu");
            });
            jQuery("a.gotop").click(function () {
                $('html, body').animate({scrollTop: 0}, 'fast');
            });
            jQuery(".cf_chat>a").click(function () {
                if (jQuery(this).parent().hasClass("active"))
                {
                    jQuery(this).parent().removeClass("active");
                }
                else
                {
                    jQuery(this).parent().addClass("active");
                }
            });
            jQuery('.block-slide .owl-carousel').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                items: 1
            });
            jQuery('#customer .owl-carousel').owlCarousel({
                nav: true,
                items: 7
            });             
            if (jQuery(document).width() >= 992) {
               // jQuery(".cf_chat>a").click();
            }          
        </script>      
    
    <input type="hidden" id="route-newsletter" value="{{ route('register.newsletter') }}">
    
    {!! $settingArr['google_analystic'] !!}
    <script type="text/javascript"> 
    
    $(document).on('keypress', '.txtSearch', function(e) {
        var obj = $(this);
        if (e.which == 13) {
            if ($.trim(obj.val()) == '') {
                return false;
            }
        }
    });
    
        
    
    </script>
    @include('frontend.partials.custom-css')
    @yield('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
              });
            $('.edit').click(function(){
                $('#txtId').val($(this).data('text'));
                $('#txtContent').val($(this).html());
                $('#editContentModal').modal('show');
            });
            $('#btnSaveContent').click(function(){
                $.ajax({
                    url : '{{ route('save-content') }}',
                    type : "POST",
                    data : {
                        id : $('#txtId').val(),
                        content : $('#txtContent').val()
                    },
                    success:  function(){
                        window.location.reload();
                    }

                });
            });
        });        
        
        var projects = [
            @foreach($listProduct as $product)
          {
            value: "{!! $product->name !!}",
            label: "{!! $product->name !!}",
            alias: "{!! $product->alias !!}"
          },
           @endforeach
        ];
     
      //   $( "#project" ).autocomplete({
      //     minLength: 0,
      //     source: projects,
      //     focus: function( event, ui ) {
      //       $( "#project" ).val( ui.item.label );
      //       return false;
      //     },
      //     select: function( event, ui ) {
      //       $( "#project" ).val( ui.item.label );
      //       $( "#project-id" ).val( ui.item.value );
      //       $( "#project-description" ).html( ui.item.desc );
      //       $( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
     
      //       return false;
      //     }
      //   })
      //   .autocomplete( "instance" )._renderItem = function( ul, item ) {
      //     return $( "<li>" )
      //       .append( "<div>" + item.label + "<br>" + item.desc + "</div>" )
      //       .appendTo( ul );
      //   };
      // } );
        $( "#txtSearch" ).autocomplete({
          source: projects,
          select: function( event, ui ) {
            $('#txtSearch').val(ui.item.label);
            $('#txtSearch').parents('form').submit();
          },
        });         
    </script>

@if(!in_array($routeName, ['news-detail', 'product']))
<div class="reviews-summary" id="rating-summary" itemscope="" itemtype="http://schema.org/Review" style="display:none">
   <div class="rating-title" itemprop="name">Đánh giá :</div>  
   <div class="rating-action dot" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating">
      <span>Xếp hạng <span itemprop="ratingValue">5</span> - 180 phiếu bầu</span>
   </div>
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="popup_khuvuc" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
             <div class="modal-body">
                <div class="bg-333 text-center">
                    <img id="imglogo" src="http://kshop247.vn/public/assets/img/logo-2.png" alt=""/>
                </div>
                <p>Chọn chi nhánh KSHOP 24/7</p>
                <div class="dropdown nvn-select-khuvuc">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Chọn quận/huyện
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        @foreach($loadDistrict as $dis)
                        <li><a href="{{ route('choose-district', ['city_id' => $dis->city_id, 'id' => $dis->id]) }}" data-city="{{ $dis->city_id }}" data-id="{{ $dis->id }}">{!! $dis->name !!}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
    .dropdown-backdrop{
        display: none !important;
    }
</style>
</body>
</html>