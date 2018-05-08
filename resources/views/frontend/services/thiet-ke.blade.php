@extends('frontend.layout') 
  
@include('frontend.partials.meta')
@section('content')
<div class="block2 block-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="{{ route('home')}}">Trang chủ</a></li>
			<li><a href="{{ route('services')}}">Dịch vụ</a></li>
			<li class="active">{!! $detail->title !!}</li>
		</ul>
	</div>
</div><!-- /block-breadcrumb -->
<div class="block block-two-col container">
	<div class="row">
		<div class="col-sm-9 col-xs-12 block-col-left">
			<div class="block-title-commom block-quote clearfix">
				<div class="block block-title">
					<h1>
						<i class="fa fa-home"></i>
						{!! $detail->title !!}
					</h1>
				</div>
				<div class="block-content">	
					<div class="block-editor-content">{!! $detail->content !!}</div>
					<div class="clearfix" style="margin-bottom:20px"></div>
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
					<form class="block-form" id="dataForm" method="POST" action="{{ route('send-thiet-ke') }}">
					{{ csrf_field() }}
						<div class="row">
						<input type="hidden" name="id" value="{{ $id }}">
							<div class="form-group col-sm-6 col-xs-12">
				              	<select class="form-control req" name="kien_truc_thiet_ke" id="kien_truc_thiet_ke">
								    <option value="">Kiến trúc...</option>
								    @foreach($arrSetting['kien_truc_thiet_ke'] as $value)
								    <option value="{!! $value->id !!}" {{ old('kien_truc_thiet_ke') == $value->id ? "selected" : "" }}>{!! $value->name !!}</option>
								    @endforeach
								</select>
							</div>
							<div class="form-group col-sm-6 col-xs-12">
				              	<select class="form-control req" name="hinh_thuc_kien_truc" id="hinh_thuc_kien_truc">
				              		<option value="">Hình thức kiến trúc...</option>
								    @foreach($arrSetting['hinh_thuc_kien_truc'] as $value)
								    <option value="{!! $value->id !!}" {{ old('hinh_thuc_kien_truc') == $value->id ? "selected" : "" }}>{!! $value->name !!}</option>
								    @endforeach
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6 col-xs-12">
				              	<select class="form-control req" name="so_tang_thiet_ke">
								    <option value="">Số tầng thiết kế ...</option>
								    @foreach($arrSetting['so_tang_thiet_ke'] as $value)
								    <option value="{!! $value->id !!}" {{ old('so_tang_thiet_ke') == $value->id ? "selected" : "" }}>{!! $value->name !!}</option>
								    @endforeach
								</select>
							</div>
							<div class="form-group col-sm-6 col-xs-12">
				              	<select class="form-control  req" name="mat_tien" id="mat_tien">
				              		<option value="">Mặt tiền...</option>
								    @foreach($arrSetting['mat_tien'] as $value)
								    <option value="{!! $value->id !!}" {{ old('mat_tien') == $value->id ? "selected" : "" }}>{!! $value->name !!}</option>
								    @endforeach
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6 col-xs-12">
								<input type="text" class="form-control req" name="chieu_dai" id="chieu_dai" placeholder="Diện tích khu đất dài...(*)" value="{{ old('chieu_dai') }}">
							</div>
							<div class="form-group col-sm-6 col-xs-12">
								<input type="text" class="form-control req" id="chieu_rong" name="chieu_rong" placeholder="Diện tích khu đất rộng...(*)" value="{{ old('chieu_rong') }}">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6 col-xs-12">
								<input type="text" class="form-control req" name="fullname" id="fullname" placeholder="Tên khách hàng...(*)" value="{{ old('fullname') }}">
							</div>
							<div class="form-group col-sm-6 col-xs-12">
								<input type="text" class="form-control req" id="phone" name="phone" placeholder="Số điện thoại...(*)" value="{{ old('phone') }}">
							</div>
						</div>						
						<div class="row">
							<div class="form-group col-sm-12 col-xs-12">
								<input type="email" class="form-control req" id="email" name="email" placeholder="Email...(*)" value="{{ old('email') }}">
							</div>							
						</div>		
						<div class="row">
							<div class="form-group col-sm-12 col-xs-12">
								<textarea name="notes" rows="4" class="form-control" placeholder="Ghi chú">{{ old('notes') }}</textarea>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12 col-xs-12">
								<button type="submit" id="btnSave" class="btn btn-prmary btn-view">Xem báo giá</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /block-ct-news -->
		</div><!-- /block-col-left -->
		<div class="col-sm-3 col-xs-12 block-col-right">
			<div class="block-sidebar">
				<div class="block-module block-links-sidebar">
					<div class="block-title">
						<h2>
							<i class="fa fa-home"></i>
							DANH MỤC DỊCH VỤ
						</h2>
					</div>
					<div class="block-content">
					<ul class="list">
						@foreach($servicesList as $ser)
						<li><a @if(isset($detail) && $detail->id == $ser->id) class="active" @endif href="{{ route('services-detail', [ $ser->slug, $ser->id ]) }}" title="{!! $ser->title !!}">{!! $ser->title !!}</a></li>
						@endforeach
					</ul>
				</div>
				</div>
			</div>
		</div><!-- /block-col-right -->
	</div>
</div><!-- /block_big-title -->	
<style type="text/css">
	.error{
		border : 1px solid red !important;
	}
</style>
@stop

@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$('#btnSave').click(function(){
	        var errReq = 0;
	        $('#dataForm .req').each(function(){
	          var obj = $(this);
	          if(obj.val() == '' || obj.val() == '0'){
	            errReq++;
	            obj.addClass('error');
	          }else{
	            obj.removeClass('error');
	          }
	        });
	        if(errReq > 0){          
	         $('html, body').animate({
	              scrollTop: $("#dataForm .req.error").eq(0).parents('div').offset().top
	          }, 500);
	          return false;
	        }	        
	        $('#dataForm').submit();
	        $('#btnSave').attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i>');
	      });
		$('#dataForm .req').blur(function(){    
	        if($(this).val() != ''){
	          $(this).removeClass('error');
	        }else{
	          $(this).addClass('error');
	        }
	      });
	});
</script>
@stop