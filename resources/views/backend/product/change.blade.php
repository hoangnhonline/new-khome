@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Chuyển đổi danh mục
    </h1>   
  </section>

  <!-- Main content -->
  <section class="content">
  
    <form role="form" method="POST" action="{{ route('product.store-change') }}" id="dataForm">    

    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Chuyển đổi</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}          
            <div class="box-body">
              @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
                <div>
                    <div class="form-group col-md-4 none-padding">
                      <label for="email">Loại sản phẩm<span class="red-star">*</span></label>
                      <select class="form-control req" name="parent_id" id="parent_id">
                        <option value="">--Chọn--</option>
                        
                        @foreach( $cateParentList as $value )
                        <option value="{{ $value->id }}" {{ $value->id == old('parent_id') || $value->id == $parent_id ? "selected" : "" }}>{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div>
                      <div class="form-group col-md-4 none-padding pleft-5">
                      <label for="email">Danh mục cha<span class="red-star">*</span></label>
                      <?php 
                      
                      if($parent_id > 0){
                        $cateList = DB::table('cate')->where('parent_id', $parent_id)->orderBy('display_order')->get();
                      }else{
                        $cateList = (object) [];
                      }
                      ?>
                      <select class="form-control req" name="cate_id" id="cate_id">
                        <option value="">--Chọn--</option>
                        @foreach( $cateList as $value )
                        <option value="{{ $value->id }}" {{ $value->id == old('cate_id') || $value->id == $cate_id ? "selected" : "" }}>{{ $value->name }}</option>
                        @endforeach
                      </select>
                    </div> 
                    <div class="clearfix"></div>
                    <div class="row clearfix" style="margin-top:20px">
                    @foreach($cateList as $cate)
                    @if($cate->id != $cate_id)
                        <div class="col-md-4">
                          <label>
                            <input type="checkbox" name="parent_id_select[]" value="{{ $cate->id }}">
                            {{ $cate->name }}
                          </label>
                        </div>
                        @endif
                        @endforeach
                    </div>                                        
                    
                    <div class="clearfix"></div>                    
                </div>
                  
            </div>
            <div class="box-footer">              
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('product.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image_multiple" value="{{ route('image.tmp-upload-multiple') }}">
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<style type="text/css">
  .nav-tabs>li.active>a{
    color:#FFF !important;
    background-color: #444345 !important;
  }
  .error{
    border : 1px solid red;
  }
  .select2-container--default .select2-selection--single{
    height: 35px !important;
  }
</style>
@stop
@section('js')
<script type="text/javascript">
var h = screen.height;
var w = screen.width;
var left = (screen.width/2)-((w-300)/2);
var top = (screen.height/2)-((h-100)/2);
function openKCFinder_singleFile() {
      window.KCFinder = {};
      window.KCFinder.callBack = function(url) {
         $('#image_url').val(url);
         $('#thumbnail_image').attr('src', $('#app_url').val() + url);
          window.KCFinder = null;
      };
      window.open('{{ URL::asset("public/admin/dist/js/kcfinder/browse.php?type=images") }}', 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
  }
$(document).on('click', '.remove-image', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    $(this).parents('.col-md-3').remove();
  }
});

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
        if( $('#image_url').val() == ""){
          alert("Bạn chưa upload hình sản phẩm."); return false;
        }

      });
       $('#is_sale').change(function(){
        if($(this).prop('checked') == true){
          $('#price_sale, #sale_percent').addClass('req');          
        }else{
          $('#price_sale, #sale_percent').val('').removeClass('req');
        }
      });
      $('#price_sale').blur(function(){

        var sale_percent = 0;
        var price = parseInt($('#price').val());
        var price_sale = parseInt($('#price_sale').val());
        if(price_sale > 0){
          $('#is_sale').prop('checked', true);          
          if(price_sale > price){
            price_sale = price;
            $('#price_sale').val(price_sale);
          }
          if( price > 0 ){
            sale_percent = 100 - Math.floor(price_sale*100/price);
            $('#sale_percent').val(sale_percent);
          }
        }
      }); 
       $('#sale_percent').blur(function(){
        var price_sale = 0;
        var price = parseInt($('#price').val());
        var sale_percent = parseInt($('#sale_percent').val());
        sale_percent = sale_percent > 100 ? 100 : sale_percent;
        if( sale_percent > 0){
          $('#is_sale').prop('checked', true);
        }
        if(sale_percent > 100){
          sale_percent = 100;
          $('#sale_percent').val(100);
        }
        if( price > 0 ){
          price_sale = Math.ceil((100-sale_percent)*price/100);
          $('#price_sale').val(price_sale);
        }
      }); 
      $('#dataForm .req').blur(function(){    
        if($(this).val() != ''){
          $(this).removeClass('error');
        }else{
          $(this).addClass('error');
        }
      });
      $('#parent_id').change(function(){
        location.href="{{ route('product.change') }}?parent_id=" + $(this).val();
      });
      $('#cate_id').change(function(){
        location.href="{{ route('product.change') }}?parent_id=" + $('#parent_id').val() + '&cate_id=' + $(this).val();
      });
      $(".select2").select2();
      $('#dataForm').submit(function(){       
        $('#btnSave').htm('<i class="fa fa-spinner fa-spin"></i>').attr('disabled', 'disabled');
      });
      var editor1 = CKEDITOR.replace( 'content',{
          height : 300
      });
      $('#btnUploadImage').click(function(){        
        openKCFinder_singleFile();
      }); 
      $('#name').change(function(){
         var name = $.trim( $(this).val() );
         if( name != ''){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug').val( response.str );
                }                
              }
            });
         }
      });  
     
     
      
    });
    
</script>
@stop
