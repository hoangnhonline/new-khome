@extends('frontend.layout')
@include('frontend.partials.meta')

@section('content')
<article>
            <section class="marg40">

                <div class="box-reset-password">
                @if (count($errors) > 0)
                  <div class="alert alert-danger" style="text-align: left;">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif 
              @if ($success == 1)
                  <div class="alert alert-info" style="text-align: left;">
                      <ul>
                          
                        <li>Yêu cầu mật khẩu mới thành công. Vui lòng kiểm tra email của quý khách.</li>
                          
                      </ul>
                  </div>
              @endif    
              
                    <h3>Quên mật khẩu</h3>
                    <form accept-charset="UTF-8" role="form" method="POST" action="{{ route('forget-password') }}">

                    {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Nhập email" id="email_reset" name="email_reset" type="email">
                            </div>
                            <input class="btn btn-success btn-block" type="submit" value="Gửi lại mật khẩu mới">
                        </fieldset>
                    </form>
                </div>
            </section>
        </article>
        @stop