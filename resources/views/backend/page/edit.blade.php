@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ trans('text.page') }}     
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('text.dashboard') }}</a></li>
      <li><a href="{{ route('page.index') }}">{{ trans('text.page') }}</a></li>
      <li class="active">{{ trans('text.modify') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('page.index') }}" style="margin-bottom:5px">{{ trans('text.back') }}</a>   
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            {{ trans('text.modify') }}
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="POST" action="{{ route('page.update') }}">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $detail->id }}">
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
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif              
              <input type="hidden" name="folder_id" value="{{ $chapterDetail->folder_id }}">
              <input type="hidden" name="book_id" value="{{ $chapterDetail->book_id }}">
              <input type="hidden" name="chapter_id" value="{{ $chapter_id }}">
                 <!-- text input -->
                 <div class="form-group">
                  <label>{{ trans('text.notes') }}</label>
                  <textarea name="notes" id="notes" class="form-control">{!! old('notes', $detail->notes) !!}</textarea>
                </div>
                <div class="form-group">
                  <label>{{ trans('text.content') }}<span class="red-star">*</span></label>
                  <textarea name="content" id="content" class="form-control">{!! old('content', $detail->content) !!}</textarea>
                </div>
              
            </div>         
              
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">{{ trans('text.save') }}</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('page.index')}}">{{ trans('text.cancel') }}</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
        
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
  .checkbox+.checkbox, .radio+.radio{
    margin-top: 10px !important;
  }
</style>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
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
var editor1 = CKEDITOR.replace( 'content',{
          height : 500
      });
    $(document).ready(function(){
      $('#btnUploadImage').click(function(){        
        openKCFinder_singleFile();
      }); 
      $('#name').change(function(){
         var name = $.trim( $(this).val() );
         
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
       
      });

    });
    
</script>
@stop
