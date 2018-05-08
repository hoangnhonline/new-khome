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
               <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="active">Liên hệ</li>
            </ul>
        </div>
    </div>
    <section id="contact" class="marg40">
        <div class="container">
            <div class="title-section">
                LIÊN HỆ
            </div>
        </div>
        <div class="container">
            <div class="content-single">
                <div class="marg40">
                    <h3 class="title-contact">HỆ THỐNG CAFE SIÊU THỊ KHANG AN 24/7</h3>
                    <p class="info-contact">
                        <b>Địa chỉ:</b>  Cao Ốc An Thịnh, 16A Thái Thuận, Phường An Phú, Quận 2<br/>
                        <b>Điện thoại:</b> 0981 323 232<br/>
                        <b>Email:</b> khangan247@gmail.com<br/>
                        <b>Website:</b> http://kshop247.vn<br/>                      
                    </p>
                </div>
                <div class="marg40">
                    <h3 class="title-contact">THÔNG TIN LIÊN HỆ</h3>
                     <div id="showmess" class="clearfix"></div>
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
                        <form class="block-form" action="{{ route('send-contact') }}" method="POST">
                        {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-sm-12 col-xs-12">
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ tên khách hàng" value="{{ old('fullname') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-xs-12">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-xs-12">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-xs-12">
                                    <textarea name="content" id="content" rows="4" class="form-control" placeholder="Ghi chú" style="margin: 0;">{{ old('content') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-xs-12">
                                    <button type="submit" id="btnSave" class="btn btn-prmary btn-view" style="color:#FFF">Gửi liên hệ</button>
                                </div>
                            </div>
                        </form>
                </div>
                <div id="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.169099259521!2d106.73682421480105!3d10.798357492306684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752611da74503d%3A0x483948608a7770b8!2zMTYgVGjDoWkgVGh14bqtbiwgS2h1IMSRw7QgdGjhu4sgQW4gUGjDuiBBbiBLaMOhbmgsIEFuIFBow7osIFF14bqtbiAyLCBI4buTIENow60gTWluaA!5e0!3m2!1svi!2s!4v1514642000317" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="cart-info cart-side">
                <div class="title-cart-info">THÔNG TIN GIỎ HÀNG</div>
                <div class="content-cart-info">
                    @if(!empty(Session::get('products')))
                    <div class="list-items-cart">                        
                        <?php $total = 0; ?>
                        @if( $arrProductInfo->count() > 0)
                            <?php $i = 0; ?>
                          @foreach($arrProductInfo as $product)
                          <?php 
                          $i++;
                          $price = $product->is_sale ? $product->price_sale : $product->price; 

                          $total += $total_per_product = ($getlistProduct[$product->id]*$price);
                          
                          ?>
                        <div class="item-cart">
                            <div class="info-qty">
                                <a class="qty-up" data-id="{{ $product->id }}" href="javascript:;"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                                <input step="1" name="quantity" value="{{ $getlistProduct[$product->id] }}" class="qty-val">
                                <a class="qty-down" data-id="{{ $product->id }}" href="javascript:;"><i class="fa fa-minus-square" aria-hidden="true"></i></a>
                            </div>
                            <p class="title-item">{!! $product->name !!}</p>
                            <div class="price clearfix" style="font-size:14px">   
                                <p class="pull-left" >{{ $getlistProduct[$product->id] }}x{{ number_format($price) }}</p>                             
                                <p class="pull-right">{!! number_format($total_per_product) !!}đ</p>
                            </div>
                        </div>   
                        
                        @endforeach
                        @endif                     
                    </div>
                    <ul class="">
                        <li>
                            <span class="pull-left cl_666">Cộng</span>
                            <span class="pull-right cl_333">{!! number_format($total) !!}đ</span>
                        </li>
                        <!--<li>
                            <span class="pull-left cl_ea0000">Giảm 30% tổng bill</span>
                            <span class="pull-right cl_ea0000">66.000đ</span>
                        </li>-->
                        <li>
                            <span class="pull-left cl_666">Phí phục vụ<br><small>(10% trên tổng đơn hàng)</small></span>
                            <span class="pull-right cl_333">{{ number_format($total*10/100) }}đ</span>
                        </li>
                        <li class="bg_fffdee">
                            <span class="pull-left cl_666">Tạm tính</span>
                            <span class="pull-right cl_ea0000">{!! number_format($total + $total*10/100) !!}đ</span>
                            <div class="clearfix"></div>
                            <div class="action-cart ">
                                <a href="{{ route('address-info') }}" class="btn btn-yellow">Đặt hàng</a>
                                <a href="{{ route('empty-cart') }}" onclick="return confirm('Quý khách có chắc chắn bỏ hết hàng ra khỏi giỏ?'); " class="btn btn-defaultyellow">Xoá</a>
                            </div>
                        </li>
                    </ul>
                    @else
                    <p class="cart-empty">Chưa có sản phẩm nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </section><!-- End product -->
</article>
@stop

@section('js')
<script type="text/javascript">
    @if (count($errors) > 0 || Session::has('message'))      
    $(document).ready(function(){
        $('html, body').animate({
            scrollTop: $("#showmess").offset().top
        });
    });
    @endif
    $(document).ready(function(){
        $('#btnSave').click(function(){
            $(this).parents('form').submit();
            $('#btnSave').attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i>');
        });
    });
</script>
@stop
